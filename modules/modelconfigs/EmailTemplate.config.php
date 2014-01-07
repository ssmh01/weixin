<?php

/**
 * 邮件模板
 * @author blueyb.java@gmail.com
 */

return array(
	'orm' => array(
		'table' => 'yyx_email_template',
		'pk' => 'id',
		'map' => array(
			'id' => 'id',
			'name' => 'name',
			'subject' => 'subject',
			'key' => 'key',
			'value' => 'value',
			'description' => 'description'
		)
	),
	'rule' => array()
);