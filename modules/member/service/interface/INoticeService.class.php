<?php

/**
 * 通知服务接口
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - Jan 8, 2013
 */
interface INoticeService{
	
	/**
	 * 发送通知
	 * @param  $notice 通知内容
	 * @param  $toUid 接收人
	 * @param 发送人 $fromUid, 0为系统
	 * @return boolean
	 */
	public function notice($notice, $toUid, $fromUid=0, $status=0);
	
	/**
	 * 获取一条通知
	 * @param int $id
	 * @return array 通知
	 */
	public function get($id);
	
	/**
	 * 获取用户新通知个数
	 * @param int $userId
	 * @return int 新通知个数
	 */
	public function getNewNoticeCount($userId);
	
}

?>