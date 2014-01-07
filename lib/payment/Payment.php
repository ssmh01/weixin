<?php

/**
 * 支付接口抽象类,供用户使用
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-08-16
 */

$root = dirname(__FILE__) . DIRECTORY_SEPARATOR;
include_once($root . './BeanUtil.php');
include_once($root . './Partner.php');
include_once($root . './PartnerProvider.php');
include_once($root . './PaymentConfig.php');
include_once($root . './PaymentException.php');
include_once($root . './ParameterTransform.php');
include_once($root . './AbstractParameterTransform.php');
include_once($root . './PaymentUtil.php');

abstract class Payment{
	
	/**
	 * 实例数组
	 */
	private static $instance;
	
	/**
	 * 请求参数
	 */
	private $requestParameter;
	
	/**
	 * 响应参数
	 */
	private $responseParameter;
	
	/**
	 * 支付接口配置
	 */
	private $config;
	
	/**
	 * 获取支付接口实例
	 * @param string $paymentType
	 * 	支付接口类型
	 * @param boolean $new
	 * 	是否创建新实例
	 * @throws PaymentException
	 * 	当创建不支持的支付类型或该支付类型实现不存在时会产生异常.
	 */
	public static function getInstance($paymentType, $config, $new=false){
		$paymentUtil = new PaymentUtil();
		$paymentUtil->isSupportPaymentType($paymentType, true);
		if($new || self::$instance[$paymentType] == null){
			$clazz = $paymentUtil->getPaymentClassName($paymentType);
			$clazzFile = $paymentUtil->getPaymentClassFile($paymentType);
			if(!include_once($clazzFile)){
				throw new PaymentException("支付类型:{$paymentType}的实现类没有被找到", PaymentException::EX_CODE_PAYMENT_CLASS_NOT_FOUND, $paymentType);
			}
			$payment = null;
			try{
				$payment = BeanUtil::builtInstance($clazz);
				if(!($payment instanceof Payment)){
					throw new Exception();
				}
				self::$instance[$paymentType] =$payment;
			}catch(Exception $exception){
				throw new PaymentException("支付类型:{$paymentType}的实现类不是Payment实例", PaymentException::EX_CODE_PAYMENT_CLASS_NOT_FOUND, $paymentType);
			}
			if(!($config instanceof PaymentConfig)){
				$config = new PaymentConfig();
			}
			$payment->setConfig($config);
		}
		return self::$instance[$paymentType];
	}
	
	/**
	 * @return PaymentConfig $config
	 */
	public function getConfig() {
		return $this->config;
	}

	/**
	 * 设置支付配置类
	 * @param PaymentConfig $config
	 */
	protected function setConfig(PaymentConfig $config) {
		$this->config = $config;
	}
	
	/**
	 * @return the $requestParameter
	 */
	public function getRequestParameter() {
		return $this->requestParameter;
	}
	
	/**
	 * @param array $requestParameter
	 */
	protected function setRequestParameter($requestParameter) {
		$this->requestParameter = $requestParameter;
	}

	/**
	 * @return the $responseParameter
	 */
	public final function getResponseParameter() {
		if(empty($this->responseParameter)){
			$this->collectResponseParameter();
		}
		return $this->responseParameter;
	}


	/**
	 * @param array $responseParameter
	 */
	protected function setResponseParameter($responseParameter) {
		$this->responseParameter = $responseParameter;
	}
	
	/**
	 * 检查是否是异步通知, 通常认为用post方法通知的是异步通知
	 * @return boolean
	 * 	如果是异步通知,则返回true,否则返回false.
	 */
	public final function isAsynNofity(){
		$method = strtolower($_SERVER['REQUEST_METHOD']);
		if($method == 'post'){
			return true;
		}
		return false;
	}
	
	protected function getPartner(){
		$paymentConfig = $this->getConfig();
		$partnerProviderName = $paymentConfig->getPartnerProvider();
		if(empty($partnerProviderName)){
			return;
		}
		$partnerProvider = BeanUtil::builtInstance($partnerProviderName);
		$partner = null;
		try{
			$partner = $partnerProvider->getPartner($this->getPaymentType());
		}catch(Exception $exception){
			throw new PaymentException("获取支付合作者信息失败:" . $exception->getMessage(), PaymentException::EX_CODE_PAYMENT_GET_PARTNER_ERROR, $this->getPaymentType());
		}
		return $partner;
	}
	
	/**
	 * 获取当前类所实现的支付类型名称
	 */
	public abstract function getPaymentType();

	/**
	 * 支付动作,子类实现.该方法的职责是用给定的请求参数向特定的第三方发送支付请求,传递进去的请求参数是
	 * 已被转换过的特定支付接口参数
	 * @param array $requestParameter
	 * 请求参数是已被转换过的特定支付接口参数
	 */
	public abstract function pay($requestParameter);
	
	/**
	 * 检查支付通知是不是由我代表的支付接口类型创建的.
	 * @return boolean
	 */
	public abstract function isMyNofity();
	
	/**
	 * 验证支付通知的正确性
	 */
	public abstract function notifyVerify();
	
	/**
	 * 验证支付交易是否成功
	 */
	public abstract function isSuccessTrade();
	
	/**
	 * 从通知中收集响应参数
	 */
	protected abstract function collectResponseParameter();
}