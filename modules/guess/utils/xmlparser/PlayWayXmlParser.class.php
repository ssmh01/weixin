<?php

/**
 * 玩法XML解析器
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-03-30
 */
class PlayWayXmlParser{
	
	/**
	 * xml文件对应的对象
	 * @var SimpleXMLElement
	 */
	private $xml;
	
	/**
	 * 玩法
	 * @var PlayWay
	 */
	private $playWay;
	
	/**
	 * 解析xml文件，返回PlayWay对象
	 * @param string $xml xml文档
	 */
	public function parse($xml){
		if(!$xml || !file_exists($xml)) return null;
		$this->xml = simplexml_load_file($xml);
		if(!$this->xml) return null;
		$this->playWay = new PlayWay();
		foreach ($this->xml->children() as $key => $node){
			switch ($key){
				case 'parameter':
					$data = $this->parseParameterNode($node);
					break;
				default:
					$data = trim((string)$node);
					break;
			}
			$attributeName = $this->ajustAttributeName($key);
			BeanUtils::install($this->playWay, array($attributeName=>$data));
		}
		return $this->playWay;
	}
	
	
	/**
	 * 解析Parameter节点
	 * @param SimpleXML $node
	 * @return PlayWayParameter
	 */
	private function parseParameterNode($parameterNode){
		$parameter = new PlayWayParameter();
		//解析parameter标签属性
		$attributes = $parameterNode->attributes();
		foreach($attributes as $key => $value){
			$attributeName = $this->ajustAttributeName($key);
			BeanUtils::install($parameter, array($attributeName=>trim((string)$value)));
		}
		//解析parameter标签option子节点
		$options = array();
		foreach($parameterNode->children() as $optionNode){
			$option = $this->getOption($optionNode);
			$options[$option->getValue()] = $option;
		}
		$parameter->setOptions($options);
		return $parameter;
	}
	
	/**
	 *解析select中的Option节点,返回一个数组
	 *@param SimpleXML $selectParameterNode parameter标签
	 *@return array
	 */
	private function getOption($optionNode){
		$option  = new PlayWayParameterOption();
		$attributes = $optionNode->attributes();
		foreach($attributes as $key => $value){
			$attributeName = $this->ajustAttributeName($key);
			BeanUtils::install($option, array($attributeName=>trim((string)$value)));
		}
		$option->setLabel(trim((string)$optionNode));
		return $option;
	}
	
	/**
	 *调整属性名
	 *@param string $attribute 
	 */
	private function ajustAttributeName($attribute){
		$attributes = explode('-', $attribute);
		for($i = 0; $i < count($attributes); $i++)
		{
			$attributes[$i] = ucfirst($attributes[$i]);
		}
		return implode($attributes);
	}
}

?>