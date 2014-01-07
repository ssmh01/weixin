<?php

/**
 * 资讯服务
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - Dec 26, 2012
 */
class NewsService extends TransationSupport implements INewsService{
	
	/**
	 * @var ModelDao
	 */
	private $dao = null;
	
	public function __construct(){
		$this->dao = MD('News');
	}
	
	/*
	 * @see INewsService::getNews()
	 */
	public function getNews($id){
		if(!is_numeric($id)) return null;
		$item = $this->dao->get($id);
		if($item){
			$this->dao->update(array('views'=>'views + 1'), $id, true);
		}
		return $item;
	}
}

?>