<?php

/**
 * 竞猜分类
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - Jan 11, 2013
 */
class CategoryAction extends Action{
	
	/**
	 * @var GuessCategoryService
	 */
	private $categoryService = null;
	
	public function __construct(){
		$this->categoryService =GuessServiceFactory::getGuessCategoryService();
	}
	
	/**
	 * 获取子分类
	 * @param HttpRequest $request
	 */
	public function childrens(HttpRequest $request){
		$parentId = $request->getParameter('parentId');
		if(!$parentId){
			AjaxResult::ajaxResult(0, '请选择父分类!');
		}
		
		$childrens = $this->categoryService->gets($parentId);
		$childrens = MD('GuessCategory')->gets("parent_id = '{$parentId}'");
		AjaxResult::ajaxResult('1', $childrens);
	}
}

?>