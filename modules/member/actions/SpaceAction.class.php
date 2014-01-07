<?php
/**
 * 用户列表
 * @author blueyb.java@gmail.com
 */
class SpaceAction extends UserCenterAction{
	public function index(HttpRequest $request){
		$this->common($request);
		$spaceUser = $request->getAttribute('spaceUser');
		// 获取竞猜
		$guessService = GuessServiceFactory::getGuessService();
		$conditions = array(
			'user_id' => $spaceUser->getId()
		);
		$order = array(
			'create_time' => 'desc'
		);
		$page = 1;
		$perpage = 2;
		$guesses = $guessService->gets($conditions, null, $order, $page, $perpage);
		
		$request->setAttribute('guesses', $guesses);
		
		//分类信息
		$guessCategoryService = GuessServiceFactory::getGuessCategoryService();
		$guessCategory = $guessCategoryService->getAlls();
		$request->setAttribute('guessCategory', $guessCategory);		
		
		$seo = array(
			'title' => "{$spaceUser->getName()}的个人主页",
			'description' => '',
			'keywords' => ''
		);
		$request->setAttribute('seo', $seo);
		$this->setView('space_index');
	}
	public function guess(HttpRequest $request){
		$this->common($request);
		// 获取竞猜
		$spaceUser = $request->getAttribute('spaceUser');
		$guessService = GuessServiceFactory::getGuessService();
		$conditions = array(
			'user_id' => $spaceUser->getId()
		);
		$order = array(
			'create_time' => 'desc'
		);
		$page = getPage();
		$perpage = 2;
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
		
		$seo = array(
			'title' => "{$spaceUser->getName()}的竞猜",
			'description' => '',
			'keywords' => ''
		);
		$request->setAttribute('seo', $seo);
		$this->setView('space_guess');
	}
	private function common(HttpRequest $request){
		// 获取空间用户
		$spaceUser = null;
		$userId = $request->getParameter('uid');
		$website = $request->getParameter('website');
		
		$userService = MemberServiceFactory::getUserService();

		if((!$userId && !$website) || $userId == $this->user->getId()){
			$spaceUser = $this->user;
		}else{
			if($userId)	$spaceUser = $userService->get($userId);
			if($website) $spaceUser = $userService->getOne(array('website'=>$website));
		}
		if(!$spaceUser){
			show_message('找不到用户主页');
		}
		
		// 获取用户列表
		/*
		$followService = MemberServiceFactory::getFollowService();
		$userList = $followService->getUserFollows($spaceUser->getId(), 1, 4);
		*/
		$userList = $userService->getUserFriend($spaceUser->getId(), 1, 4);
		
		UserService::usersAdd(array("{$spaceUser->getId()}"=>array('id'=>$spaceUser->getId(), 'name'=>$spaceUser->getName())));
		
		// 更新查看数
		$userService->addView($spaceUser->getId());
		
		$request->setAttribute('spaceUser', $spaceUser);
		$request->setAttribute('userList', $userList);
	}
}