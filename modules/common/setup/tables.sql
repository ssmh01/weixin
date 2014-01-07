/**
 * 系统配置
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_config`;
CREATE TABLE `yyx_config`(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(100) NOT NULL DEFAULT '' COMMENT '配置名称',
	`tab` varchar(10) NOT NULL DEFAULT '' COMMENT '所属选项卡',
	`type` varchar(20) COMMENT '该配置的类型，text，文本输入框；password，密码输入框；textarea，文本区域；select，下拉框单选；checkbox, 复选框 ; radio , 单选框 ;  file,文件上传；hidden , 隐藏框',
	`options` text comment '可选值,只有type字段为select,options时才有值, 以,号分隔多值',
	`key` varchar(50) COMMENT '配置键',
	`value` text COMMENT '配置值',
	`sort_num` smallint(4) DEFAULT '0' COMMENT '排序',
	UNIQUE KEY (`key`),
	PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统配置';

/**
 * 区域
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_region`;
CREATE TABLE IF NOT EXISTS `yyx_region` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' comment '上级区域',
  `type` tinyint(1) NOT NULL DEFAULT '2' comment '区域类型　0：国，1：省，2：市 3：区',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `type` (`type`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='区域';

/**
 * 邮件模板
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_email_template`;
CREATE TABLE `yyx_email_template`(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(100) NOT NULL DEFAULT '' COMMENT '类型名称',
	`subject` varchar(200) NOT NULL DEFAULT '' COMMENT '邮件主题',
	`key` varchar(50) COMMENT '键',
	`value` text COMMENT '值',
	`description` text comment '描述',
	UNIQUE KEY (`key`),
	PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='邮件模板';