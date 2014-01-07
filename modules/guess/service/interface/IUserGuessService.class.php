<?php
/**
 * 用户竞猜服务接口
 * 
 * @author blueyb.java@gmail.com
 */
interface IUserGuessService{
	
	/**
	 * 添加用户－竞猜
	 * @param array/Model/UserGuess $userGuess
	 * @return boolean
	 */
	public function add($userGuess);
	
	/**
	 * 删除用户－竞猜
	 * @param array/Model/UserGuess $userGuess
	 * @return boolean
	 */
	public function delete($userGuess);
	
	/**
	 * 获取竞猜列表
	 * @param array/string $conditions
	 * @param array/string $gets
	 * @param array/string $orders
	 * @param int $page
	 * @param int $perpage
	 * @return array(Guess)
	 */
	public function gets($conditions, $gets, $orders, $page, $perpage);
	
	/**
	 * 获取竞猜个数
	 * @param array/string $conditions
	 * @return int
	 */
	public function count($conditions);
	
	/**
	 * 获取用户关注的竞猜列表
	 * @param int $userId
	 * @param int $page
	 * @param int $perpage
	 * @return array(Guess)
	 */
	public function getAttentionGuesses($userId, $page, $perpage);
	
	/**
	 * 获取用户关注的竞猜个数
	 * @param int $userId
	 * @return int
	 */
	public function getAttentionGuessCount($userId);
	
	/**
	 * 获取邀请用户的竞猜列表
	 * @param int $userId
	 * @param int $page
	 * @param int $perpage
	 * @return array(Guess)
	 */
	public function getInviteGuesses($userId, $page, $perpage);
	
	/**
	 * 获取邀请用户的竞猜个数
	 * @param int $userId
	 * @return int
	 */
	public function getInviteGuessCount($userId);
	
	/**
	 * 获取好友竞猜个数
	 * @param int $userId
	 * @return int
	 */
	public function getFriendGuessCount($userId);
	
	/**
	 * 获取好友竞猜列表
	 * @param int $userId
	 * @param int $page
	 * @param int $perpage
	 * @return array(Guess)
	 */
	public function getFriendGuesses($userId, $page, $perpage);
}

?>