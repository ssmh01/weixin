<?php

/**
 * 竞猜点配置
 * @author blueyb.java@gmail.com
 */

return array(
	'orm' => array(
		'table' => 'yyx_guess_point',
		'pk' => 'id',
		'map' => array(
			'id' => 'id',
			'cateId' => 'cate_id',
			'title' => 'title',
			'guessCount' => 'guess_count',
			'playDeadline' => 'play_deadline',
			'params' => 'params',
			'status' => 'status',
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
		),
		'play_deadline' => array(
			array(
				'type' => 'required',
				'message' => '参与截止时间不能为空'
			)
		)
	)
);