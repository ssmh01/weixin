<?php
/**
 * 竞猜点
 * @author blueyb.java@gmail.com
 */
class GuessPointAction extends UserCenterAction{
	
	/**
	 * 获取小分类里的竞猜点
	 * @param HttpRequest $request
	 */
	public function ajaxgets(HttpRequest $request){
		$cateId = intval($request->getParameter('cateId'));
		if(!$cateId){
			AjaxResult::ajaxResult(1, null);
		}
		$conditions = "`cate_id`='{$cateId}' and `status`='1' and `play_deadline` > '{$request->getRequestTime()}'";
		$guessPoints = MD('GuessPoint')->gets($conditions);
		AjaxResult::ajaxResult('1', $guessPoints);
	}	
}