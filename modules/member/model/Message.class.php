<?php
/**
 * 消息模型
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-12-26
 */
class Message extends DynamicModelTransformSupport{

	/**
	 * 发信人，0为系统 
	 * @var int 
	 */
	private $id;

	/**
	 * 发信人，0为系统 
	 * @var int 
	 */
	private $fromUid;

	/**
	 * 收信人 
	 * @var int 
	 */
	private $toUid;

	/**
	 * 回复消息 
	 * @var int 
	 */
	private $replyId;

	/**
	 * 标题 
	 * @var string 
	 */
	private $title;

	/**
	 * 消息内容 
	 * @var string 
	 */
	private $content;

	/**
	 * 是否是新消息 
	 * @var int 
	 */
	private $new;

	/**
	 * 发信人消息状态 
	 * @var int 
	 */
	private $fromStatus;

	/**
	 * 收信人消息状态 
	 * @var int 
	 */
	private $toStatus;

	/**
	 * 发信时间 
	 * @var int 
	 */
	private $createTime;

	/**
	 * 
	 * @return int 
	 */
	public function getId(){ 
		return $this->id;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setId($id){ 
		$this->id = $id; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getFromUid(){ 
		return $this->fromUid;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setFromUid($fromUid){ 
		$this->fromUid = $fromUid; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getToUid(){ 
		return $this->toUid;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setToUid($toUid){ 
		$this->toUid = $toUid; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getReplyId(){ 
		return $this->replyId;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setReplyId($replyId){ 
		$this->replyId = $replyId; 
	}

	/**
	 * 
	 * @return string 
	 */
	public function getTitle(){ 
		return $this->title;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setTitle($title){ 
		$this->title = $title; 
	}

	/**
	 * 
	 * @return string 
	 */
	public function getContent(){ 
		return $this->content;
	}

	/**
	 * 
	 * @param string  
	 */
	public function setContent($content){ 
		$this->content = $content; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getNew(){ 
		return $this->new;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setNew($new){ 
		$this->new = $new; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getFromStatus(){ 
		return $this->fromStatus;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setFromStatus($fromStatus){ 
		$this->fromStatus = $fromStatus; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getToStatus(){ 
		return $this->toStatus;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setToStatus($toStatus){ 
		$this->toStatus = $toStatus; 
	}

	/**
	 * 
	 * @return int 
	 */
	public function getCreateTime(){ 
		return $this->createTime;
	}

	/**
	 * 
	 * @param int  
	 */
	public function setCreateTime($createTime){ 
		$this->createTime = $createTime; 
	}
}?>