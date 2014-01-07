<?php
/**
 * 竞猜管理
 * @author blueyb.java@gmail.com
 */
class GuessAction extends AbstractAdminAction{
	
	protected $leftMenuParentId = 15;
	
	/**
	 * @var ModelDao
	 */
	private $dao = null;
	
	public function __construct(){
		parent::__construct();
		$this->dao = MD("Guess");
	}
	
	/**
	 * 列表
	 *
	 * @param HttpRequest $request        	
	 */
	public function index(HttpRequest $request){
		$conditions = " 1 ";
		$parameters = $request->getParameters();
		if($parameters['uid']){
			$conditions .= " AND user_id = '{$parameters['uid']}'";
		}
		if($parameters['title']){
			$conditions .= " AND title like '%{$parameters['title']}%'";
		}
		if($parameters['wealth_type']){
			$wealth_type = $parameters['wealth_type'];
			$request->setAttribute('wealth_type', $parameters['wealth_type']);
			$conditions .= " AND wealth_type = '{$wealth_type}'";
		}		
		if($parameters['status']){
			$status = $parameters['status'] - 1;
			$request->setAttribute('status', $parameters['status']);
			$conditions .= " AND status = '{$status}'";
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
		$this->setOrders(array('create_time'=>'desc'));
		parent::index($request);
		$userIds = ArrayUtil::colKeySet($request->getAttribute('items'), 'user_id', true);
		if($userIds){
			$userDao = MD('User');
			$users = $userDao->gets("id in ({$userIds})");
			$users = ArrayUtil::changeKey($users, 'id');
		}
		$request->assign('users', $users);
		$request->assign('title', '竞猜管理');
	}
	
	/**
	 * 添加界面
	 *
	 * @param HttpRequest $request        	
	 */
	public function add(HttpRequest $request){
		$request->assign('title', '添加竞猜');
	}
	
	/**
	 * 修改界面
	 *
	 * @param HttpRequest $request        	
	 */
	public function edit(HttpRequest $request){
		parent::edit($request);
		$request->assign('title', '修改竞猜');
	}
	
	/*
	 * @see AbstractAdminAction::insert()
	 */
	public function insert(HttpRequest $request){
		parent::insert($request);
	}
	
	public function beforeUpdate($request){
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
		if($item['status']){
			show_message('竞猜已启用，不能修改');
		}
	}
	
	/*
	 * @see AbstractAdminAction::update()
	 */
	public function update(HttpRequest $request){
		parent::update($request);
	}
	
	/*
	 * @see AbstractAdminAction::del()
	 */
	public function del(HttpRequest $request){
		$id = $request->getParameter('id');
		if(empty($id)){
			show_message(get_lang('no_record_common'));
		}
        $guessService = GuessServiceFactory::getGuessService();
		$guess = $guessService->get($id, true);
		if(empty($guess)){
			show_message(get_lang('no_record_common'));
		}
		if($guess->getPlayCount()){
			show_message('竞猜已有人参与，不能删除');
		}
		$success = $guessService->delete($guess);
		if($success){
			//操作成功
			$this->setMessage('op_success');
			$request->redirect($request->getAttribute('index_url'));
		}else{
			//操作失败
			show_message(get_lang('operation_failed_common'));
		}
	}
	
	/**
	 * 审核通过
	 * @param HttpRequest $request
	 */
	public function check(HttpRequest $request){
		$id = $request->getParameter('id');
		if(empty($id)){
			show_message(get_lang('no_record_common'));
		}
		$guessService = GuessServiceFactory::getGuessService();
		$guess = $guessService->get($id, true);
		if(!$guess){
			show_message('竞猜不存在!');
		}
		$success = $guessService->check($guess);
		if($success){
			//操作成功
			$this->setMessage('op_success');
			$request->redirect($request->getAttribute('index_url'));
		}else{
			//操作失败
			show_message(get_lang('operation_failed_common'));
		}
	}
	
	/**
	 * 关闭
	 * @param HttpRequest $request
	 */
	public function close(HttpRequest $request){
		$id = $request->getParameter('id');
		if(empty($id)){
			show_message(get_lang('no_record_common'));
		}
		$guessService = GuessServiceFactory::getGuessService();
		$guess = $guessService->get($id, true);
		if(!$guess){
			show_message('竞猜不存在!');
		}
		$success = $guessService->close($guess);
		if($success){
			//操作成功
			$this->setMessage('op_success');
			$request->redirect($request->getAttribute('index_url'));
		}else{
			//操作失败
			show_message(get_lang('operation_failed_common'));
		}
	}
	
	public function rudge(HttpRequest $request){
		$id = $request->getParameter('id');
		if(empty($id)){
			show_message(get_lang('no_record_common'));
		}
		$guessService = GuessServiceFactory::getCustomGuessService();
		$guess = $guessService->get($id, true);
		if(!$guess){
			show_message('竞猜不存在');
		}
		if(!$guess->getCustom()){
			show_message('不是自定义竞猜，不能进行结果判定!');
		}
		$request->setAttribute('item', $guess);
		if(!$request->isPost()){
			$request->assign('title', '结果判定');
		}else{
			$value = trim($request->getParameter('option'));
			if(!strlen($value)){
				show_message('请选选择答案');
			}
			$guess->getParameter()->setValue($value);
			$guessDao = MD('Guess');
			$success = $guessDao->update(array('parameter'=>serialize($guess->getParameter())), $id);
			if($success){
				$success = $guessService->rudge($guess);
				if($success){
					//操作成功
					$this->setMessage('op_success');
					$request->redirect($request->getAttribute('index_url'));
				}else{
					//操作失败
					show_message(get_lang('operation_failed_common'));
				}
			}else{
				//操作失败
				show_message(get_lang('operation_failed_common'));
			}
		}
	}
}