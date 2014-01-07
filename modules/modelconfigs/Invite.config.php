<?php

/**
 * 邀请
 * @author blueyb.java@gmail.com
 */

return array(
	'orm' => array(
		'table' => 'yyx_invite',
		'pk' => 'id',
		'map' => array(
			'id' => 'id',
			'inviterId' => 'inviter_id',
			'inviteeId' => 'invitee_id',
			'rechargePercent' => 'recharge_percent',
			'integral' => 'integral',
			'createTime' => 'create_time'
		)
	),
	'rule' => array()
);