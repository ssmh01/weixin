<?php
/**
 * 充值
 * @author blueyb.java@gmail.com
 */
class RechargeAction extends UserCenterAction{
	
	/**
	 * 支付回调
	 * @var string
	 */
	private $callback = null;
	
	public function __construct(){
		parent::__construct();
		$this->callback = R::getConfig()->getConfig('stie_url') . '/member/pay/';
	}
	
	public function index(HttpRequest $request){
		if($request->isPost()){
			$money = intval($request->getParameter('money'));
			$payType = $request->getParameter('pay_type');
			$code = $request->getParameter('code');
			if(!$code){
				show_message("验证码不能为空!");
			}
			$verificationCodeService = MemberServiceFactory::getVerificationCodeService();
			if(!$verificationCodeService->verify($code)){
				show_message('验证码不对!');
			}
			
			$rechargeService = MemberServiceFactory::getRechargeService();
			
			// 充值记录
			$recharge = array(
				'sn' => $rechargeService->createSn(),
				'user_id' => $this->user->getId(),
				'money' => $money,
				'pay_type' => $payType,
				'status' => '0',
				'create_time' => $request->getRequestTime()
			);
			if(!$rechargeService->recharge($recharge)){
				show_message('充值失败!');
			}
			
			include_once (EXT_LIB_ROOT . '/payment/Payment.php');
			// 收集公共的请求参数,公共请求参数列表请参考payment_common_parameter.php文件或调用
			// PaymentUtil::getRequestCommonParameter(),该函数返回一个数组
			$requestParameter = array(
				// 基本参数
				'payment_charset' => 'utf-8', // 可以为空,如果为空,则使用配置中
				'payment_sign_type' => 'MD5', // 可以为空,如果为空,则使用配置中
				'payment_asyn_url' => $this->callback,
				'payment_sync_url' => $this->callback,
				// 业务参数
				'payment_out_trade_no' => $recharge['sn'],
				'payment_payment_type' => '1',
				'payment_money_type' => 'CNY',
				'payment_subject' => '会员充值',
				'payment_total_fee' => $recharge['money'],
				'payment_body' => '金币充值,一元等于一金币'
			);
			try{
				// 创建与支付类型对应的支付类
				$payment = Payment::getInstance($payType);
				// 调用支付方法
				$payment->pay($requestParameter);
			}catch(Exception $e){
				$message = $e->getMessage();
				if(!$message){
					$message = "充值失败";
				}
				show_message($message);
			}
			die();
		}else{
			$this->setView('recharge_index');
		}
	}
	public function history(HttpRequest $request){
		$conditions = " user_id = '{$this->user->getId()}'";
		$orders = array(
			'create_time' => 'desc'
		);
		$page = getPage();
		$perpage = 5;
		$rechargeDao = MD('Recharge');
		$items = $rechargeDao->gets($conditions, $gets, $orders, $page, $perpage);
		$total = $rechargeDao->count($conditions);
		$pages = multi_page($total, $perpage, $page);
		
		$request->setAttribute('items', $items);
		$request->setAttribute('total', $total);
		$request->setAttribute('pages', $pages);
		
		$seo = array(
			'title' => '充值记录',
			'description' => '',
			'keywords' => ''
		);
		$request->assign('seo', $seo);
		$this->setView('recharge_history');
	}
	
	/**
	 * 支付
	 * @param HttpRequest $request
	 */
	public function pay(HttpRequest $request){
		$id = $request->getParameter('id');
		if(!$id){
			show_message('请选择要支付的充值');
		}
		$rechargeDao = MD('Recharge');
		$recharge = $rechargeDao->get($id);
		if(!$recharge){
			show_message('要支付的充值不存在');
		}
		if($recharge['user_id'] != $this->user->getId()){
			show_message('非法操作');
		}
		if($recharge['status']){
			show_message('充值已支付成功，不需要重复支付');
		}
		include_once (EXT_LIB_ROOT . '/payment/Payment.php');
		// 收集公共的请求参数,公共请求参数列表请参考payment_common_parameter.php文件或调用
		// PaymentUtil::getRequestCommonParameter(),该函数返回一个数组
		$requestParameter = array(
				// 基本参数
				'payment_charset' => 'utf-8', // 可以为空,如果为空,则使用配置中
				'payment_sign_type' => 'MD5', // 可以为空,如果为空,则使用配置中
				'payment_asyn_url' => $this->callback,
				'payment_sync_url' => $this->callback,
				// 业务参数
				'payment_out_trade_no' => $recharge['sn'],
				'payment_payment_type' => '1',
				'payment_money_type' => 'CNY',
				'payment_subject' => '会员充值',
				'payment_total_fee' => $recharge['money'],
				'payment_body' => '金币充值,一元等于一金币'
		);
		try{
			// 创建与支付类型对应的支付类
			$payment = Payment::getInstance($recharge['pay_type']);
			// 调用支付方法
			$payment->pay($requestParameter);
		}catch(Exception $e){
			$message = $e->getMessage();
			if(!$message){
				$message = "支付失败";
			}
			show_message($message);
		}
		die();
	}
}