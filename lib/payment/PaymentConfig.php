<?php
/**
 * 支付接口配置类, 可配置通信协议(https或http),签名方法, 参数编码等.
 * 注意,并不是有所有支付接口都支持这些配置项,可能有个别配置只对特定的支付接口起作用.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-08-16
 */

class PaymentConfig{
	
	private static $payment_config_file = 'payment_config.php';
	
	/**
	 * 参数编码
	 */
	private $charset;
	
	/**
	 * 签名类型
	 */
	private $sign;
	
	/**
	 * 通信类型
	 */
	private $transport;
	
	/**
	 * 支付接口的合作者信息提供者
	 */
	private $partnerProvider;
	
	public function __construct(){
		$defaultConfig = include(dirname(__FILE__) . DIRECTORY_SEPARATOR . self::$payment_config_file);
		if($defaultConfig){
			BeanUtil::install($this, $defaultConfig);
		}else{
			$this->setCharset('UTF-8');
			$this->setSign('MD5');
			$this->setTransport('https');
		}
	}
	
	/**
	 * @return the $charset
	 */
	public function getCharset() {
		return $this->charset;
	}

	/**
	 * @param field_type $charset
	 */
	public function setCharset($charset) {
		$this->charset = $charset;
	}

	/**
	 * @return the $sign
	 */
	public function getSign() {
		return $this->sign;
	}

	/**
	 * @param field_type $sign
	 */
	public function setSign($sign) {
		$this->sign = $sign;
	}

	/**
	 * @return the $transport
	 */
	public function getTransport() {
		return $this->transport;
	}

	/**
	 * @param field_type $transport
	 */
	public function setTransport($transport) {
		$this->transport = $transport;
	}
	
	/**
	 * @return the $partnerProvider
	 */
	public function getPartnerProvider() {
		return $this->partnerProvider;
	}

	/**
	 * @param field_type $partnerProvider
	 */
	public function setPartnerProvider($partnerProvider) {
		$this->partnerProvider = $partnerProvider;
	}
}