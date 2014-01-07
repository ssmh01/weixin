<?php
/**
 * Email服务接口
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-03
 */
interface IEmailService{
    /**
     * 发送
     *
     * @param string $name 接收人姓名
     * @param string $email 接收人邮件地址
     * @param string $subject 邮件标题
     * @param string $content 邮件内容
     * @param int $type 0 普通邮件， 1 HTML邮件
     * @param bool $notification true 要求回执， false 不用回执
     * @return boolean|string 不成功返回错误信息
     */
    public function send($name, $email, $subject, $content, $type = 0, $notification=false);

    /**
     * 发送模板邮件
     *
     * @param string $name 接收人姓名
     * @param string $email 接收人邮件地址
     * @param string $templateCode 邮件模板标识
     * @param array $params 模板中使用的参数
     * @param bool $notification true 要求回执， false 不用回执
     * @return boolean|string 不成功返回错误信息
     */
    public function sendWithTemplate($name, $email, $templateCode, $params=array(), $notification=false);
}