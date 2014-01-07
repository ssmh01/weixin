<?php

/**
 * 公共Action
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - Jan 8, 2013
 */
abstract class CommonAction extends Action{
	
	/**
	 * 登陆检查
	 * @param boolean $ajax 是否是Ajax请求模式
	 */
	protected function loginCheck($ajax=false){
		if(!$this->isLogin()){
			if($ajax){
				AjaxResult::ajaxResult(0, '你需要先登陆才能继续操作!');
			}else{
				R::getRequest()->redirect('/member/login/');
			}
		}
	}
	
	/**
	 * 是否已经登陆
	 * @return boolean
	 */
	protected function isLogin(){
		$userService = MemberServiceFactory::getUserService();
		return $userService->isLogin();
	}
}

?>