<?php
/**
 * 微博绑定
 * @author blueyb.java@gmail.com
 */
class WeiboAction extends UserCenterAction{
	
	private static $WEIBO_AUTH_CALLBACK_URL = '';
	
	public function __construct(){
		parent::__construct();
		self::$WEIBO_AUTH_CALLBACK_URL = R::getConfig()->getConfig('site_url') . '/member/weibo/auth/';
	}
	
	public function index(HttpRequest $request){
		//获取所有的微博
		$weiboDao = MD('Weibo');
		$conditions = array('status'=>'1');
		$weibos = $weiboDao->gets($conditions, null, array('sort_num'=>'desc'));
		
		//获取用户的绑定信息
		$bindDao = MD('Bind');
		$conditions = array('user_id'=>$this->user->getId());
		$binds = $bindDao->gets($conditions);
		$binds = ArrayUtil::changeKey($binds, 'weibo_id');
		
		$seo = array(
				'title' => '微博绑定',
				'description' => '',
				'keywords' => ''
		);
		$request->assign('weibos', $weibos);
		$request->assign('binds', $binds);
		$request->assign('seo', $seo);
		$this->setView('weibo');
	}
	
	/**
	 * 绑定
	 * @param HttpRequest $request
	 */
	public function bind(HttpRequest $request){
		$request->setParameter('inajax', '1');
		//获取该微博信息
		$id = $request->getParameter('id');
		if(empty($id)){
			show_message('请选择要绑定的微博!');
		}
		$weiboDao = MD('Weibo');
		$weibo = $weiboDao->get($id);
		if(empty($weibo)){
			show_message('要绑定的微博不存在!');
		}
		if(!$weibo['status']){
			show_message('要绑定的微博已停止使用!');
		}
		include(EXT_LIB_ROOT . 'weibo/WeiboService.php');
		//构造认证参数
		$weiboParam = new WeiboParam($weibo['type'], $weibo['app_key'], $weibo['app_secret'], self::$WEIBO_AUTH_CALLBACK_URL);
		$weiboService = WeiboService::getService($weibo['type']);
		if(!$weiboService){
			show_message("很抱歉，暂不支持该类型的微博绑定服务！");
		}
		HttpSession::set('weibo_bind_id', $id);
		$weiboService->auth($weiboParam);
		die();
	}
	
	/**
	 * 绑定认证
	 * @param HttpRequest $request
	 */
	public function auth(HttpRequest $request){
		$request->setParameter('inajax', '1');
		//获取该微博信息
    	$weiboBindId = HttpSession::get('weibo_bind_id');
		$weiboDao = MD('Weibo');
		$weibo = $weiboDao->get($weiboBindId);
		if(empty($weibo)){
			show_message('要绑定的微博不存在!');
		}
		if(!$weibo['status']){
			show_message('要绑定的微博已停止使用!');
		}
    	
    	include(EXT_LIB_ROOT . 'weibo/WeiboService.php');
		//构造认证参数
		$weiboParam = new WeiboParam($weibo['type'], $weibo['app_key'], $weibo['app_secret'], self::$WEIBO_AUTH_CALLBACK_URL);
		$weiboService = WeiboService::getService($weibo['type']);
    	if(!$weiboService){
    		show_message("很抱歉，暂不支持该类型的微博绑定服务！");
    	}
    	$authResult = $weiboService->authCallBack($weiboParam);
    	if(!$authResult->isSuccess()){
    		show_message("很抱歉，微博绑定服务失败！");
    	}
    	//保存绑定结果
    	$result = $authResult->getResult();
    	$result_uid = $result['authResult']['uid'];
    	$result['type'] = $weibo['type']; 
    	$result = serialize($result);
    	$bindDao = MD('Bind');
       	$bind = array('user_id'=>$this->user->getId(), 'weibo_id'=>$weibo['id'], 'account'=>$result_uid, 'datas'=>$result, 'create_time'=>$request->getRequestTime());
    	$conditions = array('user_id'=>$this->user->getId(), 'weibo_id'=>$weiboBindId);
    	$oldBind = $bindDao->getOne($conditions);
    	if($oldBind){
    		//更新
    		$success = $bindDao->update($bind, $oldBind['id']);
    	}else{
    		//添加
    		$success = $bindDao->add($bind);
    	}
    	if($success){
    		$message = "微博绑定成功，正在刷新页面...<script>setTimeout(function(){parent.close();parent.opener.bindSuccess()}, 2000)</script>";
    	}else{
    		$message = "微博绑定失败";
    	}
    	show_message($message);
	}
	
	/**
	 * 取消绑定
	 * @param HttpRequest $request
	 */
	public function unbind(HttpRequest $request){
		//获取该微博的绑定信息
		$id = $request->getParameter('id');
		if(empty($id)){
			show_message('请选择要取消绑定的微博!');
		}
		$bindDao = MD('Bind');
		$conditions = array('user_id'=>$this->user->getId(), 'weibo_id'=>$id);
		$bind = $bindDao->getOne($conditions);
		if($bind){
			$success = $bindDao->delete($bind['id']);
		}
		if($success){
			$message = "取消绑定成功!<script>unBindSuccess();</script>";
		}else{
			$message = "取消微博绑定失败";
		}
		show_message($message);
	}
	
}