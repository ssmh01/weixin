<?php
/**
 * 菜单
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-02
 */
class MenuAction extends AbstractAdminAction{
	
    private $menuService;
    protected $cacheFun;
    protected $leftMenuParentId = 1;

    public function __construct(){
        parent::__construct();
        $this->menuService = AdminServiceFactory::getMenuService();
        $this->cacheFun = 'menu';

        $request = R::getRequest();
        $request->assign('cacheFunc', $this->cacheFun);
    }

    /**
     * 获取可分配的上级链
     */
    private function _getEnableParents(){
        $parents = $this->menuService->getParents();
        foreach($parents as $k => $v){
            if($v['status']){
                $parents[$k]['name'] = str_repeat('—', $v['layer']).$v['name'];
            }else{
                unset($parents[$k]);
            }
        }
        return $parents;
    }

    /**
     * 列表
     *
     * @param HttpRequest $request
     */
    public function index(HttpRequest $request){

        $list = $this->menuService->gets();
        foreach($list as $k => $v){
            $list[$k]['name'] = '|-'.str_repeat('----', $v['layer']).' '.$v['name'];
        }
        $request->assign('list', $list);
        $request->assign('title', '系统菜单');
        $request->assign('parents', $this->_getEnableParents());
    }

    /**
     * 添加界面
     *
     * @param HttpRequest $request
     */
    public function add(HttpRequest $request){
    	$request->assign('title', '添加菜单');
        $request->assign('parents', $this->_getEnableParents());
    }

    /**
     * 保存添加
     *
     * @param HttpRequest $request
     */
    public function insert(HttpRequest $request){
        $name = trim($request->getParameter('name'));
        empty($name) && show_message('菜单名称不能为空');
        $parent_id = intval($request->getParameter('parent_id'));
        $url = trim($request->getParameter('url'));
        $status= intval($request->getParameter('status'));
        $sort_num = intval($request->getParameter('sort_num'));

        $menu = new Menu();
        $menu->setName($name);
        $menu->setSortNum($sort_num);
        $menu->setUrl($url);
        $menu->setStatus($status);
        $menu->setParentId($parent_id);
        
        if($this->menuService->add($menu)){
        	$this->setMessage('op_success');
        	$request->redirect($request->getAttribute('index_url'));
        }else{
        	show_message('operation_failed_common');
        }
    }

    /**
     * 修改界面
     *
     * @param HttpRequest $request
     */
    public function edit(HttpRequest $request){
        parent::edit($request);
        $item = $request->getAttribute('item');
        $request->assign('parents', $this->_getEnableParents());
        $request->assign('selShow', array($item['status'] => ' checked'));
        $request->assign('title', '修改菜单');
    }

    /**
     * 保存修改
     *
     * @param HttpRequest $request
     */
    public function update(HttpRequest $request){
        $id = intval($request->getParameter('id'));
        empty($id) && show_message('param_wrong');
        $name = trim($request->getParameter('name'));
        empty($name) && show_message('admin_menu_name_empty');
        $parent_id = intval($request->getParameter('parent_id'));
        $url = trim($request->getParameter('url'));
        $status= intval($request->getParameter('status'));
        $sort_num = intval($request->getParameter('sort_num'));

        $menu = new Menu();
        $menu->setId($id);
        $menu->setName($name);
        $menu->setStatus($status);
        $menu->setSortNum($sort_num);
        $menu->setUrl($url);
        $menu->setParentId($parent_id);
        
        if($this->menuService->modify($menu)){
        	$this->setMessage('op_success');
        	$request->redirect($request->getAttribute('index_url'));
        }else{
        	show_message('operation_failed_common');
        }
    }

    /**
     * 删除
     *
     * @param HttpRequest $request
     */
    public function del(HttpRequest $request){
        $id = $request->getParameter('id');
        empty($id) && show_message(get_lang('no_record_common'));
        $this->menuService->haveSubMenu($id) && show_message('admin_menu_child_noe_delete');
        $menu = $this->menuService->get($id);
        ($menu['is_system'] == IMenuService::SYSTEM_YES) && show_message('admin_menu_system_not_delete');
        if($this->menuService->delete($id)){
            $this->setMessage('op_success');
            $request->redirect($request->getAttribute('index_url'));
        }else{
            show_message('operation_failed_common');
        }
    }

    /**
     * 批量删除
     *
     * @param HttpRequest $request
     */
    public function dels(HttpRequest $request){
        $ids = $request->getParameter('ids');
        empty($ids) && show_message(get_lang('no_record_common'));
        foreach($ids as $id){
            $this->menuService->haveSubMenu($id) && show_message('admin_menu_child_noe_delete');
        }
        if($this->menuService->delete($id)){
            show_message('operation_success_common', $request->getAttribute('index_url'));
        }else{
            show_message('operation_failed_common');
        }
    }
}