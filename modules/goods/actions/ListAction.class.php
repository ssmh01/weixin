<?php
/**
 * 商品列表
 * @author blueyb.java@gmail.com
 */
class ListAction extends UserCenterAction{
	
	public function index(HttpRequest $request){
		$dao = MD('Goods');
		$items = $dao->gets(array('status'=>'1'), null, array('sort_num'=>'desc'));
		$request->setAttribute('items', $items);
		$seo = array(
				'title' => '兑换商品列表',
				'description'=>'',
				'keywords'=>'',
		);
		$request->setAttribute('seo', $seo);
		$this->setView('list');
	}
}