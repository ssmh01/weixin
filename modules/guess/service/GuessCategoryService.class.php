<?php
/**
 * 竞猜分类服务实现
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-01
 */
class GuessCategoryService implements IGuessCategoryService{
	private $guessCategoryMD;
	
	protected $enableLevel; // 可分配的上级数
	protected $guessCategorys;
	
	public function __construct(){
		$this->categoryMD = MD('GuessCategory');
		$this->enableLevel = 2;
	}
	
	/**
	 * 获取全部竞猜分类
	 */
	protected function getGuessCategorys(){
		$this->categorys = $this->categoryMD->gets(null, null, '`sort_num` DESC,`id` ASC', null, null);
	}
	
	/**
	 * 获取竞猜分类树
	 *
	 * @param integer $id
	 *        	竞猜分类id
	 * @param boolean $returnId
	 *        	是否只返回id，true是，false否(包含竞猜分类信息)
	 * @param integer $dataType
	 *        	返回的数据，0整链，1父类，2子类
	 * @param integer $show
	 *        	0不限，1显示的
	 * @return array
	 */
	protected function getGuessCategoryTree($id = 0, $returnId = false, $dataType = 2, $show = 0){
		empty($this->categorys) && $this->getGuessCategorys();
		include_once (EXT_LIB_ROOT . 'Tree.class.php');
		$tree = new Tree();
		foreach($this->categorys as $v){
			(!$show || (($show == 1) && $v['status'])) && $tree->setNode($v['id'], $v['parent_id'], $v);
		}
		switch($dataType){
			case 0 : // 整链
				$_parents = $tree->getParents($id);
				$_childs = $tree->getChilds($id);
				is_null($_parents) && $_parents = array();
				is_null($_childs) && $_childs = array();
				$ids = array_merge($_parents, array(
					$id
				), $_childs);
				break;
			case 1 : // 父类
				$ids = $tree->getParents($id);
				break;
			default : // 子类
				$ids = $tree->getChilds($id);
				break;
		}
		
		if($returnId){
			$list = $ids;
		}else{
			$list = array();
			foreach($ids as $_id){
				$_item = $tree->getValue($_id);
				$_item['layer'] = $tree->getLayer($_id);
				$list[$_id] = $_item;
			}
		}
		return $list;
	}
	
	
	/**
	 * 获取竞猜分类列表
	 *
	 * @param integer $id
	 *        	竞猜分类id，有指定则获取子竞猜分类列表
	 * @param integer $show
	 *        	0不限，1显示的
	 * @return array
	 */
	public function gets($id = 0, $show = 0){
		return $this->getGuessCategoryTree($id, false, 2, $show);
	}
	
	/**
	 * 获取竞猜分类信息
	 *
	 * @param integer $id
	 *        	竞猜分类id
	 * @return array
	 */
	public function get($id){
		$list = $this->gets();
		return $list[$id];
	}
	
	/**
	 * 添加竞猜分类
	 *
	 * @param GuessCategory $guessCategory        	
	 * @return boolean
	 */
	public function add(GuessCategory $guessCategory){
		$success = $this->categoryMD->add($guessCategory);
		return $success;
	}
	
	/**
	 * 修改竞猜分类
	 *
	 * @param GuessCategory $guessCategory        	
	 * @return boolean
	 */
	public function modify(GuessCategory $guessCategory){
		$id = $guessCategory->getId();
		$success = $this->categoryMD->update($guessCategory, $id);
		$success && $this->setSystemGuessCategorys();
		return $success;
	}
	
	/**
	 * 删除竞猜分类
	 *
	 * @param integer|array $ids
	 *        	竞猜分类id
	 * @param boolean $deleteChild
	 *        	删除子类
	 * @param array $deleteGuessCategorys
	 *        	可以删除的竞猜分类
	 * @return boolean
	 */
	public function delete($ids, $deleteChild = false, $deleteGuessCategorys = array()){
		$success = false;
		$cond = '1';
		
		$childs = $delIds = array();
		if(is_array($ids)){ // 批量
			$delIds = $ids;
			foreach($ids as $id){
				$_childs = $this->getGuessCategoryTree($id, true);
				is_null($_childs) && $_childs = array();
				$childs = array_merge($childs, $_childs);
			}
		}else{ // 单条
			$delIds = array(
				$ids
			);
			$_childs = $this->getGuessCategoryTree($ids, true);
			is_null($_childs) && $_childs = array();
			$childs = array_merge($childs, $_childs);
		}
		if($deleteChild || empty($childs)){ // 同时删除子竞猜分类或没有子竞猜分类
			$deleteChild && $delIds = array_merge($delIds, $childs);
			$cond .= ' AND `id` IN (' . implode(',', $delIds) . ')';
			$success = $this->categoryMD->deletes($cond);
			$success && $this->setSystemGuessCategorys();
			return $success;
		}
		return $success;
	}
	
	/**
	 * 获取可选择的上级(第一、二级)
	 *
	 * @return array
	 */
	public function getParents(){
		$list = $this->gets();
		foreach($list as $k => $v){
			if($v['layer'] >= $this->enableLevel) unset($list[$k]);
		}
		return $list;
	}
	
	/**
	 * 判断是否有子竞猜分类
	 *
	 * @param integer $id
	 *        	竞猜分类id
	 * @return boolean
	 */
	public function haveSubGuessCategory($id){
		$childs = $this->getGuessCategoryTree($id, true);
		return empty($childs)? false : true;
	}
	
	/**
	 * 获取顶级
	 *
	 * @return array
	 */
	public function getRoots(){
		$roots = array();
		if(empty($this->categorys)){
			$_roots = $this->categoryMD->gets("`parent_id`='0' AND `status`='1'", null, '`sort_num` DESC,`id` ASC', null, null);
			foreach($_roots as $v){
				$roots[$v['id']] = $v;
			}
		}else{
			foreach($this->categorys as $v){
				(empty($v['parent_id']) && ($v['status'] == 1)) && $roots[$v['id']] = $v;
			}
		}
		
		return $roots;
	}
	
	/**
	 * 获取所有的分类
	 * @see IGuessCategoryService::getAlls()
	 */
	public function getAlls(){
		$categorys = $this->categoryMD->gets();
		return ArrayUtil::changeKey($categorys, 'id');
	}
}