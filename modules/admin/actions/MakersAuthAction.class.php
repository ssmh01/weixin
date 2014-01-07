<?php
/**
 * 庄家认证
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-06
 */
class MakersAuthAction extends AbstractAdminAction{
	
	protected $leftMenuParentId = 12;
	
	/**
	 * 列表
	 *
	 * @param HttpRequest $request        	
	 */
	public function index(HttpRequest $request){
		$status = $request->getParameter('status');
		$conditions = " 1 ";
		if(is_numeric($status)){
			$request->setAttribute('status', $status);
			$conditions .= " and status = '{$status}'";
		}
		$this->setConditions($conditions);
		$this->setOrders(array('create_time'=>'desc'));
		parent::index($request);
		$request->assign('title', '认证管理');
	}
	
	/**
	 * 拒绝
	 *
	 * @param HttpRequest $request        	
	 */
	public function refuse(HttpRequest $request){
		$userService = MemberServiceFactory::getUserService();
		$success = $userService->makersAuth($request->getParameter('id'), false);
		if($success){
			//操作成功
			$this->setMessage('op_success');
			$request->redirect($request->getReferer());
		}else{
			//操作失败
			show_message(get_lang('operation_failed_common'));
		}
	}
	/**
	 * 通过
	 *
	 * @param HttpRequest $request        	
	 */
	public function allow(HttpRequest $request){
		$userService = MemberServiceFactory::getUserService();
		$success = $userService->makersAuth($request->getParameter('id'), true);
		if($success){
			//操作成功
			$this->setMessage('op_success');
			$request->redirect($request->getReferer());
		}else{
			//操作失败
			show_message(get_lang('operation_failed_common'));
		}
	}
}