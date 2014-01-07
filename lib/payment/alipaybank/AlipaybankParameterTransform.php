<?php

/**
 * 支付接口参数转换接口的支付宝实现类.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-08-18
 */

class AlipaybankParameterTransform extends AbstractParameterTransform implements ParameterTransform{
	
	public function __construct(){
		parent::__construct('alipay');
	}
	
	/*
	 * @see ParameterTransform::requestParameterTransform()
	 */
	public function requestParameterTransform($requestParameter) {
		return parent::requestParameterTransform($requestParameter);
	}

	/*
	 * @see ParameterTransform::responseParameterTransform()
	 */
	public function responseParameterTransform($responseParameter) {
		return parent::responseParameterTransform($responseParameter);
	}
}