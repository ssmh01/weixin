<?php
/**
 * 分享
 * @author blueyb.java@gmail.com
 */
class ShareAction extends UserCenterAction{
	private static $WEIBO_AUTH_CALLBACK_URL = '';
	public function __construct(){
		parent::__construct();
		self::$WEIBO_AUTH_CALLBACK_URL = R::getConfig()->getConfig('site_url') . '/member/weibo/auth/';
	}
	public function index(HttpRequest $request){
		$this->guess($request);
	}
	
	/**
	 * 分享竞猜
	 * 
	 * @param HttpRequest $request        	
	 */
	public function guess(HttpRequest $request){
		// 获取用户的绑定信息
		$bindDao = MD('Bind');
		$conditions = array(
			'user_id' => $this->user->getId()
		);
		$binds = $bindDao->gets($conditions);
		if(empty($binds)){
			show_message('你需要先绑定至少一个微博!');
		}
		
		$id = $request->getParameter('id');
		if(empty($id)){
			show_message('请选择要分享的竞猜!');
		}
		$guessDao = MD("Guess");
		$guess = $guessDao->get($id);
		if(empty($guess)){
			show_message('要分享的竞猜不存在');
		}
		if($request->isPost()){
			$message = $request->getParameter('message');
			if(!$message){
				show_message('请填写分享内容!');
			}
			// 分享到绑定的微博
			$shareService = MemberServiceFactory::getShareService();
			foreach($binds as $bind){
				$shareService->share($message, $bind);
			}
			//查看分享记录
			$shareDao = MD('Share');
			$conditions = array('type'=>Share::TYPE_GUESS, 'user_id'=>$this->user->getId(), 'share_id'=>$guess['id']);
			$share = $shareDao->getOne($conditions);
			if(!$share){
				//第一次分享，记录分享信息
				$share = array('type'=>Share::TYPE_GUESS, 'user_id'=>$this->user->getId(), 'share_id'=>$guess['id'], 'create_time'=>$request->getRequestTime());
				$success = $shareDao->add($share);
				if($success){
					// 赠送积分
					$integralShare = intval(R::getConfig()->getConfig('integral_share'));
					if($integralShare > 0){
						$io = array(
								'to_user_id' => $this->user->getId(),
								'from_user_id' => 0,
								'to_title' => "分享竞猜[{$guess['title']}]",
								'wealth_type' => Io::WEALTH_TYPE_INTEGRAL,
								'wealth' => $integralShare,
								'to_balance' => $this->user->getAvailableIntegral() + $integralShare
						);
						$userService = MemberServiceFactory::getUserService();
						$userService->integral($io);
					}
				}
			}else{
				$integralShare = 0;
			}
			AjaxResult::closeAjaxWindow("分享成功，你获取了{$integralShare}积分，窗口正在关闭...");
		}else{
			$shareMessage = "{$guess['title']} （" . R::getConfig()->getConfig('site_name') . '） ' . R::getConfig()->getConfig('site_url') . "/guess/view/?id={$guess['id']}";
			$request->assign('guess', $guess);
			$request->assign('shareMessage', $shareMessage);
			$this->setView('share_guess');
		}
	}
}