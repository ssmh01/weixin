<?php
/**
 * 参与竞猜服务接口
 * 
 * @author blueyb.java@gmail.com
 */
interface IPlayService{
	
	/**
	 * 参与一个参与
	 * @param Play $play
	 * @return boolean
	 */
	public function add(Play $play);
	
	/**
	 * 获取一个竞猜
	 * @param int $id
	 * @return Play
	 */
	public function get($id);
	
	/**
	 * 获取用户的竞猜参与数据
	 * @param int $userId
	 * @param int $guessId
	 * @return Play
	 */
	public function getUserPlay($userId, $guessId);
	
	/**
	 * 获取参与列表
	 * @param array/string $conditions
	 * @param array/string $gets
	 * @param array/string $orders
	 * @param int $page
	 * @param int $perpage
	 * @return array(Play)
	 */
	public function gets($conditions, $gets, $orders, $page, $perpage);
	
	/**
	 * 获取参与个数
	 * @param array/string $conditions
	 * @return int
	 */
	public function count($conditions);
	
	/**
	 * 获取用户参与的竞猜列表
	 * @param int $userId
	 * @param array/string $orders
	 * @param int $page
	 * @param int $perpage
	 * @return array(Guess)
	 */
	public function getGuesses($userId, $gets, $orders, $page, $perpage);
	
	/**
	 * 获取竞猜的所有参与
	 * @param Guess $guess
	 * @return boolean
	 */
	public function getPlays(Guess $guess);
	
}

?>