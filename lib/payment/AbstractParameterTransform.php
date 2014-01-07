<?php

/**
 * 这个抽象类用来提供一种参数转换的实现方法,用来简化参数转换接口的实现,如果要使用该实现方法
 * 只需继承这个类并设置支付接口类型,并在名称和支付接口类型相同的文件夹里面放置名为
 * "request_parameter_map.php"和名为"response_parameter_map.php"的文件,其中第一个文件
 * 必须返回支付请求参数匹配数组,第二个文件必须返回支付响应参数匹配数组.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-08-18
 */
abstract class AbstractParameterTransform implements ParameterTransform{
	
	//支付请求参数匹配表文件
	private static $request_parameter_map_file = "request_parameter_map.php";
	
	//支付响应参数匹配表文件
	private static $response_parameter_map_file = "response_parameter_map.php";
	
	//请求参数匹配表
	private $requestParameterMap;
	
	//响应参数匹配表
	private $responseParameterMap;
	
	/**
	 * 支付接口类型
	 */
	private $paymentType;
	
	
	public function __construct($paymentType){
		$this->setPaymentType($paymentType);
	}
	
	protected function getPaymentType() {
		return $this->paymentType;
	}

	protected function setPaymentType($paymentType) {
		$this->paymentType = $paymentType;
	}
	
	/*
	 * @see ParameterTransform::requestParameterTransform()
	 */
	public function requestParameterTransform($requestParameter) {
		$this->loadRequestParameterMap();
		$transforms = array();
		$paymentConfig = new PaymentConfig();
		foreach($requestParameter as $key=>$value){
			if(isset($this->requestParameterMap[$key])){
				$transforms[$this->requestParameterMap[$key]] = $value;
			}
		}
		return $transforms;
	}

	/*
	 * @see ParameterTransform::responseParameterTransform()
	 */
	public function responseParameterTransform($responseParameter) {
		$this->loadResponseParameterMap();
		$transforms = array();
		$paymentConfig = new PaymentConfig();
		foreach($responseParameter as $key=>$value){
			if(isset($this->responseParameterMap[$key])){
				$transforms[$this->responseParameterMap[$key]] = $value;
			}else{
				//如果参数不在转换范围内原样复制
				$transforms[$key] = $value;
			}
		}
		return $transforms;
	}
	
	//加载请求参数匹配表
	protected function loadRequestParameterMap(){
		if(!$this->requestParameterMap){
			$paymentUtil = new PaymentUtil();
			$paymentUtil->isSupportPaymentType($this->paymentType, true);
			$filePath = $paymentUtil->getPaymentRoot() . $this->paymentType . DIRECTORY_SEPARATOR . self::$request_parameter_map_file;
			if(!file_exists($filePath)){
				throw new PaymentException("File Not Found:" . $filePath, PaymentException::EX_CODE_PAYMENT_RS_NOT_FOUND, $this->paymentType);
			}
			$this->requestParameterMap = include($filePath);
		}
	}
	
	//加载响应参数匹配表
	protected function loadResponseParameterMap(){
		if(!$this->responseParameterMap){
			$paymentUtil = new PaymentUtil();
			$paymentUtil->isSupportPaymentType($this->paymentType, true);
			$filePath = $paymentUtil->getPaymentRoot() . $this->paymentType . DIRECTORY_SEPARATOR . self::$response_parameter_map_file;
			if(!file_exists($filePath)){
				throw new PaymentException("File Not Found:" . $filePath, PaymentException::EX_CODE_PAYMENT_RS_NOT_FOUND, $this->paymentType);
			}
			$this->responseParameterMap = include($filePath);
		}
	}
}