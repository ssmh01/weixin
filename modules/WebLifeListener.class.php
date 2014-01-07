<?php
/**
 * 生命周期监听器,在这里主要用来进行session的初始化的和操作日志记录
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-07-31
 */
class WebLifeListener implements WebLifeTimeListener{
    /**
     * 该访求在包机制启动后HttpReqeust对象初始化前被调用
     */
    public function beforeRequestInit(){
        Init::sessionInit();
    }

    /**
     * 该访求在HttpReqeust对象初始化后被调用
     */
    public function afterRequestInit(){
    	include_once(EXT_LIB_ROOT . 'tools.fun.php');
    	//组合系统配置
    	$configs = CommonServiceFactory::getConfigService()->gets();
    	R::getConfig()->addConfigs($configs);
    }

    /**
     * 该方法在视图显示方法被调用前调用
     */
    public function beforeViewShow(){
    	//获取当前的模块
    	$moduleName = R::getRequest()->getAction()->getModule()->getName();
    	R::getRequest()->assign('currentModule', $moduleName);
    	//获取用户信息
    	UserService::usersGet();
    	
    	$request = R::getRequest();
    	$action = $request->getAction();
    	if(BeanUtils::hasMethod($action, 'createValidateJs')){
    		$request->setAttribute('validateJs', $action->createValidateJs());
    	}
    }

    /**
     * 该方法在视图显示方法被调用后调用
     */
    public function afterViewShow(){}
}
