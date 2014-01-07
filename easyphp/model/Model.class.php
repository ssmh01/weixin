<?php

/**
 * 框架的模型类
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2012-02-14
 */
class Model extends SetGetAdapter{
	
	/**
	 * 模型名称，对应模型的各种规则
	 * @var string
	 */
	private $modelName;
	
	/**
	 * 模型数据
	 * @var array
	 */
	private $data;
	
	/**
	 * 模型配置
	 * @var array
	 */
	private $config;
	
	/**
	 * 构造函数
	 */
	public function __construct($name) {
		$this->setModelName($name);
        // 模型初始化
        $this->initialize();
    }
    
	/**
	 * @return the $modelName
	 */
	public function getModelName() {
		return $this->modelName;
	}

	/**
	 * @param string $modelName
	 */
	protected  function setModelName($modelName) {
		$this->modelName = $modelName;
	}

	/**
	 * 设置数据对象属性
	 * @param string $name 键名
	 * @param string $value	键值
	 */
    public function __set($name,$value) {
        // 设置数据对象属性
        $this->data[$name]  =   $value;
    }

    /**
     * 获取模型对象的属性值
     * @param string $name 键名
     */
    public function __get($name) {
        return isset($this->data[$name])?$this->data[$name]:null;
    }

    /**
     * 检测数据对象的值
     * @param string $name 键名
     */
    public function __isset($name) {
        return isset($this->data[$name]);
    }

    /**
     * 销毁数据对象的值
     * @param string $name 键名
     */
    public function __unset($name) {
        unset($this->data[$name]);
    }
    
    /**
	 * @return the $config
	 */
	public function getConfig() {
		return $this->config;
	}

	/**
	 * @param array $config
	 */
	public function setConfig($config) {
		$this->config = $config;
	}
	
	/**
	 * 从POST中填充数据，如果指定填充字段则只获取指定的字段的数据，
	 * 如果不指定使用前缀模式来填充数据。
	 * @param string/array $fields 要填充的填充字段，使用字符串类型时多个字段用:分隔
	 */
	public function fillPostDatas($fields=null){
		$request = R::getRequest();
		if($fields){
			if(is_string($fields)){
				$fields =  explode(':', $fields);
			}
			$parameters = $request->getParameters();
			foreach($fields as $field){
				$this->$field= $parameters[$field];
			}
		}else{			
			foreach($request->getParameters() as $key=>$value){				
				if(String::startWith($key, Constant::MODEL_PARAM_PREFIX)){
					//符合要收集的模型数据格式
					$key = substr($key, strlen(Constant::MODEL_PARAM_PREFIX));
					$this->$key = $value;					
				}
			}
		}
		
	}

	/**
     * 获取模型的数据数组，不包括名称
     * @return array
     */
    public function getDataArray(){
    	return $this->data;
    }
    
    /**
     * 验证模型数据
     * @param string $fields 要验证的域，多个域用:分隔
     * @return string 如果验证通过则没有返回值,不通过则返回验证失败消息
     */
    public function validate($fields=null){
    	$validator = new ModelValidator();
    	$validator->setModel($this);
    	$validator->setRules($this->config['rule']);
    	$validateListener = R::getConfig()->getConfig('event_model_validate_listener');
    	if($validateListener){
    		//添加监听器
    		$validator->setListener(BeanUtils::builtInstance($validateListener, null));
    	}
    	return $validator->validate($fields);
    }
    
    /**
     * 设置模型的数据
     * @param array $data
     */
    protected function setDataArray($data){
    	$this->data = $data;
    }
    
    /**
     * 回调方法 初始化模型
     */
    protected function initialize() {}
    
   /**
    * 创建一个模型
    * @param string $name
    * @param array $data
    * 模型要包括的数据
    */
    public static function newModel($name, $data){
    	$model = new Model($name);
    	$model->setDataArray($data);
    	return $model;
    }
}

?>