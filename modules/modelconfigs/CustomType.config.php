<?php

/**
 * 自定义类型
 * @author blueyb.java@gmail.com
 */

return array(
	'orm' => array(
		'table' => 'yyx_custom_type',
		'pk' => 'id',
		'map' => array(
			'id' => 'id',
			'name' => 'name',
			'sortNum' => 'sort_num'
		)
	),
	'rule' => array(
		'name' => array(
			array(
				'type' => 'required',
				'message' => '类型名不能为空'
			)
		)
	)
);