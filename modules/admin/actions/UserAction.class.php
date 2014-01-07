<?php
/**
 * 用户管理
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-06
 */
class UserAction extends AbstractAdminAction{
	
	protected $leftMenuParentId = 12;
	
	/**
	 * @var ModelDao
	 */
	private $dao = null;
	
	public function __construct(){
		parent::__construct();
		$this->dao = MD("User");
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
			$conditions .= " AND name like '%{$parameters['name']}%'";
		}
		if($parameters['startTime']){
			$startTime = strtotime($parameters['startTime']);
			$conditions .= " AND register_time > '{$startTime}'";
		}
		if($parameters['endTime']){
			$endTime = strtotime($parameters['endTime']);
			$conditions .= " AND register_time < '{$endTime}'";
		}
		$this->setConditions($conditions);
		parent::index($request);
		$request->assign('title', '用户管理');
	}
	
	/**
	 * 添加界面
	 *
	 * @param HttpRequest $request        	
	 */
	public function add(HttpRequest $request){
		throw Exception("不支持操作");
	}
	
	/**
	 * 修改界面
	 *
	 * @param HttpRequest $request        	
	 */
	public function edit(HttpRequest $request){
		parent::edit($request);
		$request->assign('title', '修改用户');
	}
	
	/*
	 * @see AbstractAdminAction::insert()
	 */
	public function insert(HttpRequest $request){
		throw new Exception("不支持的操作");
	}
	
	/*
	 * @see AbstractAdminAction::update()
	 */
	public function update(HttpRequest $request){
		$newPassword = $request->getParameter('new_password');
		if($newPassword){
			$request->addParameter('m_password', md5(md5($newPassword)));
		}
		parent::update($request);
	}
	
	/*
	 * @see AbstractAdminAction::del()
	 */
	public function del(HttpRequest $request){
		throw new Exception("不支持的操作");
	}
	
	/*
	 * @see AbstractAdminAction::del()
	*/
	public function detail(HttpRequest $request){
		//
	}
}