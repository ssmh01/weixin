<?php

/**
 * 竞猜分类配置
 * @author blueyb.java@gmail.com
 */

return array(
	'orm' => array(
		'table' => 'yyx_guess_category',
		'pk' => 'id',
		'map' => array(
			'id' => 'id',
			'name' => 'name',
			'parentId' => 'parent_id',
			'playWays' => 'play_ways',
			'parameterCount'=>'parameter_count',
			'fixedOdds' => 'fixed_odds',
			'floatOdds' => 'float_odds',
			'status' => 'status',
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