<?php
/**
 * 微博管理
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-06
 */
class WeiboAction extends AbstractAdminAction{
	
	protected $leftMenuParentId = 1;
	
	/**
	 * @var ModelDao
	 */
	private $dao = null;
	
	public function __construct(){
		parent::__construct();
		$this->dao = MD("Weibo");
	}
	
	/**
	 * 列表
	 *
	 * @param HttpRequest $request        	
	 */
	public function index(HttpRequest $request){
		parent::index($request);
		$request->assign('title', '微博管理');
	}
	
	/**
	 * 添加界面
	 *
	 * @param HttpRequest $request        	
	 */
	public function add(HttpRequest $request){
		$request->assign('title', '添加微博');
	}
	
	/**
	 * 修改界面
	 *
	 * @param HttpRequest $request        	
	 */
	public function edit(HttpRequest $request){
		parent::edit($request);
		$request->assign('title', '修改微博');
	}
}