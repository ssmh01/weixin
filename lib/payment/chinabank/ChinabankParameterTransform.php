<?php

/**
 * 网银在线接口参数转换实现类.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2012-05-25
 */

class ChinabankParameterTransform extends AbstractParameterTransform implements ParameterTransform{
	
	public function __construct(){
		parent::__construct('chinabank');
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