<?php
/**
 * 我的竞猜列表
 * @author blueyb.java@gmail.com
 */
class MyAction extends UserCenterAction{
	
	public function index(HttpRequest $request){
		$this->add($request);
	}
	
	public function add(HttpRequest $request){
		$this->common($request);
		
		$guessService = GuessServiceFactory::getGuessService();
		$conditions = array(
				'user_id' => $this->user->getId()
		);
		$order = array(
				'create_time' => 'desc'
		);
		$page = getPage();
		$perpage = 5;
		$guesses = $guessService->gets($conditions, null, $order, $page, $perpage);
		$total = $guessService->count($conditions);
		$pages = multi_page($total, $perpage, $page);
		
		$request->setAttribute('guesses', $guesses);
		$request->setAttribute('total', $total);
		$request->setAttribute('pages', $pages);

		//分类信息
		$guessCategoryService = GuessServiceFactory::getGuessCategoryService();
		$guessCategory = $guessCategoryService->getAlls();
		$request->setAttribute('guessCategory', $guessCategory);		
		
		$request->assign('title', "我发布的竞猜");
		$seo = array(
				'title' => '我发布的竞猜',
				'description' => '',
				'keywords' => ''
		);
		$request->assign('seo', $seo);
		$request->assign('addClass', 'class="sel"');
		$this->setView('my_add');
	}
	
	public function play(HttpRequest $request){
		$this->common($request);
		$request->assign('title', "我参与的竞猜");
		$playService = GuessServiceFactory::getPlayService();
		$page = getPage();
		$perpage = 5;
		$guesses = $playService->getGuesses($this->user->getId(), null, array('create_time'=>'desc'), $page, $perpage);
		$total = $playService->count(array('user_id'=>$this->user->getId()));
		$pages = multi_page($total, $perpage, $page);
		$request->setAttribute('guesses', $guesses);
		$request->setAttribute('total', $total);
		$request->setAttribute('pages', $pages);
		
		UserService::usersSet(ArrayUtil::colKeySet($guesses, 'user_id'));

		//分类信息
		$guessCategoryService = GuessServiceFactory::getGuessCategoryService();
		$guessCategory = $guessCategoryService->getAlls();
		$request->setAttribute('guessCategory', $guessCategory);		
		
		$seo = array(
				'title' => '我参与的竞猜',
				'description' => '',
				'keywords' => ''
		);
		$request->assign('seo', $seo);
		$request->assign('playClass', 'class="sel"');
		$this->setView('my');
	}
	
	public function attention(HttpRequest $request){
		$this->common($request);
		
		$userGuessService = GuessServiceFactory::getUserGuessService();
		$page = getPage();
		$perpage = 5;
		$guesses = $userGuessService->getAttentionGuesses($this->user->getId(), $page, $perpage);
		$total = $userGuessService->getAttentionGuessCount($this->user->getId());
		$pages = multi_page($total, $perpage, $page);
		$request->setAttribute('guesses', $guesses);
		$request->setAttribute('total', $total);
		$request->setAttribute('pages', $pages);
		
		UserService::usersSet(ArrayUtil::colKeySet($guesses, 'user_id'));

		//分类信息
		$guessCategoryService = GuessServiceFactory::getGuessCategoryService();
		$guessCategory = $guessCategoryService->getAlls();
		$request->setAttribute('guessCategory', $guessCategory);		
		
		$request->assign('title', "我关注的竞猜");
		$seo = array(
				'title' => '我关注的竞猜',
				'description' => '',
				'keywords' => ''
		);
		$request->assign('seo', $seo);
		$request->assign('attentionClass', 'class="sel"');
		$this->setView('my');
	}
	
	public function friend(HttpRequest $request){
		$this->common($request);
	
		$userGuessService = GuessServiceFactory::getUserGuessService();
		$page = getPage();
		$perpage = 5;
		$guesses = $userGuessService->getFriendGuesses($this->user->getId(), $page, $perpage);
		$total = $userGuessService->getFriendGuessCount($this->user->getId());
		
		$pages = multi_page($total, $perpage, $page);
		$request->setAttribute('guesses', $guesses);
		$request->setAttribute('total', $total);
		$request->setAttribute('pages', $pages);
	
		UserService::usersSet(ArrayUtil::colKeySet($guesses, 'user_id'));

		//分类信息
		$guessCategoryService = GuessServiceFactory::getGuessCategoryService();
		$guessCategory = $guessCategoryService->getAlls();
		$request->setAttribute('guessCategory', $guessCategory);
				
		$request->assign('title', "我好友的竞猜");
		$seo = array(
				'title' => '我好友的竞猜',
				'description' => '',
				'keywords' => ''
		);
		$request->assign('seo', $seo);
		$request->assign('friendClass', 'class="sel"');
		$this->setView('my');
	}
	
	
	
	public function invite(HttpRequest $request){
		$this->common($request);
		$userGuessService = GuessServiceFactory::getUserGuessService();
		$page = getPage();
		$perpage = 5;
		$guesses = $userGuessService->getInviteGuesses($this->user->getId(), $page, $perpage);
		$total = $userGuessService->getInviteGuessCount($this->user->getId());
		$pages = multi_page($total, $perpage, $page);
		$request->setAttribute('guesses', $guesses);
		$request->setAttribute('total', $total);
		$request->setAttribute('pages', $pages);
		
		UserService::usersSet(ArrayUtil::colKeySet($guesses, 'user_id'));

		//分类信息
		$guessCategoryService = GuessServiceFactory::getGuessCategoryService();
		$guessCategory = $guessCategoryService->getAlls();
		$request->setAttribute('guessCategory', $guessCategory);
				
		$request->assign('title', "邀请我的竞猜");
		$seo = array(
				'title' => '邀请我的竞猜',
				'description' => '',
				'keywords' => ''
		);
		$request->assign('seo', $seo);
		$request->assign('inviteClass', 'class="sel"');
		$this->setView('my');
	}
	
	private function common(HttpRequest $request){
		//随机获取用户
		$userService = MemberServiceFactory::getUserService();
		$userList = $userService->getRandUsers(5);
		
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
		
		$request->setAttribute('userList', $userList);
		$request->setAttribute('hidePlacard', $hidePlacard);
		$request->setAttribute('guessNewCount', $guessNewCount);
		$request->setAttribute('guessAddCount', $guessAddCount);
		$request->setAttribute('guessPlayCount', $guessPlayCount);
		$request->setAttribute('inviteGuessCount', $inviteGuessCount);
		$request->setAttribute('attentionGuessCount', $attentionGuessCount);
		$request->setAttribute('friendGuessCount', $friendGuessCount);
		$request->setAttribute('totalGuessCount', $totalGuessCount);
		
		UserService::usersAdd(array("{$this->user->getId()}"=>array('id'=>$this->user->getId(), 'name'=>$this->user->getName())));
	}
}