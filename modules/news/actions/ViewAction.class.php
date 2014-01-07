<?php
/**
 * 查看文章
 * @author blueyb.java@gmail.com
 */
class ViewAction extends UserCenterAction{
	
	public function index(HttpRequest $request){
		$id = intval($request->getParameter('id'));
		if(empty($id)){
			show_message('请选择要查看的说明');
		}
		$newsService = NewsServiceFactory::getNewsService();
		$item = $newsService->getNews($id);
		if(empty($item)){
			show_message('你要查看的说明不存在');
		}
		$request->setAttribute('item', $item);
		
		$newsCategoryService = NewsServiceFactory::getNewsCategoryService();
		$categorys = $newsCategoryService->getCategorys();
		$request->setAttribute('categorys', $categorys);
		
		$seo = array(
				'title' => $item['title'],
				'description'=>'',
				'keywords'=>'',
		);
		$request->setAttribute('seo', $seo);
		$this->setView('view');
	}
}