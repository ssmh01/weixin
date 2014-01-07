<?php

/** 
 * 玩法插件验证类
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-03-16
 */
class PlayWayValidator {
	
	/**
	 * 玩法插件根目录
	 * @var string
	 */
	private $playWayRootPath;
	
	/**
	 * 验证错误消息,只有验证错误时才会产生该消息
	 * @var string
	 */
	private $validateError;
	
	/**
	 * 验证玩法插件,,如果不正确则写错误消息
	 * @param string $playWayRootPath 玩法插件根目录
	 * @return boolean 如果成功则返回true
	 */
	public function validate($playWayRootPath){
		if(!$playWayRootPath || !file_exists($playWayRootPath)) {
			$this->validateError = "玩法插件根目录为空或不存在";
			return false;
		}
		$this->setPlayWayRootPath($playWayRootPath);
		if(!$this->validateDirectoryStructure()) return false;
		if(!$this->validatePlayWayDescXml()) return false;
		return true;
	}
	
	/**
	 * @return the $templateRootPath
	 */
	public function getPlayWayRootPath() {
		return $this->playWayRootPath;
	}

	
	/**
	 * @return the $validateError
	 */
	public function getValidateError() {
		return $this->validateError;
	}
	
	/**
	 * @param string $templateRootPath
	 */
	protected function setPlayWayRootPath($templateRootPath) {
		$this->playWayRootPath = $templateRootPath;
	}
	
	/**
	 * 验证目录结构
	 * @return boolean 如果成功则返回true
	 */
	private function validateDirectoryStructure(){
		return true;
	}
	
	/**
	 * 验证玩法插件XML描述文件是否正确,如果不正确则写错误消息
	 * @return boolean 如果成功则返回true
	 */
	private function validatePlayWayDescXml(){
		return true;
	}
}
?>