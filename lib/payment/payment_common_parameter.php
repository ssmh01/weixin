<?php

/**
 * 支付接口的公共参数,共分两部分,一部分是请求参数,一部分是响应参数.
 */

//公共请求参数
$requestCommonParameter = array(
	//基本参数
	'payment_charset'=>'请求编码',
	'payment_sign_type'=>'签名方法',
	'payment_sign'=>'通过sign_type指定签名方法签名后的签名串',
	'payment_asyn_url'=>'服务器异步通知页面路径',
	'payment_sync_url'=>'服务器同步通知页面路径',
	//业务参数
	'payment_out_trade_no'=>'商户网站唯一订单号',
	'payment_payment_type'=>'支付类型,如商品购买,转账等',
	'payment_subject'=>'商品名称',
	'payment_price'=>'商品单价',
	'payment_quantity'=>'商品数量',
	'payment_total_fee'=>'交易总金额',
	'payment_body'=>'商品描述',
	'payment_show_url'=>'商品展示网址',
	'payment_pay_method'=>'默认支付方式,取值范围:directPay(余额支付), bankPay(网银支付), cartoon(卡通), creditPay(信用支付), CASH(网点支付)',
	'payment_default_bank'=>'默认网银',
);


//公共响应参数
$responseCommonParameter = array(
	//基本参数
	'payment_sign_type'=>'签名方法',
	'payment_sign'=>'通过sign_type指定签名方法签名后的签名串',
	//业务参数
	'payment_out_trade_no'=>'商户网站唯一订单号',
	'payment_payment_type'=>'支付类型,如商品购买,转账等',
	'payment_trade_no'=>'商户网站唯一订单号',
	'payment_trade_status'=>'交易状态',
	'payment_trade_message'=>'交易信息',
	'payment_subject'=>'商品名称',
	'payment_price'=>'商品单价',
	'payment_quantity'=>'商品数量',
	'payment_total_fee'=>'交易总金额',
	'payment_body'=>'商品描述',
	'payment_discount'=>'商品折扣',
	'payment_pay_bank'=>'支付银行',
);

return array(
	'request'=>$requestCommonParameter,
	'response'=>$responseCommonParameter
);