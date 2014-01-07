<?php

/**
 * 图片验证码
 * @author blueyb.java@gmail.com
 * @since 1.0 - Jan 5, 2013
 */
class ImageVerificationCodeService implements IVerificationCodeService{
	
	/**
	 * 验证名
	 * @var string
	 */
	private $sessionVerificationName = 'verification_code';
	
	/**
	 * captcha对象
	 * @var captcha
	 */
	private $captcha;
	
	/*
	 * @see IVerificationCodeService::createVerificationCode()
	 */
	public function createVerificationCode($params=null){
		@ob_end_clean(); //清除之前出现的多余输入
		$this->getCaptcha()->generate_image();
	}
	
	/*
	 * @see IVerificationCodeService::setSessionVerificationName()
	 */
	public function setSessionVerificationName($verificationName){
		$this->sessionVerificationName = $verificationName;
	}
	
	/*
	 * @see IVerificationCodeService::verify()
	 */
	public function verify($verificationCode){
		return $this->getCaptcha()->check_word($verificationCode);
	}
	
	/**
	 * 获取captcha对象
	 * @return captcha
	 */
	private function getCaptcha(){
		if(!$this->captcha){
			require(EXT_LIB_ROOT.'captcha/captcha.class.php');
			$this->captcha = new captcha(EXT_LIB_ROOT . 'captcha/data/captcha/', 80, 25);
			$this->captcha->session_word = $this->sessionVerificationName;
		}
		return $this->captcha;
	}
}

?>