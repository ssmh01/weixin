<?php

/**
 * 支付接口支付宝的实现类.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-08-18
 */

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "./lib/alipay_service.class.php");
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "./lib/alipay_notify.class.php");
class AlipayPayment extends Payment{
	
	/*
	 * @see Payment::getPaymentType()
	 */
	public function getPaymentType() {
		return 'alipay';
	}
	
	/*
	 * @see Payment::pay()
	 */
	public function pay($requestParameter) {
		//创建支付工具类
		$paymentUtil = new PaymentUtil();
		//创建与支付类型对应的参数转换,并转换参数
		$requestParameter = $paymentUtil->requestParameterTransform($this->getPaymentType(), $requestParameter);
		
		//获取合作者信息
		$partner = $this->getPartner();
		if(empty($partner)){
			throw new PaymentException("合作者信息不能为空", PaymentException::EX_CODE_PAYMENT_GET_PARTNER_ERROR, $this->getPaymentType());
		}
		//根据合作者信息创建支付宝合作者信息数组
		$aliapyConfig = array(
			'partner'=>$partner->getId(),
			'key'=>$partner->getKey(),
			'seller_email'=>$partner->getAccount()
		);
		//把合作者信息添加到请求参数中
		$requestParameter['partner'] = $aliapyConfig['partner'];
		$requestParameter['seller_email'] = $aliapyConfig['seller_email'];
		//参数校正
		$paymentConfig = $this->getConfig();
		if(empty($requestParameter['sign_type'])){
			$requestParameter['sign_type'] = $paymentConfig->getSign();
		}
		$aliapyConfig['sign_type'] = $requestParameter['sign_type'];
		if(empty($requestParameter['_input_charset'])){
			$requestParameter['_input_charset'] = $paymentConfig->getCharset();
		}
		if(empty($requestParameter['transport'])){
			$requestParameter['transport'] = $paymentConfig->getTransport();
		}
		if(empty($requestParameter['service'])){
			$requestParameter['service'] = 'create_partner_trade_by_buyer';// 'create_direct_pay_by_user';
		}
		if(empty($requestParameter['payment_type'])){
			//1代表购买
			$requestParameter['payment_type'] = '1';
		}
		
        //物流信息
        empty($requestParameter['logistics_fee']) && $requestParameter['logistics_fee'] = '0.00';
        empty($requestParameter['logistics_type']) && $requestParameter['logistics_type'] = 'EXPRESS';
        empty($requestParameter['logistics_payment']) && $requestParameter['logistics_payment'] = 'SELLER_PAY';

        $this->setRequestParameter($requestParameter);
        
		//创建支付宝服务类
		$alipayService = new AlipayService($aliapyConfig);
		//调用即时支付接口
		$htmlText = $alipayService->create_direct_pay_by_user($requestParameter);
		echo $htmlText;
	}

	/*
	 * @see Payment::isMyNofity()
	 */
	public function isMyNofity() {
		if($this->isAsynNofity()){
			$_R = $_POST;
		}else{
			$_R = $_GET;
		}
		return isset($_R['notify_id']);
	}

	/*
	 * @see Payment::notifyVerify()
	 */
	public function notifyVerify() {
		//获取合作者信息
		$partner = $this->getPartner();
		if(empty($partner)){
			throw new PaymentException("合作者信息不能为空", PaymentException::EX_CODE_PAYMENT_VERIFY_ERROR, $this->getPaymentType());
		}
		//根据合作者信息创建支付宝合作者信息数组
		$paymentConfig = $this->getConfig();
		$aliapyConfig = array(
			'partner'=>$partner->getId(),
			'key'=>$partner->getKey(),
			'seller_email'=>$partner->getAccount(),
			'sign_type'=>$paymentConfig->getSign(),
			'transport'=>$paymentConfig->getTransport(),
		);
		//创建支付宝通知服务类
		$alipayNotify = new AlipayNotify($aliapyConfig);
		return true;
		if($this->isAsynNofity()){
			return $alipayNotify->verifyNotify();
		}else{
			return $alipayNotify->verifyReturn();
		}
	}
	
	/*
	 * @see Payment::isSuccessTrade()
	 */
	public function isSuccessTrade() {
		if($this->isAsynNofity()){
			$_R = $_POST;
		}else{
			$_R = $_GET;
		}
		if($_R['trade_status'] == 'TRADE_FINISHED' ||$_R['trade_status'] == 'TRADE_SUCCESS'){
			return true;
		}
		return false;
	}

	/*
	 * @see Payment::collectResponseParameter()
	 */
	protected function collectResponseParameter() {
		if($this->isAsynNofity()){
			$this->setResponseParameter($_POST);
		}else{
			$this->setResponseParameter($_GET);
		}
	}
}