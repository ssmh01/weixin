<?php

/**
 * 自定义竞猜服务接口实现
 * 
 * @author blueyb.java@gmail.com
 */
class CustomGuessService  extends GuessService implements ICustomGuessService{
	
	/*
	 * @see IGuessService::add()
	 */
	public function add(Guess $guess){
		$guess->setParameter(serialize($guess->getParameter()));
		$user = $guess->getUser();
		try{
			$this->beginTransation();
			// 添加竞猜
			$guessDao = MD('Guess');
			$guessId = $guessDao->add($guess);
			if(!$guessId){
				$this->rollBack();
				return false;
			}
			$guess->setId($guessId);
			//邀请好友参与
			if($guess->getInviteFriend() == '1')
			{
				if(!$this->inviteFriends($guess)){
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
	
	/* 
	 * @see ICustomGuessService::rudgeApply()
	 */
	public function rudgeApply(Guess $guess){
		if(!$guess || !$guess->getCustom() || $guess->getStatus() != Guess::STATUS_NORMAL) return false;
		$guessDao = MD('Guess');
		return $guessDao->update(array('status'=>Guess::STATUS_WAITING_RUDGE), $guess->getId());
	}
	
	/* 
	 * @see ICustomGuessService::rudge()
	 */
	public function rudge(Guess $guess){
		if(!$guess || !$guess->getCustom() || $guess->getPlayDeadline() > time()) return false;
		try{
			$guessUser = $guess->getUser();
			$playService = GuessServiceFactory::getPlayService();
			$userService = MemberServiceFactory::getUserService();
			$noticeService = MemberServiceFactory::getNoticeService();
			$guessDao = MD('Guess');
			$userDao = MD('User');
			$plays = $playService->getPlays($guess);
			$playData = null;
			$chooseOption = $guess->getParameter()->getChooseOption();
			if(!$chooseOption) return false;
			$guessLink = NoticeService::makeGuessLink(array('id'=>$guess->getId(), 'title'=>$guess->getTitle()));
			foreach($plays as $play){
				//对用户的竞猜参与进行判定
				$playUser = $play->getUser();
				$playData = $play->getFirstPlayData();
				$update = array('status'=>Play::STATUS_REDGED);
				if($playData->getChoose() == $chooseOption->getValue()){
					//赢
					$playData->setWinWealth(Play::WIN_WEALTH_CUSTOM);
					$update['win_wealth'] = Play::WIN_WEALTH_CUSTOM;
					$notice = "「赢」你参与的竞猜{$guessLink}已经公布结果, 结果为[{$chooseOption->getLabel()}]";
				}else{
					//输
					$playData->setWinWealth(Play::LOST_WEALTH_CUSTOM);
					$update['win_wealth'] = Play::LOST_WEALTH_CUSTOM;
					$notice = "「输」你参与的竞猜{$guessLink}已经公布结果, 结果为[{$chooseOption->getLabel()}]";
				}
				$update['play_datas']=serialize($play->getPlayDatas());
				//保存竞猜结果
				$playDao = MD('Play');
				if(!$playDao->update($update, $play->getId())){
					$this->rollBack();
					return false;
				}
				
				//竞猜判定通知
				if($playUser->getConfig('guess_result')){
					if(!$noticeService->notice($notice, $playUser->getId())){
						$this->rollBack();
						return false;
					}
				}
				//更新用户竞猜准确率
				if(!$userService->updateGuessAccuracy($playUser->getId())){
					$this->rollBack();
					return false;
				}
			}
			
			//竞猜判定通知庄家
			if($guessUser->getConfig('guess_result')){
				$notice = "你坐庄的竞猜{$guessLink}已经公布结果, 结果为[{$chooseOption->getLabel()}]";
				if(!$noticeService->notice($notice, $guessUser->getId())){
					$this->rollBack();
					return false;
				}
			}
			//更新竞猜状态
			if(!$guessDao->update(array('status'=>Guess::STATUS_END), $guess->getId())){
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
}

?>