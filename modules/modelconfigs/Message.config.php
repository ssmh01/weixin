<?php

/**
 * 消息配置
 * @author blueyb.java@gmail.com
 */

return array(
	'orm' => array(
		'table' => 'yyx_message',
		'pk' => 'id',
		'map' => array(
			'id' => 'id',
			'fromUid' => 'from_uid',
			'toUid' => 'to_uid',
			'replyId' => 'reply_id',
			'title' => 'title',
			'content' => 'content',
			'new' => 'new',
			'fromStatus' => 'from_status',
			'toStatus' => 'to_status',
			'createTime' => 'create_time'
		)
	),
	'rule' => array()
);