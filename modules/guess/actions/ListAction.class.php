<?php
/**
 * 竞猜列表
 * @author blueyb.java@gmail.com
 */
class ListAction extends UserCenterAction{
	
	public function index(HttpRequest $request){
		$history = $request->getParameter('history');
		$cateid = $request->getParameter('cateid');
		$custom = $request->getParameter('custom');
		$wealthType = $request->getParameter('wealth');
		$oddsType = $request->getParameter('odds');
		$time = $request->getParameter('time');
		$keyword = $request->getParameter('keyword');
		$range = $request->getParameter('range');
		if($history){
			$historyStatus = Guess::STATUS_END . ',' . Guess::STATUS_CLOSE;
			$conditions = " ((status in ({$historyStatus})) OR (status <> ". Guess::STATUS_WAITING_CKECK . " AND play_deadline < ". time() . "))";
		}else{
			//$conditions = " status != " . Guess::STATUS_WAITING_CKECK . " AND status != " . Guess::STATUS_CLOSE;
			$conditions = " status = " . Guess::STATUS_NORMAL . " AND play_deadline > " . time();
		}
		
		$categoryService = GuessServiceFactory::getGuessCategoryService();
		if($cateid){
			$subCategorys = $categoryService->gets($cateid);
			if($subCategorys){
				$subIds = ArrayUtil::colKeySet($subCategorys, 'id', true);
				$conditions .= " and cate_id in ({$subIds})";
			}
		}
		$wealthTypes = array(Guess::WEALTH_TYPE_MONEY, Guess::WEALTH_TYPE_INTEGRAL);
		if($custom){
			$conditions .= " and custom = '1'";
		}
		if($wealthType){
			if(in_array($wealthType,$wealthTypes)){
				$conditions .= " and wealth_type = '{$wealthType}'";
			}else{
				$conditions .= " and custom = '1'";
			}
		}
		
		if($oddsType){
			$conditions .= " and odds_type = '{$oddsType}'";
		}
		
		if($time){
			$startTime = time() - 86400 * $time;
			$conditions .= " and create_time >= '{$startTime}'";
		}
		if($keyword){
			$conditions .= " and (title like '%{$keyword}%' or summary like '%{$keyword}%')";
		}

		if($range == '1'){
			//只显示好友的
			/*
			$followService = MemberServiceFactory::getFollowService();
			$followUserIds = $followService->getUserFollowIds($this->user->getId());
			if($followUserIds){
				$followUserIds = implode(',', $followUserIds);
				$conditions .= " and user_id in ({$followUserIds})";
			}
			*/
			$userService = MemberServiceFactory::getUserService();
			$friendUserIds = $userService->getUserFriend($this->user->getId());
			if(!empty($friendUserIds))
			{
				$friendUserStr = '';
				foreach ($friendUserIds as $f)
					$friendUserStr .= empty($friendUserStr) ? $f['id'] : ',' . $f['id'];
				
				$conditions .= " and user_id in ({$friendUserStr})";
			}
			else
			{
				$conditions .= " AND user_id IN (0)";
			}		
		}
		$orders = array();
		$otime = $request->getParameter('otime');
		$ocount = $request->getParameter('ocount');
		$owealth = $request->getParameter('owealth');
		$ors = array('asc','desc');
		if($otime && in_array($otime, $ors)){
			$orders['create_time'] = $otime;
		}
		if($ocount && in_array($ocount, $ors)){
			$orders['play_count'] = $ocount;
		}
		if($owealth && in_array($owealth, $ors)){
			$orders['play_wealth'] = $owealth;
		}
		if(empty($orders)){
			$orders['create_time'] = 'desc';
		}
		$page = getPage();
		$perpage = 8;
		
		$guessService = GuessServiceFactory::getGuessService();
		$guesses = $guessService->gets($conditions, null, $orders, $page, $perpage);
		$total = $guessService->count($conditions);
		$pages = multi_page($total, $perpage, $page);
		
		//获取顶级分类
		$rootCategorys = $categoryService->getRoots();
		//随机获取用户
		$userService = MemberServiceFactory::getUserService();
		$userList = $userService->getRandUsers(10);
		//公告状态
		$hidePlacard = $_COOKIE['hide_placard'];
		UserService::usersSet(ArrayUtil::colKeySet($guesses, 'user_id'));
		
		//分类信息
		$guessCategoryService = GuessServiceFactory::getGuessCategoryService();
		$guessCategory = $guessCategoryService->getAlls();
		
		$request->setAttribute('guessCategory', $guessCategory);
		$request->setAttribute('rootCategorys', $rootCategorys);
		$request->setAttribute('guesses', $guesses);
		$request->setAttribute('total', $total);
		$request->setAttribute('pages', $pages);
		$request->setAttribute('params', $request->getParameters());
		$request->setAttribute('userList', $userList);
		$request->setAttribute('hidePlacard', $hidePlacard);
		
		$seo = array(
				'title' => '竞猜列表',
				'description' => '',
				'keywords' => ''
		);
		$request->assign('seo', $seo);
		$this->setView('list');
	}
}