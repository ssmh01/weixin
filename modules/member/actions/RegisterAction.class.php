<?php

/**
 * 用户注册
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - Jan 4, 2013
 */
class RegisterAction extends Action{
	
	/**
	 * 转向注册界面
	 */
	public function index(HttpRequest $request){
		//TODO
		$seo = array(
			'title' => '用户注册',
			'description'=>'',
			'keywords'=>'',
		);
		$request->assign('seo', $seo);
		$this->setView('register');
	}
	
	public function register(HttpRequest $request){
		$name = $request->getParameter('name');
		$email = $request->getParameter('email');
		$password = $request->getParameter('password');
		$repassword = $request->getParameter('repassword');
		$verificationCode = $request->getParameter('code');
		$inviteCode = $request->getParameter('yqcode');
		if(empty($name) || empty($password)){
			show_message('用户名或密码不能为空');
		}
		
		if($password != $repassword){
			show_message('两次输入的密码不一致!');
		}
		if(!String::test(String::REGEX_EMAIL, $email)){
			show_message('请输入正确的邮箱!');
		}
		$verificationCodeService = MemberServiceFactory::getVerificationCodeService();
		if(!$verificationCodeService->verify($verificationCode)){
			show_message('验证码不对!');
		}
		$userService = MemberServiceFactory::getUserService();
		if($userService->nameExists($name)){
			show_message('用户已存在，请更换用户名!');
		}
		if($userService->emailExists($email)){
			show_message('邮箱已存在，请更换邮箱!');
		}
		$user = new User();
		$user->setName($name);
		$user->setEmail($email);
		$user->setPassword($password);
		$success = $userService->register($user);
		if(!$success){
			show_message('注册失败，请稍后重试!');
		}
		if(R::getConfig()->getConfig('invite_open') && $inviteCode){
			$inviteUserId = $userService->codeToId($inviteCode);
			//扣除金额
			$inviteIntegral = R::getConfig()->getConfig('integral_invite');
			if($inviteIntegral){
				$inviter = $userService->get($inviteUserId);
				$io = array(
						'from_user_id'=>0,
						'to_user_id'=>$inviter->getId(),
						'to_title'=>"邀请用户[{$user->getName()}]",
						'wealth_type'=>Io::WEALTH_TYPE_INTEGRAL,
						'wealth'=>$inviteIntegral,
						'to_balance'=>$inviter->getAvailableIntegral() + $inviteIntegral
				);
				$userService->integral($io);
			}
			$invite = array(
					'inviter_id'=>$inviteUserId,
					'invitee_id'=>$user->getId(),
					'recharge_percent'=>R::getConfig()->getConfig('recharge_inviter_reward'),
					'integral'=>R::getConfig()->getConfig('integral_invite'),
					'create_time'=>$request->getRequestTime()
					);
			$inviteDao = MD('Invite');
			$inviteDao->add($invite);
		}
		//自动登陆
		$userService->login($name, $password);
		//转向注册成功引导页面
		show_message('注册成功，正在跳转...');
	}
}

?>