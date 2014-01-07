<?php

/**
 * 用户－竞猜配置
 * @author blueyb.java@gmail.com
 */

return array(
	'orm' => array(
		'table' => 'yyx_user_guess',
		'pk' => 'id',
		'map' => array(
			'id' => 'id',
			'toUid' => 'to_uid',
			'fromUid' => 'from_uid',
			'guessId' => 'guess_id',
			'type' => 'type',
			'createTime' => 'create_time'
		)
	),
	'rule' => array()
);