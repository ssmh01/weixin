<?php
/**
 * 资讯分类
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-06
 */
class NewsCategoryAction extends AbstractAdminAction{
	
	protected $leftMenuParentId = 20;
	
	/**
	 * @var INewsCategoryService
	 */
	private $newsCategoryService = null;
	
	/**
	 * 分类类型
	 * @var array
	 */
	private $types = null;
	
	/**
	 * 当前的分类类型
	 * @var int
	 */
	private $currentType = null;
	
	/**
	 * 列表
	 *
	 * @param HttpRequest $request        	
	 */
	public function index(HttpRequest $request){
		$this->setOrders(array('sort_num'=>'desc'));
		parent::index($request);
		$request->assign('title', '资讯分类管理');
	}
	
	/**
	 * 添加界面
	 *
	 * @param HttpRequest $request        	
	 */
	public function add(HttpRequest $request){
		$request->assign('title', '添加资讯分类');
	}
	
	/**
	 * 修改界面
	 *
	 * @param HttpRequest $request        	
	 */
	public function edit(HttpRequest $request){
		parent::edit($request);
		$request->assign('title', '修改资讯分类');
	}
	
	/*
	 * @see CommonAction::del()
	 */
	public function del(HttpRequest $request){
		$id = $request->getParameter('id');
		if($this->newsCategoryService->hasNews($id)){
			show_message('分类下有资讯，不能删除!');
		}
		parent::del($request);
	}
}