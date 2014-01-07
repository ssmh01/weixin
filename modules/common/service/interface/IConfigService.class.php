<?php
/**
 * 系统设置服务接口
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-07-31
 */
interface IConfigService{
	
	/**
	 * 获取全部配置信息
	 * @param string $condition 条件
	 * @return array
	 */
	public function gets($condition=null);
	
    /**
     * 获取一项配置信息
     * @param string $key 标识
     * @return mixed
     */
    public function get($key);

    /**
     * 获取指定分组的配置项
     * @param string $group 分组标识
     * @return array
     */
    public function getGroup($group);
}