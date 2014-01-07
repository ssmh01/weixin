<?php
/**
 * 玩法管理
 * @author blueyb.java@gmail.com
 */
class PlayWayAction extends AbstractAdminAction{
	
	protected $leftMenuParentId = 15;
	
	/**
	 * @var ModelDao
	 */
	private $dao = null;
	
	public function __construct(){
		parent::__construct();
		$this->setPerpage(1000);
		$this->dao = MD("PlayWay");
	}
	
	/**
	 * 列表
	 *
	 * @param HttpRequest $request        	
	 */
	public function index(HttpRequest $request){
		parent::index($request);
		$request->assign('title', '玩法管理');
	}
	
	/**
	 * 添加界面
	 *
	 * @param HttpRequest $request        	
	 */
	public function add(HttpRequest $request){
		$request->assign('title', '添加玩法');
	}
	
	/**
	 * 修改界面
	 *
	 * @param HttpRequest $request        	
	 */
	public function edit(HttpRequest $request){
		parent::edit($request);
		$request->assign('title', '修改玩法');
	}
	
	/*
	 * @see AbstractAdminAction::insert()
	 */
	public function insert(HttpRequest $request){
		if(!$request->hasFile('playway')){
			show_message('请上传格式为zip的玩法插件压缩包!', $request->getReferer());
		}
		
		$playWayZip = $request->getFile('playway');
		$playWayZip = $playWayZip['tmp_name'];
		
		//解压到临时目录
		include_once(EXT_LIB_ROOT . 'zip/pclzip.lib.php');
		$playWayUtil = new PlayWayUtil(WEB_ROOT . GuessConstant::PLAYWAY_DIRECTORY, WEB_ROOT . GuessConstant::PLAYWAY_TEMP_DIRECTORY);
		$playWay = $playWayUtil->parsePlayWay($playWayZip);
		if(!$playWay){
			show_message('解析插件压缩包失败!', $request->getReferer());
		}
		
		//验证
		$playWayValidator = new PlayWayValidator();
		$result = $playWayValidator->validate($playWay->getPath());
		if(!$result){
			//删除这个玩法
			$playWayUtil->deleteDirectory($playWay->getClass());
			show_message($playWayValidator->getValidateError(), $request->getReferer());
		}
		$playWayService = GuessServiceFactory::getPlayWayService();
		$sucess = $playWayService->add($playWay);
		if(!$sucess){
			$playWayUtil->deleteDirectory($playWay->getClass());
			show_message('玩法上传失败', $request->getAttribute('act_url'));
		}
		show_message('玩法上传成功', $request->getAttribute('act_url'));
	}
	
	/*
	 * @see AbstractAdminAction::update()
	 */
	public function update(HttpRequest $request){
		$this->setUseValidate(false);
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
        $model = $this->createModelByAdminAction();
		$modelDao = MD($model);
		$item = $modelDao->get($id);
		if(empty($item)){
			show_message(get_lang('no_record_common'));
		}
		if($item['status']){
			show_message('玩法已启用，不能删除');
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
		$model = $this->createModelByAdminAction();
		$modelDao = MD($model);
		$success = $modelDao->update(array('status'=>1), $id);
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