<?php

/** 
 * 资讯分类接口
 * @author blueyb.java@gmail.com
 * 
 */
interface INewsCategoryService{
	
	/**
	 * 获取分类类型
	 * @return array
	 */
	public function getCategoryTypes();
	
	/**
	 * 根据类型获取分类，如果没指定类型则返回所有的分类
	 * @param int $type
	 * @return array
	 */
	public function getCategorys($type);
	
	/**
	 * 获取指定ID的分类
	 * @param int $id
	 * @return array
	 */
	public function getCategory($id);
	
	/**
	 * 分类下是否有资讯
	 * @param int $id
	 * @return boolean
	 */
	public function hasNews($id);
}

?>