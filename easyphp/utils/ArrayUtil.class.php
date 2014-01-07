<?php

/**
 * 数组工具类
 * @author blueyb.java@gmail.com
 * @since 1.0 - Mar 15, 2012
 */

abstract class ArrayUtil{
	
	/**
	 * 用第二维数组里的一个列的值当作第一维数组的键,如果用作键的值不是唯一就会发生覆盖行为.
	 * @param array $arrays 二维数组
	 * @param string $keyName 第二维数组中的键名
	 * @return array 更换过键名的二维数组
	 */
	public static function changeKey($arrays, $keyName){
		$changeArrays = array();
		foreach($arrays as $array){
			$changeArrays[$array[$keyName]] = $array; 
		}
		unset($arrays);
		return $changeArrays;
	}
	
	
	/**
	 * 获取第二维数组里的一个列的值组成的数组.
	 * @param array $arrays 二维数组
	 * @param string $keyName 第二维数组中的键名
	 * @param boolean implode 是否用,把结果数组组合成字符串
	 * @return array/string 由键值组成的一维数组或字符串
	 */
	public static function colKeySet($arrays, $keyName, $implode=false){
		$keys = array();
		foreach($arrays as $array){
			$keys[] = $array[$keyName]; 
		}
		unset($arrays);
		return $implode? implode(',', $keys) : $keys;
	}
	
	/**
	 * 对数组里的数据进行分组
	 * @param array $arrays 要进行分组的数组
	 * @param string $keyName 按哪个键名的值来分组
	 * @param boolean $preserveKey 是否保留原数组的key,默认为true
	 * @return array 分组后的数组
	 */
	public static function groupByKey($arrays, $keyName, $preserveKey=true){
		$groupArrays = array();
		foreach($arrays as $index=>$array){
			if($preserveKey){
				$groupArrays[$array[$keyName]][$index] = $array;
			}else{
				$groupArrays[$array[$keyName]][] = $array;
			}
		}
		unset($arrays);
		return $groupArrays;
	}
}