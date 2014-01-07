<?php

/**
 * 管理员服务
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-07-31 
 */
class ManagerService implements IManagerService{
	
	/**
	 * 管理员的数据访问接口
	 *
	 * @var ModelDao
	 */
	private $dao = null;
	
	public function __construct(){
		$this->dao = MD('Manager');
	}
	
	/*
	 * @see ManagerServiceInterface::isLogin()
	 */
	public function isLogin(){
		return HttpSession::get(ManagerService::SESSION_MANAGER_ID)? true : false;
	}
	
	/*
	 * @see ManagerServiceInterface::login()
	 */
	public function login($name, $password){
		$conditions = array(
			'name' => $name,
			'password' => md5(md5($password))
		);
		$manager = $this->dao->getOne($conditions);
		if($manager){
			$update = array(
				'last_login_time' => time()
			);
			$this->dao->update($update, $manager['id']);
		}
		return $manager;
	}
	
	/*
	 * @see ManagerServiceInterface::logout()
	 */
	public function logout($employeId){
		HttpSession::destroy(true);
	}
	
	/*
	 * @see ManagerServiceInterface::modifyPassword()
	 */
	public function modifyPassword($managereId, $password, $oldPassword){
		$manager = $this->dao->get($managereId);
		if(empty($manager)) return 0;
		// 验证原密码
		$oldPassword = md5(md5($oldPassword));
		if($oldPassword != $manager['password']) return -1;
		$update = array(
			'password' => md5(md5($password))
		);
		return $this->dao->update($update, $managereId)? 1 : 0;
	}
	
	/*
	 * (non-PHPdoc) @see IManagerService::getAll()
	 */
	public function getAll(){
		$managers = $this->dao->gets();
		$managers = ArrayUtil::changeKey($managers, 'id');
		return $managers;
	}
	
	/*
	 * @see IManagerService::isFounder()
	 */
	public function isFounder($employe){
		return $employe['id'] == self::ID_FOUNDER;
	}
}

?>