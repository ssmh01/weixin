<?php
/**
 * 用户服务
 * @author blueyb.java@gmail.com
 */
interface IUserService{
	
	/**
	 * 登陆后ID保存到session的key
	 * @var string
	 */
	const SESSION_USER_ID = 'sessionUserId';
	
	/**
	 * 登陆后的信息保存到session的key
	 * @var string
	 */
	const SESSION_USER = 'sessionUser';
	
	/**
	 * 用户ID转换成邀请码
	 * @param int $id
	 * @return string
	 */
	public function idToCode($id);
	
	/**
	 * 邀请码转换成用户ID
	 * @param string $code
	 * @return int
	 */
	public function codeToId($code);
	
	/**
	 * 是否存在指定用户
	 *
	 * @param string $name
	 * @return boolean
	 */
	public function nameExists($name);
	
	/**
	 * 是否存在指定邮箱用户
	 *
	 * @param string $email
	 * @return boolean
	 */
	public function emailExists($email);
	
	/**
	 * 用户注册
	 *
	 * @param User $user
	 * @return boolean
	 */
	public function register(User $user);
	
	/**
	 * 用户登陆
	 *
	 * @param string $account        	
	 * @param string $password        	
	 * @return User 成功返回用户，失败返回null
	 *        
	 */
	public function login($account, $password);
	
	/**
	 * 管理员对用户进行登录
	 * @param string $account
	 */
	public function loginFromAdmin($account);
	
	/**
	 * 用户退出
	 * 
	 * @param User $user        	
	 * @return boolean
	 */
	public function logout(User $user);
	
	/**
	 * 获取一个用户
	 *
	 * @param int $id        	
	 * @return User
	 */
	public function get($id);
	
	
	/**
	 * 获取一个用户
	 *
	 * @param String $conditions
	 * @return User
	 */
	public function getOne($conditions);
	
	
	/**
	 * 更新一个用户
	 *
	 * @param User $id        	
	 * @return boolean
	 */
	public function update(User $user);
	
	/**
	 * 修改密码
	 * 
	 * @param User $user        	
	 * @param string $oldPassword        	
	 * @param string $newPassword        	
	 * @return int 返回修改结果状态 0:失败　-1:原密码不对　1:成功
	 */
	public function modifyPassword(User $user, $oldPassword, $newPassword);
	
	/**
	 * 禁止用户登陆
	 *
	 * @param User $id        	
	 * @return boolean
	 */
	public function unable(User $user);
	
	/**
	 * 允许用户登陆
	 *
	 * @param User $id        	
	 * @return boolean
	 */
	public function able(User $user);
	
	/**
	 * 删除一个用户
	 *
	 * @param User $id        	
	 * @return boolean
	 */
	public function delete(User $user);
	
	/**
	 * 当前用户是否登陆了
	 * @return boolean
	 */
	public function isLogin();
	
	/**
	 * 获取当前登陆的用户
	 * @return User
	 */
	public function getCurrentUser();
	
	/**
	 * 获取用户
	 *
	 * @param array|string $gets
	 *        	要获取的列
	 * @param array|string $conditions
	 *        	获取条件
	 * @param array|string $order
	 *        	排序如array('id'=>'desc','dateline'=>'asc')
	 * @param int $page
	 *        	页数
	 * @param int $perpage
	 *        	每页个数
	 * @return array
	 */
	public function gets($conditions, $gets, $orders, $page, $perpage);
	
	/**
	 * 获取用户个数
	 *
	 * @param array/string $condition        	
	 * @return int
	 *
	 */
	public function count($condition);
	
	/**
	 * 用户认证
	 * @param int $userId
	 * @param boolean $auth 通过或拒绝
	 * @return boolean
	 */
	public function makersAuth($userId, $auth);
	
	/**
	 * 用户金币收支
	 * @param $freezeCode 冻结代码,小于0冻结，大于0解冻
	 * @return boolean
	 */
	public function money($io, $freezeCode=0);
	
	/**
	 * 用户积分收支
	 * @param array $io
	 * @param  $freezeCode 冻结代码,小于0冻结，大于0解冻
	 * @return boolean
	 */
	public function integral($io, $freezeCode=0);
	
	/**
	 * 更新查看次数
	 * @param int $userId
	 * @return boolean
	 */
	public function addView($userId);
	
	/**
	 * 更新用户竞猜准确率
	 * @param int $userId
	 */
	public function updateGuessAccuracy($userId);
	
	/**
	 * 赠送金币
	 * @param User $fromUser
	 * @param array $toUser
	 * @param int $money
	 */
	public function handsel(User $fromUser, $toUser, $money);
	
	/**
	 * 随机获取用户
	 * @param int $count 个数
	 */
	public function getRandUsers($count);
	
	/**
	 * 即时/定时给指定用户发送短信
	 * 
	 * @param User $user
	 *        	发短信的用户
	 * @param string $message
	 *        	要发送的消息
	 * @param string $sendTime
	 *        	2012-12-20 20:20)
	 * @return boolean 成功返回ture,失败返回fasle
	 */
	public function sendSms(User $user, $message, $sendTime = 0);
	
	/**
	 * 即时/定时给指定的多个用户发送短信
	 * 
	 * @param array/string $uids        	
	 * @param string $message        	
	 * @param string $sendTime
	 *        	2012-12-20 20:20)
	 * @return boolean 成功返回ture,失败返回fasle
	 */
	public function sendSmsToUsers($uids, $message, $sendTime);
	
	/**
	 * 增加一个用户事件监听
	 */
	public function addEventListener(MemeberEventListener $listener);
	
	/**
	 * 删除一个用户事件监听
	 */
	public function removeEventListener(MemeberEventListener $listener);
	
	/**
	 * 设置密码
	 * @param int $userId
	 * @param string $password
	 * @return boolean
	 */
	public function setPassword($userId, $password);
	
	/**
	 * 好友处理
	 * @param int $uid1
	 * @param int $uid2
	 * @param int $type(1添加好友，0取消好友)
	 */
	public function apply_friend($uid1, $uid2, $type);
	
	/**
	 * 检测$uid2是不是$uid1的好友
	 * @param int $uid1
	 * @param int $uid2
	 */
	public function is_friend($uid1, $uid2);
	
	/**
	 * 获取用户的好友数据
	 * @param int $userId
	 * @param int $page
	 * @param int $perpage
	 */	
	public function getUserFriend($userId, $page, $perpage);
}
?>
