<?php
/**
 * 菜单服务接口
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-01
 */
interface IMenuService{
	
    const SYSTEM_YES    = 1;//系统内置
    const SYSTEM_NO     = 0;//非内置

    const SHOW_YES      = 1;//显示
    const SHOW_NO       = 0;//不显示

    /**
     * 获取菜单列表
     *
     * @param integer $id 菜单id，有指定则获取子菜单列表
     * @param integer $show 0不限，1显示的
     * @return array
     */
    public function gets($id=0, $show=0);

    /**
     * 获取菜单信息
     *
     * @param integer $id 菜单id
     * @return array
     */
    public function get($id);

    /**
     * 添加菜单
     *
     * @param Menu $menu
     * @return boolean
     */
    public function add(Menu $menu);

    /**
     * 修改菜单
     *
     * @param Menu $menu
     * @return boolean
     */
    public function modify(Menu $menu);

    /**
     * 删除菜单
     *
     * @param integer|array $ids 菜单id
     * @param boolean $deleteChild 删除子类
     * @param bool $includeSys 是否包含系统内置的菜单，true是，false否(只删除非内置的菜单)
     * @return boolean
     */
    public function delete($ids, $deleteChild=false, $includeSys=false);

    /**
     * 获取可选择的上级(第一、二级)
     *
     * @return array
     */
    public function getParents();

    /**
     * 判断是否有子菜单
     *
     * @param integer $id 菜单id
     * @return boolean
     */
    public function haveSubMenu($id);

    /**
     * 获取顶级
     *
     * @return array
     */
    public function getRoots();

    /**
     * 移动菜单
     *
     * @param integer|array $ids 菜单id
     * @param integer $newId 新菜单id
     * @return boolean
     */
    public function move($ids, $newId);

}