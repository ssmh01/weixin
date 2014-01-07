<?php

/**
 * 网银在线接口实现类.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2012-05-25
 */
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "./lib/ChinaBankService.php");
class ChinabankPayment extends Payment{
	
	/*
	 * @see Payment::getPaymentType()
	 */
	public function getPaymentType() {
		return 'chinabank';
	}
	
	/*
	 * @see Payment::pay()
	 */
	public function pay($requestParameter) {
		//创建支付工具类
		$paymentUtil = new PaymentUtil();
		//创建与支付类型对应的参数转换,并转换参数
		$requestParameter = $paymentUtil->requestParameterTransform($this->getPaymentType(), $requestParameter);
		if(empty($requestParameter['v_moneytype'])){
			//CNY为人民币
			$requestParameter['v_moneytype'] = 'CNY';
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
		$service = new ChinaBankService($config);
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