<?php

/**
 * 文件操作工具类
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2011-03-14
 */

class FileUtil {
	
	/** 
	 * 建立文件夹
	 * @param string $aimUrl 
	 * @return viod 
	 */
	public static function mkDir($aimUrl) {
		$aimUrl = str_replace ('', '/', $aimUrl);
		$aimDir = '';
		$arr = explode ( '/', $aimUrl );
		foreach ( $arr as $str ) {
			$aimDir .= $str . '/';
			if (! file_exists ( $aimDir )) {
				mkdir ( $aimDir );
			}
		}
	}
	
	public static function mkDirs($dirs){
		if(!is_dir($dirs))
		{
			if(!self::mkDirs(dirname($dirs))){
				return false;
			}
			if(!mkdir($dirs,0777)){
				return false;
			}
		}
		return true;
	}
	
	/**
	 * 建立文件 
	 * @param string $aimUrl 
	 * @param boolean $overWrite 该参数控制是否覆盖原文件 
	 * @return boolean 
	 */
	public static function createFile($aimUrl, $overWrite = false) {
		if (file_exists ( $aimUrl ) && $overWrite == false) {
			return false;
		} elseif (file_exists ( $aimUrl ) && $overWrite == true) {
			FileUtil::unlinkFile ( $aimUrl );
		}
		$aimDir = dirname ( $aimUrl );
		FileUtil::mkDir ( $aimDir );
		touch ( $aimUrl );
		return true;
	}
	
	/** 
	 * 移动文件夹 
	 * @param string $oldDir 
	 * @param string $aimDir 
	 * @param boolean $overWrite 该参数控制是否覆盖原文件 
	 * @return boolean 
	 */
	public static function moveDir($oldDir, $aimDir, $overWrite = false) {
		$aimDir = str_replace ( '', '/', $aimDir );
		$aimDir = substr ( $aimDir, - 1 ) == '/' ? $aimDir : $aimDir . '/';
		$oldDir = str_replace ( '', '/', $oldDir );
		$oldDir = substr ( $oldDir, - 1 ) == '/' ? $oldDir : $oldDir . '/';
		if (! is_dir ( $oldDir )) {
			return false;
		}
		if (! file_exists ( $aimDir )) {
			FileUtil::mkDir ( $aimDir );
		}
		@$dirHandle = opendir ( $oldDir );
		if (! $dirHandle) {
			return false;
		}
		while ( false !== ($file = readdir ( $dirHandle )) ) {
			if ($file == '.' || $file == '..') {
				continue;
			}
			if (! is_dir ( $oldDir . $file )) {
				FileUtil::moveFile ( $oldDir . $file, $aimDir . $file, $overWrite );
			} else {
				FileUtil::moveDir ( $oldDir . $file, $aimDir . $file, $overWrite );
			}
		}
		closedir ( $dirHandle );
		return rmdir ( $oldDir );
	}
	
	/**
	 * 在目录名添加上目录分隔符
	 * @param string $dir
	 */
	public static function addSeparator($dir){
		return rtrim($dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
	}
	
	/**
	 * 列出目录下的文件(包括文件夹)
	 * @param string $dir
	 * @param boolean $justFile 是否只返回文件，默认返回文件文件和目录
	 * @return array/boolean 
	 * 	如果打开目录出现错误，则返回false,否则返回文件数组
	 */
	public static function listDir($dir, $justFile=false){
		$dir = FileUtil::addSeparator($dir);
		@$dirHandle = opendir ($dir);
		if (!$dirHandle) {
			return false;
		}
		$fileList = array();
		while ( false !== ($file = readdir ( $dirHandle )) ) {
			if ($file == '.' || $file == '..') {
				continue;
			}
			$file = $dir . $file;
			if(!$justFile){
				$fileList[] = $file;
			}elseif(!is_dir($file)){
				$fileList[] = $file;
			}
		}
		closedir($dirHandle);
		return $fileList;
	}
	
	/**
	 * 检查目录是否为空
	 * @param string $dir 被检查的目录路径
	 */
	public static function isEmptyDir($dir){
		$list = self::listDir($dir);
		if(empty($list)) return true;
		return false;
	}
	
	/** 
	 * 移动文件 
	 * @param string $fileUrl 
	 * @param string $aimUrl 
	 * @param boolean $overWrite 该参数控制是否覆盖原文件 
	 * @return boolean 
	 */
	public static function moveFile($fileUrl, $aimUrl, $overWrite = false) {
		if (! file_exists ( $fileUrl )) {
			return false;
		}
		if (file_exists ( $aimUrl ) && $overWrite = false) {
			return false;
		} elseif (file_exists ( $aimUrl ) && $overWrite = true) {
			FileUtil::unlinkFile ( $aimUrl );
		}
		$aimDir = dirname ( $aimUrl );
		FileUtil::mkDir ( $aimDir );
		rename ( $fileUrl, $aimUrl );
		return true;
	}
	
	/** 
	 * 删除文件夹
	 * @param string $aimDir 
	 * @return boolean
	 */
	public static function unlinkDir($aimDir) {
		$aimDir = str_replace ( '', '/', $aimDir );
		$aimDir = substr ( $aimDir, - 1 ) == '/' ? $aimDir : $aimDir . '/';
		if (! is_dir ( $aimDir )) {
			return false;
		}
		$dirHandle = opendir ( $aimDir );
		while ( false !== ($file = readdir ( $dirHandle )) ) {
			if ($file == '.' || $file == '..') {
				continue;
			}
			if (! is_dir ( $aimDir . $file )) {
				FileUtil::unlinkFile ( $aimDir . $file );
			} else {
				FileUtil::unlinkDir ( $aimDir . $file );
			}
		}
		closedir ( $dirHandle );
		return rmdir ( $aimDir );
	}
	
	/** 
	 * 删除文件 
	 * @param string $aimUrl 
	 * @return boolean 
	 */
	public static function unlinkFile($aimUrl) {
		if (file_exists ( $aimUrl )) {
			unlink ( $aimUrl );
			return true;
		} else {
			return false;
		}
	}
	
	/** 
	 * 复制文件夹 
	 * @param string $oldDir 
	 * @param string $aimDir 
	 * @param boolean $overWrite 该参数控制是否覆盖原文件 
	 * @return boolean 
	 */
	public static function copyDir($oldDir, $aimDir, $overWrite = false) {
		$aimDir = str_replace ( '', '/', $aimDir );
		$aimDir = substr ( $aimDir, - 1 ) == '/' ? $aimDir : $aimDir . '/';
		$oldDir = str_replace ( '', '/', $oldDir );
		$oldDir = substr ( $oldDir, - 1 ) == '/' ? $oldDir : $oldDir . '/';
		if (! is_dir ( $oldDir )) {
			return false;
		}
		if (! file_exists ( $aimDir )) {
			FileUtil::mkDir ( $aimDir );
		}
		$dirHandle = opendir ( $oldDir );
		while ( false !== ($file = readdir ( $dirHandle )) ) {
			if ($file == '.' || $file == '..') {
				continue;
			}
			if (! is_dir ( $oldDir . $file )) {
				FileUtil::copyFile ( $oldDir . $file, $aimDir . $file, $overWrite );
			} else {
				FileUtil::copyDir ( $oldDir . $file, $aimDir . $file, $overWrite );
			}
		}
		return closedir ( $dirHandle );
	}
	
	/** 
	 * 复制文件 
	 * @param string $fileUrl 
	 * @param string $aimUrl 
	 * @param boolean $overWrite 该参数控制是否覆盖原文件 
	 * @return boolean 
	 */
	public static function copyFile($fileUrl, $aimUrl, $overWrite = false) {
		if (! file_exists ( $fileUrl )) {
			return false;
		}
		if (file_exists ( $aimUrl ) && $overWrite == false) {
			return false;
		} elseif (file_exists ( $aimUrl ) && $overWrite == true) {
			FileUtil::unlinkFile ( $aimUrl );
		}
		$aimDir = dirname ( $aimUrl );
		FileUtil::mkDir ( $aimDir );
		copy ( $fileUrl, $aimUrl );
		return true;
	}
	
	/**
	 * 获取文件后缀名
	 * @param string $fileName 文件名
	 */
	public function getFileExt($fileName) {
		return pathinfo($fileName, PATHINFO_EXTENSION);
	}
	
	/**
	 * check readable permission of file.
	 * @param string $file
	 * 		the $file to check.
	 * @return boolean
	 * 		return true if file can be read, otherwise false.
	 */
	public static function checkReadPerm($file){
		return is_readable($file);
	}
	
	/**
	 * check writeable permission of file.
	 * @param string $file
	 * 		the $file to check.
	 * @return boolean
	 * 		return true if file can be write, otherwise false.
	 */
	public static function checkWritePerm($file){
		return is_writable($file);
	}
}
