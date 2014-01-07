<?php

/**
 * 通知配置
 * @author blueyb.java@gmail.com
 */

return array(
	'orm' => array(
		'table' => 'yyx_notice',
		'pk' => 'id',
		'map' => array(
			'id' => 'id',
			'fromUid' => 'from_uid',
			'toUid' => 'to_uid',
			'type' => 'type',
			'new' => 'new',
			'notice' => 'notice',
			'createTime' => 'create_time'
		)
	),
	'rule' => array()
);