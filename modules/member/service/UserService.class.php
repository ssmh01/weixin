<?php

/**
 * 用户服务
 * @author blueyb.java@gmail.com
 * @since 1.0 - Dec 27, 2012
 */
class UserService extends TransationSupport implements IUserService{
	
	/**
	 * 存放监听器
	 *
	 * @var array
	 */
	private $listeners = array();
	
	/**
	 * 转换基数
	 *
	 * @var string
	 */
	private static $baseNumber = 123456;
	
	/**
	 *
	 * @var ModelDao
	 */
	private $dao = null;
	public function __construct(){
		$this->dao = MD('User');
	}
	
	/**
	 * 使用户数据更适合使用
	 * @param array $users
	 */
	public static function usersDataProper($users){
		foreach($users as $key => $user){
			if(!$user['avatar']){
				$users[$key]['avatar'] = User::AVATAR_DEFAULT;
			}
			if($user['configs']){
				$users[$key]['configs'] = unserialize($user['configs']);
			}
		}
		return $users;
	}
	
	/**
	 * 批量获取用户
	 *
	 * @return array
	 */
	public static function usersGet(){
		global $_UIDS, $_USERS;
		if(empty($_UIDS)) return $_USERS;
		if(empty($_USERS)){
			$_USERS = array();
		}
		$modelDao = MD('User');
		$userIds = implode(',', $_UIDS);
		$users = $modelDao->gets("id in ({$userIds})");
		if($users){
			$_USERS = $_USERS + ArrayUtil::changeKey($users, 'id');
		}
		return $_USERS;
	}
	
	/**
	 * 设置要获取的用户的ID
	 *
	 * @param array/int $uids        	
	 */
	public static function usersSet($uids){
		if(!$uids) return;
		global $_UIDS;
		if(!isset($_UIDS)){
			$_UIDS = array();
		}
		if(is_array($uids)){
			$_UIDS = array_merge($_UIDS, $uids);
		}else{
			$_UIDS[] = $uids;
		}
		$_UIDS = array_unique($_UIDS);
	}
	
	/**
	 * 添加用户
	 *
	 * @param array $users        	
	 */
	public static function usersAdd($users){
		global $_USERS;
		if(empty($_USERS)){
			$_USERS = array();
		}
		$_USERS = $_USERS + $users;
	}
	
	/*
	 * @see IUserSerivce::addEventListener()
	 */
	public function addEventListener(MemeberEventListener $listener){
		$this->listeners[] = $listener;
	}
	
	/*
	 * @see IUserSerivce::removeEventListener()
	 */
	public function removeEventListener(MemeberEventListener $listener){
		foreach($this->listeners as $key => $value){
			if($value === $listener){
				unset($this->listeners[$key]);
			}
		}
	}
	
	/*
	 * @see IUserSerivce::able()
	 */
	public function able(User $user){
		$update = array(
			'allow_login' => '1'
		);
		return $this->dao->update($update, $user->getId());
	}
	
	/*
	 * @see IUserSerivce::count()
	 */
	public function count($condition){
		return $this->dao->count($condition);
	}
	
	/*
	 * @see IUserSerivce::delete()
	 */
	public function delete(User $user){
		// TODO Auto-generated method stub
	}
	
	/*
	 * @see IUserSerivce::get()
	 */
	public function get($id){
		$user = ModelTransform::toCustomModel($this->dao->get($id, null, true), 'User');
		if($user && !$user->getAvatar()){
			$user->setAvatar(User::AVATAR_DEFAULT);
		}
		return $user;
	}
	
	/*
	 * @see IUserSerivce::getOne()
	*/
	public function getOne($conditions){
		$user = ModelTransform::toCustomModel($this->dao->getOne($conditions, null, true), 'User');
		if($user && !$user->getAvatar()){
			$user->setAvatar(User::AVATAR_DEFAULT);
		}
		return $user;
	}	
	
	/*
	 * @see IUserSerivce::gets()
	 */
	public function gets($conditions, $gets, $orders, $page, $perpage){
		$users = $this->dao->gets($conditions, $gets, $orders, $page, $perpage);
		return self::usersDataProper($users);
	}
	
	/*
	 * @see IUserSerivce::login()
	 */
	public function login($account, $password){
		$conditions = array(
			'password' => md5(md5($password)),
		);
		if(String::test(String::REGEX_EMAIL, $account)){
			// 邮箱登录
			$conditions['email'] = $account;
		}else{
			// 用户名登录
			$conditions['name'] = $account;
		}
		$user = $this->dao->getOne($conditions, null, true);
		if($user){
			
			if($user->allow_login == '1')
			{
				// 登陆成功
				$user = ModelTransform::toCustomModel($user, 'User');
				$keepDay = intval(R::getRequest()->getParameter('keep'));
				if($keepDay){
					$expire = time() + $keepDay * 86400;
					setcookie(session_name(), session_id(), $expire, "/");
				}
				HttpSession::set(self::SESSION_USER_ID, $user->getId());
				HttpSession::set(self::SESSION_USER, $user);
				$update = array(
					'last_login_time' => time()
				);
				$this->dao->update($update, $user->getId());
				foreach($this->listeners as $listener){
					$listener->login($user);
				}
			}
			else 
			{
				$user = -1; //管理员禁止该用户登录
			}
		}
		else 
		{
			$user = 0; //用户名或密码不正确
		}
		return $user;
	}
	
	/*
	 * @see IUserSerivce::loginFromAdmin()
	*/
	public function loginFromAdmin($account){
		if(String::test(String::REGEX_EMAIL, $account)){
			// 邮箱登录
			$conditions['email'] = $account;
		}else{
			// 用户名登录
			$conditions['name'] = $account;
		}
		$user = $this->dao->getOne($conditions, null, true);
		if($user){
			// 登陆成功
			$user = ModelTransform::toCustomModel($user, 'User');
			HttpSession::set(self::SESSION_USER_ID, $user->getId());
			HttpSession::set(self::SESSION_USER, $user);
		}
		return $user;
	}
	
	/*
	 * @see IUserSerivce::logout()
	 */
	public function logout(User $user){
		HttpSession::destroy();
		foreach($this->listeners as $listener){
			$listener->logout($user);
		}
	}
	
	/*
	 * @see IUserSerivce::modifyPassword()
	 */
	public function modifyPassword(User $user, $oldPassword, $newPassword){
		if(empty($user)) return 0;
		// 验证原密码
		$oldPassword = md5(md5($oldPassword));
		if($oldPassword != $user->getPassword()) return -1;
		$update = array(
			'password' => md5(md5($newPassword))
		);
		return $this->dao->update($update, $user->getId())? 1 : 0;
	}
	
	/*
	 * @see IUserSerivce::register()
	 */
	public function register(User $user){
		$user->setConfigs(serialize(User::$CONFIGS_DEFAULT));
		$user->setPassword(md5(md5($user->getPassword())));
		$user->setAllowLogin(1);
		$user->setAvailableMoney(0.0);
		$user->setRegisterTime(time());
		$userId = $this->dao->add($user);
		if(!$userId) return false;
		$user->setId($userId);
		//发送注册通知
		$registerIntegral = intval(R::getConfig()->getConfig('integral_register'));
		if($registerIntegral){
			//赠送
			$io = array(
				'from_user_id' => 0,
				'to_user_id' => $userId,
				'to_title' => "注册赠送",
				'wealth_type' => Io::WEALTH_TYPE_INTEGRAL,
				'wealth' => $registerIntegral,
				'from_balance' => $registerIntegral
			);
			$this->integral($io);
			//通知
			$notice = "欢迎你注册成为" . R::getConfig()->getConfig('site_name') . "会员，系统赠送你{$registerIntegral}积分";
			MemberServiceFactory::getNoticeService()->notice($notice, $userId);
		}
		try{
			foreach($this->listeners as $listener){
				$listener->register($user);
			}
		}catch(Exception $e){
			return false;
		}
		return true;
	}
	
	/*
	 * @see IUserSerivce::unable()
	 */
	public function unable(User $user){
		// TODO Auto-generated method stub
	}
	
	/*
	 * @see IUserSerivce::update()
	 */
	public function update(User $user){
		// TODO Auto-generated method stub
	}
	
	/*
	 * @see IUserSerivce::sendSms()
	 */
	public function sendSms(User $user, $message, $sendTime = 0){
		if(empty($user['mobile'])) return false;
		$smsService = ToolsServiceFactory::getSmsService();
		return $smsService->send($user['mobile'], $message, $sendTime);
	}
	
	/*
	 * @see IUserSerivce::sendSmsToUsers()
	 */
	public function sendSmsToUsers($uids, $message, $sendTime){
		if(empty($uids) || !$message) return false;
		if(is_array($uids)){
			$uids = implode(',', $uids);
		}
		$conditions = array(
			'conditions' => "id in ('{$uids}') and mobile != ''"
		);
		$users = $this->gets($conditions, 'mobile');
		$mobiles = ArrayUtil::colKeySet($users, 'mobile', true);
		unset($users);
		if(empty($mobiles)) return false;
		$smsService = ToolsServiceFactory::getSmsService();
		return $smsService->send($mobiles, $message, $sendTime);
	}
	
	/*
	 * @see IUserSerivce::exists()
	 */
	public function nameExists($name){
		$conditions = array(
			'name' => $name
		);
		return $this->dao->count($conditions)? true : false;
	}
	
	/*
	 * @see IUserSerivce::exists()
	 */
	public function emailExists($email){
		$conditions = array(
			'email' => $email
		);
		return $this->dao->count($conditions)? true : false;
	}
	
	/*
	 * @see IUserSerivce::getCurrentUser()
	 */
	public function getCurrentUser(){
		$userId = HttpSession::get(self::SESSION_USER_ID);
		if(!$userId) return null;
		$user = $this->get($userId);
		// 获取短消息个数和通知个数
		$newNoticeCount = MemberServiceFactory::getNoticeService()->getNewNoticeCount($userId);
		$newMessageCount = MemberServiceFactory::getMessageService()->getNewMessageCount($userId);
		$user->setNewNoticeCount($newNoticeCount);
		$user->setNewMessageCount($newMessageCount);
		return $user;
	}
	
	/*
	 * @see IUserService::isLogin()
	 */
	public function isLogin(){
		return HttpSession::get(self::SESSION_USER_ID)? true : false;
	}
	
	/*
	 * @see IUserService::codeToId()
	 */
	public function codeToId($code){
		if(!is_numeric($code) || $code <= self::$baseNumber) return 0;
		return $code - self::$baseNumber;
	}
	
	/*
	 * @see IUserService::idToCode()
	 */
	public function idToCode($id){
		return intval($id) + self::$baseNumber;
	}
	
	/*
	 * @see IUserService::makersAuth()
	 */
	public function makersAuth($userId, $auth){
		$user = $this->dao->get($userId);
		if(!$user) return false;
		try{
			$this->beginTransation();
			if($auth){
				$update = array(
					'makers_level' => '1'
				);
			}else{
				$update = array(
					'makers_level' => '0'
				);
			}
			$success = $this->dao->update($update, $userId);
			if(!$success){
				$this->rollBack();
				return false;
			}
			$dao = MD('MakersAuth');
			$makersAuth = $dao->get($userId);
			if($makersAuth){
				if($auth){
					$update = array(
						'status' => '1'
					);
				}else{
					$update = array(
						'status' => '-1'
					);
				}
				$success = $dao->update($update, $userId);
				if(!$success){
					$this->rollBack();
					return false;
				}
			}
			$this->commit();
			return true;
		}catch(Exception $exception){
			$this->rollBack();
			return false;
		}
		return true;
	}
	
	/*
	 * @see IUserService::integral()
	 */
	public function integral($io, $freezeCode = 0){
		if(!$io) return false;
		if($freezeCode){
			if($freezeCode > 0){
				// 解冻
				$userId = $io['to_user_id'];
				$update = array(
					'available_integral' => "available_integral + {$io['wealth']}",
					'freeze_integral' => "freeze_integral - {$io['wealth']}"
				);
			}else{
				// 冻结
				$userId = $io['from_user_id'];
				$update = array(
					'available_integral' => "available_integral - {$io['wealth']}",
					'freeze_integral' => "freeze_integral + {$io['wealth']}"
				);
			}
			$success = $this->dao->update($update, $userId, true);
			if(!$success) return false;
		}else{
			if($io['to_user_id']){
				$update = array(
					'available_integral' => "available_integral + {$io['wealth']}"
				);
				$success = $this->dao->update($update, $io['to_user_id'], true);
				if(!$success) return false;
			}
			if($io['from_user_id']){
				$update = array(
					'available_integral' => "available_integral - {$io['wealth']}"
				);
				$success = $this->dao->update($update, $io['from_user_id'], true);
				if(!$success) return false;
			}
		}
		$io['create_time'] = time();
		$ioDao = MD('io');
		$ioDao->add($io);
		return true;
	}
	
	/*
	 * @see IUserService::money()
	 */
	public function money($io, $freezeCode = 0){
		if(!$io) return false;
		if($freezeCode){
			if($freezeCode > 0){
				// 解冻
				$userId = $io['to_user_id'];
				$update = array(
					'available_money' => "available_money + {$io['wealth']}",
					'freeze_money' => "freeze_money - {$io['wealth']}"
				);
			}else{
				// 冻结
				$userId = $io['from_user_id'];
				$update = array(
					'available_money' => "available_money - {$io['wealth']}",
					'freeze_money' => "freeze_money + {$io['wealth']}"
				);
			}
			$success = $this->dao->update($update, $userId, true);
			if(!$success) return false;
		}else{
			if($io['to_user_id']){
				$update = array(
					'available_money' => "available_money + {$io['wealth']}"
				);
				$success = $this->dao->update($update, $io['to_user_id'], true);
				if(!$success) return false;
			}
			if($io['from_user_id']){
				$update = array(
					'available_money' => "available_money - {$io['wealth']}"
				);
				$success = $this->dao->update($update, $io['from_user_id'], true);
				if(!$success) return false;
			}
		}
		$io['create_time'] = time();
		$ioDao = MD('io');
		$ioDao->add($io);
		return true;
	}
	
	/*
	 * @see IUserService::handsel()
	 */
	public function handsel(User $fromUser, $toUser, $money){
		if(!$fromUser || !$toUser || $money < 1 || $fromUser->getAvailableMoney() < $money){
			return false;
		}
		try{
			$this->beginTransation();
			$io = array(
				'from_user_id' => $fromUser->getId(),
				'from_title' => "赠送给用户[{$toUser['name']}]",
				'from_balance' => $fromUser->getAvailableMoney() - $money,
				'to_user_id' => $toUser['id'],
				'to_title' => "用户[{$fromUser->getName()}]赠送",
				'to_balance' => $toUser['available_money'] + $money,
				'wealth_type' => Io::WEALTH_TYPE_MONEY,
				'wealth' => $money
			);
			if(!$this->money($io)){
				$this->rollBack();
				return false;
			}
			$this->commit();
			return true;
		}catch(Exception $exception){
			die($exception->getMessage());
			$this->rollBack();
			return false;
		}
	}
	
	/*
	 * @see IUserService::addView()
	 */
	public function addView($userId){
		$this->dao->update(array('views'=>'views + 1'), $userId, true);
	}
		
	/*
	 * @see IUserService::getRandUsers()
	 */
	public function getRandUsers($count=5){
		$userTable = R::getConfig()->getConfig('database_prefix') . 'user';
		$sql = "SELECT * FROM {$userTable} AS t1 JOIN (SELECT ROUND(RAND() * ((SELECT MAX(id) FROM {$userTable})-(SELECT MIN(id) FROM {$userTable}))+(SELECT MIN(id) FROM {$userTable})) AS id) AS t2 WHERE t1.id >= t2.id ORDER BY t1.id LIMIT {$count}";
		$db = R::getDB();
		$users = $db->getRows($sql);
		return self::usersDataProper($users);
	}
	
	/* 
	 * @see IUserService::updateGuessAccuracy()
	 */
	public function updateGuessAccuracy($userId){
		if(!$userId) return false;
		$userPlays = MD('Play')->gets(array('user_id'=>$userId, 'status'=>Play::STATUS_REDGED));
		$totalCount = count($userPlays);
		if(!$totalCount) return false;
		$winCount = 0;
		foreach($userPlays as $play){
			if($play['win_wealth'] > 0){
				$winCount++;
			}
		}
		$accuracy = intval(($winCount / $totalCount) * 100);
		return $this->dao->update(array('accuracy'=>$accuracy), $userId);
	}
	
	/*
	 * @see IUserService::setPassword()
	*/
	public function setPassword($userId, $password){
		if(!$userId) return ;
		$password = md5(md5($password));
		return $this->dao->update(array('password'=>$password), $userId);
	}
	
	/**
	 * @see IUserService::apply_friend()
	 */
	public function apply_friend($uid1, $uid2, $type){
		$db = R::getDB();
		
		$u1 = $db->getRow("SELECT friend FROM yyx_user WHERE id='$uid1'");
		$u2 = $db->getRow("SELECT friend FROM yyx_user WHERE id='$uid2'");

		$u1_friend = $u1['friend'];
		$u2_friend = $u2['friend'];
		
		if($type == 1) //添加好友
		{
			if(strpos(',' . $u1_friend . ',', ',' . $uid2 . ',') === false) $u1_friend = empty($u1_friend) ? $uid2 : $u1_friend . ',' . $uid2;
			if(strpos(',' . $u2_friend . ',', ',' . $uid1 . ',') === false) $u2_friend = empty($u2_friend) ? $uid1 : $u2_friend . ',' . $uid1;
		}
		else //取消好友
		{
			$u1_friend = str_replace(',' . $uid2 . ',', ',', ',' . $u1_friend . ',');
			$u2_friend = str_replace(',' . $uid1 . ',', ',', ',' . $u2_friend . ',');
			$u1_friend = trim($u1_friend, ',');
			$u2_friend = trim($u2_friend, ',');
		}
		
		$db->query("UPDATE yyx_user SET friend='$u1_friend' WHERE id='$uid1'");
		$db->query("UPDATE yyx_user SET friend='$u2_friend' WHERE id='$uid2'");
	}
	
	/**
	 * @see IUserService::is_friend()
	 */
	public function is_friend($uid1, $uid2)
	{
		$r = $this->dao->get($uid1, 'friend');
		$friend = $r['friend'];
		return strpos(','.$friend.',', ','.$uid2.',') !== false;
	}
	
	/**
	 * @see IUserService::getUserFriend()
	 */
	public function getUserFriend($userId, $page, $perpage)
	{
		$userTable = R::getConfig()->getConfig('database_prefix') . 'user';
		$users = array();
		$db = R::getDB();
		$friend = $db->getRowFiled("SELECT friend FROM {$userTable} WHERE id='$userId'");
		if(!empty($friend))
		{
			if($page > 1)
			{
				$friend_arr = explode(',', $friend);				
				$start = ($page - 1) * $perpage;
				$query_arr = array_slice($friend_arr, $start, $perpage);
				if(!empty($query_arr))
				{
					$query_str = implode(',', $query_arr);
					$sql = "SELECT * FROM {$userTable} WHERE id IN($query_str)";
					$users = $db->getRows($sql);
				}
			}
			else
			{
				$sql = "SELECT * FROM {$userTable} WHERE id IN($friend)";
				$users = $db->getRows($sql);				
			}			
		}
		return self::usersDataProper($users);
	}	
}

?>