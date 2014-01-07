<?php

/**
 * 商品模块服务加载器
 * @author blueyb.java@gmail.com
 */
class GoodsServiceFactory{
	
	/**
	 * 商品服务
	 * @var IGoodsService
	 */
	private static $goodsService;
	
	/**
	 * @return IGoodsService
	 */
	public static function getGoodsService(){
		if(self::$goodsService == null){
			self::$goodsService = new GoodsService();
		}
		return self::$goodsService;
	}
}

?>