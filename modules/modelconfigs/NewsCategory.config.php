<?php

/**
 * 资讯分类配置
 * @author blueyb.java@gmail.com
 */

return array(
	'orm' => array(
		'table' => 'yyx_news_category',
		'pk' => 'id',
		'map' => array(
			'id' => 'id',
			'name' => 'name',
			'type' => 'type',
			'sortNum' => 'sort_num'
		)
	),
	'rule' => array(
		'name' => array(
			array(
				'type' => 'required',
				'message' => '分类名称不能为空'
			)
		)
	)
);