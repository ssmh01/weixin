<?php
/**
 * 管理员
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-06
 */
class ManagerAction extends AbstractAdminAction{
	
	protected $leftMenuParentId = 5;
	
	private $manageGroups = null;
	
	public function __construct(){
		parent::__construct();
		// 获取角色
		$manageGroupDao = MD("ManageGroup");
		$this->manageGroups = $manageGroupDao->gets();
		$this->manageGroups = ArrayUtil::changeKey($this->manageGroups, 'id');
	}
	
	/**
	 * 列表
	 *
	 * @param HttpRequest $request        	
	 */
	public function index(HttpRequest $request){
		$conditions = " 1 ";
		$parameters = $request->getParameters();
		if($parameters['name']){
			$conditions .= " AND name like '%{$parameters['name']}%'";
		}
		if($parameters['groupId']){
			$conditions .= " AND group_id = '{$parameters['groupId']}'";
			$request->setAttribute('groupId', $parameters['groupId']);
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
		parent::index($request);
		$request->assign('manageGroups', $this->manageGroups);
		$request->assign('title', '管理员管理');
	}
	
	/**
	 * 添加界面
	 *
	 * @param HttpRequest $request        	
	 */
	public function add(HttpRequest $request){
		$request->assign('manageGroups', $this->manageGroups);
		$request->assign('title', '添加管理员');
	}
	
	/**
	 * 修改界面
	 *
	 * @param HttpRequest $request        	
	 */
	public function edit(HttpRequest $request){
		parent::edit($request);
		$request->assign('manageGroups', $this->manageGroups);
		$request->assign('title', '修改管理员');
	}
	
	/*
	 * @see CommonAction::insert()
	 */
	public function insert(HttpRequest $request){
		$request->setParameter('m_create_time', $request->getRequestTime());
		$password = $request->getParameter('m_password');
		if($password){
			$request->setParameter('m_password', md5(md5($password)));
		}else{
			show_message('密码不能为空');
		}
		parent::insert($request);
	}
	
	/*
	 * @see CommonAction::update()
	 */
	public function update(HttpRequest $request){
		$newPassword = $request->getParameter('new_password');
		if($newPassword){
			$request->addParameter('m_password', md5(md5($newPassword)));
		}
		parent::update($request);
	}
	
	/*
	 * @see CommonAction::del()
	 */
	public function del(HttpRequest $request){
		$id = $request->getParameter('id');
		if($id == ManagerService::ID_FOUNDER){
			show_message('创始人不能被删除!');
		}
		parent::del($request);
	}
}