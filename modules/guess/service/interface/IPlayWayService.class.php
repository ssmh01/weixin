<?php
/**
 * 玩法服务接口
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - Jan 14, 2013
 */
interface IPlayWayService{
	
	/**
	 * 添加一个玩法
	 * @param PlayWay $playWay
	 */
	public function add(PlayWay $playWay);
	
	/**
	 * 获取一个玩法
	 * @param int $id
	 * @return PlayWay
	 */
	public function get($id);
	
	/**
	 * 获取指定条件下的玩法
	 * @param array/string $conditions
	 * @return array
	 */
	public function gets($conditions=null);
	
	/**
	 * 获取指定条件下的玩法
	 * @param array/string $conditions
	 * @return array
	 */
	public function getObjects($conditions=null);
}

?>