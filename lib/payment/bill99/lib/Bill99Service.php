<?php

/**
 * 快钱的服务类
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2012-05-26
 */
class Bill99Service{

	private $config;
	
	private $gateway = 'https://www.99bill.com/gateway/recvMerchantInfoAction.htm';
	
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
		$requestParameters['merchantAcctId'] = $this->config['partner'];
		$requestParameters['key'] = $this->config['key'];
		$paramString = $this->makeParameterString($requestParameters);
		$sign = strtoupper(md5($paramString));
		$requestParameters['signMsg'] = $sign;
		return $this->buildForm($requestParameters, $this->gateway, 'post', '正在转跳到快钱...');
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
	
	private function makeParameterString($params){
		$joinString = '';
		$paramString = '';
		foreach($params as $k=>$v){
			if(!$v)continue;
			$paramString = "{$paramString}{$joinString}{$k}={$v}";
			$joinstring = '&';
		}
	}
}

?>