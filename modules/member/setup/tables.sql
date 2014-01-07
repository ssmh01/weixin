/**
 * 用户
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_user`;
CREATE TABLE `yyx_user`(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
	`password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
	`email` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱',
	`nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
	`avatar` varchar(150) NOT NULL DEFAULT '' COMMENT '头像',
	`sex` tinyint(1) NOT NULL DEFAULT '1' COMMENT '性别 0:未知 1:男 2:女',
	`birthday_year` smallint(4) NOT NULL DEFAULT '0' COMMENT '生日:年',
	`birthday_month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '生日:月',
	`birthday_day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '生日:日',
	`mobile` varchar(15) NOT NULL DEFAULT '' COMMENT '手机号码',
	`qq` varchar(15) NOT NULL DEFAULT '' COMMENT 'QQ号码',
	`province` varchar(50) COMMENT '省份',
	`city` varchar(50) COMMENT '城市',
	`area` varchar(50) COMMENT '地区',
	`address` varchar(150) not null default '' comment '现居住地',
	`sign` text not null default '' comment '个性签名',
	`website` varchar(150) not null default '' comment '个性网址',
	`sina_weibo` varchar(150) not null default '' comment '新浪weibo',
	`qq_weibo` varchar(150) not null default '' comment '腾讯weibo',
	`available_money` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '可用金额',
	`freeze_money` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '冻结的金额',
	`available_integral` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '可用积分',
	`freeze_integral`  int(11) unsigned NOT NULL DEFAULT '0' COMMENT '冻结的积分',
	`views`  int(11) unsigned NOT NULL DEFAULT '0' COMMENT '被查看次数',
	`makers_level`  tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '庄家级别',
	`guess_add_count`  int(11) unsigned NOT NULL DEFAULT '0' COMMENT '坐庄次数',
	`guess_count`  int(11) unsigned NOT NULL DEFAULT '0' COMMENT '竞猜次数',
	`accuracy`  tinyint(2) unsigned NOT NULL DEFAULT '100' COMMENT '竞猜准确率',
	`fan_count`  int(11) unsigned NOT NULL DEFAULT '0' COMMENT '粉丝次数',
	`follow_count`  int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关注次数',
	`allow_login` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否允许登陆 0：不允许 1：允许',
	`last_login_time` int(10) NOT NULL DEFAULT '0' COMMENT '上次登陆时间',
	`configs` text comment '个人设置,序列化',
	`register_time` int(10) not null default 0 comment '注册时间',
	`friend` text NOT NULL comment '好友ID',
	PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户表';

/**
 * 充值
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_recharge`;
CREATE TABLE `yyx_recharge`(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`sn` varchar(20) NOT NULL comment '充值编号',
	`user_id` int(11) unsigned NOT NULL default 0 comment '用户ID',
	`money` int(11) NOT NULL DEFAULT '0' COMMENT '充值的金额',
	`pay_type`  varchar(20) not null COMMENT '支付类型, alipay:支付宝，bank:网银 offline:线下',
	`status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '充值状态 0:未支付 1：成功',
	`create_time` int(10) not null default 0 comment '注册时间',
	PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='充值';

/**
 * 通知
 */
drop table if exists `yyx_notice`;
CREATE TABLE IF NOT EXISTS `yyx_notice` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_uid` int(10) unsigned NOT NULL DEFAULT '0' comment '动作发起人 0为系统',
  `to_uid` int(10) unsigned NOT NULL DEFAULT '0' comment '通知接收人',
  `type` varchar(20) NOT NULL DEFAULT '' comment '通知类型',
  `new` tinyint(1) NOT NULL DEFAULT '1' comment '是否是新通知',
  `notice` text NOT NULL comment '通知',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' comment '通知时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/**
 * 消息
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_message`;
CREATE TABLE `yyx_message`(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`from_uid` int(11) unsigned NOT NULL default 0 comment '发信人，0为系统',
	`to_uid` int(11) unsigned NOT NULL comment '收信人',
	`repay_id` int(11) unsigned NOT NULL default 0 comment '回复消息ID',
	`title` varchar(150) NOT NULL DEFAULT '' COMMENT '标题',
	`content` text COMMENT '消息内容',
	`new` tinyint(1) not null default 1 COMMENT '是否是新消息',
	`from_status` tinyint(1) not null default 2 COMMENT '发信人消息状态  2：正常 1：删除 0：彻底删除',
	`to_status` tinyint(1) not null default 2 COMMENT '收信人消息状态  2：正常 1：删除 0：彻底删除',
	`create_time` int(10) not null default 0 COMMENT '发信时间',
	PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='消息';

/**
 * 关注
 */
drop table if exists `yyx_follow`;
CREATE TABLE IF NOT EXISTS `yyx_follow` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_uid` int(10) unsigned NOT NULL DEFAULT '0' comment '关注人',
  `to_uid` int(10) unsigned NOT NULL DEFAULT '0' comment '被关注人',
  `add_time` int(10) unsigned NOT NULL DEFAULT 0 comment '关注时间',
  PRIMARY KEY (`id`),
  key `from_uid` (`from_uid`),
  key `to_uid` (to_uid),
  unique key (`from_uid`,`to_uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/**
 * 收支
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_io`;
CREATE TABLE `yyx_io`(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`from_user_id` int(11) not null default 0 comment '支出人ID, 0为系统',
	`to_user_id` int(11) not null default 0 comment '收入人ID, 0为系统',
	`from_title` varchar(255) not null default '' comment '支出标题',
	`to_title` varchar(255) not null default '' comment '收入标题',
	`type` smallint(3) DEFAULT '0' COMMENT '收支类型,如充值，投资',
	`source_id` int(11) unsigned not null default 0 comment '收支源ID',
	`wealth_type` tinyint(1) unsigned not null default 1 comment '财富类型 1为金币 2为积分',
	`wealth` double(10,2) not null default 0 comment '财富数',
	`tax`  double(10,2) not null default 0 comment '税',
	`from_balance` double(10,2) not null default 0 comment '支出人余额',
	`to_balance` double(10,2)  not null default 0 comment '收入人余额',
	`summary` text comment '说明',
	`create_time` int(10) not null default 0 comment '创建时间',
	PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='收支';

/**
 * 微博
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_weibo`;
CREATE TABLE `yyx_weibo`(
	`id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
	`logo` varchar(200) NOT NULL DEFAULT '' COMMENT 'logo图片',
	`type` varchar(50) COMMENT '类型代码',
	`app_key` varchar(100) comment '应用KEY',
	`app_secret` varchar(100) comment '应用Secret',
	`url` varchar(200) NOT NULL DEFAULT '' comment '链接地址',
	`sort_num` smallint(4) DEFAULT '0' COMMENT '排序',
	`status` tinyint(1) DEFAULT '1' COMMENT '0：不显示，1：显示，默认为1',
	UNIQUE KEY (`type`),
	PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='微博';

/**
 * weibo绑定
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_bind`;
CREATE TABLE `yyx_bind`(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` int(11) not null default 0 comment '绑定用户',
	`weibo_id` int(11) not null default 0 comment '绑定微博',
	`account` varchar(100) comment '绑定账号',
	`password` varchar(100) comment '绑定密码',
	`datas` text comment '绑定数据',
	`create_time` int(10) not null default 0 comment '创建时间',
	UNIQUE KEY (`user_id`, `weibo_id`),
	PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='weibo绑定';

/**
 * 分享记录
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_share`;
CREATE TABLE `yyx_share`(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`type` smallint(4) not null comment '分享类型 1:微博',
	`user_id` int(11) not null default 0 comment '用户',
	`share_id` int(11) not null default 0 comment '分享内容ID',
	`create_time` int(10) not null default 0 comment '创建时间',
	UNIQUE KEY (`type`, `user_id`, `share_id`),
	PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='分享记录';


/**
 * 庄家认证
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_makers_auth`;
CREATE TABLE `yyx_makers_auth`(
	`id` int(11) unsigned NOT NULL comment '用户ID',
	`title` varchar(150) not null comment '认证标题',
	`summary` text comment '认证说明',
	`status` tinyint(2) not null default 0 COMMENT '认证状态，0未处理 -1拒绝 1通过',
	`create_time` int(10) not null default 0 comment '创建时间',
	PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='庄家认证';

/**
 * 邀请
 * @author blueyb.java@gmail.com
 */
DROP TABLE IF EXISTS `yyx_invite`;
CREATE TABLE `yyx_invite`(
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`inviter_id` int(11) unsigned NOT NULL comment '邀请人ID',
	`invitee_id` int(11) unsigned NOT NULL comment '被邀请人ID',
	`recharge_percent` double(3,3) not null default 0.0 comment '邀请充值提成比例',
	`integral` int(10) unsigned not null default 0 comment '邀请用户注册赠送积分',
	`create_time` int not null default 0 comment '邀请时间',
	UNIQUE KEY (`inviter_id`, `invitee_id`),
	PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='邀请';