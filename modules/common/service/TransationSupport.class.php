<?php

/**
 * 数据库事务支持类
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-04-05
 */
abstract class TransationSupport {
	
	/**
	 * 开启事务
	 * @return 
	 */
	public function beginTransation(){
		$db = R::getDB();
		return $db->query("BEGIN");
	}
	
	/**
	 * 提交事务
	 * @return 
	 */
	public function commit(){
		$db = R::getDB();
		return $db->query("COMMIT");
	}
	
	/**
	 *回滚事务
	 * @return 
	 */
	public function rollBack(){
		$db = R::getDB();
		return $db->query("ROLLBACK");
	}
}

?>