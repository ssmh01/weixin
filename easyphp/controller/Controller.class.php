<?php

/**
 * This is the default controller of mvc framework. If you want to use self define 
 * controller, just set up the configure item in ${EasyConfig} object, the configure 
 * item named "base_controller".
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2010-12-24
 * @see ${ControllerInterface}
 */
 
class Controller implements ControllerInterface{
	
	/**
	 * @see ${ControllerInterface::requestDispatch}
	 */
	public function requestDispatch(HttpRequest $request){
		$easyConfig = $request->getConfig();
		//初始化ActionMatcher
		$actionMatchers = $easyConfig->getConfig('base_matchers');
		//the matcher use to match the action mapping and the request
		$matcher = new Matcher();
		$actionMapping = new ActionMapping();
		foreach($actionMatchers as $actionMatcher){
			$actionMatcher = BeanUtils::builtInstance($actionMatcher['class'], $actionMatcher['params']);
			$matcher->setActionMatcher($actionMatcher);
			if($matcher->matchs($request, $actionMapping)){
				return R::getAction($actionMapping);;
			}
		}
		//首页判断
		$context = $request->getContext();
		if($context == '/' || !$context){
			//转跳到首页Action
			$indexActionConfig = $easyConfig->getConfig('base_index_action');
			if(empty($indexActionConfig)){
				die("请配置base_index_action项");
			}
			$actionMapping = BeanUtils::builtInstance('ActionMapping', $indexActionConfig);
			return R::getAction($actionMapping);;
		}
	}
}