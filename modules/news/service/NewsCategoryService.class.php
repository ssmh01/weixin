<?php

/**
 * 资讯分类服务
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - Dec 26, 2012
 */
class NewsCategoryService extends TransationSupport implements INewsCategoryService{
	
	/**
	 *
	 * @var ModelDao
	 */
	private $dao = null;
	
	/**
	 * 分类类型
	 *
	 * @var array
	 */
	private $types = array(
		NewsCategory::TYPE_BULLETION => '系统公告',
		NewsCategory::TYPE_FINANCIAL_SECURITY => '资金保障',
		NewsCategory::TYPE_FINANCIAL_MANAGE => '优贷理财',
		NewsCategory::TYPE_QUESTION => '常见问题',
		NewsCategory::TYPE_NEWS => '行业新闻'
	);
	
	public function __construct(){
		$this->dao = MD('NewsCategory');
	}
	
	/**
	 *
	 * @see INewsCategoryService::getCategoryTypes()
	 */
	public function getCategoryTypes(){
		return $this->types;
	}
	
	/*
	 * @see INewsCategoryService::getCategory()
	 */
	public function getCategory($id){
		if(!is_numeric($id)) return null;
		return $this->dao->get($id);
	}
	
	/*
	 * @see INewsCategoryService::getCategorys()
	 */
	public function getCategorys($type){
		$conditions = null;
		if($type){
			$conditions = array(
				'type' => $type
			);
		}
		$orders = array(
			'sort_num' => 'desc'
		);
		$categorys = $this->dao->gets($conditions, null, $orders);
		return ArrayUtil::changeKey($categorys, 'id');
	}
		
	/*
	 * @see INewsCategoryService::hasNews()
	 */
	public function hasNews($id){
		$newsDao = MD('News');
		$count = $newsDao->count("cate_id = '{$id}'");
		return $count? true:false;
	}
}

?>