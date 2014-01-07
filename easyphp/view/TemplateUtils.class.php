<?php

/**
 * This is a tool class to support some operations for template cache. 
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-15
 */
class TemplateUtils{
	
	/**
	 * The name of cache dir.
	 */
	private static $CACHE_DIR = 'views';
	
	private static $CACHE_FILE_SUFFIX = '.php';

	public static function write(Template $template){
		TemplateUtils::checkWritePerm($template);
		$filePath = TemplateUtils::getCacheFilePath($template);
		file_put_contents($filePath, $template->getContent(), LOCK_EX);
	}
	
	public static function load(Template $template){
		TemplateUtils::checkReadPerm($template);
		$filePath = TemplateUtils::getCacheFilePath($template);
		$content = @file_get_contents($filePath);
		$template->setContent($content);
	}
	
	public static function exists(Template $template){
		$filePath = TemplateUtils::getCacheFilePath($template);
		return file_exists($filePath);
	}
	
	public static function expire(Template $template, $time){
		
	}
	
	public static function getCacheFilePath(Template $template){
		$fullDir = self::getCacheFileDir($template);
		$filePath = $fullDir . $template->getName() . TemplateUtils::$CACHE_FILE_SUFFIX;
		return $filePath;
	}
	
	public static function getCacheFileDir(Template $template){
		$webRoot = R::getConfig()->getConfig('base_webroot');
		$compilePath = R::getConfig()->getConfig('base_compile_path');
		$templateDir = $template->getTemplateSet()->getFullName();
		$tempPaths = explode($webRoot, $templateDir, 2);
		if($tempPaths[1]){
			$fullDir = $compilePath . self::$CACHE_DIR . DIRECTORY_SEPARATOR . $tempPaths[1];
		}else{
			$fullDir = $compilePath . self::$CACHE_DIR . DIRECTORY_SEPARATOR . md5($templateDir) . DIRECTORY_SEPARATOR;
		}
		return $fullDir;
	}
	
	private static function checkWritePerm(Template $template){
		$fullDir = self::getCacheFileDir($template);
		if(!file_exists($fullDir)){
			FileUtil::mkDirs($fullDir);
		}
		Permission::checkWritePerm($fullDir);
		if(TemplateUtils::exists($template)){
			$fullName = TemplateUtils::getCacheFilePath($template);
			Permission::checkWritePerm($fullName);
		}
	}
	
	private static function checkReadPerm(Template $template){
		$fullDir = self::getCacheFileDir($template);
		if(!file_exists($fullDir)){
			FileUtil::mkDirs($fullDir);
		}
		Permission::checkReadPerm($fullDir);
		if(TemplateUtils::exists($template)){
			$fullName = TemplateUtils::getCacheFilePath($template);
			Permission::checkReadPerm($fullName);
		}
	}
	
	/**
	 * 创建视图
	 * @param string $view 要创建的视图名
	 * @param string $global 是否是全局的视图,如果不是并且模块自己管理视图时则加载模块视图
	 * @return Template 返回一个模板类
	 */
	public static function createView($view, $global=false){
		$request = R::getRequest();
		$action = $request->getAction();
		//全局配置
		$easyConfig = R::getConfig();
		//模块配置
		$moduleConfig = $action->getModule()->getConfig();
		$moduleViewRoot = $moduleConfig->getConfig('view_root');
		//设置模板的根目录
		if(!$global && $moduleViewRoot){
			//用模块的模板
			$rootDir = get_module_dir($action->getModule()->getName()) . $moduleConfig->getConfig('view_root');
		}else{
			//用全局的模板
			$rootDir = $easyConfig->getConfig('base_webroot') . $easyConfig->getConfig('view_root');
		}
		//set up the template style
		if($request->getParameter('view_style')){
			$style = $request->getParameter('view_style');
		}else{
			$style = $easyConfig->getConfig('view_style');
		}
		$suffix = $easyConfig->getConfig('view_suffix');
		$templateSet = new TemplateSet($rootDir, $style);
		return $templateSet->newTemplate($view, $suffix);
	}
}

