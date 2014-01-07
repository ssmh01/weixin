<?php
/**
 * 查看商品
 * @author blueyb.java@gmail.com
 */
class ViewAction extends UserCenterAction{
	
	public function index(HttpRequest $request){
		$id = intval($request->getParameter('id'));
		if(empty($id)){
			show_message('请选择要查看的商品');
		}
		$dao = MD('Goods');
		$item = $dao->get($id);
		if(empty($item)){
			show_message('你要查看的商品不存在');
		}
		$request->setAttribute('item', $item);
		
		$seo = array(
				'title' => $item['title'],
				'description'=>'',
				'keywords'=>'',
		);
		$request->setAttribute('seo', $seo);
		$this->setView('view');
	}
}