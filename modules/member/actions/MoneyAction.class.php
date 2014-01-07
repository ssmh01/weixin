<?php
/**
 * 我的金币
 * @author blueyb.java@gmail.com
 */
class MoneyAction extends UserCenterAction{
	
	public function index(HttpRequest $request){
		$yqcode = MemberServiceFactory::getUserService()->idToCode($this->user->getId());
		$request->assign('yqcode', $yqcode);
		$seo = array(
				'title' => '我的金币',
				'description' => '',
				'keywords' => ''
		);
		$request->assign('seo', $seo);
		$this->setView('money_index');
	}
	
	public function io(HttpRequest $request){
		$wealthType = Io::WEALTH_TYPE_MONEY;
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
				'title' => '金币收支明细',
				'description' => '',
				'keywords' => ''
		);
		$request->assign('seo', $seo);
		$this->setView('money_io');
	}
	
	/**
	 * 赠送
	 * @param HttpRequest $request
	 */
	public function handsel(HttpRequest $request){
		if($request->isPost()){
			$name = $request->getParameter('name');
			$userId = $request->getParameter('uid');
			$money = intval($request->getParameter('money'));
			$userDao = MD('User');
			if($userId){
				$toUser = $userDao->get($userId);
			}elseif($name){
				$toUser = $userDao->getOne(array('name'=>$name));
			}
			if(!$toUser){
				show_message("接收用户不存在");
			}
			if($toUser['id'] == $this->user->getId()){
				show_message("不能给自己赠送金币");
			}
			if($money < 1){
				show_message("赠送金额不能为小于1!");
			}
			$userService = MemberServiceFactory::getUserService();
			if($userService->handsel($this->user, $toUser, $money)){
				AjaxResult::closeAjaxWindow('赠送成功，正在关闭窗口!');
			}else{
				show_message('赠送失败!');
			}
		}else{
			$userId = $request->getParameter('uid');
			if($userId){
				$userDao = MD('User');
				$toUser = $userDao->get($userId);
				if(!$toUser){
					show_message('接收用户不存在');
				}
				$request->setAttribute('toUser', $toUser);
			}
			$this->setView('money_handsel');
		}
	}
}