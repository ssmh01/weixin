<?php

/**
 * 网银在线的服务类
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2012-05-25
 */
class ChinaBankService{

	private $gateway = 'https://Pay3.chinabank.com.cn/PayGate';
	
	private $config;
	
	/**
	 * @param array $config
	 */
	public function __construct($config){
		if(empty($config['partner']) || empty($config['key'])){
			throw new PaymentException("合作者信息不完整", PaymentException::EX_CODE_PAYMENT_GET_PARTNER_ERROR, 'chinabank');
		}
		$this->config = $config;
		
	}
	
	/**
	 * 支付，返回能自动提交的支付表单hmtl
	 * @param array $requestParameters
	 */
	public function pay($requestParameters){
		$md5Info = md5($requestParameters['v_amount'].$requestParameters['v_moneytype'].$requestParameters['v_oid'].$this->config['partner'].$requestParameters['v_url'].$this->config['key']);
		$requestParameters['v_md5info'] = strtoupper($md5Info);
		$requestParameters['v_mid'] = $this->config['partner'];
		return $this->buildForm($requestParameters, $this->gateway, 'post', '正在转跳到网银在线...');
	}
	
	/**
	 * 构造提交表单HTML数据
	 * @param array $params
	 * @param string $gateway
	 * @param string $method
	 * @param string $button_name
	 */
	private function buildForm($params, $gateway, $method, $button_name) {
		$sHtml = "<form id='paysubmit' name='paysubmit' action='".$gateway . "' method='".$method."'>";
		foreach ($params as $key=>$val){
            $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
        }
		//submit按钮控件请不能含有name属性
        $sHtml = $sHtml."<input type='submit' value='".$button_name."' style='display:none;'></form>";
		$sHtml = $sHtml."<script>document.forms['paysubmit'].submit();</script>";
		$sHtml = $sHtml."<div style='text-align:center;color:red;'>{$button_name}</div>";
		return $sHtml;
	}
}

?>