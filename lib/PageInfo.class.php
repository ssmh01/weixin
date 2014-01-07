<?php
class PageInfo{
	private $page = 1;
	private $perPage = 10;
	private $total = 0;
	
	public function PageInfo($page=1, $perPage=10){
		$this->setPage($page);
		$this->setPerPage($perPage);
	}
    public function setPage($page){
		$page = intval($page);
		$page>0 && $this->page = $page;
	}
    public function setPerPage($perPage){
		$perPage = intval($perPage);
		$perPage>0 && $this->perPage = $perPage;
	}
	public function setTotal($total){
		$this->total = $total;
	}
	
	public function getPage(){
		return $this->page;
	}
	public function getPerPage(){
		return $this->perPage;
	}
	public function getStart(){
		return $this->page>1 ? (($this->page-1)*$this->perPage) : 0;
	}
	public function getTotal(){
		return $this->total;
	}
}