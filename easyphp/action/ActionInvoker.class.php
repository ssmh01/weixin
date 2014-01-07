<?php

/**
 * Invoke rule:
 * First:	If the method of <code>ActionMapping</code> is null, the default 
 * 			method of <code>Action</code> will be invoked.
 * Second:	If the method of <code>ActionMapping</code> is not null. In this case, 
 * 			if the method of http request is not null goto rule Three otherwise rule Four.
 * Three:	Now the method name is the method name of http request plus the method of  
 * 			<code>ActionMapping</code>. If the method not exists in <Action>,goto rule Four.
 * Four:	Now the method name is the method of <code>ActionMapping</code>, it will be 
 * 			invoked, if the method if not found on the <code>Action</code> context, the
 * 			<code>NoSuchMethodException</coce> instance will been throw.
 * 
 * @see <code>ActionInvokerInterface</code>
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2011-1-5
 */

class ActionInvoker implements ActionInvokerInterface{
	
	/**
	 * Invoke the method of action base on the ActionMapping,
	 * The ActionMapping is belong the action, you can call 
	 * <code>Action::getActionMapping</code> to get it.
	 */
	public function invoke(Action $action, HttpRequest $request){
		//先调用模块的Filter
		$module = $action->getModule();
		$moduleFilterName = $module->getConfig()->getConfig('filter');
		if($moduleFilterName){
			//创建Filter类
			$moduleFilter = BeanUtils::builtInstance($moduleFilterName);
			if($moduleFilter instanceof ModuleFilter){
				$moduleFilter->doFilter($module, $request);
			}
		}

		//处理Action方法调用监听器
		$actionInvokeListener = R::getActionInvokeListener($action);
		if($actionInvokeListener){
			$actionInvokeEvent = new ActionInvokeEvent($request);
			$actionInvokeEvent->setAction($action);
			$actionInvokeListener->beforeInvoke($actionInvokeEvent);
		}
		
		//调用方法
		$mapping = $action->getActionMapping();
		$methodName = '';
		$actionReflection = new ReflectionClass($action);
		if(!$mapping->getMethod()){
			$methodName = 'index';
		}else{
			if($request->getMethod()){
				$methodName = strtolower($request->getMethod()) . ucwords($mapping->getMethod());
				if(!$actionReflection->hasMethod($methodName)){
					$methodName = $mapping->getMethod();
				}
			}else{
				$methodName = $mapping->getMethod();
			}
		}
		if(!$actionReflection->hasMethod($methodName)){
			throw new NoSuchMethodException("Method::{$methodName}() not found on: " . $actionReflection->getName());
		}
		$method = $actionReflection->getMethod($methodName);
		try{
			$method->invoke($action, $request);
			//处理Action方法调用监听器
			if($actionInvokeListener){
				$actionInvokeEvent->setMethod($methodName);
				$actionInvokeListener->afterInvoke($actionInvokeEvent);
			}
		}catch(ReflectionException $e){
			throw new MethodInvokeException($e->getMessage());
		}
	}
}