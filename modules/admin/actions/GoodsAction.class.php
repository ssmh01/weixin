<?php
/**
 * 商品管理
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-06
 */
class GoodsAction extends AbstractAdminAction{
	
	protected $leftMenuParentId = 9;
	
	/**
	 * @var ModelDao
	 */
	private $dao = null;
	
	public function __construct(){
		parent::__construct();
		$this->dao = MD("Goods");
	}
	
	/**
	 * 列表
	 *
	 * @param HttpRequest $request        	
	 */
	public function index(HttpRequest $request){
		$conditions = " 1 ";
		$parameters = $request->getParameters();
		if($parameters['id']){
			$conditions .= " AND id = '{$parameters['id']}'";
		}
		if($parameters['name']){
			$conditions .= " AND title like '%{$parameters['title']}%'";
		}
		if($parameters['startTime']){
			$startTime = strtotime($parameters['startTime']);
			$conditions .= " AND create_time > '{$startTime}'";
		}
		if($parameters['endTime']){
			$endTime = strtotime($parameters['endTime']);
			$conditions .= " AND create_time < '{$endTime}'";
		}
		$this->setConditions($conditions);
		$this->setOrders(array('sort_num'=>'desc'));
		parent::index($request);
		$request->assign('title', '商品管理');
	}
	
	/**
	 * 添加界面
	 *
	 * @param HttpRequest $request        	
	 */
	public function add(HttpRequest $request){
		$request->assign('title', '添加商品');
	}
	
	/**
	 * 修改界面
	 *
	 * @param HttpRequest $request        	
	 */
	public function edit(HttpRequest $request){
		parent::edit($request);
		$request->assign('manageGroups', $this->manageGroups);
		$request->assign('title', '修改商品');
	}
	
	/*
	 * @see AbstractAdminAction::insert()
	 */
	public function insert(HttpRequest $request){
		$request->setParameter('m_create_time', $request->getRequestTime());
		parent::insert($request);
	}
	
	/*
	 * @see AbstractAdminAction::del()
	 */
	public function del(HttpRequest $request){
		$id = $request->getParameter('id');
		if(empty($id)){
			show_message(get_lang('no_record_common'));
		}
        $model = $this->createModelByAdminAction();
		$modelDao = MD($model);
		$item = $modelDao->get($id);
		if(empty($item)){
			show_message(get_lang('no_record_common'));
		}
		if($item['exchanges']){
			show_message('商品已被抽中或兑换过,不能删除，只能下架');
		}
		$success = $modelDao->delete($id);
		if($success){
			//操作成功
			$this->setMessage('op_success');
			$request->redirect($request->getAttribute('index_url'));
		}else{
			//操作失败
			show_message(get_lang('operation_failed_common'));
		}
	}
}