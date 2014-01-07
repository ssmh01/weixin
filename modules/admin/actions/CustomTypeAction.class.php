<?php
/**
 * 自定义竞猜类型
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-06
 */
class CustomTypeAction extends AbstractAdminAction{
	
	protected $leftMenuParentId = 15;
	
	/**
	 * 列表
	 *
	 * @param HttpRequest $request        	
	 */
	public function index(HttpRequest $request){
		$this->setOrders(array('sort_num'=>'desc'));
		parent::index($request);
		$request->assign('title', '自定义类型管理');
	}
	
	/**
	 * 添加界面
	 *
	 * @param HttpRequest $request        	
	 */
	public function add(HttpRequest $request){
		$request->assign('title', '添加自定义类型');
	}
	
	/**
	 * 修改界面
	 *
	 * @param HttpRequest $request        	
	 */
	public function edit(HttpRequest $request){
		parent::edit($request);
		$request->assign('title', '修改自定义类型');
	}
}