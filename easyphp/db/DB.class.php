<?php
/**
 * 数据库访问接口
 * @author blueyb.java@gmail.com
 * @since 1.0 -	2011.06.02
 * @todo 用来访问数据数据库
 */

interface DB{
	
	/**
	 * 获取当前的连接参数
	 * @return ConnectParameter 当前的连接参数
	 */
	public function getConnectParameter();
	
	/**
	 * 设置连接参数
	 * @param ConnectParameter $connectParameter
	 */
	public function setConnectParameter($connectParameter);
	
	/**
	 * 连接数据库
	 * @param ConnectParameter $connectParameter
	 * 	连接参数,如果连接参数为空,则用从getConnectParameter获取到的参数进行连接
	 */
	public function connect($connectParameter);
	
	/**
	 * 一个查询
	 * @param $sql
	 * 查询语句
	 * @return 
	 * 查询结果
	 */
	function query($sql);
	
	/**
	 * 执行一个SQL语句并从中取得一行数组类型的结果
	 * @param string $sql SQL语句
	 * @param int $row 
	 * 	要取得的行数,如果没有指定行数,则返回结果集中的下一行记录
	 * @return array 一个一维数组
	 */
	function getRow($sql, $row);
	
	/**
	 * 返回查询结果中一个单元的内容
	 * @param $query
	 * 查询结果
	 * @param $row
	 * 要取得的行数,如果没有指定行数,则返回结果集中的下一行记录
	 * @return array 查询结果中的一行记录
	 */
	function getRowFromQuery($query, $row);
	
	/**
	 * 执行一个SQL语句并从中取得数组类型的结果
	 * @param $sql SQL语句
	 * @param $count 返回的结果个数
	 * @return array 一个二维数组
	 */
	function getRows($sql, $count);
	
	/**
	 * 返回查询结果中一个单元的内容
	 * @param $query
	 * 查询结果
	 * @param $count
	 * 从查询结果中返回的个数
	 * @return array 查询结果中的多行记录
	 */
	function getRowsFromQuery($query, $count);
	
	/**
	 * 执行一个SQL语句并从中取出某行中的某列
	 * @param string $sql SQL语句
	 * @param int $row
	 * 查询结果中记录的行数,默认为第一行
	 * @param int/string $field
	 * 某行中的某列,可以是数字或列名
	 */
	function getRowFiled($sql, $row=0, $field=0);
	
	/**
	 * 执行一个SQL语句并从中取出某行中的某列
	 * @param mixed $query 
	 * 	查询结果
	 * @param int $row
	 * 	查询结果中记录的行数,默认为第一行
	 * @param int/string $field
	 * 	某行中的某列,可以是数字或列名
	 */
	function getRowFiledFromQuery($query, $row=0, $field=0);
	
	/**
	 * 返回一次SQL语句执行影响记录条数
	 * @return 
	 * 影响记录条数
	 */
	function affectedRows();
	
	/**
	 * 返回结果集中行的数目
	 * @param $query
	 * 查询结果
	 * @return 数目
	 */
	function rowCount($query);
	
	/**
	 * 返回结果集中列的数目
	 * @param $query
	 * 查询结果
	 * @return 数目
	 */
	function filedCount($query);
	
	/**
	 * 错误信息
	 * @return 错误信息
	 */
	function getError();

	/**
	 * 错误码
	 * @return 错误码
	 */
	function getErrorCode();

	/**
	 * 将释放所有与查询结果关联的内存
	 * @param $query
	 * 查询结果
	 * @return 
	 * 如果成功则返回 TRUE，失败则返回 FALSE
	 */
	function freeQuery($query);
	
	/**
	 * 最后一条插入语句产生的ID
	 * @return ID
	 */
	function getInsertId();
	
	/**
	 * 数据库版本
	 * @return 数据库版本
	 */
	function getVersion();
	
	/**
	 * 关闭当前连接
	 * @return
	 * 如果成功则返回 TRUE，失败则返回 FALSE
	 */
	function close();
}
?>