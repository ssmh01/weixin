<?php

/** 
 * 玩法工具类
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-03-16
 */
class PlayWayUtil {
	
	/**
	 * 玩法路径
	 * @var string
	 */
	private $playWayDirectory;
	

	/**
	 * 玩法临时路径
	 * @var string
	 */
	private $playWayTempDirectory;
	
	/**
	 * 当前的玩法临时路径
	 * @var string
	 */
	private $currentPlayWayTempPath;
	
	public function __construct($playWayDirectory, $playWayTempDirectory){
		$this->setPlayWayDirectory($playWayDirectory);
		$this->setPlayWayTempDirectory($playWayTempDirectory);
	}
	
	public function parsePlayWay($package){
		$this->extract($package);
		$xml = $this->currentPlayWayTempPath . GuessConstant::PLAYWAY_DESCRIPTION_FILE;;
		$parser = new PlayWayXmlParser();
		$playWay = $parser->parse($xml);
		if($playWay && $playWay->getClass()){
			$this->moveTempDirectory($playWay->getClass());
		}else{
			$this->deleteTempDirectory();
		}
		return $playWay;
	}
	
	/**
	 * 解压到临时路径
	 */
	private function extract($package){
		if(!file_exists($package)) return false;
		$zip = new PclZip($package);
		$this->currentPlayWayTempPath = $this->playWayTempDirectory .date('YmdHis') . '/';
		FileUtil::mkDirs($this->currentPlayWayTempPath);
		$zip->extract(PCLZIP_OPT_PATH, $this->currentPlayWayTempPath);
		unlink($package);
	}
	
	/**
	 * @param $class 模块标识
	 * @return 成功返回模板所在的目录，失败返回false
	 */
	public function moveTempDirectory($class){
		if(empty($class)) return false;
		$playWayPath = $this->playWayDirectory . $class . '/';
		if(FileUtil::moveDir($this->currentPlayWayTempPath, $playWayPath)){
			return $playWayPath;
		}
		return false;
	}
	
	/**
	 * 删除当前临时玩法目录
	 */
	public function deleteTempDirectory(){
		return FileUtil::unlinkDir($this->currentPlayWayTempPath);
	}
	
	/**
	 * 删除指定玩法目录
	 * @param string $class 玩法标识
	 */
	public function deleteDirectory($class){
		$playWayPath = $this->playWayDirectory . $class . '/' ;
		//删除版本目录
		return FileUtil::unlinkDir($playWayPath);
	}
	
	/**
	 * @return the $playWayDirectory
	 */
	public function getPlayWayDirectory() {
		return $this->playWayDirectory;
	}

	/**
	 * @return the $playWayTempDirectory
	 */
	public function getPlayWayTempDirectory() {
		return $this->playWayTempDirectory;
	}
	
	/**
	 * @param string $playWayDirectory
	 */
	public function setPlayWayDirectory($playWayDirectory) {
		$this->playWayDirectory = $playWayDirectory;
	}

	/**
	 * @param string $playWayTempDirectory
	 */
	public function setPlayWayTempDirectory($playWayTempDirectory) {
		$this->playWayTempDirectory = $playWayTempDirectory;
	}
}

?>