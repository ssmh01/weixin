<?php

/**
 * 分享服务接口实现
 * @author blueyb.java@gmail.com
 */
class FollowService extends TransationSupport implements IFollowService{
	
	/*
	 * @see IFollowService::getUserFans()
	 */
	public function getUserFans($userId, $page, $perpage){
		$userTable = R::getConfig()->getConfig('database_prefix') . 'user';
		$followTable = R::getConfig()->getConfig('database_prefix') . 'follow';
		if($page > 1){
			$start = ($page - 1) * $perpage;
			$sql = "select * from {$userTable} where id in (select from_uid from {$followTable} where to_uid = '{$userId}' limit $start,$perpage)";
		}else{
			$sql = "select * from {$userTable} where id in (select from_uid from {$followTable} where to_uid = '{$userId}')";
		}
		$db = R::getDB();
		$users = $db->getRows($sql);
		return UserService::usersDataProper($users);
	}
	
	/*
	 * @see IFollowService::getUserFollows()
	 */
	public function getUserFollows($userId, $page, $perpage){
		$userTable = R::getConfig()->getConfig('database_prefix') . 'user';
		$followTable = R::getConfig()->getConfig('database_prefix') . 'follow';
		if($page > 1){
			$start = ($page - 1) * $perpage;
			$sql = "select * from {$userTable} where id in (select to_uid from {$followTable} where from_uid = '{$userId}' limit $start,$perpage)";
		}else{
			$sql = "select * from {$userTable} where id in (select to_uid from {$followTable} where from_uid = '{$userId}')";
		}
		$db = R::getDB();
		$users = $db->getRows($sql);
		return UserService::usersDataProper($users);
	}
	
	/*
	 * @see IFollowService::getUserFanIds()
	 */
	public function getUserFollowIds($userId, $page, $perpage){
		$followDao = MD('Follow');
		$conditions = array(
			'from_uid' => $userId
		);
		$follows = $followDao->gets($conditions, array(
			'to_uid'
		), null, null, null);
		return ArrayUtil::colKeySet($follows, 'to_uid');
	}
	
	/*
	 * @see IFollowService::hasFollow()
	 */
	public function isFollow($fromUid, $toUid){
		$followDao = MD('Follow');
		return $followDao->count(array('from_uid'=>$fromUid, 'to_uid'=>$toUid));
	}
		
	/*
	 * @see IFollowService::add()
	 */
	public function add(Follow $follow){
		$followDao = MD('Follow');
		try{
			$this->beginTransation();
			//添加
			$id = $followDao->add($follow);
			if(!$id){
				$this->rollBack();
				return false;
			}
			$follow->setId($id);
			//更新关注数和粉丝数
			$userDao = MD('User');
			if(!$userDao->update(array('follow_count'=>'follow_count+1'), $follow->getFromUid(),true)){
				$this->rollBack();
				return false;
			}
			if(!$userDao->update(array('fan_count'=>'fan_count+1'), $follow->getToUid(),true)){
				$this->rollBack();
				return false;
			}
			//发送通知
			if($follow->getToUser()->getConfigs('follow_add')){
				//被关注用设置了接收被关注通知
				$noticeService = MemberServiceFactory::getNoticeService();
				$userLink = NoticeService::makeUserLink(array('id'=>$follow->getFromUser()->getId(), 'name'=>$follow->getFromUser()->getName()));
				$notice = "用户{$userLink}关注了你";
				if(!$noticeService->notice($notice, $follow->getToUid())){
					$this->rollBack();
					return false;
				}
			}
			$this->commit();
			return true;
		}catch(Exception $e){
			$this->rollBack();
			return false;
		}
	}
}

?>