<?php

/**
 * 后台操作服务接口
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-05
 */
interface IAdminOperationService{
	
	/**
	 * 获取操作数组
	 * @return array
	 */
	public function getOperations();
	
	/**
	 * 获取操作名
	 * @param Operation $operation
	 * @return string
	 */
	public function getOperationName(Operation $operation);
	
	/**
	 * 是否需要会员权限
	*  @param Operation $operation
	 * @return boolean
	 */
	public function needPermission(Operation $operation);
	
	/**
	 * 检查权限
	 * @param Operation $operation
	 * @param array $employe
	 * @return boolean 如果有操作权限则返回true, 否则返回false
	 */
	public function hasPermission(Operation $operation, $employe);
}

?>