<?php

/**
 * 后台模块服务加载器
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-01
 */
class AdminServiceFactory{
	
	/**
	 * 菜单服务
	 * @var IMenuService
	 */
	private static $menuService;
	
	/**
	 * 管理员服务
	 * @var IManagerService
	 */
	private static $managerService;
	
	/**
	 * 后台操作服务
	 * @var IAdminOperationService
	 */
	private static $adminOperationService;
	
	
	/**
	 * @return IMenuService
	 */
	public static function getMenuService(){
		if(self::$menuService == null){
			self::$menuService = new MenuService();
		}
		return self::$menuService;
	}
	
	/**
	 * @return IManagerService
	 */
	public static function getManagerService(){
		if(self::$managerService == null){
			self::$managerService = new ManagerService();
		}
		return self::$managerService;
	}
	
	/**
	 * @return IAdminOperationService
	 */
	public static function getAdminOperationService(){
		if(self::$adminOperationService == null){
			self::$adminOperationService = new AdminOperationService();
		}
		return self::$adminOperationService;
	}
}

?>