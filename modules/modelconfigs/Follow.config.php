<?php

/**
 * 关注配置
 * @author blueyb.java@gmail.com
 */

return array(
	'orm' => array(
		'table' => 'yyx_follow',
		'pk' => 'id',
		'map' => array(
			'id' => 'id',
			'fromUid' => 'from_uid',
			'toUid' => 'to_uid',
			'addTime' => 'add_time'
		)
	),
	'rule' => array()
);