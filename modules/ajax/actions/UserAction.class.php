<?php

/**
 * 用户ajax请求
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - Jan 18, 2013
 */
class UserAction extends CommonAction{
	
	/**
	 * 用户名检查
	 */
	public function nameCheck(HttpRequest $request){
		$name = $request->getParameter('name');
		$userService = MemberServiceFactory::getUserService();
		if($userService->nameExists($name)){
			AjaxResult::ajaxResult(0, '用户名已被使用');
		}else{
			AjaxResult::ajaxResult(1, '用户名可用');
		}
	}
	/**
	 * 邮箱检查
	 */
	public function emailCheck(HttpRequest $request){
		$email = $request->getParameter('email');
		$userService = MemberServiceFactory::getUserService();
		if($userService->emailExists($email)){
			AjaxResult::ajaxResult(0, '邮箱已被使用');
		}else{
			AjaxResult::ajaxResult(1, '邮箱可用');
		}
	}
}

?>