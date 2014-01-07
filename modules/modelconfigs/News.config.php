<?php

/**
 * 资讯配置
 * @author blueyb.java@gmail.com
 */

return array(
	'orm' => array(
		'table' => 'yyx_news',
		'pk' => 'id',
		'map' => array(
			'id' => 'id',
			'title' => 'title',
			'cateId' => 'cate_id',
			'content' => 'content',
			'views' => 'views',
			'sortNum' => 'sort_num',
			'createTime' => 'create_time'
		)
	),
	'rule' => array(
		'cate_id' => array(
			array(
				'type' => 'required',
				'message' => '分类不能为空'
			)
		),
		'title' => array(
			array(
				'type' => 'required',
				'message' => '标题不能为空'
			)
		)
	)
);