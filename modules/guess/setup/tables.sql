/**
 * 竞猜玩法
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_play_way`;
CREATE TABLE `yyx_play_way`(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(150) NOT NULL DEFAULT '' COMMENT '名称',
	`class` varchar(30) NOT NULL COMMENT '玩法类名，用与区别其它玩法,用于加载玩法解析器',
	`parameter` text comment '玩法参数,序列化参数类',
	`summary` text COMMENT '玩法简介',
	`news_id` int(11) unsigned NOT NULL default 0 comment '玩法说明资讯ID',
	`status` tinyint(1)  not null DEFAULT '0' COMMENT '玩法使用状态 0：禁用，1：使用，默认为0，一旦开启就无法修改、删除',
	PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='竞猜玩法';

/**
 * 竞猜分类
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_guess_category`;
CREATE TABLE `yyx_guess_category`(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
	`parent_id` int(11) DEFAULT '0' COMMENT '父分类',
	`play_ways` text COMMENT '竞猜玩法ID, 多个用,分隔',
	`parameter_count` smallint(2) not null default '1' comment '竞猜点参数个数',
	`fixed_odds` tinyint(1) DEFAULT '1' COMMENT '固定赔率状态 0：禁用，1：使用，默认为1',
	`float_odds` tinyint(1) DEFAULT '1' COMMENT '浮动赔率状态 0：禁用，1：使用，默认为1',
	`status` tinyint(1)  not null DEFAULT '1' COMMENT '分类使用状态 0：禁用，1：使用，默认为1',
	`sort_num` smallint(4) DEFAULT '0' COMMENT '排序',
	PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='竞猜分类';

/**
 * 竞猜点
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_guess_point`;
CREATE TABLE `yyx_guess_point`(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`cate_id` int(11) DEFAULT '0' COMMENT '分类Id',
	`title` varchar(150) NOT NULL DEFAULT '' COMMENT '竞猜点标题',
	`guess_count` int(11) not null default '0' comment '竞猜个数',
	`play_deadline` int(10) not null comment '参与竟猜截止时间',
	`params` text comment '参数数组',
	`status` tinyint(1)  not null DEFAULT '1' COMMENT '竞猜点状态 0：禁用，1：使用，默认为1, 2:已判定',
	`create_time` int(10) unsigned default 0 comment '创建时间',
	PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='竞猜点';

/**
 * 竞猜
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_guess`;
CREATE TABLE `yyx_guess`(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(11) unsigned NOT NULL comment '坐庄用户',
	`custom` tinyint(1) unsigned not null default 0 comment '竟猜类型 0:系统玩法 1:自定义',
	`guess_point_id` int(11) DEFAULT '0' COMMENT '竞猜点ID',
	`cate_id` int(11) not null COMMENT '分类Id',
	`tax` double(3,3) not null COMMENT '系统税收比例',
	`title` varchar(150) NOT NULL DEFAULT '' COMMENT '标题',
	`play_start_time` int(10) not null comment '参与竟猜开始时间',
	`play_deadline` int(10) not null comment '参与竟猜截止时间',
	`odds_type` tinyint(1) unsigned not null default 0 comment '赔率类型 0未知赔率 1为固定 2为浮动 3为组合',
	`wealth_type` tinyint(2) unsigned not null default 1 comment '竟猜财富类型 1为金币 2为积分, 自定义竟猜见详细',
	`custom_type` varchar(50) not null default '' comment '自定义竟猜类型',
	`play_count` int(10) unsigned not null default 0 comment '参与竟猜人数',
	`play_wealth` int(10) unsigned not null default 0 comment '参与竟猜财富数',
	`keep_wealth` int(10) unsigned not null default 0 COMMENT '托管金额',
	`win_wealth` double(10,2) unsigned not null default 0.0 COMMENT '赢的金额',
	`play_datas` text COMMENT '多个竞猜玩法的数组数据(玩法ID,赔率类型，投注上下限,竞猜人数上限,赔率)',
	`parameter` text COMMENT '自定义竟猜的参数',
	`play_role` tinyint(1) not null DEFAULT '0' COMMENT '参与角色 0：所有人，1：好友',
	`summary` text  COMMENT '竞猜简介',
	`status` tinyint(2) not null DEFAULT '1' COMMENT '竟猜状态 0：待审核，1：审核通过 2:提交判定 3：结束 4:关闭',
	`create_time` int(10) unsigned default 0 comment '创建时间',
	PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='竞猜';

/**
 * 竞猜参与
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_play`;
CREATE TABLE IF NOT EXISTS `yyx_play` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT '参与用户',
  `custom` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '竟猜类型 0:系统玩法 1:自定义',
  `guess_id` int(11) unsigned NOT NULL COMMENT '参与的竞猜',
  `wealth_type` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '竟猜财富类型 1为金币 2为积分, 自定义竟猜见详细',
  `wealth` int(11) unsigned NOT NULL default 0 COMMENT '总投注',
  `win_wealth` double(10,2) NOT NULL default 0 COMMENT '总赢财富,如果是自定义玩法，就设置为1.00',
  `play_datas` text COMMENT '竞猜数据 PlayData类型数组',
  `status` tinyint(1) unsigned DEFAULT 0 COMMENT '竞猜是否已判定 1:已判定 0:未判定',
  `create_time` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='竞猜参与';

/**
 * 用户－竞猜对应表
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_user_guess`;
CREATE TABLE IF NOT EXISTS `yyx_user_guess` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_uid` int(11) unsigned NOT NULL COMMENT '主动用户',
  `to_uid` int(11) unsigned NOT NULL COMMENT '被动用户',
  `guess_id` int(11) unsigned NOT NULL COMMENT '参与的竞猜',
  `type` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '关系类型 1:我关注的竞猜 2:邀请我参与的竞猜',
  `create_time` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  unique key (`to_uid`,`guess_id`, `type`),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户－竞猜对应表';

/**
 * 自定义竞猜类型
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_custom_type`;
CREATE TABLE `yyx_custom_type`(
	`id` int(4) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(150) NOT NULL DEFAULT '' COMMENT '名称',
	`sort_num` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
	PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='自定义竞猜类型';