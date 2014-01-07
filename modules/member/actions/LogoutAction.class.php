<?php

/**
 * 用户退出
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - Jan 4, 2013
 */
class LogoutAction extends CommonAction{
	
	/**
	 * 用户退出
	 */
	public function index(HttpRequest $request){
		$userService = MemberServiceFactory::getUserService();
		$user = $userService->getCurrentUser();
		if($user){
			$userService->logout($user);
		}
		$request->redirect('/');
	}
}

?>