<?php

/**
 * 支付参数转换接口,把参数在特定支付接口类型和公共参数之间转换.
 * 区分请求参数和响应参数.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-08-16
 */
interface ParameterTransform{
	
	/**
	 * 把公共的请求参数转换成特定支付接口的请求参数
	 * @param array/string requestParameter
	 */
	public function requestParameterTransform($requestParameter);
	
	/**
	 * 把特定支付接口的响应参数转换成公共的响应参数
	 * @param array/string $responseParameter
	 */
	public function responseParameterTransform($responseParameter);
}