<?php
/**
 * 充值管理
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-06
 */
class RechargeAction extends AbstractAdminAction{
	
	protected $leftMenuParentId = 12;
	
	/**
	 * @var ModelDao
	 */
	private $dao = null;
	
	private $payTypes = array('alipay'=>'支付宝','bank'=>'网银', 'offline'=>'线下');
	
	public function __construct(){
		parent::__construct();
		$this->dao = MD("Recharge");
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
			$conditions .= " AND user_id = '{$parameters['id']}'";
		}
		if($parameters['status']){
			$request->setAttribute('status', $parameters['status']);
			$sendStatus = intval($parameters['status']) - 1;
			$conditions .= " AND status = '{status}'";
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
		$userIds = ArrayUtil::colKeySet($request->getAttribute('items'), 'user_id', true);
		if($userIds){
			$userDao = MD('User');
			$users = $userDao->gets("id in ({$userIds})");
			$users = ArrayUtil::changeKey($users, 'id');
		}
		$request->assign('users', $users);
		$request->assign('payTypes', $this->payTypes);
		$request->assign('title', '充值管理');
	}
	
	/**
	 * 添加界面
	 *
	 * @param HttpRequest $request        	
	 */
	public function add(HttpRequest $request){
		
	}
	
	/**
	 * 修改界面
	 *
	 * @param HttpRequest $request        	
	 */
	public function edit(HttpRequest $request){
		throw new Exception("不支持的操作");
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
		throw new Exception("不支持的操作");
	}
	
	/*
	 * @see AbstractAdminAction::del()
	 */
	public function del(HttpRequest $request){
		throw new Exception("不支持的操作");
	}
}