<?php
/**
 * 修改密码
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-06
 */
class PasswordAction extends AbstractAdminAction{
	
	protected $leftMenuParentId = 5;
	
	/**
	 * 列表
	 *
	 * @param HttpRequest $request        	
	 */
	public function index(HttpRequest $request){
		$request->assign('title', '修改密码');
	}
	
	/**
	 * 修改密码
	 * @param HttpRequest $request        	
	 */
	public function update(HttpRequest $request){
		$oldPassword = $request->getParameter('old_password');
		$newPassword = $request->getParameter('new_password');
		if(empty($newPassword)){
			show_message('新密码不能为空');
		}
		$managerService = AdminServiceFactory::getManagerService();
		$managerId = HttpSession::get(ManagerService::SESSION_MANAGER_ID);
		$status = $managerService->modifyPassword($managerId, $newPassword, $oldPassword);
		if($status == 1){
			$this->setMessage("修改密码成功!");
		}elseif($status == -1){
			$this->setMessage('原密码不对,修改密码失败!');
		}else{
			$this->setMessage('修改密码失败!');
		}
		$request->redirect($request->getAttribute('index_url'));
	}
}