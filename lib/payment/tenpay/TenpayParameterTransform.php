<?php

/**
 * 财付通接口参数转换实现类.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2012-05-25
 */

class TenpayParameterTransform extends AbstractParameterTransform implements ParameterTransform{
	
	public function __construct(){
		parent::__construct('tenpay');
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