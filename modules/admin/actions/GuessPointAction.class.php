<?php
/**
 * 竞猜点管理
 * @author blueyb.java@gmail.com
 */
class GuessPointAction extends AbstractAdminAction{
	
	
	protected $leftMenuParentId = 15;
	
	/**
	 * @var ModelDao
	 */
	private $dao = null;
	
	/**
	 * @var GuessCategoryService
	 */
	private $categoryService = null;
	
	/**
	 * 顶级分类
	 * @var array
	 */
	private $rootCategorys = null;
	
	private $categorys = null;
	
	public function __construct(){
		parent::__construct();
		$this->dao = MD("GuessPoint");
		$this->categoryService =GuessServiceFactory::getGuessCategoryService();
		$this->rootCategorys = $this->categoryService->getRoots();
		$this->categorys = $this->categoryService->gets();
		R::getRequest()->setAttribute('rootCategorys', $this->rootCategorys);
		R::getRequest()->setAttribute('categorys', $this->categorys);
	}
	
	/**
	 * 列表
	 *
	 * @param HttpRequest $request        	
	 */
	public function index(HttpRequest $request){
		$conditions = " 1 ";
		$parameters = $request->getParameters();
		if($parameters['title']){
			$conditions .= " AND title like '%{$parameters['title']}%'";
		}
		if($parameters['sub_cateid']){
			//获取当前分类
			$request->setAttribute('currentSubCategory', $this->categoryService->get($$parameters['sub_cateid']));
			$conditions .= " AND cate_id = '{$parameters['sub_cateid']}'";
		}
		if($parameters['cateid']){
			//获取所有的子分类
			$subCategorys = $this->categoryService->gets($parameters['cateid']);
			$request->setAttribute('subCategorys', $subCategorys);
			if(!$parameters['sub_cateid']){
				$cateIds = ArrayUtil::colKeySet($subCategorys, 'id', true);
				if($cateIds){
					$conditions .= " AND cate_id in ({$cateIds})";
				}
			}
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
		$this->categoryService->gets();
		$request->assign('title', '竞猜点管理');
	}
	
	/**
	 * 添加界面
	 *
	 * @param HttpRequest $request        	
	 */
	public function add(HttpRequest $request){
		$request->assign('title', '添加竞猜点');
	}
	
	/**
	 * 修改界面
	 *
	 * @param HttpRequest $request        	
	 */
	public function edit(HttpRequest $request){
		parent::edit($request);
		$item = $request->getAttribute('item');
		$category = $this->categoryService->get($item['cate_id']);
		$request->setAttribute('currentCategory', $category);
		$request->setAttribute('playDeadline', date('Y-m-d H:i', $item['play_deadline']));
		$request->assign('title', '修改竞猜点');
	}
	
	
	/*
	 * @see AbstractAdminAction::insert()
	 */
	public function beforeInsert(HttpRequest $request){
		//处理参数
		$inputParams = $request->getParameter('params');
		$params = array();
		foreach($inputParams as $name=>$label){
			$label = trim($label);
			if($label){
				$param = new PlayWayParameter();
				$param->setName($name);
				$param->setLabel($label);
				$params[$name] = $param;
			}
		}
		$paramCount = count($params);
		$category = MD('GuessCategory')->get($request->getParameter('m_cate_id'));
		if($paramCount != $category['parameter_count']){
			$request->setParameter('m_status', '0');
		}
		if($params){
			$request->setParameter('m_params', serialize($params));
		}
		$request->setParameter('m_create_time', $request->getRequestTime());
		$playDeadline = $request->getParameter('m_play_deadline');
		if($playDeadline){
			$playDeadline = strtotime($playDeadline);
			$request->setParameter('m_play_deadline', $playDeadline);
		}
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
		if($item['guess_count']){
			show_message('竞猜点已被使用，不能修改');
		}
		$params = unserialize($item['params']);
		$paramCount = count($params);
		$category = MD('GuessCategory')->get($request->getParameter('m_cate_id'));
		if($paramCount != $category['parameter_count']){
			$request->setParameter('m_status', '0');
		}
		$playDeadline = $request->getParameter('m_play_deadline');
		if($playDeadline){
			$playDeadline = strtotime($playDeadline);
			$request->setParameter('m_play_deadline', $playDeadline);
		}
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
		if($item['status']){
			show_message('竞猜点已启用，不能删除');
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
	
	public function enable(HttpRequest $request){
		$id = $request->getParameter('id');
		if(empty($id)){
			show_message(get_lang('no_record_common'));
		}
		$guessService = GuessServiceFactory::getGuessService();
		$guessPoint = $guessService->getGuessPoint($id);
		if(!$guessPoint){
			show_message('竞猜点不存在');
		}
		$params = $guessPoint->getParams();
		$paramCount = count($params);
		if(!$paramCount){
			show_message('该竞猜点没有参数，请先添加竞猜参数!!');
		}
		
		$category = MD('GuessCategory')->get($guessPoint->getCateId());
		if($paramCount != $category['parameter_count']){
			show_message('该竞猜点参数个数和分类要求的参数个数不同，请先确认!');
		}
		$success = MD('GuessPoint')->update(array('status'=>1), $id);
		if($success){
			//操作成功
			$this->setMessage('op_success');
			$request->redirect($request->getAttribute('index_url'));
		}else{
			//操作失败
			show_message(get_lang('operation_failed_common'));
		}
	}
	
	public function param(HttpRequest $request){
		$id = $request->getParameter('id');
		if(empty($id)){
			show_message(get_lang('no_record_common'));
		}
		$model = $this->createModelByAdminAction();
		$modelDao = MD($model);
		$item = $modelDao->get($id);
		if(!$item){
			show_message('竞猜点不存在');
		}
		if($item['guess_count']){
			show_message('竞猜点已被使用，不能修改!');
		}
		$item['params'] = unserialize($item['params']);
		$request->setAttribute('item', $item);
		if(!$request->isPost()){
			$request->assign('title', '编辑竞猜参数');
		}else{
			$inputParams = $request->getParameter('params');
			$params = array();
			foreach($inputParams as $name=>$label){
				$label = trim($label);
				if($label){
					$param = new PlayWayParameter();
					$param->setName($name);
					$param->setLabel($label);
					$params[$name] = $param;
				}
			}
			$success = $modelDao->update(array('params'=>serialize($params)), $id);
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
	

	public function result(HttpRequest $request){
		$id = $request->getParameter('id');
		if(empty($id)){
			show_message(get_lang('no_record_common'));
		}
		$guessService = GuessServiceFactory::getGuessService();
		$guessPoint = $guessService->getGuessPoint($id);
		if(!$guessPoint){
			show_message('竞猜点不存在');
		}
		if(!$guessPoint->getParams()){
			show_message('该竞猜点没有参数，不能进行结果判定!');
		}
		$request->setAttribute('item', $guessPoint);
		if(!$request->isPost()){
			$request->assign('title', '结果判定');
		}else{
			foreach($guessPoint->getParams() as $param){
				$param->setValue(trim($request->getParameter($param->getName())));
			}
			$guessPointDao = MD('GuessPoint');
			$success = $guessPointDao->update(array('params'=>serialize($guessPoint->getParams())), $id);
			if($success){
				$success = $guessService->guessPointRudge($guessPoint);
				if($success){
					//操作成功
					$this->setMessage('op_success');
					$request->redirect($request->getAttribute('index_url'));
				}else{
					//操作失败
					die(get_lang('operation_failed_common'));
				//	show_message(get_lang('operation_failed_common'));
				}
			}else{
				//操作失败
				die(get_lang('operation_failed_common'));
				//show_message(get_lang('operation_failed_common'));
			}
		}
	}
}