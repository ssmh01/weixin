<?php

/**
 * 竞猜配置
 * @author blueyb.java@gmail.com
 */

return array(
	'orm' => array(
		'table' => 'yyx_guess',
		'pk' => 'id',
		'map' => array(
			'id' => 'id',
			'userId' => 'user_id',
			'custom' => 'custom',
			'guessPointId' => 'guess_point_id',
			'cateId' => 'cate_id',
			'tax' => 'tax',
			'title' => 'title',
			'playStartTime' => 'play_start_time',
			'playDeadline' => 'play_deadline',
			'oddsType' => 'odds_type',
			'wealthType' => 'wealth_type',
			'customType' => 'custom_type',
			'playCount' => 'play_count',
			'playWealth' => 'play_wealth',
			'keepWealth' => 'keep_wealth',
			'winWealth' => 'win_wealth',
			'playDatas' => 'play_datas',
			'parameter' => 'parameter',
			'playRole' => 'play_role',
			'summary' => 'summary',
			'status' => 'status',
			'createTime' => 'create_time'
		)
	),
	'rule' => array()
);