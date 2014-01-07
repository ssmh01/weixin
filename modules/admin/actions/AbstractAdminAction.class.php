<?php

/**
 * 抽象后台Action类
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-07-31
 */
abstract class AbstractAdminAction extends Action {
	
	/**
	 * 页数
	 * @var int
	 */
	private $page = 1;
	
	/**
	 * 每页显示个数
	 * @var int
	 */
	private $perpage = 25;
	
	/**
	 * 查询条件
	 */
	private $conditions = null;
	
	/**
	 * 排列顺序
	 * @var $orders
	 */
	private $orders = null;
	
	/**
	 * 是否开启验证
	 * @var boolean 默认为开启
	 */
	private $useValidate = true;
	
	/**
	 * 要验证的域
	 * @var string
	 */
	private $validateFields = null;

    /**
     * 登陆管理员id
     *
     * @var int
     */
    protected $managerId;
    
    /**
     * 登陆管理员
     *
     * @var array
     */
    protected $manager;
    
    /**
     * 左侧菜单上级id
     *
     * @var integer
     */
    protected $leftMenuParentId;
    
	/**
	 * 构造函数,子类必须调用
	 */
	public function __construct(){
		$easyConfig = R::getConfig();
		//设置验证监听器
		$easyConfig->setConfig('event_model_validate_listener', 'ShowMessageValidateListener');
		//消息显示
		$easyConfig->setConfig('base_message_action', array('module'=>'admin','action'=>'message', 'method'=>'show'));
		//处理分页
		$request = R::getRequest();
		$this->setPage($request->getParameter('page'));
		$this->setPerpage($request->getParameter('perpage'));

		//处理排序
		$order = $request->getParameter('order');
		if($order){
			$sort =  $request->getParameter('sort');
			$sorts = array('desc', 'asc');
			if(!in_array($sort, $sorts)){
				$sort = 'asc';
			}
			$request->setAttribute('order', $order);
			$request->setAttribute('sort', $sort);
			//nextsort是告诉table组件下一次排序顺序
			if($sort == 'desc'){
				$nextsort = 'asc';
			}else{
				$nextsort = 'desc';
			}
			$request->setAttribute('nextsort', $nextsort);
			$this->setOrders(array($order=>$sort));
		}
		$parameters = $request->getParameters();
		
		//当前的action和方法
		$actionMapping = R::getActionMapping();
		$currentModule = $actionMapping->getModule();
		$currentAction = $actionMapping->getAction();
		$currentMethod = $actionMapping->getMethod();
		$request->setAttribute('currentModule', $currentModule);
		$request->setAttribute('currentAction', $currentAction);
		$request->setAttribute('currentMethod', $currentMethod);
		
		$site_url = get_config('site_url');	
		$act_url = $site_url . "/{$currentModule}/$currentAction/";
		$met_url = $act_url ."{$currentMethod}/";
		$index_url = $act_url ."index/";
		$insert_url = $act_url ."insert/";
		$update_url = $act_url ."update/";
		
		//当前URL
		$request->setAttribute('site_url', $site_url); //当前站点URL
		$request->setAttribute('act_url', $act_url); //当前ActionURL
		$request->setAttribute('met_url', $met_url); //当前MethodURL
		$request->setAttribute('index_url', $index_url);
		$request->setAttribute('insert_url', $insert_url);
		$request->setAttribute('update_url', $update_url);
		$request->setAttribute('req_url', $request->getRequestURI()); //当前RequestURL
		
		//背景色
		$background = HttpCookie::get("admin_background") ? HttpCookie::get("admin_background") : "body_KK_Manage1";
		$request->setAttribute('background', $background);

        $this->managerId = HttpSession::get(ManagerService::SESSION_MANAGER_ID);
        $this->manager = HttpSession::get(ManagerService::SESSION_MANAGER);
        $request->setAttribute('manager', $this->manager);

        //菜单
        $this->lefMenu($this->leftMenuParentId);
        
        //检查更新权限
        $nowOperation = new Operation($currentModule, $currentAction, $currentMethod);
        $operationService = AdminServiceFactory::getAdminOperationService();
        if(!$operationService->hasPermission($nowOperation,  $this->manager)){
        	show_message(get_lang('no_permission'));
        }        
	}
	
	/**
	 * 模型列表，只能处理单表
	 * @see Action::index()
	 */
	public function index(HttpRequest $request){
        $modelDao = MD($this->createModelByAdminAction());
		$items = $modelDao->gets($this->getConditions(), null, $this->getOrders(), $this->getPage(), $this->getPerpage());
		$total = $modelDao->count($this->getConditions());
		$pages = multi_page($total, $this->getPerpage(), $this->getPage());
		$request->setAttribute('items', $items);
		$request->setAttribute('total', $total);
		$request->setAttribute('pages', $pages);
	}	
	
	public function add(HttpRequest $request){
		
	}
	
	public function beforeInsert(HttpRequest $request){
		//检查编辑权限
		$mapping = $this->getActionMapping();
		$addOperation = new Operation($mapping->getModule(), $mapping->getAction(), 'add');
		$operationService = AdminServiceFactory::getAdminOperationService();
		if(!$operationService->hasPermission($addOperation,  $this->manager)){
			show_message(get_lang('no_permission'));
		}
	}
	
	/**
	 * 添加模型，只能处理单表，如果有文件上传，请先上传文件，并设置值到请求参数中
	 * @param HttpRequest $request
	 */
	public function insert(HttpRequest $request){
		$this->beforeInsert($request);
        $model = $this->createModelByAdminAction();
		$model->fillPostDatas();	//收集与m_开头的数据
		if($this->getUseValidate()){
			//使用验证			
			$model->validate($this->getValidateFields());
		}
		$modelDao = MD($model);
		$success = $modelDao->add($model);
        $redirectInfo = $request->getAttribute('redirectInfo');
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
	 * 更新模型，要更新的id参数名为id
	 * @param HttpRequest $request
	 */
	public function edit(HttpRequest $request){
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
		$request->setAttribute('item', $item);
	}
	
	public function beforeUpdate(HttpRequest $request){
		//检查更新权限
		$mapping = $this->getActionMapping();
		$editOperation = new Operation($mapping->getModule(), $mapping->getAction(), 'edit');
		$operationService = AdminServiceFactory::getAdminOperationService();
		if(!$operationService->hasPermission($editOperation,  $this->manager)){
			show_message(get_lang('no_permission'));
		}
	}
	
	/**
	 * 更新模型，要更新的id参数名为id, 只能处理单表，
	 * 如果有文件上传，请先上传文件，并设置值到请求参数中
	 * @param HttpRequest $request
	 */
	public function update(HttpRequest $request){
		$this->beforeUpdate($request);
		$id = $request->getParameter('id');
		if(empty($id)){
			show_message(get_lang('no_record_common'));
		}
        $model = $this->createModelByAdminAction();
		$model->fillPostDatas();	//收集与m_开头的数据
		if($this->getUseValidate()){
			//使用验证
			$model->validate($this->getValidateFields());
		}
		$modelDao = MD($model);
		$success = $modelDao->update($model, $id);
		        
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
	 * 删除一个模型,要删除的id参数名为id.
	 * @param HttpRequest $request
	 */
	public function del(HttpRequest $request){
		$id = $request->getParameter('id');
		if(empty($id)){
			show_message(get_lang('no_record_common'));
		}
        $model = $this->createModelByAdminAction();
		$modelDao = MD($model);
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
	
	/**
	 * 异步修改单字段,参数中需指定参数id(记录ID)、field(修改的域)、value(修改后的值)
	 * @param HttpRequest $request
	 * @return json 返回{code:'', message:'', content''},成功时code为1,失败为0
	 */
	public function field(HttpRequest $request){
		//检查更新权限
		$mapping = $this->getActionMapping();
		$editOperation = new Operation($mapping->getModule(), $mapping->getAction(), 'edit');
		$operationService = AdminServiceFactory::getAdminOperationService();
		if(!$operationService->hasPermission($editOperation,  $this->manager)){
			die(json_encode(array('code'=>'0', 'message'=>'你没有操作权限!')));
		}
		
		$id = $request->getParameter('id');
		$field = $request->getParameter('field');
		$value = $request->getParameter('value');
		$value = trim($value);
		$message = array('code'=>0, 'message'=>'');
		if(empty($id)){
			$message['message'] = get_lang('no_record_common');
			die(json_encode($message));
		}
		if(empty($field)){
			$message['message'] = get_lang('no_field_common');
			die(json_encode($message));
		}
		$model = $this->createModelByAdminAction();
        $modelDao = MD($model);
		$success = $modelDao->update(array($field=>$value), $id);
		
		if($success){
			$message['code'] = '1';
			$message['content'] = $value;
			$message['message'] = get_lang('modify_success_common');
		}else{
			$message['message'] = get_lang('modify_failed_common');
		}
		die(json_encode($message));
	}
	
	/**
	 * @return the $page
	 */
	protected function getPage() {
		return $this->page;
	}

	/**
	 * @return the $perpage
	 */
	protected function getPerpage() {
		return $this->perpage;
	}

	/**
	 * @param int $page
	 */
	protected function setPage($page) {
		if($page > 0){
			$this->page = $page;
		}else{
			$this->page = 1;
		}
	}

	/**
	 * @param int $perpage
	 */
	protected function setPerpage($perpage) {
		if($perpage > 0){
			$this->perpage = $perpage;
		}else{
			$this->perpage = 20;
		}
	}
	
	/**
	 * @return the $conditions
	 */
	protected function getConditions() {
		return $this->conditions;
	}

	/**
	 * @param field_type $conditions
	 */
	protected function setConditions($conditions) {
		$this->conditions = $conditions;
	}

	/**
	 * @return the $orders
	 */
	protected function getOrders() {
		return $this->orders;
	}

	/**
	 * @param $orders $orders
	 */
	protected function setOrders($orders) {
		$this->orders = $orders;
	}
	
	/**
	 * @return the $useValidate
	 */
	protected function getUseValidate() {
		return $this->useValidate;
	}

	/**
	 * @param boolean $useValidate
	 */
	protected function setUseValidate($useValidate) {
		$this->useValidate = $useValidate;
	}

	/**
	 * @return the $validateFields
	 */
	protected function getValidateFields() {		
		return $this->validateFields;
	}

	/**
	 * @param string $validateFields
	 */
	protected function setValidateFields($validateFields) {
		$this->validateFields = $validateFields;
	}
	
	/**
	 * 获取当前Action的默认URL
	 */
	protected function getActionIndexUrl(){
		return get_config('site_url');
	}

	/**
	 * 根据后台Action创建动态模型
	 * @return Model
	 */
	protected function createModelByAdminAction(){
		$modelName = $this->getAdminActionName();
		return M($modelName);
	}
	
	/**
	 * 获取Action名称
	 * @return string
	 */
	private function getAdminActionName(){
		$request = R::getRequest();
		$actionMapping = $request->getAction()->getActionMapping();
		$actionName = $actionMapping->getAction();
		return $actionName;
	}
	
	protected function setMessage($message){
		$message = get_lang($message);
		setcookie('message',$message, 0, '/');
		$_COOKIE['message'] = $message;
	}
	
	/**
	 * 左侧菜单
	 */
	protected function lefMenu(){
		include_once(EXT_LIB_ROOT.'tools.fun.php');
		get_admin_menu($this->leftMenuParentId);
	}
	
	/**
	 * 生成验证js
	 * @param $useModelDataPrefix 是否使用模型数据前缀
	 */
	public function createValidateJs($useModelDataPrefix=true){
		$model = $this->createModelByAdminAction();
		$config = $model->getConfig();
		$rules = $config['rule'];
		$enter = "\n";
		$tab = '	';
		$tab2 = $tab . $tab;
		$tab3 = $tab2 . $tab;
		$validateJs  = "<script>" . $enter;
		$validateJs .= $tab . "function checkForm(form){" . $enter;
		if($rules){
			foreach($rules as $input=>$inputRules){
				foreach($inputRules as $rule){
					if($rule['type'] == 'required'){
						//暂时只做必需项的验证
						if($useModelDataPrefix){
							$inputName = Constant::MODEL_PARAM_PREFIX .$input;
						}else{
							$inputName = $input;
						}
						$validateJs .= $tab2 . "var {$input} = getFormValue(form, '{$inputName}');" . $enter;
						$validateJs .= $tab2 . "if({$input} == null || {$input} == 'undefined' || {$input} == ''){" . $enter;
						$validateJs .= $tab3 . "alert('{$rule['message']}');" . $enter;
						$validateJs .= $tab3 . "return false;" . $enter;
						$validateJs .= $tab2 . "}" . $enter;
					}
				}
			}
		}
		$validateJs .= $tab2 . "return true;" . $enter;
		$validateJs .= $tab . "}" . $enter;
		$validateJs .= "</script>";
		return $validateJs;
	}
	
	/**
	 * 记录后台背景色
	 */
	public function changeBackground(HttpRequest $request){
		HttpCookie::set("admin_background", $request->getParameter("css_name"));
		exit;
	}
}

?>