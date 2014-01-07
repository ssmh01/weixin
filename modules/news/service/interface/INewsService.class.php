<?php

/** 
 * 资讯服务接口
 * @author blueyb.java@gmail.com
 * 
 */
interface INewsService{
	
	/**
	 * 获取指定资讯并把查看数增加1
	 * @param int $id
	 * @return array
	 */
	public function getNews($id);
}

?>