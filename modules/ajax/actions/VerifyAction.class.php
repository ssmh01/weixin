<?php
/**
 * 验证Action
 */
class VerifyAction extends Action{
	
	public function index(HttpRequest $request){
		$this->image($request);
	}
	
	/**
	 * 图片验证码
	 * @param HttpRequest $request
	 */
	public function image(HttpRequest $request){
		$verificationService = MemberServiceFactory::getVerificationCodeService();
		$verificationService->createVerificationCode(null);
		exit(0);
	}
	
	public function imageVerify(HttpRequest $request){
		$code = $request->getParameter('code');
		$verificationService = MemberServiceFactory::getVerificationCodeService();
		if($verificationService->verify($code)){
			AjaxResult::ajaxResult(1, '验证码验证成功');
		}else{
			AjaxResult::ajaxResult(0, '验证码验证失败');
		}
	}
}