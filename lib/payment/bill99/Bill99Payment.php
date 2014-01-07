<?php

/**
 * 快钱接口实现类.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2012-05-26
 */
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "./lib/Bill99Service.php");
class Bill99Payment extends Payment{
	
	/*
	 * @see Payment::getPaymentType()
	 */
	public function getPaymentType() {
		return 'bill99';
	}
	
	/*
	 * @see Payment::pay()
	 */
	public function pay($requestParameter) {
		//创建支付工具类
		$paymentUtil = new PaymentUtil();
		//创建与支付类型对应的参数转换,并转换参数
		$requestParameter = $paymentUtil->requestParameterTransform($this->getPaymentType(), $requestParameter);
		if($requestParameter['orderAmount']){
			//转换成以分为单位
			$requestParameter['orderAmount'] = $requestParameter['orderAmount'] * 100;
		}
		if(empty($requestParameter['inputCharset'])){
			//编码
			$requestParameter['inputCharset'] = '1';
		}
		if(empty($requestParameter['orderTime'])){
			//下单时间
			$requestParameter['orderTime'] = time();
		}
		if(empty($requestParameter['signType'])){
			$requestParameter['signType'] = '1';
		}
		if(empty($requestParameter['version'])){
			$requestParameter['version'] = 'v2.0';
		}
		if(empty($requestParameter['language'])){
			$requestParameter['language'] = '1';
		}
		if(empty($requestParameter['payType'])){
			$requestParameter['payType'] = '00';
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
		$service = new Bill99Service($config);
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