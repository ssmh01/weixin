<?php
/**
 * 加上缓存功能的菜单服务实现
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-01
 */
class CacheMenuService extends MenuService implements IMenuService{

    /**
     * 获取菜单列表
     */
    private function _getMenus(){
        if(empty($this->menus)){
            $this->menus = cache_get('Menu');
            if(empty($this->menus)){
                $this->menus = $this->getMenus();
                cache_get('Menu', $this->menus);
            }
        }
    }

    /**
     * 获取菜单列表
     *
     * @param integer $id 菜单id，有指定则获取子菜单列表
     * @param integer $show 0不限，1显示的
     * @return array
     */
    public function gets($id=0, $show=0)
    {
        $this->_getMenus();
        return $this->getMenuTree($id, false, 2, $show);
    }

    /**
     * 获取顶级
     *
     * @return array
     */
    public function getRoots(){
        $this->_getMenus();
        return parent::getRoots();
    }
}