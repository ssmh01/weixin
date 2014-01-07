<?php
/**
 * 我的商品列表
 * @author blueyb.java@gmail.com
 */
class MyAction extends UserCenterAction{
	
	public function index(HttpRequest $request){
		$conditions = array('user_id'=>$this->user->getId());
		$orders = array('create_time'=>'desc');
		$page = getPage();
		$perpage = 5;
		$exchangeDao = MD('Exchange');
		$items = $exchangeDao->gets($conditions, $gets, $orders, $page, $perpage);
		$total = $exchangeDao->count($conditions);
		$pages = multi_page($total, $perpage, $page);
		
		if($items){
			//获取当前用户与搜索用户之间的好友关系
			$goodsIds = ArrayUtil::colKeySet($items, 'goods_id', true);
			$goodsConditions = "id in ({$goodsIds})";
			$goodsDao = MD('Goods');
			$goods = $goodsDao->gets($goodsConditions);
			$goods = ArrayUtil::changeKey($goods, 'id');
			$request->setAttribute('goods', $goods);
		}
		
		$request->setAttribute('items', $items);
		$request->setAttribute('total', $total);
		$request->setAttribute('pages', $pages);
		
		$seo = array(
				'title' => '我的奖品',
				'description'=>'',
				'keywords'=>'',
		);
		$request->setAttribute('seo', $seo);
		$this->setView('my');
	}
}