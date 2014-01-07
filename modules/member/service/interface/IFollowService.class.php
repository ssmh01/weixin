<?php

/**
 * 关注好友服务接口
 * 
 * @author blueyb.java@gmail.com
 */
interface IFollowService{
	
	/**
	 * 添加一个关注
	 * @param Follow $follow
	 */
	public function add(Follow $follow);
	
	/**
	 * 获取用户关注的用户列表
	 * @param int $userId
	 * @param int $page
	 * @param int $perpage
	 * @return array
	 */
	public function getUserFollows($userId, $page, $perpage);
	
	/**
	 * 获取用户的粉丝列表
	 * @param int $userId
	 * @param int $page
	 * @param int $perpage
	 * @return array
	 */
	public function getUserFans($userId, $page, $perpage);
	
	/**
	 * 获取用户关注的用户ID列表
	 * @param int $userId
	 * @param int $page
	 * @param int $perpage
	 * @return array
	 */
	public function getUserFollowIds($userId, $page, $perpage);
	
	/**
	 * 用户是否关注是另一个用户
	 * @param int $fromUid
	 * @param int $toUid
	 */
	public function isFollow($fromUid, $toUid);
}

?>