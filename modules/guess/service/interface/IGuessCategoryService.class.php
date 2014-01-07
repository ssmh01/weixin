<?php
/**
 * 竞猜分类服务接口
 * @author blueyb.java@gmail.com
 */
interface IGuessCategoryService{
	
	/**
	 * 获取所有的分类
	 * @return array
	 */
	public function getAlls();
	
    /**
     * 获取竞猜分类列表
     *
     * @param integer $id 竞猜分类id，有指定则获取子竞猜分类列表
     * @return array
     */
    public function gets($id=0);

    /**
     * 获取竞猜分类信息
     *
     * @param integer $id 竞猜分类id
     * @return array
     */
    public function get($id);

    /**
     * 添加竞猜分类
     *
     * @param GuessCategory $guessCategory
     * @return boolean
     */
    public function add(GuessCategory $guessCategory);

    /**
     * 修改竞猜分类
     *
     * @param GuessCategory $guessCategory
     * @return boolean
     */
    public function modify(GuessCategory $guessCategory);

    /**
     * 删除竞猜分类
     *
     * @param integer|array $ids 竞猜分类id
     * @param boolean $deleteChild 删除子类
     * @return boolean
     */
    public function delete($ids, $deleteChild=false);

    /**
     * 获取可选择的上级(第一、二级)
     *
     * @return array
     */
    public function getParents();

    /**
     * 判断是否有子竞猜分类
     *
     * @param integer $id 竞猜分类id
     * @return boolean
     */
    public function haveSubGuessCategory($id);

    /**
     * 获取顶级
     *
     * @return array
     */
    public function getRoots();
}