<?php

/**
 * 财付通的服务类
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2012-05-25
 */
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "./RequestHandler.class.php");
class TenpayService{

	/**
	 * @var RequestHandler
	 */
	private $requestHandler;
	
	private $config;
	
	private $gateway = 'https://gw.tenpay.com/gateway/pay.htm';
	
	/**
	 * @param array $config
	 */
	public function __construct($config){
		if(empty($config['partner']) || empty($config['key'])){
			throw new PaymentException("合作者信息不完整", PaymentException::EX_CODE_PAYMENT_GET_PARTNER_ERROR, 'chinabank');
		}
		$this->config = $config;
		$this->requestHandler = new RequestHandler();
		$this->requestHandler->init();
		$this->requestHandler->setGateUrl($this->gateway);
	}
	
	/**
	 * 支付，返回能自动提交的支付表单hmtl
	 * @param array $requestParameters
	 */
	public function pay($requestParameters){
		$this->requestHandler->setKey($this->config['key']);
		$this->requestHandler->setParameter("partner", $this->config['partner']);
		$this->requestHandler->setParameter("out_trade_no", $requestParameters['out_trade_no']);
		$this->requestHandler->setParameter("total_fee", $requestParameters['total_fee']);  //总金额
		$this->requestHandler->setParameter("return_url",  $requestParameters['return_url']);
		$this->requestHandler->setParameter("notify_url", $requestParameters['notify_url']);
		$this->requestHandler->setParameter("body", $requestParameters['body']);
		$this->requestHandler->setParameter("bank_type", $requestParameters['bank_type']);  	  //银行类型，默认为财付通
		//用户ip
		$this->requestHandler->setParameter("spbill_create_ip", $requestParameters['spbill_create_ip']);//客户端IP
		$this->requestHandler->setParameter("fee_type", $requestParameters['fee_type']);               //币种
		$this->requestHandler->setParameter("subject",$requestParameters['subject']);          //商品名称，（中介交易时必填）
		$this->requestHandler->createSign();
		$params = $this->requestHandler->getAllParameters();
		return $this->buildForm($params, $this->requestHandler->getGateURL(), 'post', '正在转跳到财付通...');
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