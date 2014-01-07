<?php

/**
 * URL伪静态处理和参数解析
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2012-02-23
 */
class UrlPseudoStatic{
	
	/**
	 * 参数连接符
	 * @var string
	 */
	private $paramConnectChar = '-';
	
	/**
	 * 静态后缀
	 * @var string
	 */
	private $staticSuffix = '.shtml';
	
	/**
	 * 把URL变成伪静态形式
	 * @param string $uri 请求URL
	 */
	public function pseudoStatic($url){
		$urls = parse_url($url);
		$params = '';
		$paramString = '';
		if($urls['query']){
			//处理参数
			parse_str($urls['query'], $params);
			$paramConnectChar = '';
			foreach($params as $name=>$value){
				$paramString .= $paramConnectChar . $name . $this->paramConnectChar . $value;
				$paramConnectChar = $this->paramConnectChar;
			}
		}
		if($urls['scheme']){
			$purl = $urls['scheme'] . '://' . $urls['host'];
		}
		$purl .= $urls['path'];
		if($paramString){
			$purl .= $paramString . $this->staticSuffix;
		}
		
		if($urls['fragment']){
			$purl .= "#{$urls['fragment']}";
		}
		return $purl;
	}
	
	/**
	 * 把伪静态URL转换成动态URL
	 * @param string $url 伪静态URL
	 */
	public function dynamicUrl($url){
		$params = $this->parseStaticParameter($url);
		if(!$params)return $url;
		$urls = parse_url($url);
		$durl = '';
		if($urls['scheme']){
			$durl = $urls['scheme'] . '://' . $urls['host'];
		}
		if($urls['path']){
			$context = dirname($urls['path']);
			if($context == '.'){
				$context = '/';
			}else{
				$context .= '/';
			}
		}
		$durl .= $context . '?';
		$paramConnectChar = '';
		foreach($params as $name=>$value){
			$durl .= $paramConnectChar . $name . '=' . $value;
			$paramConnectChar = '&';
		}
		return $durl;
	}
	
	/**
	 * 解析当前URL
	 * @return array 返回参数
	 */
	public function parseStaticParameter($uri){
		if(!$uri || strpos($uri, '?') != false) return;
		if(!String::endWith($uri, $this->staticSuffix)) return;
		//去掉去掉上下文和后缀
		$uri = basename($uri, $this->staticSuffix);
		//进行安全转码
		$uri = addslashes($uri);
		$tempParams = explode($this->paramConnectChar, $uri);
		$params = array();
		$paramCount = count($tempParams);
		for($i = 0 ; $i < $paramCount; $i=$i+2){
			$params[$tempParams[$i]] = $tempParams[$i+1];
		}
		return $params;
	}
}

?>