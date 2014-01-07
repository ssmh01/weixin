<?php

/**
 * 后台权限过滤器
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-01
 */
class AdminOpPermissionFilter implements ModuleFilter{
	
	/*
	 * @see ModuleFilter::doFilter()
	 */
	public function doFilter(Module $module, HttpRequest $request){
		$actionMapping = $request->getAction()->getActionMapping();
		$operation = new Operation($actionMapping->getModule(), $actionMapping->getAction(), $actionMapping->getMethod());
		
		//先判断是否登陆
		$managerService = AdminServiceFactory::getManagerService();
		$notLoginCheckActions = array('login', 'message', 'logout');
		if(!in_array($operation->getAction(), $notLoginCheckActions) && !$managerService->isLogin()){
			header("location:".url('/admin/login'));
		}
		$operationService = AdminServiceFactory::getAdminOperationService();
		//检查权限
		if(!$operationService->hasPermission($operation,  HttpSession::get(ManagerService::SESSION_MANAGER))){
			show_message(get_lang('no_permission'));
			die();
		}
	}
}