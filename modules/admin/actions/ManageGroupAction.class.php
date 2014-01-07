<?php
/**
 * 管理组
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-06
 */
class ManageGroupAction extends AbstractAdminAction{
	
	protected $leftMenuParentId = 5;
	
	/**
	 * 列表
	 *
	 * @param HttpRequest $request        	
	 */
	public function index(HttpRequest $request){
		parent::index($request);
		$request->assign('title', '管理组管理');
	}
	
	/**
	 * 添加界面
	 *
	 * @param HttpRequest $request        	
	 */
	public function add(HttpRequest $request){
		$copyId = $request->getParameter('copyId');
		$request->assign('copyId', $copyId);
		if($copyId){
			$request->assign('title', '复制新管理组');
		}else{
			$request->assign('title', '添加管理组');
		}
	}
	
	/*
	 * @see CommonAction::insert()
	 */
	public function insert(HttpRequest $request){
		$request->setParameter('m_create_time', $request->getRequestTime());
		$copyId = $request->getParameter('copyId');
		if($copyId){
			$model = $this->createModelByAdminAction();
			$modelDao = MD($model);
			$copyRole = $modelDao->get($copyId);
			$request->setParameter('m_permissions', $copyRole['permissions']);
		}
		parent::insert($request);
	}
	
	/**
	 * 修改界面
	 *
	 * @param HttpRequest $request        	
	 */
	public function edit(HttpRequest $request){
		parent::edit($request);
		$request->assign('title', '修改管理组');
	}
	
	public function permission(HttpRequest $request){
		// 权限分配
		$id = $request->getParameter('id');
		if(empty($id)){
			show_message('no_record_common');
		}
		$model = $this->createModelByAdminAction();
		$modelDao = MD($model);
		$item = $modelDao->get($id);
		if(empty($item)){
			show_message(get_lang('empty_record_common'));
		}
		$item['permissions'] = unserialize($item['permissions']);
		// 获取所有的动作
		$operationService = AdminServiceFactory::getAdminOperationService();
		$operations = $operationService->getOperations();
		$request->setAttribute('operations', $operations);
		$request->setAttribute('groupCount', count($operations));
		$request->setAttribute('item', $item);
		$request->setAttribute('title', '分配管理组权限');
	
	}
	
	public function updatePermission(HttpRequest $request){
		// 权限分配
		$id = $request->getParameter('id');
		if(empty($id)){
			show_message('no_record_common');
		}
		$model = $this->createModelByAdminAction();
		$modelDao = MD($model);
		$item = $modelDao->get($id);
		if(empty($item)){
			show_message(get_lang('empty_record_common'));
		}
		$params = $request->getParameters();
		unset($params['id']);
		$update['permissions'] = serialize($params);
		if($modelDao->update($update, $id)){
			$this->setMessage('op_success');
		}else{
			$this->setMessage('op_failed');
		}
		$request->redirect($request->getReferer());
	}
}