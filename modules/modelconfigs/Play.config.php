<?php

/**
 * 竞猜参与
 * @author blueyb.java@gmail.com
 */

return array(
	'orm' => array(
		'table' => 'yyx_play',
		'pk' => 'id',
		'map' => array(
			'id'=>'id',
			'userId'=>'user_id',
			'custom'=>'custom',
			'guessId'=>'guess_id',
			'wealthType'=>'wealth_type',
			'wealth'=>'wealth',
			'winWealth'=>'win_wealth',
			'playDatas'=>'play_datas',
			'status'=>'status',
			'createTime'=>'create_time'
		)
	),
	'rule' => array()

	
);