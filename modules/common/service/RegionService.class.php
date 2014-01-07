<?php

/**
 * 地区服务
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-01
 */
class RegionService implements IRegion{
	
	private $dao;
	
	public function __construct(){
		$this->dao = MD('region');
	}
	
	public function getRegions($type=null, $parentId=null){
		$tempRegions = $this->dao->gets();
		$regions = array();
		foreach($tempRegions as $region){
			if(isset($type) && $type != $region['type']) continue;
			if(isset($parentId) && $parentId != $region['parent_id']) continue;
			$regions[$region['id']] = $region;
		}
		unset($tempRegions);
		return $regions;
	}
	
	/**
	 * 获到所有地区树形列表
	 */
	public function getRegionTree($id = 1){
		include_once (EXT_LIB_ROOT . 'Tree.class.php');
		$tree = new Tree();
		$regions = $this->getRegions();
		foreach($regions as $region){
			$tree->setNode($region['id'], $region['parent_id'], $region);
		}
		$child = $tree->getChild($id);
		$regions = $this->getChildren($child, $tree);
		unset($child);
		return $regions;
	}
	
	private function getChildren($child, $tree){
		foreach($child as $k => $childId){
			$cur = $tree->getValue($childId);
			$cur['layer'] = $tree->getLayer($childId);
			$cur['childen'] = $this->getChildren($tree->getChild($childId), $tree);
			$regions[$childId] = $cur;
		}
		return $regions;
	}

}
