<?php

/**
 * 管理员
 * @author blueyb.java@gmail.com
 */

return array(
	'orm' => array(
		'table' => 'yyx_manager',
		'pk' => 'id',
		'map' => array(
			'id' => 'id',
			'name' => 'name',
			'password' => 'password',
			'mobile' => 'mobile',
			'groupId' => 'group_id',
			'allowLogin' => 'allow_login',
			'lastLoginTime' => 'last_login_time',
			'createTime' => 'create_time'
		)
	),
	'rule' => array(
		'name' => array(
			array(
				'type' => 'required',
				'message' => '名称不能为空'
			)
		)
	)
);