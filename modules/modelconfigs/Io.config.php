<?php

/**
 * 收支配置
 * @author blueyb.java@gmail.com
 */

return array(
	'orm' => array(
		'table' => 'yyx_io',
		'pk' => 'id',
		'map' => array(
			'id' => 'id',
			'fromUserId' => 'from_user_id',
			'toUserId' => 'to_user_id',
			'fromTitle' => 'from_title',
			'toTitle' => 'to_title',
			'type' => 'type',
			'sourceId' => 'source_id',
			'wealthType' => 'wealth_type',
			'wealth' => 'wealth',
			'tax' => 'tax',
			'fromBalance' => 'from_balance',
			'toBalance' => 'to_balance',
			'summary' => 'summary',
			'createTime' => 'create_time'
		)
	),
	'rule' => array()
)
;