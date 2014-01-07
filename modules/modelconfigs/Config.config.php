<?php

/**
 * 系统配置
 * @author blueyb.java@gmail.com
 */

return array(
	'orm'=>array(
		'table'=>'yyx_config',
		'pk'=>'id',
		'map'=>array(
			'id'=>'id',
			'name'=>'name',
			'tab'=>'tab',
			'type'=>'type',
			'options'=>'options',
			'key'=>'key',
			'value'=>'value',
			'sortNum'=>'sort_num'
		)
	),
	'rule'=>array(
	)
);