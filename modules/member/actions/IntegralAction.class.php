<?php
/**
 * 我的积分
 * @author blueyb.java@gmail.com
 */
class IntegralAction extends UserCenterAction{
	
	public function index(HttpRequest $request){
		$yqcode = MemberServiceFactory::getUserService()->idToCode($this->user->getId());
		$request->assign('yqcode', $yqcode);
		$seo = array(
				'title' => '我的积分',
				'description' => '',
				'keywords' => ''
		);
		$request->assign('seo', $seo);
		$this->setView('integral_index');
	}
	
	public function io(HttpRequest $request){
		$wealthType = Io::WEALTH_TYPE_INTEGRAL;
		$conditions = " wealth_type = '{$wealthType}' and (from_user_id = '{$this->user->getId()}' or to_user_id = '{$this->user->getId()}')";
		$orders = array('id'=>'desc');
		$page = getPage();
		$perpage = 5;
		$ioDao = MD('Io');
		$items = $ioDao->gets($conditions, $gets, $orders, $page, $perpage);
		$total = $ioDao->count($conditions);
		$pages = multi_page($total, $perpage, $page);
		
		$request->setAttribute('items', $items);
		$request->setAttribute('total', $total);
		$request->setAttribute('pages', $pages);
	
		$seo = array(
				'title' => '积分收支明细',
				'description' => '',
				'keywords' => ''
		);
		$request->assign('seo', $seo);
		$this->setView('integral_io');
	}
}