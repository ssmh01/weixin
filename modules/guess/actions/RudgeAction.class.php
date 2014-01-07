<?php
/**
 * 竞猜提交判定
 * @author blueyb.java@gmail.com
 */
class RudgeAction extends UserCenterAction{
	
	protected function setMessage($message){
		$message = get_lang($message);
		setcookie('message',$message, 0, '/');
		$_COOKIE['message'] = $message;
	}
		
	public function index(HttpRequest $request){
		$this->apply($request);
	}
	/*
	public function apply(HttpRequest $request){
		//获取竞猜
		$id = $request->getParameter('id');
		if(empty($id)){
			show_message('请选择要提交判定的竞猜!');
		}
		$guessService = GuessServiceFactory::getCustomGuessService();
		$guess = $guessService->get($id, true);
		if(!$guess || !$guess->getCustom() || $guess->getStatus() != Guess::STATUS_NORMAL){
			show_message('非法操作!');
		}
		$success = $guessService->rudgeApply($guess);
		if($success){
			//操作成功
			show_message('提交判定成功!');
		}else{
			//操作失败
			show_message('提交判定失败!');
		}
	}
	*/
	public function apply(HttpRequest $request){
		$id = $request->getParameter('id');
		if(empty($id)){
			show_message(get_lang('no_record_common'));
		}
		$guessService = GuessServiceFactory::getCustomGuessService();
		$guess = $guessService->get($id, true);
		if(!$guess){
			show_message('竞猜不存在');
		}
		if(!$guess->getCustom()){
			show_message('不是自定义竞猜，不能进行结果判定!');
		}
		$request->setAttribute('item', $guess);
		if(!$request->isPost()){
			$request->assign('title', '结果判定');
		}else{
			$value = trim($request->getParameter('option'));
			if(!strlen($value)){
				show_message('请选选择答案');
			}
			$guess->getParameter()->setValue($value);
			$guessDao = MD('Guess');
			$success = $guessDao->update(array('parameter'=>serialize($guess->getParameter())), $id);
			
			if($success){
				$success = $guessService->rudge($guess);
			
				if($success){
					show_message(get_lang('operation_success_common'));
				}else{
					//操作失败
					show_message(get_lang('operation_failed_common'));
				}
			}else{
				//操作失败
				show_message(get_lang('operation_failed_common'));
			}
		}
	}	
}