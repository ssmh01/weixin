<?php

/**
 * 上传Action
 * @author blueyb.java@gmail.com
 */
class UploadAction extends CommonAction {
	
	/**
	 * @var UploadHelper
	 */
	private $uploadHepler = null;
	
	public function __construct(){
		HttpSession::stop();
		HttpSession::id(R::getRequest()->getParameter('PHPSESSID'));
		HttpSession::start();
		$this->uploadHepler = new UploadHelper('image','jpg|gif|png|jpeg');
	}

	public function avatar(HttpRequest $request){
		$this->loginCheck(true);
		if(!$request->hasFile('avatar')){
			AjaxResult::ajaxResult(0, '请选择要上传的文件!');
		}
		$this->uploadHepler->setUploadDir(WEB_ROOT . 'res/attached/avatar/');
		$fileName = $this->uploadHepler->saveFileWithTimeStampName('avatar');
		if($fileName){
			$fileName = '/res/attached/avatar/'.$fileName;
			AjaxResult::ajaxResult(1, $fileName);
		}else{
			AjaxResult::ajaxResult(0, '上传的头像失败!');
		}
	}
}

?>