<?php
/**
 * 验证码服务接口
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - Jan 5, 2013
 */
interface IVerificationCodeService{
	
	/**
	 * 设置session验证名
	 * @param string $verificationName
	 */
	public function setSessionVerificationName($verificationName);
	
	/**
	 * 生成验证码
	 * @param $params 参数，结构如：array('mobiles'='', 'template'='', 'data'=>array('name'=>'','pass'=>''))
	 */
	public function createVerificationCode($params);
	
	/**
	 * 验证验证码
	 * @param tring $verificationCode
	 * @return boolean
	 */
	public function verify($verificationCode);
}

?>