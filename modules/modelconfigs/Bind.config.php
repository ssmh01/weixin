<?php

/**
 * 微博绑定
 * @author blueyb.java@gmail.com
 */

return array(
	'orm' => array(
		'table' => 'yyx_bind',
		'pk' => 'id',
		'map' => array(
				'id'=>'id',
				'userId'=>'user_id',
				'weiboId'=>'weibo_id',
				'account'=>'account',
				'password'=>'password',
				'datas'=>'datas',
				'createTime'=>'create_time'
		)
	),
	'rule' => array(
		
	)
);