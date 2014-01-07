<?php

/**
 * This class use to create sql.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-06-05
 */
class SQL{
	
	/**
	 * 创建查询SQL
	 * @param string $table
	 * 	表名
	 * @param array/string/null $gets
	 * 	要查询的列
	 * @param array/string/null $conditions
	 * 	查询条件
	 * @param array/string/null $order
	 *  排序方式
	 * @param int/null $page
	 * 	查询页数
	 * @param int/null $perpage
	 *  每页多少条记录
	 */
	public static function createSelect($table, $gets, $conditions, $orders, $page, $perpage){
		if(empty($table)){
			throw new DatabaseException("Create SQL Error: table name is missing");
		}
		$sql = "";
		if(empty($gets)){
			$sql = "select *";
		}elseif(is_array($gets)){
			$sql = "select ";
			$comma = "";
			foreach($gets as $key=>$value){
				$sql .= $comma . '`' . $value . '`';
				$comma = ",";
			}
		}elseif (is_string($gets)) {
			$sql = "select {$gets}";
		}else{
			throw new DatabaseException("Create SQL Error: select parameter is illegal");
		}
		$sql .= " from {$table} ";
		if($conditions){
			$con = self::createCondition($conditions);
			if($con == null){
				throw new DatabaseException("Create SQL Error: select condition is illegal");
			}else{
				$sql .= " where {$con}";
			}
		}
		if($orders){
			if(is_string($orders)){
				$sql .= " order by {$orders}";
			}elseif(is_array($orders)){
				$sql .= " order by ";
				$comma = "";
				foreach($orders as $key=>$value){
					$sql .= $comma . " " . $key . " " . $value;
					$comma = ",";
				}
			}else{
				throw new DatabaseException("Create SQL Error: select order is illegal");
			}
		}
		if(!empty($page) && !empty($perpage)){
			$start = self::getStart($page, $perpage);
			$sql .= " limit {$start},{$perpage}";
		}
		return $sql;
	}
	
	/**
	 * 创建插入SQL
	 * @param string $table
	 * 	表名
	 * @param array $datas
	 * 	数据
	 */
	public static function createInsert($table, $datas){
		if(empty($table)){
			throw new DatabaseException("Create SQL Error: table name is missing");
		}
		if(!is_array($datas) || empty($datas)){
			throw new DatabaseException("Create SQL Error: insert datas is illegal");
		}
		$insertKey = $insertValue = $comma = '';
		foreach ($datas as $key => $value) {
			$insertKey .= $comma."`" . $key ."`";
			$insertValue .= $comma."'" . $value."'";
			$comma = ", ";
		}
		$sql = "insert into {$table}(" . $insertKey . ") VALUES (" . $insertValue . ")";
		return $sql;
	}
	
	/**
	 * 创建更新SQL
	 * @param string $table
	 * 	表名
	 * @param array $datas
	 * 	数据
	 * @param string/array $conditions
	 * 	条件
	 * @param boolean $intMode
	 * 	是否开启值运算模式,如果开启则支持在原来的值上进行运算,默认不开启.
	 */
	public static function createUpdate($table, $datas, $conditions, $mathMode=false){
		if(empty($table)){
			throw new DatabaseException("Create SQL Error: table name is missing");
		}
		if(!is_array($datas) || empty($datas)){
			throw new DatabaseException("Create SQL Error: update datas is illegal");
		}
		$setSql = $comma = "";
		if(!$mathMode){
			foreach ($datas as $key => $value) {
				$setSql .= $comma . "`" . $key . "`" . " = '" . $value . "'";
				$comma = ", ";
			}
		}else{
			foreach ($datas as $key => $value) {
				if(!self::isMathValue($value)){
					$setSql .= $comma . "`" . $key . "`" . " = '" . $value . "'";
				}else{
					$setSql .= $comma . "`" . $key . "`" . " = " . $value;
				}
				$comma = ", ";
			}
		}
		$sql = "update {$table} set {$setSql} ";
		if($conditions){
			$con = self::createCondition($conditions);
			if($con == null){
				throw new DatabaseException("Create SQL Error: update condition is illegal");
			}else{
				$sql .= " where {$con}";
			}
		}
		return $sql;
	}
	
	/**
	 * 创建更新SQL
	 * @param string $table
	 * 	表名
	 * @param string/array $conditions
	 * 	条件
	 */
	public static function createDelete($table, $conditions){
		if(empty($table)){
			throw new DatabaseException("Create SQL Error: table name is missing");
		}
		$sql = "delete from {$table}";
		if($conditions){
			$con = self::createCondition($conditions);
			if($con == null){
				throw new DatabaseException("Create SQL Error: update condition is illegal");
			}else{
				$sql .= " where {$con}";
			}
		}
		return $sql;
	}
	
	/**
	 * 创建查询条件,当参数为数组时,key和value的关系为'=',key-value和key-value的关系为'and'.
	 * @param string/array $conditions
	 * @return string/null
	 * 	如果参数$conditions非法,返回null
	 */
	private static function createCondition($conditions){
		if(is_string($conditions) || is_numeric($conditions)){
			return $conditions;
		}elseif(is_array($conditions) && !empty($conditions)){
			$con = $comma= '';
			foreach ($conditions as $key => $value) {
				$con .= $comma . "`" . $key . "`" . " = '" . $value . "'";
				$comma = " and ";
			}
			return $con;
		}else{
			return null;
		}
	}
	
	private static function checkStart($start){
		if($start < 0 || !is_int($start)){
			$start = 0;
		}
		return $start;
	}
	
	private static function getStart($page, $perpage){
		$start = self::checkStart(($page - 1) * $perpage);
		return $start;
	}
	
	private static function isMathValue($value){
		$pattern = '/\w+\s*[\+\-\*\/\%]\s*\w+/i';
		if(preg_match($pattern, $value)){
			return true;
		}
		return false;
	}
}