<?php

/**
 * 短消息服务接口实现
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - Jan 4, 2013
 */
class MessageService extends TransationSupport implements IMessageService{
	
	/**
	 *
	 * @var ModelDao
	 */
	private $dao = null;
	public function __construct(){
		$this->dao = MD('Message');
	}
	
	/*
	 * @see IMessageService::message()
	 */
	public function message($title, $message, $toUid, $fromUid = 0, $replyId = 0){
		$item = array(
			'to_uid' => $toUid,
			'from_uid' => $fromUid,
			'reply_id' => $replyId,
			'content' => $message,
			'new'=>1,
			'create_time'=>time(),
		);
		return $this->dao->add($item);
	}
	
	/*
	 * @see IMessageService::registerMessage()
	 */
	public function registerMessage(User $user, $datas = array()){
		// TODO Auto-generated method stub
	}
	
	/*
	 * @see IMessageService::getNewMessageCount()
	 */
	public function getNewMessageCount($userId){
		if(!$userId) return 0;
		$conditions = array(
			'to_uid' => $userId,
			'new' => '1'
		);
		return $this->dao->count($conditions);
	}
	
	/*
	 * @see IMessageService::get()
	 */
	public function get($id){
		if(!$id) return null;
		$this->dao->update(array(
			'new' => '0'
		), $id);
		return $this->dao->get($id);
	}
}

?>