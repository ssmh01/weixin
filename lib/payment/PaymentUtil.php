<?php

/**
 * 支付接口工具类
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-08-16
 */

final class PaymentUtil{
	
	private static $payment_type_support_file = 'payment_type_support.php';
	
	private static $payment_common_parameter_file = 'payment_common_parameter.php';
	
	private static $payment_alipay_banks_file = 'alipaybank/alipay_banks.php';
	
	/**
	 * 支付接口根目录
	 */
	private $paymentRoot;
	
	/**
	 * 所支持的支付接口类型
	 * @type array
	 */
	private $paymentTypes;
	
	/**
	 * 公共的请求参数列表
	 */
	private $requestCommonParameter;
	
	/**
	 * 公共的响应参数列表
	 */
	private $responseCommonParameter;
	
	public function __construct(){
		$this->paymentRoot = dirname(__FILE__) . DIRECTORY_SEPARATOR;
		$this->paymentTypes = include($this->paymentRoot . './' . self::$payment_type_support_file);
		$commonParameter = include($this->paymentRoot . './' . self::$payment_common_parameter_file);
		$this->requestCommonParameter = $commonParameter['request'];
		$this->responseCommonParameter = $commonParameter['response'];
	}
	
	/**
	 * 判断给定的支付类型是不是被支持的
	 * @param string $paymentType
	 */
	public function isSupportPaymentType($paymentType, $throw=false){
		if($throw && !isset($this->paymentTypes[$paymentType])){
			throw new PaymentException("不被支持的支付类型:{$paymentType}", PaymentException::EX_CODE_PAYMENT_TYPE_NOT_SUPPORT, $paymentType);
		}
		return isset($this->paymentTypes[$paymentType]);
	}
	
	/**
	 * 获取支付类型对应的实现类名
	 * @param string $paymentType
	 */
	public function getPaymentClassName($paymentType){
		return ucwords($paymentType) . 'Payment';
	}
	
	/**
	 * 获取支付类型对应的实现类文件路径
	 * @param string $paymentType
	 */
	public function getPaymentClassFile($paymentType){
		return $this->getPaymentRoot() . $paymentType . DIRECTORY_SEPARATOR . ucwords($paymentType) . 'Payment.php';
	}
	
	/**
	 * 获取支付类型对应的参数转换类名
	 * @param string $paymentType
	 */
	public function getParameterTransformClassName($paymentType){
		return ucwords($paymentType) . 'ParameterTransform';
	}
	
	/**
	 * 根据支付类型获取相应的参数转换类
	 * @param string $paymentType
	 */
	public function getParameterTransform($paymentType){
		$this->isSupportPaymentType($paymentType, true);
		$clazz = ucwords($paymentType) . 'ParameterTransform';
		$clazzFile = $this->getPaymentRoot() . $paymentType . DIRECTORY_SEPARATOR . $clazz . '.php';
		include_once($clazzFile);
		return BeanUtil::builtInstance($clazz);
	}
	
	/**
	 * 把公共的请求参数转换成特定支付接口的请求参数
	 * @param array/string $requestParameters
	 */
	public function requestParameterTransform($paymentType, $requestParameter){
		$transform = $this->getParameterTransform($paymentType);
		return $transform->requestParameterTransform($requestParameter);
	}
	
	/**
	 * 把特定支付接口的响应参数转换成公共的响应参数
	 * @param array/string $responseParameters
	 */
	public function responseParameterTransform($paymentType, $responseParameter){
		$transform = $this->getParameterTransform($paymentType);
		return $transform->responseParameterTransform($responseParameter);
	}
	
	/**
	 * 获取支付接口根目录
	 */
	public function getPaymentRoot() {
		return $this->paymentRoot;
	}

	/**
	 * 获取支付接口所支持的支付类型
	 * @return array
	 */
	public function getPaymentSupportTypes() {
		return $this->paymentTypes;
	}
	
	/**
	 * @return the $requestCommonParameter
	 */
	public function getRequestCommonParameter() {
		return $this->requestCommonParameter;
	}

	/**
	 * @return the $responseCommonParameter
	 */
	public function getResponseCommonParameter() {
		return $this->responseCommonParameter;
	}
	
	/**
	 * 获取支付宝所绑定的网银列表,为了方便用户使用才加上.当支付接口不支持alipaybank
	 * 类型时或当网银列表文件不存在时返回空
	 */
	public function getAlipayBanks(){
		if($this->isSupportPaymentType('alipaybank')){
			$banks = include($this->getPaymentRoot() . self::$payment_alipay_banks_file);
			return $banks? $banks:null;
		}
		return null;
	}
	
	/**
	 * 获取合适类型的支付接口,该函数在支付通知页面中调用,它会根据通知信息在所支持的支付类型中
	 * 选择合适类型的支付接口.如果没有找到则返回空.
	 */
	public function getProperPayment(){
		//获取所支持的支付接口
		$paymentTypes = $this->getPaymentSupportTypes();
		foreach($paymentTypes as $type => $name){
			try{
				//创建支付接口
				$payment = Payment::getInstance($type);
				if($payment->isMyNofity()){
					//如果是支付接口应该处理的通知刚返回
					return $payment;
				}
				//如果不是则回收
				unset($payment);
			}catch(Exception $exception){
				//Do nothing
			}
		}
	}
}