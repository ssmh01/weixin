<?php

/**
 * 把自定义模型转换成动态模型的支持接口
 * @author blueyb.java@gmail.com
 * @since 1.0 - Mar 26, 2012
 */

abstract class DynamicModelTransformSupport{
    private $fields;
	
	/**
	 * 获取动态模型名称
	 */
	public function getModelName(){
		return get_class($this);
	}

    /**
     * 获取要转换的Fields
     */
    public function getFields(){
        return $this->fields;
    }

    /**
     * 设置要转换的Fields
     * @param $fields
     */
    public function setFields($fields){
        $this->fields = $fields;
    }
}