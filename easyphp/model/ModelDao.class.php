<?php

/** 
 * 模型－数据库访问类
 * @author blueyb.java@gmail.com
 * @since 1.0 -	2011.06.05
 * 
 */
class ModelDao {
	
	/**
	 * 模型名
	 * @var string
	 */
	private $modelName;
	
	/**
	 * 记录库操作类
	 * @var DB
	 */
	private $db;
	
	/**
	 * 模型对应的表名
	 * @var string
	 */
	private $table;
	
	/**
	 * 模型对应的表主键
	 * @var string
	 */
	private $pk = 'id';
	
	/**
	 * 构造函数
	 * @param DB $db
	 * @param string $table
	 * @param string $pk
	 * @param string $modelName
	 */
	public function __construct($db, $table, $pk, $modelName=null){
		$this->db = $db;
		$this->table = $table;
		$this->pk = $pk;
		$this->modelName = $modelName;
	}
	
	/**
	 * 获取Dao对应的模型名称
	 */
	public function getModelName(){
		return $this->modelName;
	}
	
	/**
	 * 根据条件获取记录
	 * @param id 主键
	 * @param array/string $gets	获取列
	 * @param $returnModel
	 * 控制返回的结果类型是数组还是模型对象，默认是数组
	 * @return Model
	 * 返回第一条获取的记录
	 */
	public function get($id, $gets=null, $returnModel=false){
		$conditions = "{$this->pk} = '{$id}'";
		$datas = $this->gets($conditions, $gets, null, 1, 1);
		if(empty($datas)){
			return null;
		}
		if($returnModel){
			//返回模型对象
			return Model::newModel($this->modelName, current($datas));
		}
		return current($datas);
	}
	
	/**
	 * 从表中获取信息
	 * @param array|string $gets
	 * 	要获取的列
	 * @param array|string $conditions
	 *  获取条件
	 * @param array|string $order
	 * 	排序如array('id'=>'desc','dateline'=>'asc')
	 * @param int $page
	 * 	页数
	 * @param int $perpage
	 * 	每页个数
	 * @return
	 *  返回一个二维数组
	 */
	public function gets($conditions, $gets, $orders, $page, $perpage){
		$sql = SQL::createSelect($this->table, $gets, $conditions, $orders, $page, $perpage);
		return $this->db->getRows($sql);
	}
	
	/**
	 * 获取一行记录
	 * @param array/string $conditions
	 *  获取条件
	 * @param array/string $gets
	 * 	要获取的列
	 * @param $returnModel
	 * 	控制返回的结果类型是数组还是模型对象，默认是数组
	 * @return Model|array
	 * 	返回第一条获取的记录
	 */
	public function getOne($conditions, $gets=null, $returnModel=false){
		$datas = $this->gets($conditions, $gets, null, 1, 1);
		if(empty($datas)){
			return null;
		}
		if($returnModel){
			//返回模型对象
			return Model::newModel($this->modelName, current($datas));
		}
		return current($datas);
	}
	
	/**
	 * 添加一条记录
	 * @param Model/Array/DynamicModelTransformSupport $model
	 */
	public function add($model){
		$model = $this->makeSureModelData($model);
		$sql = SQL::createInsert($this->table, $model);
		$this->query($sql);
		return $this->db->getInsertId();
	}
	
	/**
	 * 删除一条记录
	 * @param string/array $conditions
	 * @return 
	 */
	public function delete($id){
		$conditions = array($this->pk=>$id);
		return $this->deletes($conditions);
	}
	
	/**
	 * 删除多条记录
	 * @param string/array $conditions
	 * @return 
	 */
	public function deletes($conditions){
		$sql = SQL::createDelete($this->table, $conditions);
		return $this->query($sql);
	}
	
	/**
	 * 
	 * @param Model/Array/DynamicModelTransformSupport $model
	 * @param id $id
	 * @param boolean $mathMode
	 * 	是否开启值运算模式,如果开启则支持在原来的值上进行运算,默认不开启.
	 * @return 成功返回true,失败返回false
	 */
	public function update($model, $id, $mathMode=false){
		$conditions = array($this->pk=>$id);
		return $this->updates($model, $conditions, $mathMode);
	}
	
	/**
	 * 更新记录
	 * @param Model/Array/DynamicModelTransformSupport $model $datas
	 * 	要更新的记录
	 * @param string/array $conditions
	 * 	更新条件
	 * @param boolean $mathMode
	 * 	是否开启值运算模式,如果开启则支持在原来的值上进行运算,默认不开启.
	 * @return 
	 * 	成功返回true,失败返回false
	 */
	 public function updates($model, $conditions, $mathMode=false) {
	 	$model = $this->makeSureModelData($model);
		$sql = SQL::createUpdate($this->table, $model, $conditions, $mathMode);
		return $this->query($sql);
	}
	
	/**
	 * 获取记录个数
	 * @param string/array $conditions
	 * 获取条件
	 * @return 
	 */
	public function count($conditions){
		$sql = SQL::createSelect($this->table, "count(*)", $conditions);
		return $this->db->getRowFiled($sql, 0, 0);
	}
	
	/**
	 * 执行SQL语言
	 * @param string $sql
	 */
	public function query($sql){
		return $this->db->query($sql);
	}
	
	/**
	 * 开启事务
	 * @return 
	 */
	public function beginTransation(){
		return $this->query("BEGIN");
	}
	
	/**
	 * 提交事务
	 * @return 
	 */
	public function commit(){
		return $this->query("COMMIT");
	}
	
	/**
	 *回滚事务
	 * @return 
	 */
	public function rollBack(){
		return $this->query("ROLLBACK");
	}
	
	/**
	 * 写锁定
	 * @return boolean
	 */
	public function writeLock(){
		return $this->query("lock tables {$this->table} write");
	}
	
	/**
	 * 读锁定
	 * @return boolean
	 */
	public function readLock(){
		return $this->query("lock tables {$this->table} read");
	}
	
	/**
	 * 解锁
	 * @return boolean
	 */
	public function unLock(){
		return $this->query("unlock tables");
	}
	
	/**
	 * 模型Dao转换,转换成别的模型Dao
	 * @param string/Model $model
	 * @return ModelDao
	 */
	public function transform($model){
		$modelConfig = R::getModelConfig($model);
		$this->table = $modelConfig['orm']['table'];
		$this->pk = $modelConfig['orm']['pk'];
		return $this;
	}
	
	/**
	 * 确保把模型数据转换成数组数据
	 */
	protected function makeSureModelData($model){
		if(is_array($model)) return $model;
		if($model instanceof Model){
			return $model->getDataArray();
		}
		if($model instanceof DynamicModelTransformSupport){
			$model = ModelTransform::toDynamicModel($model, null, $model->getFields());
			return $model->getDataArray();
		}
		return $model;
	}
	
	/**
	 * 获取模型的数据访问对象
	 * @param string/Model $model
	 */
	public static function newModelDao($model){
        if($model instanceof Model){
            $modelName =  $model->getModelName();
        }else{
            $modelName = $model;
        }
		$modelConfig = R::getModelConfig($model);
		$db = R::getDB();
		return new ModelDao($db, $modelConfig['orm']['table'], $modelConfig['orm']['pk'], $modelName);
	}

    /**
     * 获取执行的影响数
     *
     * @return integer
     */
    public function affectedRows(){
        return $this->db->affectedRows();
    }
}

?>