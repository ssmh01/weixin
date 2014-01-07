<?php

/**
 * 首页Action
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-07-31
 */
class IndexAction extends UserCenterAction {

	public function index(HttpRequest $request){
		
		//获取未读通知
		$modelDao = MD('Notice');
		$conditions = array('to_uid'=>$this->user->getId(), 'new'=>1);
		$orders = array('create_time'=>'desc');
		$page = 1;
		$perpage = 6;
		$notices = $modelDao->gets($conditions, null, $orders, $page, $perpage);
		
		//随机获取用户
		$userService = MemberServiceFactory::getUserService();
		$userList = $userService->getRandUsers(10);
		
		//公告状态
		$hidePlacard = $_COOKIE['hide_placard'];
		
		//获取统计
		$guessService = GuessServiceFactory::getGuessService();
		$guessNewCount = $guessService->count(" status = " . Guess::STATUS_NORMAL . " AND play_deadline > " . time());
		$guessAddCount = $guessService->count(array('user_id'=>$this->user->getId()));
		$playService = GuessServiceFactory::getPlayService();
		$guessPlayCount = $playService->count(array('user_id'=>$this->user->getId()));
		$userGuessService = GuessServiceFactory::getUserGuessService();
		$inviteGuessCount = $userGuessService->getInviteGuessCount($this->user->getId());
		$attentionGuessCount = $userGuessService->getAttentionGuessCount($this->user->getId());
		$friendGuessCount = $userGuessService->getFriendGuessCount($this->user->getId());
		$totalGuessCount = $guessAddCount + $guessPlayCount + $inviteGuessCount + $attentionGuessCount + $friendGuessCount;
		
		//根据设置获取动态
		$userConfig = $this->user->getConfigs();

		//$guessConditions = " status != " . Guess::STATUS_WAITING_CKECK . " && status != " . Guess::STATUS_CLOSE;
		$guessConditions = " status = " . Guess::STATUS_NORMAL . " AND play_deadline > " . time();
		
		if($userConfig['trend_condition']){
			//只显示好友
			/*
			$followService = MemberServiceFactory::getFollowService();
			$followUserIds = $followService->getUserFollowIds($this->user->getId());
			if($followUserIds){
				$followUserIds = implode(',', $followUserIds);
				$guessConditions .= " and user_id in ({$followUserIds})";
			}
			*/
			$userService = MemberServiceFactory::getUserService();
			$friendUserIds = $userService->getUserFriend($this->user->getId());
			if(!empty($friendUserIds))
			{
				$friendUserStr = '';
				foreach ($friendUserIds as $f)
					$friendUserStr .= empty($friendUserStr) ? $f['id'] : ',' . $f['id'];
			
				$guessConditions .= " and user_id in ({$friendUserStr})";
			}
			else
			{
				$guessConditions .= " AND user_id IN (0)";
			}			
		}
		
		if($userConfig['trend_time']){
			$startTime = time() - (86400 * $userConfig['trend_time']);
			$guessConditions .= " and create_time > '{$startTime}'";
		}
		
		$guessService = GuessServiceFactory::getGuessService();
		$guesses = $guessService->gets($guessConditions, null, array('create_time'=>'desc'), 1, 10);
		
		UserService::usersSet(ArrayUtil::colKeySet($guesses, 'user_id'));

		//分类信息
		$guessCategoryService = GuessServiceFactory::getGuessCategoryService();
		$guessCategory = $guessCategoryService->getAlls();
				
		$request->setAttribute('guessCategory', $guessCategory);
		
		$request->setAttribute('notices', $notices);
		$request->setAttribute('userList', $userList);
		$request->setAttribute('hidePlacard', $hidePlacard);
		$request->setAttribute('guessNewCount', $guessNewCount);
		$request->setAttribute('guessAddCount', $guessAddCount);
		$request->setAttribute('guessPlayCount', $guessPlayCount);
		$request->setAttribute('inviteGuessCount', $inviteGuessCount);
		$request->setAttribute('attentionGuessCount', $attentionGuessCount);
		$request->setAttribute('friendGuessCount', $friendGuessCount);
		$request->setAttribute('totalGuessCount', $totalGuessCount);
		$request->setAttribute('guesses', $guesses);
		
		
		
		$seo = array(
				'title' => "{$this->user->getName()}的首页",
				'description' => '',
				'keywords' => ''
		);
		$request->assign('seo', $seo);
		$this->setView('index');
	}
}

?>