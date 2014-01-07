<?php
/**
 * 竞猜详细
 * @author blueyb.java@gmail.com
 */
class ViewAction extends UserCenterAction{
	
	public function index(HttpRequest $request){
		//获取竞猜
		$id = $request->getParameter('id');
		if(empty($id)){
			show_message('请选择要查看竞猜!');
		}
		$guessService = GuessServiceFactory::getGuessService();
		$guess = $guessService->get($id, true);
		if(!$guess){
			show_message('竞猜不存在，请确认!');
		}
		if(!$guess->getStatus() && $guess->getUserId() != $this->user->getId()){
			show_message('竞猜还没通过审核!');
		}
		if($guess->getStatus() == Guess::STATUS_CLOSE){
			show_message('竞猜已关闭');
		}
// 		Debug::println($guess);
		if(!$guess->getCustom()){
			//获取所在的分类
			$guessCategoryService = GuessServiceFactory::getGuessCategoryService();
			if($guess->getCateId()){
				$subCategory = $guessCategoryService->get($guess->getCateId());
				$rootCategory = $guessCategoryService->get($subCategory['parent_id']);
			}
			//获取玩法
			$playWayService = GuessServiceFactory::getPlayWayService();
			$playWays = $playWayService->gets();
			
			$request->setAttribute('playWays', $playWays);
			$request->setAttribute('subCategory', $subCategory);
			$request->setAttribute('rootCategory', $rootCategory);
		}
		//计算剩余时间
		//echo time();
		$time = $guess->getPlayDeadline() - time();
		
		$guessDay = sprintf('%02d',floor($time/86400));
		$guessHour = sprintf('%02d',floor(($time-$guessDay*86400)/3600));
		$guessMinute = sprintf('%02d',floor(($time-$guessDay*86400-$guessHour*3600)/60));
		
		/*
		if($time >= 86400){
			$guessDay = date('d', $time);
		}else{
			$guessDay = 0;
		}
		$time = $time % 86400;
		if($time >= 3600){
			$guessHour = date('H', $time);
		}else{
			$guessHour = 0;
		}
		$time = $time % 3600;
		if($time >= 60){
			$guessMinute = date('i', $time);
		}else{
			$guessMinute = 0;
		}
		*/
		
		$request->setAttribute('guessDay', $guessDay);
		$request->setAttribute('guessHour', $guessHour);
		$request->setAttribute('guessMinute', $guessMinute);
		
		//获取参与的用户
		$playDao = MD('Play');
		$playUserIds = $playDao->gets(array('guess_id'=>$id), 'user_id', array('create_time'=>'desc'), 1, 6);
		if($playUserIds){
			$playUserIds = ArrayUtil::colKeySet($playUserIds, 'user_id', true);
			$userService = MemberServiceFactory::getUserService();
			$playUsers = $userService->gets("id in ($playUserIds)");
			$request->setAttribute('userList', $playUsers);
		}
		
		//获取用户的参与情况
		$playService = GuessServiceFactory::getPlayService();
		$play = $playService->getUserPlay($this->user->getId(), $guess->getId());
		
		//竞猜是否只对好友开放,如果是则获取好友情况
		if($this->user->getId() != $guess->getUserId() && $guess->justFriendCanPlay()){
			/*
			$followService = MemberServiceFactory::getFollowService();
			$isFollow = $followService->isFollow($guess->getUserId(), $this->user->getId());
			*/
			$userService = MemberServiceFactory::getUserService();
			$isFollow = $userService->is_friend($guess->getUserId(), $this->user->getId());
			$request->setAttribute('isFollow', $isFollow);
		}
		
		//查看用户是否关注了该竞猜
		$guessIsFollow = $guessService->isFollow($this->user->getId(), $guess->getId());
		
		$request->setAttribute('guess', $guess);
		$request->setAttribute('play', $play);
		$request->setAttribute('guessIsFollow', $guessIsFollow);
		$seo = array(
				'title' => $guess->getTitle(),
				'description' => '',
				'keywords' => ''
		);
		$request->setAttribute('seo', $seo);
		if($guess->getCustom()){
			$this->setView('custom_view');
		}else{
			if($play){
				$this->setView('view_played');
			}else{
				$this->setView('view');
			}
		}
	}
}