<?php
/**
* A map implements by the array.
* @author blueyb.java@gmail.com
* @since 1.0 - 2010-12-17
*/
class ArrayMap {

	private $stack = array();

	function __construct($key='', $val='') {	
		if($key != '' && $val != '') {
			$this->put($key, $val);
		}
	}

	function put($key, $val) {
		$this->stack[$key] = $val;
	}

	function get($key) {
		return $this->stack[$key];
	}

	// A set view of the keys contained in this map
	function keySet() {
		$arrayList = array();
		foreach($this->stack as $k => $v) {
			$arrayList[] = $k;
		}
		return $arrayList;	
	}

	function clear() {
		unset($this->stack);
		$this->stack = array();
	}

	function toString() {
		$sb=NULL;
		$sb .= "***** ------------------------------------------- *****<br>\n";
		foreach($this->stack as $k => $v) {
			$sb .= "Key: ".$k." Value: ".$v."<br>\n";
		}
		$sb .= "***** ------------------------------------------- *****<br>\n";
		return $sb;
	}

}
?>