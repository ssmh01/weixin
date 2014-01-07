<?php
/**
 * 管理员预览
 * @author blueyb.java@gmail.com
 */
class AdminReviewAction extends Action{
	
	public function index(HttpRequest $request){
		//先判断是否登陆
		$managerService = AdminServiceFactory::getManagerService();
		if(!$managerService->isLogin()){
			header("location:".url('/admin/login'));
		}
		
		//获取竞猜
		$id = $request->getParameter('id');
		if(empty($id)){
			show_message('请选择要预览竞猜!');
		}
		$guessService = GuessServiceFactory::getGuessService();
		$guess = $guessService->get($id, true);
		if(!$guess){
			show_message('竞猜不存在，请确认!');
		}
		//从后台为用户登录
		$userService = MemberServiceFactory::getUserService();
		$user = $userService->loginFromAdmin($guess->getUser()->getName());
		$request->setAttribute('user', $user);
		
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
		$time = $guess->getPlayDeadline() - time();
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
		$request->setAttribute('guessDay', $guessDay);
		$request->setAttribute('guessHour', $guessHour);
		$request->setAttribute('guessMinute', $guessMinute);
		$request->setAttribute('guess', $guess);
		
		//获取参与的用户
		$playDao = MD('Play');
		$playUserIds = $playDao->gets(array('guess_id'=>$id), 'user_id', array('create_time'=>'desc'), 1, 6);
		if($playUserIds){
			$playUserIds = ArrayUtil::colKeySet($playUserIds, 'user_id', true);
			$userService = MemberServiceFactory::getUserService();
			$playUsers = $userService->gets("id in ($playUserIds)");
			$request->setAttribute('userList', $playUsers);
		}
		
		$seo = array(
				'title' => $guess->getTitle(),
				'description' => '',
				'keywords' => ''
		);
		$request->setAttribute('seo', $seo);
		if($guess->getCustom()){
			$this->setView('custom_adminreview');
		}else{
			$this->setView('adminreview');
		}
	}
}