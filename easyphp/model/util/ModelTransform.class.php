<?php

/** 
 * 模型转换类，实现动态模型和自定义模型间的转换
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-03-09
 */
abstract class ModelTransform {
	
	/**
	 * 把自定义模型转换成动态模型
	 * @param object $customModel 自定义模型
	 * @param string $dynamicModelName 模型名，如果自定义模型实现了DynamicModelTransformSupport接口，可以不填写该参数
	 * @param string $fields 要转换的属性域,多个用:分隔
	 * @return 动态模型 @see Model
	 */
	public static function toDynamicModel($customModel, $dynamicModelName=null, $fields=null){
		if(!$dynamicModelName && $customModel instanceof DynamicModelTransformSupport){
			$dynamicModelName = $customModel->getModelName();
		}
		if(!$dynamicModelName)return null;

		$modelConfig = R::getModelConfig($dynamicModelName);
		$tempAttributeMap = $modelConfig['orm']['map'];
		$attributeMap = null;
		if(!$fields){
			//复制配置里的所有属性域
			$attributeMap = $tempAttributeMap;
		}else{
			//确保要复制的属性域的有效性
			$attributeMap = array();
			$fields = explode(':', $fields);
			foreach($fields as $field){
				if(key_exists($field, $tempAttributeMap)){
					$attributeMap[$field] = $tempAttributeMap[$field];
				}
			}
			unset($fields);
		}
		unset($tempAttributeMap);
		$dynamicModel = M($dynamicModelName);
		$attributeGetMethodName = '';
		foreach($attributeMap as $attributeName => $modelFieldName){
			$attributeGetMethodName = 'get'. ucwords($attributeName);
			$dynamicModel->$modelFieldName = $customModel->$attributeGetMethodName();
		}
		return $dynamicModel;
	}
	
	/**
	 * 把动态模型转换成自定义模型
	 * @param Model $dynamicModel 动态模型调用M()方法返回的对象
	 * @param String $customModelName 自定义模型名称
	 * @return 自定义模型
	 */
	public static function toCustomModel(Model $dynamicModel, $customModelName){
		$modelConfig = R::getModelConfig($dynamicModel);
		$attributeMap = array_flip($modelConfig['orm']['map']);
		$attributes = $dynamicModel->getDataArray();
		$attributeParams = array();
		foreach($attributes as $attributeName=>$attributeValue){
			if(isset($attributeMap[$attributeName])){
				$attributeParams[$attributeMap[$attributeName]] = $attributeValue;
			}
		}
		return BeanUtils::builtInstance($customModelName, $attributeParams);
	}
}

?>