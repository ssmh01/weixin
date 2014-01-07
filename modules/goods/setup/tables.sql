/**
 * 商品
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_goods`;
CREATE TABLE `yyx_goods`(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`title` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
	`image` varchar(150) default '' comment '商品图片',
	`detail` text default '' comment '详细',
	`status` tinyint(1) DEFAULT '1' COMMENT '0：下架，1：上架，默认为1',
	`can_lottery` tinyint(1) default '1' comment '是否能抽奖 0:不能， 1:能， 默认为1',
	`lottery_count` smallint(4) unsigned not null default '1' comment '每个用户抽奖次数 0为不限',
	`probability` double(8,8) not null default 0 comment '中奖概率',
	`can_exchange` tinyint(1) not null default '1' comment '是否能兑换 0:不能， 1:能， 默认为1',
	`money` int(11) unsigned not null default '0' comment '兑换金币 0为免费',
	`money_limit` int(11) unsigned not null default '0' comment '用户金币下限 0为不设限',
	`count` int(11) unsigned not null default '0' comment '库存数',
	`exchanges` int(11) unsigned not null default '0' comment '中/兑奖次数',
	`sort_num` smallint(4) DEFAULT '0' COMMENT '排序',
	`summary` text comment '简介',
	`create_time` int(10) not null default 0 comment '创建时间',
	PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品表';

/**
 * 中/兑奖表
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_exchange`;
CREATE TABLE `yyx_exchange`(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`goods_id` int(11) unsigned NOT NULL comment '商品',
	`user_id` int(11) unsigned NOT NULL comment '商品',
	`is_lottery` tinyint(1) default '0' comment '是否是抽奖奖品',
	`is_exchange` tinyint(1) not null default '0' comment '是否兑换是兑换',
	`money` int(11) unsigned not null default '0' comment '兑换金币',
	`username` varchar(50) not null default '' comment '收货人姓名',
	`mobile` varchar(15) not null default '' comment '收货人手机',
	`zip` varchar(15) not null default '' comment '邮编',
	`address` varchar(150) not null default '' comment '收货人地址',
	`send_status` tinyint(1) DEFAULT '0' COMMENT '发货状态，0：未发货，1：已发货，默认为0',
	`receive_status` tinyint(1) DEFAULT '0' COMMENT '收货状态，0：未收货，1：已收货，默认为0',
	`create_time` int(10) not null default 0 comment '创建时间',
	PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='中/兑奖表';

/**
 * 抽奖记录表
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_lottery_record`;
CREATE TABLE `yyx_lottery_record`(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`goods_id` int(11) unsigned NOT NULL comment '商品',
	`user_id` int(11) unsigned NOT NULL comment '用户',
	`count` smallint(4) default '0' comment '抽奖次数',
	PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='抽奖记录表';