<?php

/**
 * This class use to parse the gtpl tag.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-19
 */
class gtpl extends TagSelfParse{
	
	public function getName(){
		return __CLASS__;
	}
	
	/**
	 * @see TagSelfParse::start()
	 */
	public function start($tag){
		$templateName = $tag->getBody();
		if(!$templateName){
			return $tag->toString();
		}
		$request = R::getRequest();
		//全局配置
		$easyConfig = R::getConfig();
		//模块配置
		$rootDir = $easyConfig->getConfig('base_webroot') . $easyConfig->getConfig('view_root');
		if($request->getParameter('view_style')){
			$style = $request->getParameter('view_style');
		}else{
			$style = $easyConfig->getConfig('view_style');
		}
		$suffix = $easyConfig->getConfig('view_suffix');
		$templateSet = new TemplateSet($rootDir, $style);
		$template = $templateSet->newTemplate($templateName, $suffix);
		if($easyConfig->getConfig('debug_enable') || !TemplateUtils::exists($template)){
			$compiler = new TemplateCompiler();
			$compiler->setUp($easyConfig);
			$compiler->compile($template);
			TemplateUtils::write($template);
		}
		$script = Constant::PHP_START_TAG . Constant::BLANK;
		$script .= "include_once('" . TemplateUtils::getCacheFilePath($template) . "');";
		$script .= Constant::PHP_END_TAG;
		return $script;
	}
	
	/**
	 * @see TagSelfParse::end()
	 */
	public function end($tag){
		return $tag->toString();
	}
}