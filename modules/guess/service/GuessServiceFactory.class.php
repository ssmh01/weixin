<?php

/**
 * 竞猜模块服务加载器
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-01
 */
class GuessServiceFactory{
	
	/**
	 * 竞猜分类服务
	 * @var IGuessCategoryService
	 */
	private static $guessCategoryService;
	
	/**
	 * 玩法服务
	 * @var IPlayWayService
	 */
	private static $playWayService;
	

	/**
	 * 竞猜服务
	 * @var IGuessService
	 */
	private static $guessService;
	
	/**
	 * 自定义竞猜服务
	 * @var ICustomGuessService
	 */
	private static $customGuessService;
	
	/**
	 * 用户-竞猜服务
	 * @var IUserGuessService
	 */
	private static $userGuessService;
	
	/**
	 * 参与服务
	 * @var IPlayService
	 */
	private static $playService;
	
	/**
	 * 自定义参与服务
	 * @var IPlayService
	 */
	private static $customPlayService;
	
	/**
	 * @return IGuessCategoryService
	 */
	public static function getGuessCategoryService(){
		if(self::$guessCategoryService == null){
			self::$guessCategoryService = new GuessCategoryService();
		}
		return self::$guessCategoryService;
	}
	
	/**
	 * @return IPlayWayService
	 */
	public static function getPlayWayService(){
		if(self::$playWayService == null){
			self::$playWayService = new PlayWayService();
		}
		return self::$playWayService;
	}
	
	/**
	 * @return IGuessService
	 */
	public static function getGuessService(){
		if(self::$guessService == null){
			self::$guessService = new GuessService();
		}
		return self::$guessService;
	}
	
	/**
	 * @return ICustomGuessService
	 */
	public static function getCustomGuessService(){
		if(self::$customGuessService == null){
			self::$customGuessService = new CustomGuessService();
		}
		return self::$customGuessService;
	}
	
	/**
	 * @return IUserGuessService $userGuessService
	 */
	public static function getUserGuessService(){
		if(self::$userGuessService == null){
			self::$userGuessService = new UserGuessService();
		}
		return self::$userGuessService;
	}

	/**
	 * @return IPlayService $playService
	 */
	public static function getPlayService(){
		if(self::$playService == null){
			self::$playService = new PlayService();
		}
		return self::$playService;
	}
	
	/**
	 * @return IPlayService $customPlayService
	 */
	public static function getCustomPlayService(){
		if(self::$customPlayService == null){
			self::$customPlayService = new CustomPlayService();
		}
		return self::$customPlayService;
	}
}

?>