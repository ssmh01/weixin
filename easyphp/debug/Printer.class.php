<?php

class Printer{
	
	public static function println($line){
		if(is_array($line) || is_object($line)){
			echo '<br/>';
			echo '<pre>' . print_r($line, true) . '</pre>';
			echo '<br/><hr>';
		}else{
			echo '<br/>' .$line . '<br/><hr>';
		}
		
	}
	
	public static function printKeyValue($key, $value){
		self::println($key . ': ' . $value);
	}

    /**
     * 格式化打印数组
     *
     * @static
     * @param array $arr 要打印的数组
     */
    public static function printArray($arr){
        echo '<pre>'.print_r($arr, true).'</pre>';
    }
}