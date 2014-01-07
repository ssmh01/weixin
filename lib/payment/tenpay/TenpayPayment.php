<?php

/**
 * 财付通接口实现类.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2012-05-25
 */
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "./lib/TenpayService.php");
class TenpayPayment extends Payment{
	
	/*
	 * @see Payment::getPaymentType()
	 */
	public function getPaymentType() {
		return 'tenpay';
	}
	
	/*
	 * @see Payment::pay()
	 */
	public function pay($requestParameter) {
		//创建支付工具类
		$paymentUtil = new PaymentUtil();
		//创建与支付类型对应的参数转换,并转换参数
		$requestParameter = $paymentUtil->requestParameterTransform($this->getPaymentType(), $requestParameter);
		if($requestParameter['total_fee']){
			//转换成以分为单位
			$requestParameter['total_fee'] = $requestParameter['total_fee'] * 100;
		}
		if(empty($requestParameter['fee_type'])){
			//1为人民币
			$requestParameter['fee_type'] = '1';
		}
		if(empty($requestParameter['spbill_create_ip'])){
			$requestParameter['spbill_create_ip'] = $_SERVER['REMOTE_ADDR'];
		}
		if(empty($requestParameter['body'])){
			$requestParameter['body'] = '请放心支付';
		}
		if(empty($requestParameter['bank_type'])){
			$requestParameter['bank_type'] = 'DEFAULT';
		}
		$paymentConfig = $this->getConfig();
		if(empty($requestParameter['sign_type'])){
			$requestParameter['sign_type'] = $paymentConfig->getSign();
		}
		
		$this->setRequestParameter($requestParameter);
		
		//获取合作者信息
		$partner = $this->getPartner();
		if(empty($partner)){
			throw new PaymentException("合作者信息不能为空", PaymentException::EX_CODE_PAYMENT_GET_PARTNER_ERROR, $this->getPaymentType());
		}
		//根据合作者信息创建网银合作者信息数组
		$config = array(
				'partner'=>$partner->getId(),
				'key'=>$partner->getKey(),
		);
		//创建支付服务类
		$service = new TenpayService($config);
		//调用即时支付接口
		$htmlText = $service->pay($requestParameter);
		echo $htmlText;
	}

	/*
	 * @see Payment::isMyNofity()
	 */
	public function isMyNofity() {
		
	}

	/*
	 * @see Payment::notifyVerify()
	 */
	public function notifyVerify() {
		
	}
	
	/*
	 * @see Payment::isSuccessTrade()
	 */
	public function isSuccessTrade() {
		
	}

	/*
	 * @see Payment::collectResponseParameter()
	 */
	protected function collectResponseParameter() {
		
	}
}