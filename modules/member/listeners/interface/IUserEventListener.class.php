<?php
/**
 * 用户事件监听接口
 * @author blueyb.java@gmail.com
 */
interface IUserEventListener{

	/**
	 * 会员注册事件
	 * @param User $user
	 */
	public function register(User $user);

	/**
	 * 会员登录事件
	 * @param User $user
	*/
	public function login(User $user);

	/**
	 * 会员退出事件
	 * @param User $user
	*/
	public function logout(User $user);
}