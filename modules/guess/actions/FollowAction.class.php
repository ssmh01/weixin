<?php
/**
 * 关注
 * @author blueyb.java@gmail.com
 */
class FollowAction extends UserCenterAction{
	
	public function index(HttpRequest $request){
		$this->add($request);
	}
	
	/**
	 * 加关注
	 * @param HttpRequest $request
	 */
	public function add(HttpRequest $request){
		$id = $request->getParameter('id');
		if(!$id){
			show_message('请选择要关注的竞猜');
		}
		$guessService = GuessServiceFactory::getGuessService();
		$guess = $guessService->get($id, true);
		if(!$guess){
			show_message('你关注的竞猜不存在');
		}
		
		if($guessService->isFollow($this->user->getId(), $id)){
			show_message('你已经关注该竞猜，不须重复关注!');
		}
		if($guessService->follow($this->user, $guess)){
			show_message('关注成功');
		}else{
			show_message('关注失败');
		}
	}
	
	/**
	 * 取消关注
	 * @param HttpRequest $request
	 */
	public function cancel(HttpRequest $request){
		$id = $request->getParameter('id');
		if(!$id){
			show_message('请选择要取消关注的竞猜');
		}
		$guessService = GuessServiceFactory::getGuessService();
		$guess = $guessService->get($id, true);
		if(!$guess){
			show_message('你要取消关注的竞猜不存在');
		}
		if(!$guessService->isFollow($this->user->getId(), $id)){
			show_message('你没有关注该竞猜，不须取消关注!');
		}
		if($guessService->unFollow($this->user, $guess)){
			show_message('取消关注成功');
		}else{
			show_message('取消关注失败');
		}
	}
}