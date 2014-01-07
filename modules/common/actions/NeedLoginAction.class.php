<?php

/**
 * 需用户登录的Action
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - Jan 8, 2013
 */
abstract class NeedLoginAction extends CommonAction{
	
	/**
	 * 当前登陆的用户
	 * @var User
	 */
	protected $user;
	
	public function __construct(){
		$this->loginCheck();
		$userService = MemberServiceFactory::getUserService();
		$this->user = $userService->getCurrentUser();
		R::getRequest()->assign('user', $this->user);
	}
}

?>