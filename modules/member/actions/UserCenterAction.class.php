<?php

/**
 * 用户中心基础类
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - Jan 8, 2013
 */
abstract  class UserCenterAction extends NeedLoginAction{
	
	public function __construct(){
		parent::__construct();
	}
}

?>