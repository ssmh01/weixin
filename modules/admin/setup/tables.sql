/**
 * 菜单
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_menu`;
CREATE TABLE `yyx_menu`(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
	`url` varchar(150) NOT NULL DEFAULT '' COMMENT '链接地址',
	`parent_id` int(11) DEFAULT '0' COMMENT '父菜单',
	`status` tinyint(1) DEFAULT '1' COMMENT '0：不显示，1：显示，默认为1',
	`is_system` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为系统内置，0否1是',
	`sort_num` smallint(4) DEFAULT '0' COMMENT '排序',
	PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='菜单表';

/**
 * 管理组
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_manage_group`;
CREATE TABLE `yyx_manage_group`(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
	`permissions` text comment '权限 Array序列化,　用动作标识作为下标,权限值作为值;其中权限值代表(0没权限 1：读 2：写 3：读写)',
	`summary` text COMMENT '简介',
	`create_time` int(10) not null default 0 comment '创建时间',
	PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理组';

/**
 * 系统管理员
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_manager`;
CREATE TABLE `yyx_manager`(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
	`password` varchar(32) COMMENT '密码',
	`mobile` varchar(15) COMMENT '手机',
	`group_id` int(11) unsigned NOT NULL default 0 comment '管理组ID',
	`allow_login` tinyint(1) not null default '0' COMMENT '是否允许登陆 0：不允许 1：允许',
	`last_login_time` int(10) not null default 0 comment '上次登陆时间',
	`create_time` int(10) not null default 0 comment '创建时间',
	PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统管理员';