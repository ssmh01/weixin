<?php
/**
 * 好友列表
 * @author blueyb.java@gmail.com
 */
class FriendAction extends UserCenterAction{
	
	public function index(HttpRequest $request){
		$myFriend = $this->user->getFriend();
		
		if(!empty($myFriend))
		{
			$conditions = 'id IN(' . $myFriend . ')';
			$page = getPage();
			$perpage = 5;
			$userService = MemberServiceFactory::getUserService();
			$items = $userService->gets($conditions, $gets, $orders, $page, $perpage);
			$total = $userService->count($conditions);
			$pages = multi_page($total, $perpage, $page);			

			/*
			if($items){
				//获取当前用户与搜索用户之间的好友关系
				$userIds = ArrayUtil::colKeySet($items, 'to_uid', true);
				$conditions = "id in ({$userIds})";
				$userService = MemberServiceFactory::getUserService();
				$items = $userService->gets($conditions);
			}
			*/
			
			$request->setAttribute('items', $items);
			$request->setAttribute('total', $total);
			$request->setAttribute('pages', $pages);
			$request->setAttribute('page', $page);
			$request->setAttribute('perpage', $perpage);		
		}	
		
		$seo = array(
				'title' => '好友列表',
				'description' => '',
				'keywords' => ''
		);
		$request->assign('seo', $seo);
		$this->setView('friend');
	}
	
	/**
	 * 发送好友申请
	 * @param HttpRequest $request
	 */
	public function add(HttpRequest $request){
		$toUid = $request->getParameter('uid');
		if(!$toUid){
			show_message('请选择用户');
		}
		if($toUid == $this->user->getId()){
			show_message('你不能加自己为好友');
		}
		$userService = MemberServiceFactory::getUserService();
		$toUser = $userService->get($toUid);
		if(!$toUser){
			show_message('用户不存在');
		}

		$myFriend = $this->user->getFriend();		
		if(!empty($myFriend) && strpos(',' . $myFriend . ',', ',' . $toUid . ',') !== false)
		{
			show_message('该用户已经是你的好友，不须重复添加');
		}
		
		$noticeService = MemberServiceFactory::getNoticeService();
		$userLink = NoticeService::makeUserLink(array('id'=>$this->user->getId(), 'name'=>$this->user->getName()));
		$notice = "用户{$userLink}请求加你为好友";
		if($noticeService->notice($notice, $toUid, $this->user->getId(), 1)){
			show_message('请求发送成功，请等待对方验证');
		}
		else
		{
			show_message('请求发送失败');
		}
	}
	
	/**
	 * 删除好友
	 * @param HttpRequest $request
	 */
	public function cancel(HttpRequest $request){
		$toUid = $request->getParameter('uid');
		if(!$toUid){
			show_message('请选择用户');
		}
		if($toUid == $this->user->getId()){
			show_message('非法参数');
		}
		
		$userService = MemberServiceFactory::getUserService();
		$userService->apply_friend($this->user->getId(), $toUid, 0);
		show_message('好友取消成功');
	}	
	
	/**
	 * 取消关注
	 * @param HttpRequest $request
	 */
	/*
	public function cancel(HttpRequest $request){
		$toUid = $request->getParameter('uid');
		if(!$toUid){
			show_message('请选择要取消关注的用户');
		}
		if($toUid == $this->user->getId()){
			show_message('非法参数');
		}
		$conditions = array('from_uid'=>$this->user->getId(), 'to_uid'=>$toUid);
		$follow = $this->dao->getOne($conditions);
		if(!$follow){
			show_message('你还没有关注该用户！');
		}
		if($this->dao->delete($follow['id'])){
			show_message('取消关注成功');
		}else{
			show_message('取消关注失败');
		}
	}	
	*/
}