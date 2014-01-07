<?php

/**
 * 管理组
 * @author blueyb.java@gmail.com
 */

return array(
	'orm' => array(
		'table' => 'yyx_manage_group',
		'pk' => 'id',
		'map' => array(
			'id' => 'id',
			'name' => 'name',
			'permissions' => 'permissions',
			'summary' => 'summary',
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