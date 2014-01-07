<?php

/**
 * 管理员服务接口
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-07-31
 */
interface IManagerService{
	
	/**
	 * 创建人ID
	 * @var int
	 */
	const ID_FOUNDER = 1;
	
	/**
	 * 登陆后ID保存到session的key
	 * @var string
	 */
	const SESSION_MANAGER_ID = 'sessionManagerId';
	
	/**
	 * 登陆后的信息保存到session的key
	 * @var string
	 */
	const SESSION_MANAGER = 'sessionManager';
	
	/**
	 * 获取所有的管理员,并用id作为它的数组下标
	 * @return array
	 */
	public function getAll();
	
	/**
	 * 是否处于登陆状态
	 * @return boolean
	 */
	public function isLogin();
	
	/**
	 * 管理员登陆
	 * @param string $name 用户名
	 * @param string $password 用户密码
	 * @return mixed 成功返回管理员数组,失败返回null
	 */
	public function login($name, $password);
	
	/**
	 * 管理员退出登陆
	 * @param int $managerId
	 */
	public function logout($managerId);
	
	/**
	 * 修改密码
	 * @param integer $managerId 用户id
	 * @param string $password 新密码
	 * @param string $oldPassword 旧密码
	 * @return int 返回修改结果状态 0:失败　-1:原密码不对　1:成功
	 */
	public function modifyPassword($managerId, $password, $oldPassword);
	
	/**
	 * 是否是创始人
	 * @param array $manager
	 * @return boolean
	 */
	public function isFounder($manager);
}

?>