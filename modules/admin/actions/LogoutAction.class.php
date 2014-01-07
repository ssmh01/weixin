<?php
/**
 * 职员退出登录
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-07-31
 */
class LogoutAction extends AbstractAdminAction{
	
    public function index(HttpRequest $request){
    	$managerService = AdminServiceFactory::getManagerService();
        $managerService->logout();
        show_message('logout_success', url('/admin/login/'));
    }
}