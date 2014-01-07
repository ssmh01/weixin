<?php
/**
 * 地区服务接口
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-01
 */
interface IRegion{
	
    /**
     * 根据条件获得地区,并把地区ID作为数组的key
     *
     * @param integer $type 地区级别类型，０：国家，１：省份 ２:城市 ３:镇区
     * @param integer $parentId 上级地区ID
     * @return array
     */
    public function getRegions($type=null, $parentId=null);
    
    /**
     * 获到所有地区树形列表
     * @param int $rootId　最顶级地区的ID,默认为中国
     */
    public function getRegionTree($rootId = 1);
}