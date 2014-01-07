<?php
/**
 * 兑换管理
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-06
 */
class ExchangeAction extends AbstractAdminAction{
	
	protected $leftMenuParentId = 9;
	
	/**
	 * 列表
	 *
	 * @param HttpRequest $request        	
	 */
	public function index(HttpRequest $request){
		$conditions = " 1 ";
		$parameters = $request->getParameters();
		if($parameters['userId']){
			$conditions .= " AND user_id = '{$parameters['userId']}'";
		}
		if($parameters['sendStatus']){
			$request->setAttribute('sendStatus', $parameters['sendStatus']);
			$sendStatus = intval($parameters['sendStatus']) - 1;
			$conditions .= " AND send_status = '{$sendStatus}'";
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
		$userIds = ArrayUtil::colKeySet($request->getAttribute('items'), 'user_id', true);
		if($userIds){
			$userDao = MD('User');
			$users = $userDao->gets("id in ({$userIds})");
			$users = ArrayUtil::changeKey($users, 'id');
		}
		$goodsIds = ArrayUtil::colKeySet($request->getAttribute('items'), 'goods_id', true);
		if($goodsIds){
			$goodsDao = MD('Goods');
			$goodses = $goodsDao->gets("id in ({$goodsIds})");
			$goodses = ArrayUtil::changeKey($goodses, 'id');
		}
		$request->assign('users', $users);
		$request->assign('goodses', $goodses);
		$request->assign('title', '兑换抽奖管理');
	}
	
	/**
	 * 发货
	 * @param HttpRequest $request
	 */
	public function shipments(HttpRequest $request){
		$id = $request->getParameter('id');
		if(empty($id)){
			show_message('请选择要发货的商品');
		}
		$dao = MD($this->createModelByAdminAction());
		$item = $dao->get($id);
		if(empty($item)){
			show_message(get_lang('no_record_common'));
		}
		$success = $dao->update(array('send_status'=>'1'), $id);
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
	 * 添加界面
	 *
	 * @param HttpRequest $request        	
	 */
	public function add(HttpRequest $request){
		throw new Exception("不支持的操作");
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
	 * @see CommonAction::insert()
	 */
	public function insert(HttpRequest $request){
		throw new Exception("不支持的操作");
	}
	
	/*
	 * @see CommonAction::update()
	 */
	public function update(HttpRequest $request){
		throw new Exception("不支持的操作");
	}
	
	/*
	 * @see CommonAction::del()
	 */
	public function del(HttpRequest $request){
		throw new Exception("不支持的操作");
	}
	
	/*
	 * @see AbstractAdminAction::field()
	 */
	public function field(HttpRequest $request){
		throw new Exception("不支持的操作");
	}
}