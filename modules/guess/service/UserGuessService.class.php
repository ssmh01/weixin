<?php

/**
 * 用户竞猜服务接口实现
 * 
 * @author blueyb.java@gmail.com
 */
class UserGuessService implements IUserGuessService{
	
	/**
	 * @var ModelDao
	 */
	private $dao = null;
	
	public function __construct(){
		$this->dao = MD('UserGuess');
	}
	
	/*
	 * @see IUserGuessService::add()
	 */
	public function add($userGuess){
		return $this->dao->add($userGuess);
	}
	
	/*
	 * @see IUserGuessService::count()
	 */
	public function count($conditions){
		return $this->dao->count($conditions);
	}
	
	/*
	 * @see IUserGuessService::getAttentionGuessCount()
	 */
	public function getAttentionGuessCount($userId){
		$conditions = array('from_uid'=>$userId, 'type'=>UserGuess::TYPE_ATTENTION);
		return $this->count($conditions);
	}
	
	/*
	 * @see IUserGuessService::getAttentionGuesses()
	 */
	
	public function getAttentionGuesses($userId, $page, $perpage){
		$guessTable = R::getConfig()->getConfig('database_prefix') . 'guess';
		$userGuessTable = R::getConfig()->getConfig('database_prefix') . 'user_guess';
		$type = UserGuess::TYPE_ATTENTION;
		$tempGuesses = array();
		$db = R::getDB();
		
		if($page >= 1){
			$start = ($page - 1) * $perpage;
			$r = $db->getRows("select guess_id from {$userGuessTable} where from_uid = '{$userId}' and `type`='{$type}' order by create_time desc limit $start,$perpage");
			$query_str = '';
			foreach($r as $v)
				$query_str .= empty($query_str) ? $v['guess_id'] : ',' . $v['guess_id'];

			if(!empty($query_str))
			{
				$sql = "select * from {$guessTable} where id in ($query_str)";
				$tempGuesses =  $db->getRows($sql);
			}			
		}else{
			$sql = "select * from {$guessTable} where id in (select guess_id from {$userGuessTable} where from_uid = '{$userId}' and `type`='{$type}' order by create_time desc)";
			$tempGuesses =  $db->getRows($sql);			
		}

		$guesses = array();
		foreach($tempGuesses as $guess){
			$guess['play_datas'] = unserialize($guess['play_datas']);
			$guess['parameter'] = unserialize($guess['parameter']);
			$guesses[$guess['id']] = $guess;
		}
		return $guesses;
	}
	
	/*
	 * @see IUserGuessService::getInviteGuessCount()
	 */
	public function getInviteGuessCount($userId){
		$conditions = array('to_uid'=>$userId, 'type'=>UserGuess::TYPE_INVITE);
		return $this->count($conditions);
	}
	
	/*
	 * @see IUserGuessService::getInviteGuesses()
	 */
	public function getInviteGuesses($userId, $page, $perpage){
		$guessTable = R::getConfig()->getConfig('database_prefix') . 'guess';
		$userGuessTable = R::getConfig()->getConfig('database_prefix') . 'user_guess';
		$type = UserGuess::TYPE_INVITE;
		$tempGuesses = array();
		$db = R::getDB();
		if($page >= 1){
			$start = ($page - 1) * $perpage;
			$r = $db->getRows("select guess_id from {$userGuessTable} where to_uid = '{$userId}' and `type`='{$type}' order by create_time desc limit $start,$perpage");
			$query_str = '';
			foreach($r as $v)
				$query_str .= empty($query_str) ? $v['guess_id'] : ',' . $v['guess_id'];

			if(!empty($query_str))
			{
				$sql = "select * from {$guessTable} where id in ($query_str)";
				$tempGuesses =  $db->getRows($sql);
			}
		}else{
			$sql = "select * from {$guessTable} where id in (select guess_id from {$userGuessTable} where to_uid = '{$userId}' and `type`='{$type}' order by create_time desc)";
			$tempGuesses =  $db->getRows($sql);
		}

		$guesses = array();
		foreach($tempGuesses as $guess){
			$guess['play_datas'] = unserialize($guess['play_datas']);
			$guess['parameter'] = unserialize($guess['parameter']);
			$guesses[$guess['id']] = $guess;
		}
		return $guesses;
	}
	
	/**
	 * @see IUserGuessService::getFriendGuessCount()
	 */
	public function getFriendGuessCount($userId)
	{
		$userDao = MD('user');
		$f = $userDao->get($userId,'friend');
		$friend_str = $f['friend'];
		
		if(empty($friend_str)) return 0;
		$guessDao = MD('guess');
		return $guessDao->count("user_id IN($friend_str)");
	}
	
	/**
	 * @see IUserGuessService::getFriendGuesses()
	 */
	public function getFriendGuesses($userId, $page, $perpage)
	{
		$guessTable = R::getConfig()->getConfig('database_prefix') . 'guess';
		
		$userDao = MD('user');
		$f = $userDao->get($userId,'friend');
		$friend_str = $f['friend'];
		
		$tempGuesses = array();
		$db = R::getDB();
		if(!empty($friend_str))
		{
			if($page >= 1){
				$start = ($page - 1) * $perpage;
				$sql = "select * from {$guessTable} where user_id in ($friend_str) LIMIT $start,$perpage";
				$tempGuesses =  $db->getRows($sql);
			}else{
				$sql = "select * from {$guessTable} where user_id in ($friend_str)";
				$tempGuesses =  $db->getRows($sql);
			}
		}
		
		$guesses = array();
		foreach($tempGuesses as $guess){
			$guess['play_datas'] = unserialize($guess['play_datas']);
			$guess['parameter'] = unserialize($guess['parameter']);
			$guesses[$guess['id']] = $guess;
		}
		return $guesses;
	}
	
	/*
	 * @see IUserGuessService::gets()
	 */
	public function gets($conditions, $gets, $orders, $page, $perpage){
		return $this->dao->gets($conditions, $gets, $orders, $page, $perpage);
	}
	
	/* 
	 * @see IUserGuessService::delete()
	 */
	public function delete($userGuess){
		return $this->dao->deletes($userGuess);
	}
}

?>