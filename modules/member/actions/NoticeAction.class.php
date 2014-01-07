<?php
/**
 * 用户通知
 * @author blueyb.java@gmail.com
 */
class NoticeAction extends UserCenterAction{
	
	public function index(HttpRequest $request){
		//获取当前页的通知
		$modelDao = MD('Notice');
		$conditions = array('to_uid'=>$this->user->getId());
		$orders = array('create_time'=>'desc');
		$page = getPage();
		$perpage = 10;
		$items = $modelDao->gets($conditions, null, $orders, $page, $perpage);
		$total = $modelDao->count($conditions);
		$pages = multi_page($total, $perpage, $page);
		
		//获取发送通知的用户信息
		UserService::usersSet(ArrayUtil::colKeySet($items, 'from_uid'));
		
		$request->setAttribute('items', $items);
		$request->setAttribute('total', $total);
		$request->setAttribute('pages', $pages);
		
		$seo = array(
				'title' => '用户通知',
				'description'=>'',
				'keywords'=>'',
		);
		$request->assign('seo', $seo);
		$this->setView('notice');
	}
	
	/**
	 * 标记为已读
	 * @param HttpRequest $request
	 */
	public function read(HttpRequest $request){
		$this->loginCheck(true);
		$id = $request->getParameter('id');
		if(!$id){
			show_message('请先选择要操作的通知!');
		}
		$modelDao = MD('Notice');
		$notice = $modelDao->get($id);
		if(!$notice){
			show_message('你要操作的通知不存在!');
		}
		if($notice['to_uid'] != $this->user->getId()){
			show_message('非法操作!');
		}
		$conditions = array('id'=>$id);
		$update = array('new'=>'0');
		if($modelDao->updates($update, $conditions)){
			show_message('操作成功!');
		}else{
			show_message('操作失败!');
		}
	}
	
	/**
	 * 处理好友申请
	 * @param HttpRequest $request
	 */
	public function friend(HttpRequest $request){
		$this->loginCheck(true);
		
		$id = $request->getParameter('id');
		$oper = $request->getParameter('oper');
	
		if(!$id){
			show_message('请先选择需要处理的请求!');
		}
		$modelDao = MD('Notice');
		$notice = $modelDao->get($id);
		if(!$notice){
			show_message('你要操作的请求不存在!');
		}
		if($notice['to_uid'] != $this->user->getId()){
			show_message('非法操作!');
		}
		$conditions = array('id'=>$id);
		$update = array('new'=>'0');
		if($modelDao->updates($update, $conditions)){
			
			$userService = MemberServiceFactory::getUserService();
			if($oper == 1){
				//同意好友请求
				$noticeStatus = 2;
				$userService->apply_friend($this->user->getId(), $notice['from_uid'], 1);				
			}
			else
			{
				$noticeStatus = 3;
			}
			
			$modelDao->updates(array('status'=>$noticeStatus), array('id'=>$id)); //处理结果
			show_message('操作成功!');
		}else{
			show_message('操作失败!');
		}
	}	
	
	
	public function ignore(HttpRequest $request){
		$modelDao = MD('Notice');
		$conditions = array('to_uid'=>$this->user->getId());
		$update = array('new'=>'0');
		if($modelDao->updates($update, $conditions)){
			show_message('操作成功');
		}else{
			show_message('失败成功');
		}
	}
}