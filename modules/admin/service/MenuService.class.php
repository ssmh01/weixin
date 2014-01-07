<?php
/**
 * 菜单服务实现
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-01
 */
class MenuService implements IMenuService{
	private $menuMD;
	
	protected $enableLevel; // 可分配的上级数
	protected $menus;
	
	public function __construct(){
		$this->menuMD = MD('Menu');
		$this->enableLevel = 2;
	}
	
	/**
	 * 获取全部菜单
	 */
	protected function getMenus(){
		$this->menus = $this->menuMD->gets(null, null, '`sort_num` DESC,`id` ASC', null, null);
	}
	
	/**
	 * 获取菜单树
	 *
	 * @param integer $id
	 *        	菜单id
	 * @param boolean $returnId
	 *        	是否只返回id，true是，false否(包含菜单信息)
	 * @param integer $dataType
	 *        	返回的数据，0整链，1父类，2子类
	 * @param integer $show
	 *        	0不限，1显示的
	 * @return array
	 */
	protected function getMenuTree($id = 0, $returnId = false, $dataType = 2, $show = 0){
		empty($this->menus) && $this->getMenus();
		include_once (EXT_LIB_ROOT . 'Tree.class.php');
		$tree = new Tree();
		foreach($this->menus as $v){
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
	 * 设置菜单链为内置菜单
	 */
	protected function setSystemMenus(){
		$systemMenus = $this->menuMD->gets("`is_system`='" . self::SYSTEM_YES . "'", null, null, null, null);
		if(!empty($systemMenus)){
			$parents = array();
			foreach($systemMenus as $v){
				$_parents = $this->getMenuTree($v['id'], true, 1);
				is_null($_parents) && $_parents = array();
				$parents = array_merge($parents, $_parents);
			}
			$parents = array_unique($parents);
			!empty($parents) && $this->menuMD->updates(array(
				'is_system' => self::SYSTEM_YES
			), '`id` IN (' . implode(',', $parents) . ')');
		}
	}
	
	/**
	 * 获取菜单列表
	 *
	 * @param integer $id
	 *        	菜单id，有指定则获取子菜单列表
	 * @param integer $show
	 *        	0不限，1显示的
	 * @return array
	 */
	public function gets($id = 0, $show = 0){
		return $this->getMenuTree($id, false, 2, $show);
	}
	
	/**
	 * 获取菜单信息
	 *
	 * @param integer $id
	 *        	菜单id
	 * @return array
	 */
	public function get($id){
		$list = $this->gets();
		return $list[$id];
	}
	
	/**
	 * 添加菜单
	 *
	 * @param Menu $menu        	
	 * @return boolean
	 */
	public function add(Menu $menu){
		$success = $this->menuMD->add($menu);
		$success && $this->setSystemMenus();
		return $success;
	}
	
	/**
	 * 修改菜单
	 *
	 * @param Menu $menu        	
	 * @return boolean
	 */
	public function modify(Menu $menu){
		$id = $menu->getId();
		$success = $this->menuMD->update($menu, $id);
		$success && $this->setSystemMenus();
		return $success;
	}
	
	/**
	 * 删除菜单
	 *
	 * @param integer|array $ids
	 *        	菜单id
	 * @param boolean $deleteChild
	 *        	删除子类
	 * @param bool $includeSys
	 *        	是否包含系统内置的菜单，true是，false否(只删除非内置的菜单)
	 * @param array $deleteMenus
	 *        	可以删除的菜单
	 * @return boolean
	 */
	public function delete($ids, $deleteChild = false, $includeSys = false, $deleteMenus = array()){
		$success = false;
		$cond = '1';
		
		$childs = $delIds = array();
		if(is_array($ids)){ // 批量
			$delIds = $ids;
			foreach($ids as $id){
				$_childs = $this->getMenuTree($id, true);
				is_null($_childs) && $_childs = array();
				$childs = array_merge($childs, $_childs);
			}
		}else{ // 单条
			$delIds = array(
				$ids
			);
			$_childs = $this->getMenuTree($ids, true);
			is_null($_childs) && $_childs = array();
			$childs = array_merge($childs, $_childs);
		}
		if($deleteChild || empty($childs)){ // 同时删除子菜单或没有子菜单
			$deleteChild && $delIds = array_merge($delIds, $childs);
			$cond .= ' AND `id` IN (' . implode(',', $delIds) . ')';
			!$includeSys && $cond .= ' AND `is_system`=' . self::SYSTEM_NO;
			$success = $this->menuMD->deletes($cond);
			$success && $this->setSystemMenus();
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
	 * 判断是否有子菜单
	 *
	 * @param integer $id
	 *        	菜单id
	 * @return boolean
	 */
	public function haveSubMenu($id){
		$childs = $this->getMenuTree($id, true);
		return empty($childs)? false : true;
	}
	
	/**
	 * 获取顶级
	 *
	 * @return array
	 */
	public function getRoots(){
		$roots = array();
		if(empty($this->menus)){
			$_roots = $this->menuMD->gets("`parent_id`='0' AND `status`='" . self::SHOW_YES . "'", null, '`sort_num` DESC,`id` ASC', null, null);
			foreach($_roots as $v){
				$roots[$v['id']] = $v;
			}
		}else{
			foreach($this->menus as $v){
				(empty($v['parent_id']) && ($v['status'] == self::SHOW_YES)) && $roots[$v['id']] = $v;
			}
		}
		
		return $roots;
	}
	
	/**
	 * 移动菜单
	 *
	 * @param integer|array $ids
	 *        	菜单id
	 * @param integer $newId
	 *        	新菜单id
	 * @return boolean
	 */
	public function move($ids, $newId){
		$success = false;
		if(!empty($ids) && isset($newId)){
			!is_array($ids) && $ids = array(
				$ids
			);
			$success = $this->menuMD->updates(array(
				'parent_id' => $newId
			), '`id` IN (' . implode(',', $ids) . ')');
		}
		return $success;
	}
}