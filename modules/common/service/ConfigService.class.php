<?php
/**
 * 系统设置服务
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-07-31
 */
class ConfigService implements IConfigService{
	
    private $dao;

    public function __construct(){
        $this->dao = MD('Config');
    }
    
    
    public function gets($condition=null){
    	$tempConfigs = $this->dao->gets($condition, null, null, null, null);
    	$configs = array();
    	foreach($tempConfigs as $config){
    		$configs[$config['key']] = $config['value'];
    	}
    	unset($tempConfigs);
    	return $configs;
    }

    /**
     * 获取配置信息
     * @param string $key 配置key
     * @return string  配置值
     */
    public function get($key)
    {
        $configs = $this->gets();
        return $configs[$key];
    }

    /**
     * 获取指定分组的配置项
     *
     * @param string $group 分组标识
     * @return array
     */
    public function getGroup($group){
        $configs = $this->__gets("`tab`='{$group}'");
        $configs = ArrayUtil::groupByKey($configs, 'tab');
        return $configs[$group];
    }

    /**
     * 获取全部配置信息
     * @param string $condition 条件
     * @return array
     */
    protected function __gets($condition=null){
    	$configs = $this->dao->gets($condition, null, null, null, null);
    	return ArrayUtil::changeKey($configs, 'key');
    }
}