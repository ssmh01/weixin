<?php

/**
 * Ajax请求结果
 * @author blueyb.java@gmail.com
 * 
 */
class AjaxResult {
	
	/**
	 * 状态
	 * @var int 默认[0失败,1成功]
	 */
	private $state;
	
	/**
	 * 消息
	 * @var string
	 */
	private $message;
	
	/**
	 * 显示ajax操作失败默认结果
	 */
	public static function ajaxFailtureResult(){
		$result = new AjaxResult(0, "操作失败!");
		die($result->toJsonMessage());
	}
	
	/**
	 * 显示ajax操作成功默认结果
	 */
	public static function ajaxSuccessResult(){
		$result = new AjaxResult(1, "操作成功!");
		die($result->toJsonMessage());
	}
	
	/**
	 * 显示ajax操作结果
	 */
	public static function ajaxResult($state, $message){
		$result = new AjaxResult($state, $message);
		die($result->toJsonMessage());
	}
	
	/**
	 * 显示消息并关闭窗口
	 * @param $message
	 */
	public static function closeAjaxWindow($message){
		$scripts =  '<script type="text/javascript">
						setTimeout(function(){parent.hideMenu()}, 2000)
						</script>';
		die($message . $scripts);
	}
	
	/**
	 * 显示消息并刷新页面
	 * @param $message
	 */
	public static function refreshPage($message){
		$scripts =  '<script type="text/javascript">
						parent.refreshPage(1500);
						</script>';
		die($message . $scripts);
	}
	
	/**
	 * 输出没有状态的消息
	 * @param string $message
	 */
	public static function message($message){
		die($message);
	}
	
	public static function successMessage(){
		die('操作成功');
	}
	
	public static function failtureMessage(){
		die('操作失败');
	}
	
	public function __construct($state, $message){
		$this->setState($state);
		$this->setMessage($message);
	}
	
	/**
	 * @return the $state
	 */
	public function getState() {
		return $this->state;
	}

	/**
	 * @param number $state
	 */
	public function setState($state) {
		$this->state = $state;
	}

	/**
	 * @return the $message
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * @param string $message
	 */
	public function setMessage($message) {
		$this->message = $message;
	}
	
	/**
	 * 返回Json格式结果
	 */
	public function toJsonMessage(){
		return json_encode(array('state'=>$this->getState(), 'message'=>$this->getMessage()));
	}
}

?>