<?php

/** 
 * 竞猜常量类
 * @author blueyb.java@gmail.com
 */
abstract class GuessConstant {
	
	/**
	 * 竞猜玩法保存目录,相对根目录
	 * @var string
	 */
	const PLAYWAY_DIRECTORY = 'playways/';
	
	/**
	 * 临时竞猜玩法保存目录,相对根目录
	 * @var string
	 */
	const PLAYWAY_TEMP_DIRECTORY = 'runtime/playways/';
	
	/**
	 * 竞猜玩法描述文件名
	 * @var string
	 */
	const PLAYWAY_DESCRIPTION_FILE = 'playway.xml';
}

?>