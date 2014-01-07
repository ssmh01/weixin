<?php
/**
* A unsort list implements by the array.
* @author blueyb.java@gmail.com
* @since 1.0 - 2010-12-17
*/
class ArrayList implements Iterable{
	
	/**
	 * The pointer point to the position of current item.
	 * @type int
	 */
	private $pointer;

	/**
	 * a array to store object
	 */
	private $stack = array();
	
	function __construct(){
		$this->stack = array();
		$this->reset();
	}

	/**
	 * Add a Object to list
	 * @param any $obj
	 * 	The object want to add
	 */
	public function add($obj) {
		$this->stack[] = $obj;
	}
	
	/**
	 * add a set objects to list.
	 * @param Array $list
	 */
	public function adds(Array $list){
		if(is_array($list)){
			foreach($list as $obj){
				$this->add($obj);
			}
		}
	}
	
	/**
	 * Get a object from list
	 * @param int $index
	 * 	The index of object that you want to get.
	 */
	public function get($index){
		return $this->stack[$index];
	}
	
	/**
	 * The list contain object or not.
	 * @param any $obj
	 * @return int return the index of the object in list.
	 */
	public function contain($obj){
		while($this->hasNext()){
			if($obj == $this->next()){
				$this->reset();
				return $this->pointer;
			}
		}
		$this->reset();
		return -1;
	}
	
	/**
	 * Clear all object
	 */
	function clear() {
		unset($this->stack);
		$this->stack = array();
		$this->reset();
	}
	
	/**
	 * Get the size of list
	 * @return int the size of list
	 */
	public function size(){
		return count($this->stack);
	}
	
	/**
	 * The list is empty or not
	 * @return boolean
	 */
	public function isEmpty(){
		return count($this->stack) > 0 ? false:true;
	}
		
	/**
	 * Has next item or not
	 * @return boolean
	 */
	public function hasNext(){
		return $this->pointer < count($this->stack) - 1;
	}
	
	/**
	 * Get the next item.
	 */
	public function next(){
		$this->pointer += 1;
		return $this->stack[$this->pointer];
	}
	
	public function reset(){
		$this->pointer = -1;
	}
}
?>