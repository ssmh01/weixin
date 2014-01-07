<?php

/**
 * 菜单
 * @author blueyb.java@gmail.com
 */

return array(
	'orm'=>array(
		'table'=>'yyx_menu',
		'pk'=>'id',
		'map'=>array(
			'id'=>'id',
			'name'=>'name',
			'url'=>'url',
			'parentId'=>'parent_id',
			'status'=>'status',
			'isSystem'=>'is_system',
			'sortNum'=>'sort_num'
		)
	),
	'rule'=>array(
	)
);