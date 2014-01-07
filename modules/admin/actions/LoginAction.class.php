<?php
/**
 * 职员登录
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-07-31
 */
class LoginAction extends AbstractAdminAction{
	
    /**
     * 登录界面
     * @param HttpRequest $request
     */
    public function index(HttpRequest $request){
    	//背景色
    	$background = HttpCookie::get("admin_background") ? HttpCookie::get("admin_background") : "body_KK_Manage1";
    	$request->assign('background', $background);
    	$request->assign('iscaptcha', 0);
    	$request->assign('currentAction', "login");
    	$request->assign('title', "请先登陆");
        
        $this->setView('login');
    }

    /**
     * 登录
     *
     * @param HttpRequest $request
     */
    public function signin(HttpRequest $request){
        if($this->iscaptcha){
            $captchaText = trim($request->getParameter('captcha'));
            empty($captchaText) && show_message('请填写验证码');
            !checkCaptcha($captchaText) && show_message('验证码错误');
        }

        $username = $request->getParameter('name');
        $password = $request->getParameter('password');
        
        $managerService = AdminServiceFactory::getManagerService();
        $manager = $managerService->login($username, $password);
        if($manager){
        	//登陆成功
        	HttpSession::set(ManagerService::SESSION_MANAGER_ID, $manager['id']);
        	HttpSession::set(ManagerService::SESSION_MANAGER, $manager);
        	header("location:".url('/admin/index/'));
        }else{
        	//登陆失败
        	show_message('login_failure');
        }
    }
}