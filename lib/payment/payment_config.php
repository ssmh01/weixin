<?php

/**
 * 支付接口默认配置
 */
return array(
	//请求参数编码
	'charset'=>'utf-8',
	//参数签名方法
	'sign'=>'MD5',
	//传输协议,可选值为http或https,需服务器支持.
	'transport'=>'http',
	//支付接口的合作者信息提供者
	'partnerProvider'=>'PaymentPartnerProvider',
);