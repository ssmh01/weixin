<?php

/**
 * 键-值读写的文件介质实现
 * @author blueyb.java@gmail.com
 * @since 1.0	2012-11-02
 */
class FileKeyValue{
	
	/**
	 * 键值文件存储目录
	 * 
	 * @var string
	 */
	private $storeDirectory;
	
	public function __construct($storeDirectory){
		$this->setStoreDirectory($storeDirectory);
	}
	
	/**
	 * 放入键-值对
	 * @param string $key
	 * @param mixed $value
	 */
	public function put($key, $value){
		$value = serialize($value);
		file_put_contents($this->getFile($key), $value);
	}
	
	/**
	 * 根据键获取值
	 * @param string $key
	 * @return mixed
	 */
	public function get($key){
		$value = file_get_contents($this->getFile($key));
		return unserialize($value);
	}
	
	/**
	 * 是否存在以$key为键的值
	 * @param string $key
	 * @return boolean
	 */
	public function exists($key){
		return file_exists($this->getFile($key));
	}
	
	/**
	 * 获取存储目录
	 * @return the $storeDirectory
	 */
	public function getStoreDirectory(){
		return $this->storeDirectory;
	}
	
	/**
	 * 设置存储目录并创建该目录
	 * @param string $storeDirectory        	
	 */
	public function setStoreDirectory($storeDirectory){
		$this->storeDirectory = $storeDirectory;
		FileUtil::mkDirs($this->storeDirectory);
	}
	
	private function getFile($key){
		return $this->storeDirectory . $key . '.php';
	}
}

?>