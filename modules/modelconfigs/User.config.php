<?php

/**
 * 用户配置
 * @author blueyb.java@gmail.com
 */

return array(
	'orm' => array(
		'table' => 'yyx_user',
		'pk' => 'id',
		'map' => array(
			'id' => 'id',
			'name' => 'name',
			'password' => 'password',
			'email' => 'email',
			'nickname' => 'nickname',
			'avatar' => 'avatar',
			'sex' => 'sex',
			'birthdayYear' => 'birthday_year',
			'birthdayMonth' => 'birthday_month',
			'birthdayDay' => 'birthday_day',
			'mobile' => 'mobile',
			'qq' => 'qq',
			'province' => 'province',
			'city' => 'city',
			'area' => 'area',
			'address' => 'address',
			'sign' => 'sign',
			'website' => 'website',
			'sinaWeibo' => 'sina_weibo',
			'qqWeibo' => 'qq_weibo',
			'availableMoney' => 'available_money',
			'freezeMoney' => 'freeze_money',
			'availableIntegral' => 'available_integral',
			'freezeIntegral' => 'freeze_integral',
			'views' => 'views',
			'makersLevel' => 'makers_level',
			'addGuessCount' => 'guess_add_count',
			'guessCount' => 'guess_count',
			'accuracy' => 'accuracy',
			'fanCount' => 'fan_count',
			'followCount' => 'follow_count',
			'allowLogin' => 'allow_login',
			'lastLoginTime' => 'last_login_time',
			'configs' => 'configs',
			'registerTime' => 'register_time',
			'friend' => 'friend',
		)
	),
	'rule' => array()
);