<?php
/**
 * Email服务
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-03
 */
class EmailService implements IEmailService{
	
	private $config;
	
	private $emailTemplateDao = null;
	
	public function __construct(){
		$configService = CommonServiceFactory::getConfigService();
		$this->config = array(
			'type' => $configService->get('email_service_type'),
			'host' => $configService->get('email_smtp'),
			'port' => $configService->get('email_server_port'),
			'send_email' => $configService->get('email_send_email'),
			'password' => $configService->get('email_send_email_password'),
			'reply' => $configService->get('email_reply_email'),
			'ssl' => $configService->get('email_ssl'),
			'charset' => 'utf-8',
			'site_name' => $configService->get('site_name')
		);
	}
	
	/**
	 * 发送
	 *
	 * @param string $name
	 *        	接收人姓名
	 * @param string $email
	 *        	接收人邮件地址
	 * @param string $subject
	 *        	邮件标题
	 * @param string $content
	 *        	邮件内容
	 * @param int $type
	 *        	0 普通邮件， 1 HTML邮件
	 * @param bool $notification
	 *        	true 要求回执， false 不用回执
	 * @return boolean string
	 */
	public function send($name, $email, $subject, $content, $type = 0, $notification = false){
		return $this->sendMail($name, $email, $subject, $content, $type, $notification);
	}
	
	/**
	 * 发送模板邮件
	 *
	 * @param string $name
	 *        	接收人姓名
	 * @param string $email
	 *        	接收人邮件地址
	 * @param string $templateKey
	 *        	邮件模板标识
	 * @param array $params
	 *        	模板中使用的参数
	 * @param bool $notification
	 *        	true 要求回执， false 不用回执
	 * @return boolean string
	 */
	public function sendWithTemplate($name, $email, $templateKey, $params = array(), $notification = false){
		$result = get_lang('email_template_not_exist');
		$template = $this->getEmailTemplate($templateKey);
		if(!empty($template)){
			include_once (EXT_LIB_ROOT . 'tools.fun.php');
			$content = emailTemplateTag($template['value'], $params);
			$subject = emailTemplateTag($template['subject'], $params);
			$result = $this->sendMail($name, $email, $subject, $content, 1, $notification);
		}
		return $result;
	}
	
	/**
	 * 获取邮件模板
	 * @param string $templateKey
	 */
	protected function getEmailTemplate($templateKey){
		if(!$this->emailTemplateDao){
			$this->emailTemplateDao = MD('EmailTemplate');
		}
		$conditions = array('key'=>$templateKey);
		return $this->emailTemplateDao->getOne($conditions);
	}
	
	/**
	 * 发送邮件
	 *
	 * @param string $name
	 *        	接收人姓名
	 * @param string $email
	 *        	接收人邮件地址
	 * @param string $subject
	 *        	邮件标题
	 * @param string $content
	 *        	邮件内容
	 * @param int $type
	 *        	0 普通邮件， 1 HTML邮件
	 * @param bool $notification
	 *        	true 要求回执， false 不用回执
	 * @return boolean string
	 */
	protected function sendMail($name, $email, $subject, $content, $type = 0, $notification = false){
		if(($this->config['type'] == 'mail') && function_exists('mail')){
			//使用mail函数发送邮件
			/* 邮件的头部信息 */
			$content_type = ($type == 0)? 'Content-Type: text/plain; charset=' . $this->config['charset'] : 'Content-Type: text/html; charset=' . $this->config['charset'];
			$headers = array();
			$headers[] = 'From: "' . '=?' . $this->config['charset'] . '?B?' . base64_encode($this->config['site_name']) . '?=' . '" <' . $this->config['reply'] . '>';
			$headers[] = $content_type . '; format=flowed';
			if($notification){
				$headers[] = 'Disposition-Notification-To: ' . '=?' . $this->config['charset'] . '?B?' . base64_encode($this->config['site_name']) . '?=' . '" <' . $this->config['reply'] . '>';
			}
				
			$res = @mail($email, '=?' . $this->config['charset'] . '?B?' . base64_encode($subject) . '?=', $content, implode("\r\n", $headers));
				
			if(!$res){
				return get_lang('sendemail_false');
			}else{
				return true;
			}
		}else{
			//使用smtp服务发送邮件
			include_once (EXT_LIB_ROOT . 'Smtp.class.php');
			/* 邮件的头部信息 */
			$content_type = ($type == 0)? 'Content-Type: text/plain; charset=' . $this->config['charset'] : 'Content-Type: text/html; charset=' . $this->config['charset'];
			$content = base64_encode($content);
				
			$headers = array();
			$headers[] = 'Date: ' . gmdate('D, j M Y H:i:s') . ' +0000';
			$headers[] = 'To: "' . '=?' . $this->config['charset'] . '?B?' . base64_encode($name) . '?=' . '" <' . $email . '>';
			$headers[] = 'From: "' . '=?' . $this->config['charset'] . '?B?' . base64_encode($this->config['site_name']) . '?=' . '" <' . $this->config['reply'] . '>';
			$headers[] = 'Subject: ' . '=?' . $this->config['charset'] . '?B?' . base64_encode($subject) . '?=';
			$headers[] = $content_type . '; format=flowed';
			$headers[] = 'Content-Transfer-Encoding: base64';
			$headers[] = 'Content-Disposition: inline';
			if($notification){
				$headers[] = 'Disposition-Notification-To: ' . '=?' . $this->config['charset'] . '?B?' . base64_encode($this->config['site_name']) . '?=' . '" <' . $this->config['reply'] . '>';
			}
				
			/* 获得邮件服务器的参数设置 */
			$params['host'] = $this->config['host'];
			$params['port'] = $this->config['port'];
			$params['user'] = $this->config['send_email'];
			$params['pass'] = $this->config['password'];
			$params['ssl'] = $this->config['ssl'];
				
			if(empty($params['host']) || empty($params['port'])){
				// 如果没有设置主机和端口直接返回
				return get_lang('smtp_setting_error');
			}else{
				// 发送邮件
				if(!function_exists('fsockopen')){
					// 如果fsockopen被禁用，直接返回
					return get_lang('disabled_fsockopen');
				}
	
				$send_params['recipients'] = $email;
				$send_params['headers'] = $headers;
				$send_params['from'] = $this->config['send_email'];
				$send_params['body'] = $content;
	
				$smtp = new Smtp($params);
				if($smtp->connect() && $smtp->send($send_params)){
					return true;
				}else{
					$err_msg = $smtp->error_msg();
					$err = '';
					if(empty($err_msg)){
						$err = get_lang('unknown_error');
					}else{
						if(strpos($err_msg, 'Failed to connect to server') !== false){
							$err = sprintf(get_lang('smtp_connect_failure'), $params['host'] . ':' . $params['port']);
						}else if(strpos($err_msg, 'AUTH command failed') !== false){
							$err = get_lang('smtp_login_failure');
						}elseif(strpos($err_msg, 'bad sequence of commands') !== false){
							$err = get_lang('smtp_refuse');
						}else{
							$err = $err_msg;
						}
					}
						
					return $err;
				}
			}
		}
	}
}