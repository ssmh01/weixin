<?php
/**
 * 修改密码
 * @author blueyb.java@gmail.com
 */
class PasswordAction extends CommonAction{
	
	public function index(HttpRequest $request){
		$this->loginCheck();
		$seo = array(
				'title' => '修改密码',
				'description'=>'',
				'keywords'=>'',
		);
		$request->assign('seo', $seo);
		$this->setView('member_password');
	}
	
	public function findAccount(HttpRequest $request){
		$this->findCheck();
		$seo = array(
				'title' => '找回密码-输入账号',
				'description'=>'',
				'keywords'=>'',
		);
		$request->setAttribute('account', $request->getParameter('account'));
		$request->assign('seo', $seo);
		$this->setView('password_find_account');
	}
	
	public function findEmail(HttpRequest $request){
		$this->findCheck();
		$account = urldecode($request->getParameter('account'));
		if(!$account){
			show_message('账号不能为空', '/member/password/findAccount/');
		}
		$user = MD('User')->getOne(array('name'=>$account));
		if(!$user){
			show_message('账号不存在，请确认', '/member/password/findAccount/');
		}
		if(!$user['email']){
			show_message('该账号没有设置邮箱，不能使用找回密码功能');
		}
		//发送邮件
		$emailService = CommonServiceFactory::getEmailService();
		$code = md5(rand());
		
		//$url = CommonServiceFactory::getConfigService()->get('site_url') . '/member/password/findReset/?code=' . $code;
		$url = R::getConfig()->getConfig('site_url') . '/member/password/findReset/?code=' . $code;
		$params = array('account'=>$user['name'], 'url'=>$url);
		if(!$emailService->sendWithTemplate($user['name'], $user['email'], 'find_password_email', array('account'=>$user['name'], 'url'=>$url))){
			show_message('发送邮件失败，请重试或联系管理员', '/member/password/findAccount/?account='.$account);
		}
		//生成链接记录
		$passwordFindDao = MD('PasswordFind');
		$passwordFind = array(
			'user_id'=>$user['id'],
			'code'=>$code,
			'deadline'=>time() + 1800,
		);
		$passwordFindDao->add($passwordFind);
		$seo = array(
				'title' => '找回密码-发送重置链接',
				'description'=>'',
				'keywords'=>'',
		);
		$request->assign('account', $account);
		$request->assign('seo', $seo);
		$this->setView('password_find_email');
	}
	
	public function findReset(HttpRequest $request){
		$this->findCheck();
		$code = trim($request->getParameter('code'));
		if(!$code){
			show_message('非法操作', '/');
		}
		$findPassword = MD('PasswordFind')->getOne(array('code'=>$code));
		if(!$findPassword){
			show_message('非法操作', '/');
		}
		if($request->isPost()){
			$password = trim($request->getParameter('password'));
			$userService = MemberServiceFactory::getUserService();
			if(!$userService->setPassword($findPassword['user_id'], $password)){
				show_message('密码重置失败,请重试!');
			}else{
				show_message('密码重置成功，请登陆', '/member/login/');
			}
		}else{
			$seo = array(
					'title' => '找回密码-重置密码',
					'description'=>'',
					'keywords'=>'',
			);
			$request->assign('code', $code);
			$request->assign('seo', $seo);
			$this->setView('password_find_reset');
		}
	}
	
	private function findCheck(){
		if($this->isLogin()){
			header("Location: /");
			//$request->redirect('/');
		}
	}
}