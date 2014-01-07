<?php
/**
 * 充值服务接口
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - Jan 23, 2013
 */
interface IRechargeService{
	
	/**
	 * 创建充值编号
	 * @return string
	 */
	public function createSn();
	
	/**
	 * 根据充值ID获取充值
	 * @param string $id 充值ID
	 * @return array
	 */
	public function get($id);
	
	/**
	 * 根据充值编号获取充值
	 * @param string $sn 充值编号
	 * @return array
	 */
	public function getBySn($sn);
	
	/**
	 * 充值
	 * @param mixed $recharge
	 * @return boolean
	 */
	public function recharge($recharge);
	
	/**
	 * 支付充值
	 * @param mixed $recharge
	 * @return boolean
	 */
	public function pay($user, $recharge);
	
	/**
	 * 获取用户充值记录
	 * 
	 * @param int $userId
	 *        	用户ID
	 * @param int $page
	 *        	页数
	 * @param int $perpage
	 *        	每页个数
	 * @return array 返回一个二维数组
	 */
	public function getUserRecharges($userId, $page, $perpage);
	
	/**
	 * 获取充值记录
	 * 
	 * @param array|string $conditions
	 *        	获取条件
	 * @param array|string $order
	 *        	排序
	 * @param int $page
	 *        	页数
	 * @param int $perpage
	 *        	每页个数
	 * @return array 返回一个二维数组
	 */
	public function gets($conditions, $orders, $page, $perpage);
	
	/**
	 * 统计个数
	 * @param array/string $conditions
	 * @return int
	 */
	public function count($conditions);
}

?>