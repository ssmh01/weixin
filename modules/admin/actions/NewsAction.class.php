<?php
/**
 * 资讯
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-06
 */
class NewsAction extends AbstractAdminAction{
	
	protected $leftMenuParentId = 20;
	
	/**
	 * @var INewsCategoryService
	 */
	private $newsCategoryService = null;
	
	/**
	 * 
	 * @var INewsService
	 */
	private $newsService= null;
	
	/**
	 * 资讯分类
	 * @var array
	 */
	private $categorys = null;
	
	public function __construct(){
		parent::__construct();
		$request = R::getRequest();
		$this->newsCategoryService = NewsServiceFactory::getNewsCategoryService();
		$this->categorys = $this->newsCategoryService->getCategorys();
		$request->setAttribute('categorys', $this->categorys);
	}
	
	/**
	 * 列表
	 *
	 * @param HttpRequest $request        	
	 */
	public function index(HttpRequest $request){
		$cate = $request->getParameter('cate');
		$conditions = " 1 ";
		if($cate){
			$request->setAttribute('cate', $cate);
			$conditions .= " and cate_id = '{$cate}'";
		}
		$this->setConditions($conditions);
		$this->setOrders(array('sort_num'=>'desc'));
		parent::index($request);
		$request->assign('title', '资讯管理');
	}
	
	/**
	 * 添加界面
	 *
	 * @param HttpRequest $request        	
	 */
	public function add(HttpRequest $request){
		$request->assign('title', '添加资讯');
	}
	
	public function beforeInsert(HttpRequest $request){
		$request->setParameter('m_create_time', $request->getRequestTime());
	}
	
	/**
	 * 修改界面
	 *
	 * @param HttpRequest $request        	
	 */
	public function edit(HttpRequest $request){
		parent::edit($request);
		$request->assign('title', '修改资讯');
	}
}