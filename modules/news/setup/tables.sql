/**
 * 资讯分类
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_news_category`;
CREATE TABLE `yyx_news_category`(
	`id` int(4) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(150) NOT NULL DEFAULT '' COMMENT '名称',
	`type` tinyint(1) unsigned NOT NULL default 0 comment '分类类型',
	`sort_num` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
	PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='资讯分类';

/**
 * 资讯
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_news`;
CREATE TABLE `yyx_news`(
	`id` int(4) unsigned NOT NULL AUTO_INCREMENT,
	`title` varchar(150) NOT NULL DEFAULT '' COMMENT '标题',
	`type` tinyint(1) unsigned NOT NULL default 0 comment '资讯类型',
	`cate_id` int(4) unsigned NOT NULL comment '分类ID',
	`content` text  COMMENT '内容',
	`views` int(11) NOT NULL DEFAULT 0 COMMENT '浏览数',
	`sort_num` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
	`create_time` int(10) NOT NULL DEFAULT 0 COMMENT '创建时间',
	PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='资讯';