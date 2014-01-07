<?php

/**
 * 缓存配置
 * @author blueyb.java@gmail.com
 * @since 1.0 - Mar 27, 2012
 */

return array(
	//基础配置，如各驱动的配置
	'base'=>array(
		//redis的配置
		'redis'=>array(
    		'namespace' => 'tpymall_',
    		'servers'   => array(
                array('host' => 'localhost', 'port' => 6379),
    		)
		),
		//memcache的配置
		'memcache_servers'=>array(				//memcache的服务器列表
			array(
				'host'=>'localhost',	//memcache的服务器地址，为空时默认使用127.0.0.1
				'port'=>'11211',		//memcache的服务器端口，为空时默认使用11211
				'persistent'=>false,	//memcache是否保持连接持久性，为空时默认false(不会持久)
				'weight'=>10,			//memcache槽数
				'timeout'=>60,			//memcache连接超时，为空时默认false(不会超时)
			),
			array(
				'host'=>'localhost',	//memcache的服务器地址，为空时默认使用127.0.0.1
				'port'=>'11111',		//memcache的服务器端口，为空时默认使用11211
				'persistent'=>false,	//memcache是否保持连接持久性，为空时默认false(不会持久)
				'weight'=>10,			//memcache槽数
				'timeout'=>60,			//memcache连接超时，为空时默认false(不会超时)
			)
		)
	),
	//缓存项配置,没有特殊情况可以不设置
	'caches'=>array(
		'templateCategorys'=>array('lifetime'=>5)
	),
);