<?php
/**
 * 文章列表
 * @author blueyb.java@gmail.com
 */
class ListAction extends UserCenterAction{
	
	public function index(HttpRequest $request){
		$newsCategoryService = NewsServiceFactory::getNewsCategoryService();
		$categorys = $newsCategoryService->getCategorys();
		$request->setAttribute('categorys', $categorys);
		
		$page = getPage();
		$perpage = 10;
		$cateId = $request->getParameter('cate');
		$conditions = " 1 ";
		if($cateId){
			$conditions .= " and cate_id = '{$cateId}'";
		}
		$orders = array('sort_num'=>'desc');
		$dao = MD('News');
		
		$items = $dao->gets($conditions, null, $orders, $page, $perpage);
		$total = $dao->count($conditions);
		$pages = multi_page($total, $perpage, $page);
		
		$request->setAttribute('items', $items);
		$request->setAttribute('total', $total);
		$request->setAttribute('pages', $pages);
		
		$seo = array(
				'title' => '文章列表',
				'description'=>'',
				'keywords'=>'',
		);
		$request->setAttribute('seo', $seo);
		$this->setView('list');
	}
}