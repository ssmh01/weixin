<?php

/**
 * 支付接口的合作者信息提供者,要使用支付接口的功能,用户要先实现这个类,并自行引入.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -   2011-08-17
 */
interface PartnerProvider{
	
	/**
	 * 根据支付接口类型获取相应的合作者信息
	 * @param string $paymentType
	 * 	支付接口类型
	 */
	public function getPartner($paymentType);
}