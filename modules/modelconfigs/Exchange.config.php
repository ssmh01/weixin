<?php

/**
 * 兑换配置
 * @author blueyb.java@gmail.com
 */

return array(
	'orm' => array(
		'table' => 'yyx_exchange',
		'pk' => 'id',
		'map' => array(
			'id' => 'id',
			'goodsId' => 'goods_id',
			'userId' => 'user_id',
			'isLottery' => 'is_lottery',
			'isExchange' => 'is_exchange',
			'money' => 'money',
			'username' => 'username',
			'mobile' => 'mobile',
			'address' => 'address',
			'sendStatus' => 'send_status',
			'receiveStatus' => 'receive_status',
			'createTime' => 'create_time'
		)
	),
	'rule' => array()
);