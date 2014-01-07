<?php

/**
 * 参与竞猜服务接口实现
 * 
 * @author blueyb.java@gmail.com
 */
class PlayService extends TransationSupport implements IPlayService{
	
	/**
	 *
	 * @var ModelDao
	 */
	protected $dao = null;
	
	public function __construct(){
		$this->dao = MD('Play');
	}
	/*
	 * @see IPlayService::add()
	 */
	public function add(Play $play){
		if(!$play || $play->isEmpty() || $play->getCustom()) return false;
		$user = $play->getUser();
		$guess = $play->getGuess();
		$playDatas = $play->getPlayDatas();
		$play->setPlayDatas(serialize($play->getPlayDatas()));
		$guessLink = NoticeService::makeGuessLink(array('id'=>$guess->getId(), 'title'=>$guess->getTitle()));
		try{
			$this->beginTransation();
			//增加投注
			$id = $this->dao->add($play);
			if(!$id){
				$this->rollBack();
				return false; 
			}
			$play->setId($id);
			//冻结投注金
			$userService = MemberServiceFactory::getUserService();
			if($play->wealthTypeIsMoney()){
				$io = array(
						'from_user_id' => $user->getId(),
						'to_user_id' => 0,
						'from_title' => "参与竞猜{$guessLink}",
						'wealth_type' => Io::WEALTH_TYPE_MONEY,
						'wealth' => $play->getWealth(),
						'from_balance' => $user->getAvailableMoney() - $play->getWealth()
				);
				if(!$userService->money($io, -1)){
					$this->rollBack();
					return false;
				}
			}elseif($play->wealthTypeIsIntegral()){
				$io = array(
						'from_user_id' => $user->getId(),
						'to_user_id' => 0,
						'from_title' => "参与竞猜{$guessLink}",
						'wealth_type' => Io::WEALTH_TYPE_INTEGRAL,
						'wealth' => $play->getWealth(),
						'from_balance' => $user->getAvailableIntegral() - $play->getWealth()
				);
				if(!$userService->integral($io, -1)){
					$this->rollBack();
					return false;
				}
			}
			//更新竞猜
			$guessDao = MD('Guess');
			$playCount = $guess->getPlayCount() + 1;
			$playWealth = $guess->getPlayWealth() + $play->getWealth();
			foreach($guess->getPlayDatas() as $playWayData){
				if(isset($playDatas[$playWayData->getId()])){
					$playWayData->addPlayCount($playDatas[$playWayData->getId()]->getChoose());
					$playWayData->addPlayWealth($playDatas[$playWayData->getId()]->getChoose(), $playDatas[$playWayData->getId()]->getWealth());
					$guess->addPlayData($playWayData);
				}
			}
			
			$update = array(
					'play_count'=>$playCount,
					'play_wealth'=>$playWealth,
					'play_datas'=>serialize($guess->getPlayDatas())
					);
			
			if(!$guessDao->update($update, $guess->getId())){
				$this->rollBack();
				return false;
			}
			//更新用户竞猜数
			$userDao = MD('User');
			if(!$userDao->update(array('guess_count'=>'guess_count + 1'), $user->getId(), true)){
				$this->rollBack();
				return false;
			}
			$this->commit();
			return true;
		}catch(Exception $e){
			$this->rollBack();
			return false;
		}
	}
	
	/*
	 * @see IPlayService::count()
	 */
	public function count($conditions){
		return $this->dao->count($conditions);
	}
	
	/*
	 * @see IPlayService::get()
	 */
	public function get($id){
		$play = $this->dao->get($id, null, true);
		return $this->toObject($play);
	}
	
	/*
	 * @see IPlayService::getGuesses()
	 */
	public function getGuesses($userId, $gets, $orders, $page, $perpage){
		if(!$userId)return null;
		$guessIds = $this->dao->gets(array('user_id'=>$userId), 'guess_id');
		if(!$guessIds) return null;
		$guessIds = ArrayUtil::colKeySet($guessIds, 'guess_id', true);
		$guessService = GuessServiceFactory::getGuessService();
		return $guessService->gets("id in ({$guessIds})", $gets, $orders, $page, $perpage);
	}
	
	/*
	 * @see IPlayService::gets()
	 */
	public function gets($conditions, $gets, $orders, $page, $perpage){
		return $this->dao->gets($conditions, $gets, $orders, $page, $perpage);
	}
	
	/*
	 * @see IPlayService::getUserPlay()
	 */
	public function getUserPlay($userId, $guessId){
		$play = $this->dao->getOne(array('user_id'=>$userId, 'guess_id'=>$guessId), null, true);
		return $this->toObject($play);
	}
	
	/**
	 * 转换成对象
	 * @param Model $play
	 * @return Ambigous <自定义模型, Play, object>
	 */
	private function toObject($play){
		if($play){
			$play->play_datas = unserialize($play->play_datas);
			$play = ModelTransform::toCustomModel($play, 'Play');
		}
		return $play;
	}
	
	/* 
	 * @see IPlayService::getPlays()
	 */
	public function getPlays(Guess $guess){
		$playDao = MD('Play');
		$tempPlays = $playDao->gets(array('guess_id'=>$guess->getId()));
		$userIds = ArrayUtil::colKeySet($tempPlays, 'user_id');
		if($userIds){
			$userIds = implode(',', $userIds);
			$userService = MemberServiceFactory::getUserService();
			$tempUsers = $userService->gets("id in ({$userIds})");
			$users = array();
			foreach($tempUsers as $user){
				$user = ModelTransform::toCustomModel(Model::newModel('User', $user), 'User');
				$users[$user->getId()] = $user;
			}
			unset($tempUsers);
		}else{
			$users = array();
		}
		$plays = array();
		foreach($tempPlays as $play){
			$play = $this->toObject(Model::newModel('Play', $play));
			$play->setGuess($guess);
			$play->setUser($users[$play->getUserId()]);
			$plays[$play->getId()] = $play;
		}
		unset($tempPlays);
		return $plays;
	}
}

?>