<?php

/**
 * 用户登陆
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - Jan 4, 2013
 */
class LoginAction extends CommonAction{
	
	private static $WEIBO_LOGIN_CALLBACK_URL = '';
	
	public function __construct(){
		self::$WEIBO_LOGIN_CALLBACK_URL = R::getConfig()->getConfig('site_url') . '/member/login/auth/';
	}
		
	/**
	 * 转向登陆界面
	 */
	public function index(HttpRequest $request){
		if(MemberServiceFactory::getUserService()->isLogin()){
			$request->redirect('/member/setting/');
		}
		//TODO
		$seo = array(
				'title' => '用户登陆',
				'description'=>'',
				'keywords'=>'',
		);
		$request->assign('seo', $seo);
		$this->setView('login');
	}
	
	/**
	 * 登陆
	 * @param HttpRequest $request
	 */
	public function login(HttpRequest $request){
		$account = $request->getParameter('account');
		$password = $request->getParameter('password');
		$userService = MemberServiceFactory::getUserService();
		$loginflag = $userService->login($account, $password);
		
		if($loginflag == 0){
			show_message('登录失败，账户名或密码不正确!');
		}
		elseif($loginflag == -1){
			show_message('该用户已禁止登录!');
		}
		$request->redirect('/');
	}
	
	/**
	 * APP登录
	 * @param HttpRequest $request
	 */
	public function app(HttpRequest $request){
		//获取该微博信息
		$id = $request->getParameter('id');
		if(empty($id)){
			show_message('请选择要登录的微博类型!');
		}
		$weiboDao = MD('Weibo');
		$weibo = $weiboDao->get($id);
		if(empty($weibo)){
			show_message('登录微博不存在!');
		}
		if(!$weibo['status']){
			show_message('登录微博已停止使用!');
		}
		include(EXT_LIB_ROOT . 'weibo/WeiboService.php');
		//构造认证参数
		$weiboParam = new WeiboParam($weibo['type'], $weibo['app_key'], $weibo['app_secret'], self::$WEIBO_LOGIN_CALLBACK_URL);
		$weiboService = WeiboService::getService($weibo['type']);
		if(!$weiboService){
			show_message("很抱歉，暂不支持该类型的微博登录服务！");
		}
		HttpSession::set('weibo_bind_id', $id);
		$weiboService->auth($weiboParam);
		die();
	}
	
	/**
	 * 登录认证
	 * @param HttpRequest $request
	 */
	public function auth(HttpRequest $request){
		
		//获取该微博信息
		$weiboBindId = HttpSession::get('weibo_bind_id');
		$weiboDao = MD('Weibo');
		$weibo = $weiboDao->get($weiboBindId);
		if(empty($weibo)){
			show_message('登录微博不存在!');
		}
		if(!$weibo['status']){
			show_message('微博已停止使用!');
		}
		 
		include(EXT_LIB_ROOT . 'weibo/WeiboService.php');
		//构造认证参数
		$weiboParam = new WeiboParam($weibo['type'], $weibo['app_key'], $weibo['app_secret'], self::$WEIBO_LOGIN_CALLBACK_URL);
		$weiboService = WeiboService::getService($weibo['type']);
		if(!$weiboService){
			show_message("很抱歉，暂不支持该类型的微博登录服务！");
		}
		$authResult = $weiboService->authCallBack($weiboParam);
		if($authResult->isSuccess()){ //登录成功
			
			//获取返回信息
			$result = $authResult->getResult();
			
			//检测是否绑定帐号
			$result_uid = $result['authResult']['uid'];
			$bindDao = MD('Bind');
			$conditions = array('account'=>$result_uid, 'weibo_id'=>$weiboBindId);
			$bindInfo = $bindDao->getOne($conditions);
			
			//序列化
			$result['type'] = $weibo['type'];
			$result = serialize($result);			
			
			if($bindInfo) //已绑定
			{
				//更新信息
				$bind = array('datas'=>$result, 'create_time'=>$request->getRequestTime());
				$bindDao->update($bind, $bindInfo['id']);
				
				//登录
				$userDao = MD('user');
				$u = $userDao->getOne(array('id'=>$bindInfo['user_id']), 'name');
				$account = $u['name'];
				$userService = MemberServiceFactory::getUserService();
				$userService->loginFromAdmin($account);
				
				//跳转
				$request->redirect(R::getConfig()->getConfig('site_url'));
				
			}
			else
			{
				$weibo_id = $weiboBindId;
				$account = $result_uid;
				$datas = base64_encode($result);
				
				$request->assign('weibo_id', $weibo_id);
				$request->assign('account', $account);
				$request->assign('datas', $datas);
				
				//显示绑定与注册帐号页面
				$seo = array(
						'title' => '绑定帐号',
						'description'=>'',
						'keywords'=>'',
				);
				$request->assign('seo', $seo);
				$this->setView('loginapp');				
			}
		}
		else {
			show_message('登录失败');
		}
	}

	/**
	 * 绑定操作
	 */
	public function bind(HttpRequest $request)
	{
		$type = $request->getParameter('type');
		$weibo_id = $request->getParameter('weibo_id');
		$datas = $request->getParameter('datas');
		$account = $request->getParameter('account');
		$datas = base64_decode($datas);
		$bindDao = MD('Bind');
				
		if($type == 'bind') //绑定
		{
			$bind_name = $request->getParameter('bind_name');
			$bind_password = $request->getParameter('bind_password');
			$userService = MemberServiceFactory::getUserService();
			$user = $userService->login($bind_name, $bind_password);
			if($user) //用户名密码正确
			{
				$bind = array('user_id'=>$user->getId(), 'weibo_id'=>$weibo_id, 'account'=>$account, 'datas'=>$datas, 'create_time'=>$request->getRequestTime());
				$bindDao->add($bind);
				$request->redirect('/');
			}
			else 
			{
				show_message('帐号或密码不正确，请返回重新填写!',R::getConfig()->getConfig('site_url'));
			}
		}
		elseif($type == 'register') //注册
		{
			$register_name = $request->getParameter('register_name');
			$register_password = $request->getParameter('register_password');
			$register_email = $request->getParameter('register_email');
			
			if(!String::test(String::REGEX_EMAIL, $register_email)){
				show_message('请输入正确的邮箱!', R::getConfig()->getConfig('site_url'));
			}
			
			$userService = MemberServiceFactory::getUserService();
			if($userService->nameExists($register_name)){
				show_message('用户已存在，请更换用户名!', R::getConfig()->getConfig('site_url'));
			}
			if($userService->emailExists($register_email)){
				show_message('邮箱已存在，请更换邮箱!', R::getConfig()->getConfig('site_url'));
			}
			$user = new User();
			$user->setName($register_name);
			$user->setEmail($register_email);
			$user->setPassword($register_password);
			$success = $userService->register($user);
			if(!$success){
				show_message('注册失败，请稍后重试!', R::getConfig()->getConfig('site_url'));
			}			
			
			//登录
			$user = $userService->login($register_name, $register_password);
			
			//绑定
			$bind = array('user_id'=>$user->getId(), 'weibo_id'=>$weibo_id, 'account'=>$account, 'datas'=>$datas, 'create_time'=>$request->getRequestTime());
			$bindDao->add($bind);
			
			//跳转
			$request->redirect('/');			
		}		
	}
}

?>