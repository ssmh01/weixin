<?php

/**
 * 微博
 * @author blueyb.java@gmail.com
 */

return array(
	'orm' => array(
		'table' => 'yyx_weibo',
		'pk' => 'id',
		'map' => array(
			'id' => 'id',
			'name' => 'name',
			'logo' => 'logo',
			'type' => 'type',
			'appKey' => 'app_key',
			'appSecret' => 'app_secret',
			'url' => 'url',
			'sortNum' => 'sort_num',
			'status' => 'status'
		)
	),
	'rule' => array(
		'name' => array(
			array(
				'type' => 'required',
				'message' => '微博名称不能为空'
			)
		),
		'type' => array(
			array(
				'type' => 'required',
				'message' => '类型代码不能为空'
			),
			array(
				'type' => 'format',
				'format' => 'english',
				'message' => '类型代码只能为英文'
			)
		)
	)
);