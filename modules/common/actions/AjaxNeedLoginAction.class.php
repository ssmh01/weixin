<?php

/**
 * Ajax请求需用户登录的Action
 * 
 * @author blueyb.java@gmail.com
 */
abstract class AjaxNeedLoginAction extends NeedLoginAction{
	
	public function __construct(){
		$this->loginCheck(true);
		$userService = MemberServiceFactory::getUserService();
		$this->user = $userService->getCurrentUser();
		R::getRequest()->assign('user', $this->user);
	}
}

?>