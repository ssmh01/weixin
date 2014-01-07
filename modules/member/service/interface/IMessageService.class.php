<?php

/**
 * 短消息服务接口
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - Jan 8, 2013
 */
interface IMessageService{
	
	/**
	 * 发送消息
	 * @param string $title 短消息标题
	 * @param string $message 短消息
	 * @param int $toUid 收信人
	 * @param int $fromUid	发信人，0为系统
	 * @param int $replyId	回复的短消息ID
	 */
	public function message($title, $message, $toUid, $fromUid=0, $replyId=0);
	
	/**
	 * 获取一条短消息
	 * @param int $id
	 * @return array 短消息
	 */
	public function get($id);
	
	/**
	 * 获取用户新短消息个数
	 * @param int $userId
	 * @return int 新短消息个数
	 */
	public function getNewMessageCount($userId);
	
	/**
	 * 用户注册发送的消息
	 * @param User $user 用户
	 * @param array $datas 其它数据
	 */
	public function registerMessage(User $user, $datas=array());
}

?>