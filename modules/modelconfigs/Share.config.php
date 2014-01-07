<?php

/**
 * 分享配置
 * @author blueyb.java@gmail.com
 */

return array(
	'orm' => array(
		'table' => 'yyx_share',
		'pk' => 'id',
		'map' => array(
				'id'=>'id',
				'type'=>'type',
				'userId'=>'user_id',
				'shareId'=>'share_id',
				'createTime'=>'create_time'
		)
	),
	'rule' => array()
);