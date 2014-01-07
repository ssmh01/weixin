<?php

/**
 * 支付接口异常类
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -   2011-08-16
 */
class PaymentException extends Exception{
	
	//支付类型不支持
	const EX_CODE_PAYMENT_TYPE_NOT_SUPPORT = -0x001;
	
	//支付类型实现类没找到
	const EX_CODE_PAYMENT_CLASS_NOT_FOUND = -0x002;
	
	//资源没有找到
	const EX_CODE_PAYMENT_RS_NOT_FOUND = -0x003;
	
	//参数转换异常
	const EX_CODE_PAYMENT_PARAMETER_TRANSFORM_ERROR = -0x004;
	
	//获取支付合作者信息异常
	const EX_CODE_PAYMENT_GET_PARTNER_ERROR = -0x005;
	
	//支付异常
	const EX_CODE_PAYMENT_PAY_ERROR = -0x006;
	
	//响应验证异常
	const EX_CODE_PAYMENT_VERIFY_ERROR = -0x007;
	
	/**
	 * 支付接口类型名称
	 */
	private $paymentType;
	
	/**
	 * 数据装载器
	 */
	private $data;
	
	function __construct($message, $code, $paymentType){
		parent::__construct($message, $code);
		$this->setPaymentType($paymentType);
		$data = array();
	}
	
	public function getPaymentType() {
		return $this->paymentType;
	}

	public function setPaymentType($paymentType) {
		$this->paymentType = $paymentType;
	}
	
	function putData($key, $value){
		$this->data[$key] = $value;
	}
	
	function getData($key){
		return $this->data[$key];
	}

}