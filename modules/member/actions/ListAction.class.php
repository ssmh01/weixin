<?php
/**
 * 用户列表
 * @author blueyb.java@gmail.com
 */
class ListAction extends UserCenterAction{
	
	public function index(HttpRequest $request){
		$keyword = $request->getParameter('keyword');
		$sex = $request->getParameter('sex');
		$province = $request->getParameter('province');
		$city = $request->getParameter('city');		
		$t = $request->getParameter('t');
		
		$conditions = " 1 ";
		if($keyword){
			$conditions .= " and (name like '%{$keyword}%' or sign like '%{$keyword}%')";
		}
		if($sex == '1' || $sex == '2')
		{
			$conditions .= " AND (sex='$sex')";
		}
		if(!empty($province) && $province != 'all')
		{
			$conditions .= " AND (province='$province')";
			if(!empty($city) && $city != 'all')
			{
				$conditions .= " AND (city='$city')";
			}
		}	
		
		if($t == 1)
			$orders = array('accuracy'=>'desc'); //胜率排行
		elseif($t == 2)
			$orders = array('available_integral'=>'desc'); //积分排行
		elseif($t == 3)
			$orders = array('available_money'=>'desc'); //金钱排行
		else
			$orders = array('id'=>'desc');
		
		if($t>=1 && $t<=3) $astr[$t] = 'class="active"'; else $astr[0] = 'class="active"';		
		
		$page = getPage();
		$perpage = 5;
		$userService = MemberServiceFactory::getUserService();
		$items = $userService->gets($conditions, $gets, $orders, $page, $perpage);
		$total = $userService->count($conditions);
		$pages = multi_page($total, $perpage, $page);
		
		/*
		if($items){
			//获取当前用户与搜索用户之间的好友关系
			$userIds = ArrayUtil::colKeySet($items, 'id', true);
			$followConditions = " from_uid = '{$this->user->getId()}' and to_uid in ({$userIds})";
			$followDao = MD('Follow');
			$follows = $followDao->gets($followConditions);
			$follows = ArrayUtil::changeKey($follows, 'to_uid');
			$request->setAttribute('follows', $follows);
		}
		*/

		//省
		$db = R::getDB();
		$province_arr = $db->getRows("SELECT * FROM yyx_province WHERE 1 ORDER BY id ASC");
		
		$request->setAttribute('items', $items);
		$request->setAttribute('total', $total);
		$request->setAttribute('pages', $pages);
		$request->setAttribute('page', $page);
		$request->setAttribute('perpage', $perpage);
		$request->setAttribute('astr', $astr);
		$request->setAttribute('province_arr', $province_arr);
		
		$seo = array(
				'title' => '用户列表',
				'description' => '',
				'keywords' => ''
		);
		$request->assign('seo', $seo);
		$this->setView('list');
	}
}