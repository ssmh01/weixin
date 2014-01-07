<?php

/**
 * The front Class of MVC framework. 
 * It use to make user can use the framework simplicity.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2011-1-4
 */

include 'EasyConfig.class.php';
include 'Init.class.php';
include 'R.class.php';
include 'functions.core.php';

abstract class EasyPHP{

	public static function doItEasy($configFile){
		//初始化配置
		$easyConfig = Init::configInit($configFile);
		try{
			//设置调试信息
			error_reporting($easyConfig->getConfig('debug_display'));
			//启动包机制
			Init::packetInit();
			
			if($easyConfig->getConfig('base_url_static')){
				//如果开启了URL静态化处理
				$params = R::getUrlPseudoStatic()->parseStaticParameter($_SERVER['REQUEST_URI']); //解析伪静态URI中的参数
				if($params)	$_GET = $_GET+$params;
			}
			//调用生命周期监听器
			$webLifeTimeListener = R::getWebLifeTimeListener();
			if($webLifeTimeListener){
				$webLifeTimeListener->beforeRequestInit();
			}
			//初始化请求
			$request = R::getRequest();
			$request->setConfig($easyConfig);
			//调用生命周期监听器
			if($webLifeTimeListener){
				$webLifeTimeListener->afterRequestInit();
			}
			//设置分发控制器
			$controller = BeanUtils::builtInstance($easyConfig->getConfig('base_controller'));
			$dispatcher = new Dispatcher($controller);
			//设置分发监听器
			$dispathListener = $easyConfig->getConfig('event_dispatch_listener');
			if($dispathListener){
				$dispatcher->setListener(BeanUtils::builtInstance($dispathListener));
			}
			//分发请求
			$action = $dispatcher->dispatch($request);
			$request->setAction($action);
			//调用Action
			$actionInvoker = BeanUtils::builtInstance($easyConfig->getConfig('base_action_invoker'));
			$actionInvoker->invoke($action, $request); //执行action
			$view = TemplateUtils::createView($action->getView());
			R::setTemplate($view);
			if($webLifeTimeListener){
				$webLifeTimeListener->beforeViewShow();
			}
			$view->show($request);
			if($webLifeTimeListener){
				$webLifeTimeListener->afterViewShow();
			}
		}catch(Exception $e){
			$exceptionProcessor = new ExceptionProcessor();
			$exceptionHandlers = null;
			$exceptionProcessor->setHandlerMap($exceptionHandlers);
			$exceptionProcessor->process($request, $e);
		}
	}
}