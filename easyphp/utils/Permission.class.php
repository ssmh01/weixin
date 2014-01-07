<?php
/**
 * This class use to check read and write Permission and throw Exception.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-14
 */

class Permission{
	
	/**
	 * check readable permission of file.
	 * @param string $file
	 * 		the $file to check.
	 * @throws ReadPermissionException
	 * @return boolean
	 * 		if not throw a exception, a boolean value will return.
	 */
	public static function checkReadPerm($file){
		if(!FileUtil::checkReadPerm($file)){
			$e = new ReadPermissionException($file . " is not allow to read");
			$e->setFileName($file);
			throw $e;
		}
		return true;
	}
	
/**
	 * check writeable permission of file.
	 * @param string $file
	 * 		the $file to check.
	 * @throws ReadPermissionException
	 * @return boolean
	 * 		if not throw a exception, a boolean value will return.
	 */
	public static function checkWritePerm($file){
		if(!FileUtil::checkWritePerm($file)){
			$e = new WritePermissionException($file . " is not allow to write");
			$e->setFileName($file);
			throw $e;
		}
		return true;
	}
}