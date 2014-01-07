<?php

/**
 * 玩法配置
 * @author blueyb.java@gmail.com
 */
return array(
	'orm' => array(
		'table' => 'yyx_play_way',
		'pk' => 'id',
		'map' => array(
			'id' => 'id',
			'name' => 'name',
			'class' => 'class',
			'parameter' => 'parameter',
			'summary' => 'summary',
			'newsId' => 'news_id',
			'status' => 'status',
		)
	),
	'rule' => array(
		'name' => array(
			array(
				'type' => 'required',
				'message' => '玩法名称不能为空'
			)
		),
		'class' => array(
			array(
				'type' => 'required',
				'message' => '玩法类名不能为空'
			),
			array(
				'type' => 'format',
				'format' => 'english',
				'message' => '玩法类名只能为英文'
			)
		)
	)
);