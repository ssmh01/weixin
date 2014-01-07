<?php

/**
 * 后台首页Action
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-07-31
 */
class IndexAction extends AbstractAdminAction {

	/**
	 * 加载后台模板框架
	 */
	public function index(HttpRequest $request){
		$managerService = AdminServiceFactory::getManagerService();
		if(!$managerService->isLogin()){
			header("location:".url('/admin/login'));
		}
		$request->assign('title', '欢迎使用' . get_config('site_name'));
		$this->setView('index');
	}
}

?>