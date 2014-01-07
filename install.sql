-- ----------------------------
-- Table structure for `yyx_bind`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_bind`;
CREATE TABLE `yyx_bind` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '绑定用户',
  `weibo_id` int(11) NOT NULL DEFAULT '0' COMMENT '绑定微博',
  `account` varchar(100) DEFAULT NULL COMMENT '绑定账号',
  `password` varchar(100) DEFAULT NULL COMMENT '绑定密码',
  `datas` text COMMENT '绑定数据',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`weibo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='weibo绑定';

-- ----------------------------
-- Records of yyx_bind
-- ----------------------------

-- ----------------------------
-- Table structure for `yyx_city`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_city`;
CREATE TABLE `yyx_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city_index` int(11) NOT NULL,
  `province_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=392 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yyx_city
-- ----------------------------
INSERT INTO `yyx_city` VALUES ('5', '1', '5', '石家庄市');
INSERT INTO `yyx_city` VALUES ('6', '2', '5', '唐山市');
INSERT INTO `yyx_city` VALUES ('7', '3', '5', '秦皇岛市');
INSERT INTO `yyx_city` VALUES ('8', '4', '5', '邯郸市');
INSERT INTO `yyx_city` VALUES ('9', '5', '5', '邢台市');
INSERT INTO `yyx_city` VALUES ('10', '6', '5', '保定市');
INSERT INTO `yyx_city` VALUES ('11', '7', '5', '张家口市');
INSERT INTO `yyx_city` VALUES ('12', '8', '5', '承德市');
INSERT INTO `yyx_city` VALUES ('13', '9', '5', '沧州市');
INSERT INTO `yyx_city` VALUES ('14', '10', '5', '廊坊市');
INSERT INTO `yyx_city` VALUES ('15', '11', '5', '衡水市');
INSERT INTO `yyx_city` VALUES ('16', '1', '6', '太原市');
INSERT INTO `yyx_city` VALUES ('17', '2', '6', '大同市');
INSERT INTO `yyx_city` VALUES ('18', '3', '6', '阳泉市');
INSERT INTO `yyx_city` VALUES ('19', '4', '6', '长治市');
INSERT INTO `yyx_city` VALUES ('20', '5', '6', '晋城市');
INSERT INTO `yyx_city` VALUES ('21', '6', '6', '朔州市');
INSERT INTO `yyx_city` VALUES ('22', '7', '6', '晋中市');
INSERT INTO `yyx_city` VALUES ('23', '8', '6', '运城市');
INSERT INTO `yyx_city` VALUES ('24', '9', '6', '忻州市');
INSERT INTO `yyx_city` VALUES ('25', '10', '6', '临汾市');
INSERT INTO `yyx_city` VALUES ('26', '11', '6', '吕梁市');
INSERT INTO `yyx_city` VALUES ('27', '1', '7', '台北市');
INSERT INTO `yyx_city` VALUES ('28', '2', '7', '高雄市');
INSERT INTO `yyx_city` VALUES ('29', '3', '7', '基隆市');
INSERT INTO `yyx_city` VALUES ('30', '4', '7', '台中市');
INSERT INTO `yyx_city` VALUES ('31', '5', '7', '台南市');
INSERT INTO `yyx_city` VALUES ('32', '6', '7', '新竹市');
INSERT INTO `yyx_city` VALUES ('33', '7', '7', '嘉义市');
INSERT INTO `yyx_city` VALUES ('34', '8', '7', '台北县');
INSERT INTO `yyx_city` VALUES ('35', '9', '7', '宜兰县');
INSERT INTO `yyx_city` VALUES ('36', '10', '7', '桃园县');
INSERT INTO `yyx_city` VALUES ('37', '11', '7', '新竹县');
INSERT INTO `yyx_city` VALUES ('38', '12', '7', '苗栗县');
INSERT INTO `yyx_city` VALUES ('39', '13', '7', '台中县');
INSERT INTO `yyx_city` VALUES ('40', '14', '7', '彰化县');
INSERT INTO `yyx_city` VALUES ('41', '15', '7', '南投县');
INSERT INTO `yyx_city` VALUES ('42', '16', '7', '云林县');
INSERT INTO `yyx_city` VALUES ('43', '17', '7', '嘉义县');
INSERT INTO `yyx_city` VALUES ('44', '18', '7', '台南县');
INSERT INTO `yyx_city` VALUES ('45', '19', '7', '高雄县');
INSERT INTO `yyx_city` VALUES ('46', '20', '7', '屏东县');
INSERT INTO `yyx_city` VALUES ('47', '21', '7', '澎湖县');
INSERT INTO `yyx_city` VALUES ('48', '22', '7', '台东县');
INSERT INTO `yyx_city` VALUES ('49', '23', '7', '花莲县');
INSERT INTO `yyx_city` VALUES ('50', '1', '8', '沈阳市');
INSERT INTO `yyx_city` VALUES ('51', '2', '8', '大连市');
INSERT INTO `yyx_city` VALUES ('52', '3', '8', '鞍山市');
INSERT INTO `yyx_city` VALUES ('53', '4', '8', '抚顺市');
INSERT INTO `yyx_city` VALUES ('54', '5', '8', '本溪市');
INSERT INTO `yyx_city` VALUES ('55', '6', '8', '丹东市');
INSERT INTO `yyx_city` VALUES ('56', '7', '8', '锦州市');
INSERT INTO `yyx_city` VALUES ('57', '8', '8', '营口市');
INSERT INTO `yyx_city` VALUES ('58', '9', '8', '阜新市');
INSERT INTO `yyx_city` VALUES ('59', '10', '8', '辽阳市');
INSERT INTO `yyx_city` VALUES ('60', '11', '8', '盘锦市');
INSERT INTO `yyx_city` VALUES ('61', '12', '8', '铁岭市');
INSERT INTO `yyx_city` VALUES ('62', '13', '8', '朝阳市');
INSERT INTO `yyx_city` VALUES ('63', '14', '8', '葫芦岛市');
INSERT INTO `yyx_city` VALUES ('64', '1', '9', '长春市');
INSERT INTO `yyx_city` VALUES ('65', '2', '9', '吉林市');
INSERT INTO `yyx_city` VALUES ('66', '3', '9', '四平市');
INSERT INTO `yyx_city` VALUES ('67', '4', '9', '辽源市');
INSERT INTO `yyx_city` VALUES ('68', '5', '9', '通化市');
INSERT INTO `yyx_city` VALUES ('69', '6', '9', '白山市');
INSERT INTO `yyx_city` VALUES ('70', '7', '9', '松原市');
INSERT INTO `yyx_city` VALUES ('71', '8', '9', '白城市');
INSERT INTO `yyx_city` VALUES ('72', '9', '9', '延边朝鲜族自治州');
INSERT INTO `yyx_city` VALUES ('73', '1', '10', '哈尔滨市');
INSERT INTO `yyx_city` VALUES ('74', '2', '10', '齐齐哈尔市');
INSERT INTO `yyx_city` VALUES ('75', '3', '10', '鹤岗市');
INSERT INTO `yyx_city` VALUES ('76', '4', '10', '双鸭山市');
INSERT INTO `yyx_city` VALUES ('77', '5', '10', '鸡西市');
INSERT INTO `yyx_city` VALUES ('78', '6', '10', '大庆市');
INSERT INTO `yyx_city` VALUES ('79', '7', '10', '伊春市');
INSERT INTO `yyx_city` VALUES ('80', '8', '10', '牡丹江市');
INSERT INTO `yyx_city` VALUES ('81', '9', '10', '佳木斯市');
INSERT INTO `yyx_city` VALUES ('82', '10', '10', '七台河市');
INSERT INTO `yyx_city` VALUES ('83', '11', '10', '黑河市');
INSERT INTO `yyx_city` VALUES ('84', '12', '10', '绥化市');
INSERT INTO `yyx_city` VALUES ('85', '13', '10', '大兴安岭地区');
INSERT INTO `yyx_city` VALUES ('86', '1', '11', '南京市');
INSERT INTO `yyx_city` VALUES ('87', '2', '11', '无锡市');
INSERT INTO `yyx_city` VALUES ('88', '3', '11', '徐州市');
INSERT INTO `yyx_city` VALUES ('89', '4', '11', '常州市');
INSERT INTO `yyx_city` VALUES ('90', '5', '11', '苏州市');
INSERT INTO `yyx_city` VALUES ('91', '6', '11', '南通市');
INSERT INTO `yyx_city` VALUES ('92', '7', '11', '连云港市');
INSERT INTO `yyx_city` VALUES ('93', '8', '11', '淮安市');
INSERT INTO `yyx_city` VALUES ('94', '9', '11', '盐城市');
INSERT INTO `yyx_city` VALUES ('95', '10', '11', '扬州市');
INSERT INTO `yyx_city` VALUES ('96', '11', '11', '镇江市');
INSERT INTO `yyx_city` VALUES ('97', '12', '11', '泰州市');
INSERT INTO `yyx_city` VALUES ('98', '13', '11', '宿迁市');
INSERT INTO `yyx_city` VALUES ('99', '1', '12', '杭州市');
INSERT INTO `yyx_city` VALUES ('100', '2', '12', '宁波市');
INSERT INTO `yyx_city` VALUES ('101', '3', '12', '温州市');
INSERT INTO `yyx_city` VALUES ('102', '4', '12', '嘉兴市');
INSERT INTO `yyx_city` VALUES ('103', '5', '12', '湖州市');
INSERT INTO `yyx_city` VALUES ('104', '6', '12', '绍兴市');
INSERT INTO `yyx_city` VALUES ('105', '7', '12', '金华市');
INSERT INTO `yyx_city` VALUES ('106', '8', '12', '衢州市');
INSERT INTO `yyx_city` VALUES ('107', '9', '12', '舟山市');
INSERT INTO `yyx_city` VALUES ('108', '10', '12', '台州市');
INSERT INTO `yyx_city` VALUES ('109', '11', '12', '丽水市');
INSERT INTO `yyx_city` VALUES ('110', '1', '13', '合肥市');
INSERT INTO `yyx_city` VALUES ('111', '2', '13', '芜湖市');
INSERT INTO `yyx_city` VALUES ('112', '3', '13', '蚌埠市');
INSERT INTO `yyx_city` VALUES ('113', '4', '13', '淮南市');
INSERT INTO `yyx_city` VALUES ('114', '5', '13', '马鞍山市');
INSERT INTO `yyx_city` VALUES ('115', '6', '13', '淮北市');
INSERT INTO `yyx_city` VALUES ('116', '7', '13', '铜陵市');
INSERT INTO `yyx_city` VALUES ('117', '8', '13', '安庆市');
INSERT INTO `yyx_city` VALUES ('118', '9', '13', '黄山市');
INSERT INTO `yyx_city` VALUES ('119', '10', '13', '滁州市');
INSERT INTO `yyx_city` VALUES ('120', '11', '13', '阜阳市');
INSERT INTO `yyx_city` VALUES ('121', '12', '13', '宿州市');
INSERT INTO `yyx_city` VALUES ('122', '13', '13', '巢湖市');
INSERT INTO `yyx_city` VALUES ('123', '14', '13', '六安市');
INSERT INTO `yyx_city` VALUES ('124', '15', '13', '亳州市');
INSERT INTO `yyx_city` VALUES ('125', '16', '13', '池州市');
INSERT INTO `yyx_city` VALUES ('126', '17', '13', '宣城市');
INSERT INTO `yyx_city` VALUES ('127', '1', '14', '福州市');
INSERT INTO `yyx_city` VALUES ('128', '2', '14', '厦门市');
INSERT INTO `yyx_city` VALUES ('129', '3', '14', '莆田市');
INSERT INTO `yyx_city` VALUES ('130', '4', '14', '三明市');
INSERT INTO `yyx_city` VALUES ('131', '5', '14', '泉州市');
INSERT INTO `yyx_city` VALUES ('132', '6', '14', '漳州市');
INSERT INTO `yyx_city` VALUES ('133', '7', '14', '南平市');
INSERT INTO `yyx_city` VALUES ('134', '8', '14', '龙岩市');
INSERT INTO `yyx_city` VALUES ('135', '9', '14', '宁德市');
INSERT INTO `yyx_city` VALUES ('136', '1', '15', '南昌市');
INSERT INTO `yyx_city` VALUES ('137', '2', '15', '景德镇市');
INSERT INTO `yyx_city` VALUES ('138', '3', '15', '萍乡市');
INSERT INTO `yyx_city` VALUES ('139', '4', '15', '九江市');
INSERT INTO `yyx_city` VALUES ('140', '5', '15', '新余市');
INSERT INTO `yyx_city` VALUES ('141', '6', '15', '鹰潭市');
INSERT INTO `yyx_city` VALUES ('142', '7', '15', '赣州市');
INSERT INTO `yyx_city` VALUES ('143', '8', '15', '吉安市');
INSERT INTO `yyx_city` VALUES ('144', '9', '15', '宜春市');
INSERT INTO `yyx_city` VALUES ('145', '10', '15', '抚州市');
INSERT INTO `yyx_city` VALUES ('146', '11', '15', '上饶市');
INSERT INTO `yyx_city` VALUES ('147', '1', '16', '济南市');
INSERT INTO `yyx_city` VALUES ('148', '2', '16', '青岛市');
INSERT INTO `yyx_city` VALUES ('149', '3', '16', '淄博市');
INSERT INTO `yyx_city` VALUES ('150', '4', '16', '枣庄市');
INSERT INTO `yyx_city` VALUES ('151', '5', '16', '东营市');
INSERT INTO `yyx_city` VALUES ('152', '6', '16', '烟台市');
INSERT INTO `yyx_city` VALUES ('153', '7', '16', '潍坊市');
INSERT INTO `yyx_city` VALUES ('154', '8', '16', '济宁市');
INSERT INTO `yyx_city` VALUES ('155', '9', '16', '泰安市');
INSERT INTO `yyx_city` VALUES ('156', '10', '16', '威海市');
INSERT INTO `yyx_city` VALUES ('157', '11', '16', '日照市');
INSERT INTO `yyx_city` VALUES ('158', '12', '16', '莱芜市');
INSERT INTO `yyx_city` VALUES ('159', '13', '16', '临沂市');
INSERT INTO `yyx_city` VALUES ('160', '14', '16', '德州市');
INSERT INTO `yyx_city` VALUES ('161', '15', '16', '聊城市');
INSERT INTO `yyx_city` VALUES ('162', '16', '16', '滨州市');
INSERT INTO `yyx_city` VALUES ('163', '17', '16', '菏泽市');
INSERT INTO `yyx_city` VALUES ('164', '1', '17', '郑州市');
INSERT INTO `yyx_city` VALUES ('165', '2', '17', '开封市');
INSERT INTO `yyx_city` VALUES ('166', '3', '17', '洛阳市');
INSERT INTO `yyx_city` VALUES ('167', '4', '17', '平顶山市');
INSERT INTO `yyx_city` VALUES ('168', '5', '17', '安阳市');
INSERT INTO `yyx_city` VALUES ('169', '6', '17', '鹤壁市');
INSERT INTO `yyx_city` VALUES ('170', '7', '17', '新乡市');
INSERT INTO `yyx_city` VALUES ('171', '8', '17', '焦作市');
INSERT INTO `yyx_city` VALUES ('172', '9', '17', '濮阳市');
INSERT INTO `yyx_city` VALUES ('173', '10', '17', '许昌市');
INSERT INTO `yyx_city` VALUES ('174', '11', '17', '漯河市');
INSERT INTO `yyx_city` VALUES ('175', '12', '17', '三门峡市');
INSERT INTO `yyx_city` VALUES ('176', '13', '17', '南阳市');
INSERT INTO `yyx_city` VALUES ('177', '14', '17', '商丘市');
INSERT INTO `yyx_city` VALUES ('178', '15', '17', '信阳市');
INSERT INTO `yyx_city` VALUES ('179', '16', '17', '周口市');
INSERT INTO `yyx_city` VALUES ('180', '17', '17', '驻马店市');
INSERT INTO `yyx_city` VALUES ('181', '18', '17', '济源市');
INSERT INTO `yyx_city` VALUES ('182', '1', '18', '武汉市');
INSERT INTO `yyx_city` VALUES ('183', '2', '18', '黄石市');
INSERT INTO `yyx_city` VALUES ('184', '3', '18', '十堰市');
INSERT INTO `yyx_city` VALUES ('185', '4', '18', '荆州市');
INSERT INTO `yyx_city` VALUES ('186', '5', '18', '宜昌市');
INSERT INTO `yyx_city` VALUES ('187', '6', '18', '襄樊市');
INSERT INTO `yyx_city` VALUES ('188', '7', '18', '鄂州市');
INSERT INTO `yyx_city` VALUES ('189', '8', '18', '荆门市');
INSERT INTO `yyx_city` VALUES ('190', '9', '18', '孝感市');
INSERT INTO `yyx_city` VALUES ('191', '10', '18', '黄冈市');
INSERT INTO `yyx_city` VALUES ('192', '11', '18', '咸宁市');
INSERT INTO `yyx_city` VALUES ('193', '12', '18', '随州市');
INSERT INTO `yyx_city` VALUES ('194', '13', '18', '仙桃市');
INSERT INTO `yyx_city` VALUES ('195', '14', '18', '天门市');
INSERT INTO `yyx_city` VALUES ('196', '15', '18', '潜江市');
INSERT INTO `yyx_city` VALUES ('197', '16', '18', '神农架林区');
INSERT INTO `yyx_city` VALUES ('198', '17', '18', '恩施土家族苗族自治州');
INSERT INTO `yyx_city` VALUES ('199', '1', '19', '长沙市');
INSERT INTO `yyx_city` VALUES ('200', '2', '19', '株洲市');
INSERT INTO `yyx_city` VALUES ('201', '3', '19', '湘潭市');
INSERT INTO `yyx_city` VALUES ('202', '4', '19', '衡阳市');
INSERT INTO `yyx_city` VALUES ('203', '5', '19', '邵阳市');
INSERT INTO `yyx_city` VALUES ('204', '6', '19', '岳阳市');
INSERT INTO `yyx_city` VALUES ('205', '7', '19', '常德市');
INSERT INTO `yyx_city` VALUES ('206', '8', '19', '张家界市');
INSERT INTO `yyx_city` VALUES ('207', '9', '19', '益阳市');
INSERT INTO `yyx_city` VALUES ('208', '10', '19', '郴州市');
INSERT INTO `yyx_city` VALUES ('209', '11', '19', '永州市');
INSERT INTO `yyx_city` VALUES ('210', '12', '19', '怀化市');
INSERT INTO `yyx_city` VALUES ('211', '13', '19', '娄底市');
INSERT INTO `yyx_city` VALUES ('212', '14', '19', '湘西土家族苗族自治州');
INSERT INTO `yyx_city` VALUES ('213', '1', '20', '广州市');
INSERT INTO `yyx_city` VALUES ('214', '2', '20', '深圳市');
INSERT INTO `yyx_city` VALUES ('215', '3', '20', '珠海市');
INSERT INTO `yyx_city` VALUES ('216', '4', '20', '汕头市');
INSERT INTO `yyx_city` VALUES ('217', '5', '20', '韶关市');
INSERT INTO `yyx_city` VALUES ('218', '6', '20', '佛山市');
INSERT INTO `yyx_city` VALUES ('219', '7', '20', '江门市');
INSERT INTO `yyx_city` VALUES ('220', '8', '20', '湛江市');
INSERT INTO `yyx_city` VALUES ('221', '9', '20', '茂名市');
INSERT INTO `yyx_city` VALUES ('222', '10', '20', '肇庆市');
INSERT INTO `yyx_city` VALUES ('223', '11', '20', '惠州市');
INSERT INTO `yyx_city` VALUES ('224', '12', '20', '梅州市');
INSERT INTO `yyx_city` VALUES ('225', '13', '20', '汕尾市');
INSERT INTO `yyx_city` VALUES ('226', '14', '20', '河源市');
INSERT INTO `yyx_city` VALUES ('227', '15', '20', '阳江市');
INSERT INTO `yyx_city` VALUES ('228', '16', '20', '清远市');
INSERT INTO `yyx_city` VALUES ('229', '17', '20', '东莞市');
INSERT INTO `yyx_city` VALUES ('230', '18', '20', '中山市');
INSERT INTO `yyx_city` VALUES ('231', '19', '20', '潮州市');
INSERT INTO `yyx_city` VALUES ('232', '20', '20', '揭阳市');
INSERT INTO `yyx_city` VALUES ('233', '21', '20', '云浮市');
INSERT INTO `yyx_city` VALUES ('234', '1', '21', '兰州市');
INSERT INTO `yyx_city` VALUES ('235', '2', '21', '金昌市');
INSERT INTO `yyx_city` VALUES ('236', '3', '21', '白银市');
INSERT INTO `yyx_city` VALUES ('237', '4', '21', '天水市');
INSERT INTO `yyx_city` VALUES ('238', '5', '21', '嘉峪关市');
INSERT INTO `yyx_city` VALUES ('239', '6', '21', '武威市');
INSERT INTO `yyx_city` VALUES ('240', '7', '21', '张掖市');
INSERT INTO `yyx_city` VALUES ('241', '8', '21', '平凉市');
INSERT INTO `yyx_city` VALUES ('242', '9', '21', '酒泉市');
INSERT INTO `yyx_city` VALUES ('243', '10', '21', '庆阳市');
INSERT INTO `yyx_city` VALUES ('244', '11', '21', '定西市');
INSERT INTO `yyx_city` VALUES ('245', '12', '21', '陇南市');
INSERT INTO `yyx_city` VALUES ('246', '13', '21', '临夏回族自治州');
INSERT INTO `yyx_city` VALUES ('247', '14', '21', '甘南藏族自治州');
INSERT INTO `yyx_city` VALUES ('248', '1', '22', '成都市');
INSERT INTO `yyx_city` VALUES ('249', '2', '22', '自贡市');
INSERT INTO `yyx_city` VALUES ('250', '3', '22', '攀枝花市');
INSERT INTO `yyx_city` VALUES ('251', '4', '22', '泸州市');
INSERT INTO `yyx_city` VALUES ('252', '5', '22', '德阳市');
INSERT INTO `yyx_city` VALUES ('253', '6', '22', '绵阳市');
INSERT INTO `yyx_city` VALUES ('254', '7', '22', '广元市');
INSERT INTO `yyx_city` VALUES ('255', '8', '22', '遂宁市');
INSERT INTO `yyx_city` VALUES ('256', '9', '22', '内江市');
INSERT INTO `yyx_city` VALUES ('257', '10', '22', '乐山市');
INSERT INTO `yyx_city` VALUES ('258', '11', '22', '南充市');
INSERT INTO `yyx_city` VALUES ('259', '12', '22', '眉山市');
INSERT INTO `yyx_city` VALUES ('260', '13', '22', '宜宾市');
INSERT INTO `yyx_city` VALUES ('261', '14', '22', '广安市');
INSERT INTO `yyx_city` VALUES ('262', '15', '22', '达州市');
INSERT INTO `yyx_city` VALUES ('263', '16', '22', '雅安市');
INSERT INTO `yyx_city` VALUES ('264', '17', '22', '巴中市');
INSERT INTO `yyx_city` VALUES ('265', '18', '22', '资阳市');
INSERT INTO `yyx_city` VALUES ('266', '19', '22', '阿坝藏族羌族自治州');
INSERT INTO `yyx_city` VALUES ('267', '20', '22', '甘孜藏族自治州');
INSERT INTO `yyx_city` VALUES ('268', '21', '22', '凉山彝族自治州');
INSERT INTO `yyx_city` VALUES ('269', '1', '23', '贵阳市');
INSERT INTO `yyx_city` VALUES ('270', '2', '23', '六盘水市');
INSERT INTO `yyx_city` VALUES ('271', '3', '23', '遵义市');
INSERT INTO `yyx_city` VALUES ('272', '4', '23', '安顺市');
INSERT INTO `yyx_city` VALUES ('273', '5', '23', '铜仁地区');
INSERT INTO `yyx_city` VALUES ('274', '6', '23', '毕节地区');
INSERT INTO `yyx_city` VALUES ('275', '7', '23', '黔西南布依族苗族自治州');
INSERT INTO `yyx_city` VALUES ('276', '8', '23', '黔东南苗族侗族自治州');
INSERT INTO `yyx_city` VALUES ('277', '9', '23', '黔南布依族苗族自治州');
INSERT INTO `yyx_city` VALUES ('278', '1', '24', '海口市');
INSERT INTO `yyx_city` VALUES ('279', '2', '24', '三亚市');
INSERT INTO `yyx_city` VALUES ('280', '3', '24', '五指山市');
INSERT INTO `yyx_city` VALUES ('281', '4', '24', '琼海市');
INSERT INTO `yyx_city` VALUES ('282', '5', '24', '儋州市');
INSERT INTO `yyx_city` VALUES ('283', '6', '24', '文昌市');
INSERT INTO `yyx_city` VALUES ('284', '7', '24', '万宁市');
INSERT INTO `yyx_city` VALUES ('285', '8', '24', '东方市');
INSERT INTO `yyx_city` VALUES ('286', '9', '24', '澄迈县');
INSERT INTO `yyx_city` VALUES ('287', '10', '24', '定安县');
INSERT INTO `yyx_city` VALUES ('288', '11', '24', '屯昌县');
INSERT INTO `yyx_city` VALUES ('289', '12', '24', '临高县');
INSERT INTO `yyx_city` VALUES ('290', '13', '24', '白沙黎族自治县');
INSERT INTO `yyx_city` VALUES ('291', '14', '24', '昌江黎族自治县');
INSERT INTO `yyx_city` VALUES ('292', '15', '24', '乐东黎族自治县');
INSERT INTO `yyx_city` VALUES ('293', '16', '24', '陵水黎族自治县');
INSERT INTO `yyx_city` VALUES ('294', '17', '24', '保亭黎族苗族自治县');
INSERT INTO `yyx_city` VALUES ('295', '18', '24', '琼中黎族苗族自治县');
INSERT INTO `yyx_city` VALUES ('296', '1', '25', '昆明市');
INSERT INTO `yyx_city` VALUES ('297', '2', '25', '曲靖市');
INSERT INTO `yyx_city` VALUES ('298', '3', '25', '玉溪市');
INSERT INTO `yyx_city` VALUES ('299', '4', '25', '保山市');
INSERT INTO `yyx_city` VALUES ('300', '5', '25', '昭通市');
INSERT INTO `yyx_city` VALUES ('301', '6', '25', '丽江市');
INSERT INTO `yyx_city` VALUES ('302', '7', '25', '思茅市');
INSERT INTO `yyx_city` VALUES ('303', '8', '25', '临沧市');
INSERT INTO `yyx_city` VALUES ('304', '9', '25', '文山壮族苗族自治州');
INSERT INTO `yyx_city` VALUES ('305', '10', '25', '红河哈尼族彝族自治州');
INSERT INTO `yyx_city` VALUES ('306', '11', '25', '西双版纳傣族自治州');
INSERT INTO `yyx_city` VALUES ('307', '12', '25', '楚雄彝族自治州');
INSERT INTO `yyx_city` VALUES ('308', '13', '25', '大理白族自治州');
INSERT INTO `yyx_city` VALUES ('309', '14', '25', '德宏傣族景颇族自治州');
INSERT INTO `yyx_city` VALUES ('310', '15', '25', '怒江傈傈族自治州');
INSERT INTO `yyx_city` VALUES ('311', '16', '25', '迪庆藏族自治州');
INSERT INTO `yyx_city` VALUES ('312', '1', '26', '西宁市');
INSERT INTO `yyx_city` VALUES ('313', '2', '26', '海东地区');
INSERT INTO `yyx_city` VALUES ('314', '3', '26', '海北藏族自治州');
INSERT INTO `yyx_city` VALUES ('315', '4', '26', '黄南藏族自治州');
INSERT INTO `yyx_city` VALUES ('316', '5', '26', '海南藏族自治州');
INSERT INTO `yyx_city` VALUES ('317', '6', '26', '果洛藏族自治州');
INSERT INTO `yyx_city` VALUES ('318', '7', '26', '玉树藏族自治州');
INSERT INTO `yyx_city` VALUES ('319', '8', '26', '海西蒙古族藏族自治州');
INSERT INTO `yyx_city` VALUES ('320', '1', '27', '西安市');
INSERT INTO `yyx_city` VALUES ('321', '2', '27', '铜川市');
INSERT INTO `yyx_city` VALUES ('322', '3', '27', '宝鸡市');
INSERT INTO `yyx_city` VALUES ('323', '4', '27', '咸阳市');
INSERT INTO `yyx_city` VALUES ('324', '5', '27', '渭南市');
INSERT INTO `yyx_city` VALUES ('325', '6', '27', '延安市');
INSERT INTO `yyx_city` VALUES ('326', '7', '27', '汉中市');
INSERT INTO `yyx_city` VALUES ('327', '8', '27', '榆林市');
INSERT INTO `yyx_city` VALUES ('328', '9', '27', '安康市');
INSERT INTO `yyx_city` VALUES ('329', '10', '27', '商洛市');
INSERT INTO `yyx_city` VALUES ('330', '1', '28', '南宁市');
INSERT INTO `yyx_city` VALUES ('331', '2', '28', '柳州市');
INSERT INTO `yyx_city` VALUES ('332', '3', '28', '桂林市');
INSERT INTO `yyx_city` VALUES ('333', '4', '28', '梧州市');
INSERT INTO `yyx_city` VALUES ('334', '5', '28', '北海市');
INSERT INTO `yyx_city` VALUES ('335', '6', '28', '防城港市');
INSERT INTO `yyx_city` VALUES ('336', '7', '28', '钦州市');
INSERT INTO `yyx_city` VALUES ('337', '8', '28', '贵港市');
INSERT INTO `yyx_city` VALUES ('338', '9', '28', '玉林市');
INSERT INTO `yyx_city` VALUES ('339', '10', '28', '百色市');
INSERT INTO `yyx_city` VALUES ('340', '11', '28', '贺州市');
INSERT INTO `yyx_city` VALUES ('341', '12', '28', '河池市');
INSERT INTO `yyx_city` VALUES ('342', '13', '28', '来宾市');
INSERT INTO `yyx_city` VALUES ('343', '14', '28', '崇左市');
INSERT INTO `yyx_city` VALUES ('344', '1', '29', '拉萨市');
INSERT INTO `yyx_city` VALUES ('345', '2', '29', '那曲地区');
INSERT INTO `yyx_city` VALUES ('346', '3', '29', '昌都地区');
INSERT INTO `yyx_city` VALUES ('347', '4', '29', '山南地区');
INSERT INTO `yyx_city` VALUES ('348', '5', '29', '日喀则地区');
INSERT INTO `yyx_city` VALUES ('349', '6', '29', '阿里地区');
INSERT INTO `yyx_city` VALUES ('350', '7', '29', '林芝地区');
INSERT INTO `yyx_city` VALUES ('351', '1', '30', '银川市');
INSERT INTO `yyx_city` VALUES ('352', '2', '30', '石嘴山市');
INSERT INTO `yyx_city` VALUES ('353', '3', '30', '吴忠市');
INSERT INTO `yyx_city` VALUES ('354', '4', '30', '固原市');
INSERT INTO `yyx_city` VALUES ('355', '5', '30', '中卫市');
INSERT INTO `yyx_city` VALUES ('356', '1', '31', '乌鲁木齐市');
INSERT INTO `yyx_city` VALUES ('357', '2', '31', '克拉玛依市');
INSERT INTO `yyx_city` VALUES ('358', '3', '31', '石河子市　');
INSERT INTO `yyx_city` VALUES ('359', '4', '31', '阿拉尔市');
INSERT INTO `yyx_city` VALUES ('360', '5', '31', '图木舒克市');
INSERT INTO `yyx_city` VALUES ('361', '6', '31', '五家渠市');
INSERT INTO `yyx_city` VALUES ('362', '7', '31', '吐鲁番市');
INSERT INTO `yyx_city` VALUES ('363', '8', '31', '阿克苏市');
INSERT INTO `yyx_city` VALUES ('364', '9', '31', '喀什市');
INSERT INTO `yyx_city` VALUES ('365', '10', '31', '哈密市');
INSERT INTO `yyx_city` VALUES ('366', '11', '31', '和田市');
INSERT INTO `yyx_city` VALUES ('367', '12', '31', '阿图什市');
INSERT INTO `yyx_city` VALUES ('368', '13', '31', '库尔勒市');
INSERT INTO `yyx_city` VALUES ('369', '14', '31', '昌吉市　');
INSERT INTO `yyx_city` VALUES ('370', '15', '31', '阜康市');
INSERT INTO `yyx_city` VALUES ('371', '16', '31', '米泉市');
INSERT INTO `yyx_city` VALUES ('372', '17', '31', '博乐市');
INSERT INTO `yyx_city` VALUES ('373', '18', '31', '伊宁市');
INSERT INTO `yyx_city` VALUES ('374', '19', '31', '奎屯市');
INSERT INTO `yyx_city` VALUES ('375', '20', '31', '塔城市');
INSERT INTO `yyx_city` VALUES ('376', '21', '31', '乌苏市');
INSERT INTO `yyx_city` VALUES ('377', '22', '31', '阿勒泰市');
INSERT INTO `yyx_city` VALUES ('378', '1', '32', '呼和浩特市');
INSERT INTO `yyx_city` VALUES ('379', '2', '32', '包头市');
INSERT INTO `yyx_city` VALUES ('380', '3', '32', '乌海市');
INSERT INTO `yyx_city` VALUES ('381', '4', '32', '赤峰市');
INSERT INTO `yyx_city` VALUES ('382', '5', '32', '通辽市');
INSERT INTO `yyx_city` VALUES ('383', '6', '32', '鄂尔多斯市');
INSERT INTO `yyx_city` VALUES ('384', '7', '32', '呼伦贝尔市');
INSERT INTO `yyx_city` VALUES ('385', '8', '32', '巴彦淖尔市');
INSERT INTO `yyx_city` VALUES ('386', '9', '32', '乌兰察布市');
INSERT INTO `yyx_city` VALUES ('387', '10', '32', '锡林郭勒盟');
INSERT INTO `yyx_city` VALUES ('388', '11', '32', '兴安盟');
INSERT INTO `yyx_city` VALUES ('389', '12', '32', '阿拉善盟');

-- ----------------------------
-- Table structure for `yyx_config`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_config`;
CREATE TABLE `yyx_config` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '配置名称',
  `tab` varchar(10) NOT NULL DEFAULT '' COMMENT '所属选项卡',
  `type` varchar(20) DEFAULT NULL COMMENT '该配置的类型，text，文本输入框；password，密码输入框；textarea，文本区域；select，下拉框单选；checkbox, 复选框 ; radio , 单选框 ;  file,文件上传；hidden , 隐藏框',
  `options` text COMMENT '可选值,只有type字段为select,options时才有值, 以,号分隔多值',
  `key` varchar(50) DEFAULT NULL COMMENT '配置键',
  `value` text COMMENT '配置值',
  `sort_num` smallint(4) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COMMENT='系统配置';

-- ----------------------------
-- Records of yyx_config
-- ----------------------------
INSERT INTO `yyx_config` VALUES ('1', '', 'email', 'radio', 'mail,mail|smtp,smtp', 'email_service_type', '', '0');
INSERT INTO `yyx_config` VALUES ('2', '', 'email', 'text', '', 'email_smtp', '', '0');
INSERT INTO `yyx_config` VALUES ('3', '', 'email', 'text', '', 'email_server_port', '', '0');
INSERT INTO `yyx_config` VALUES ('4', '', 'email', 'text', '', 'email_send_email', '', '0');
INSERT INTO `yyx_config` VALUES ('5', '', 'email', 'text', '', 'email_send_email_password', '', '0');
INSERT INTO `yyx_config` VALUES ('6', '', 'email', 'text', '', 'email_reply_email', '', '0');
INSERT INTO `yyx_config` VALUES ('7', '', 'email', 'radio', '0,否|1,是', 'email_ssl', '0', '0');
INSERT INTO `yyx_config` VALUES ('8', '', 'basic', 'text', '', 'site_name', '网站名称', '0');
INSERT INTO `yyx_config` VALUES ('9', '', 'basic', 'text', '', 'beian', '粤ICP备11111111号', '0');
INSERT INTO `yyx_config` VALUES ('10', '', 'basic', 'text', '', 'copyright', 'Copyright © 2012-2013 Yuyanxing 版权所有', '0');
INSERT INTO `yyx_config` VALUES ('11', '', 'money', 'text', '', 'integral_invite', '100', '100');
INSERT INTO `yyx_config` VALUES ('12', '', 'money', 'text', '', 'recharge_inviter_reward', '0.1', '100');
INSERT INTO `yyx_config` VALUES ('13', '', 'pay', 'text', '', 'alipay_parter_id', '', '0');
INSERT INTO `yyx_config` VALUES ('14', '', 'pay', 'text', '', 'alipay_parter_key', '', '0');
INSERT INTO `yyx_config` VALUES ('15', '', 'pay', 'text', '', 'alipay_parter_account', '', '0');
INSERT INTO `yyx_config` VALUES ('16', '', 'money', 'text', '', 'integral_share', '50', '100');
INSERT INTO `yyx_config` VALUES ('17', '', 'placard', 'textarea', '', 'placard', '今日系统与庄家分比调整为，庄家全部利润的10%，系统扣除。请各位庄家朋友们注意。 ', '0');
INSERT INTO `yyx_config` VALUES ('18', '', 'money', 'text', '', 'guess_tax', '0.1', '100');
INSERT INTO `yyx_config` VALUES ('19', '', 'money', 'radio', '0,开启|1,关闭', 'guess_add_check', '0', '0');
INSERT INTO `yyx_config` VALUES ('20', '', 'money', 'radio', '0,开启|1,关闭', 'guess_custom_add_check', '0', '0');
INSERT INTO `yyx_config` VALUES ('21', '', 'basic', 'radio', '0,关闭|1,开启', 'invite_open', '0', '0');
INSERT INTO `yyx_config` VALUES ('28', '', 'ad', 'textarea', null, 'ad', '<img width=\"270\" height=\"129\" src=\"http://www.baidu.com/img/bdlogo.gif\">', '0');
INSERT INTO `yyx_config` VALUES ('26', '', 'money', 'text', '', 'integral_register', '50', '100');
INSERT INTO `yyx_config` VALUES ('27', '', 'money', 'text', '', 'integral_user_info', '50', '100');
INSERT INTO `yyx_config` VALUES ('29', '', 'basic', 'text', null, 'wx_account', '', '0');
INSERT INTO `yyx_config` VALUES ('30', '', 'basic', 'text', null, 'admin_email', '', '0');
INSERT INTO `yyx_config` VALUES ('31', '', 'basic', 'text', null, 'sina_weibo', '', '0');
INSERT INTO `yyx_config` VALUES ('32', '', 'basic', 'text', null, 'qq_weibo', '', '0');

-- ----------------------------
-- Table structure for `yyx_custom_type`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_custom_type`;
CREATE TABLE `yyx_custom_type` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL DEFAULT '' COMMENT '名称',
  `sort_num` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='自定义竞猜类型';

-- ----------------------------
-- Records of yyx_custom_type
-- ----------------------------
INSERT INTO `yyx_custom_type` VALUES ('1', '美食', '0');
INSERT INTO `yyx_custom_type` VALUES ('2', 'KTV', '0');
INSERT INTO `yyx_custom_type` VALUES ('3', '旅游', '0');
INSERT INTO `yyx_custom_type` VALUES ('4', '喝酒', '0');

-- ----------------------------
-- Table structure for `yyx_email_template`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_email_template`;
CREATE TABLE `yyx_email_template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '类型名称',
  `subject` varchar(200) NOT NULL DEFAULT '' COMMENT '邮件主题',
  `key` varchar(50) DEFAULT NULL COMMENT '键',
  `value` text COMMENT '值',
  `description` text COMMENT '描述',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='邮件模板';

-- ----------------------------
-- Records of yyx_email_template
-- ----------------------------
INSERT INTO `yyx_email_template` VALUES ('1', '找回密码邮件模板', '找回密码-预言星', 'find_password_email', '您好，{account}，密码重置链接为：{url}，30分钟内有效。', '变量说明：账号名(account), 密码重置链接(url)');

-- ----------------------------
-- Table structure for `yyx_exchange`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_exchange`;
CREATE TABLE `yyx_exchange` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) unsigned NOT NULL COMMENT '商品',
  `user_id` int(11) unsigned NOT NULL COMMENT '商品',
  `is_lottery` tinyint(1) DEFAULT '0' COMMENT '是否是抽奖奖品',
  `is_exchange` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否兑换是兑换',
  `money` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '兑换金币',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '收货人姓名',
  `mobile` varchar(15) NOT NULL DEFAULT '' COMMENT '收货人手机',
  `zip` varchar(15) NOT NULL DEFAULT '' COMMENT '邮编',
  `address` varchar(150) NOT NULL DEFAULT '' COMMENT '收货人地址',
  `send_status` tinyint(1) DEFAULT '0' COMMENT '发货状态，0：未发货，1：已发货，默认为0',
  `receive_status` tinyint(1) DEFAULT '0' COMMENT '收货状态，0：未收货，1：已收货，默认为0',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='中/兑奖表';

-- ----------------------------
-- Records of yyx_exchange
-- ----------------------------

-- ----------------------------
-- Table structure for `yyx_follow`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_follow`;
CREATE TABLE `yyx_follow` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关注人',
  `to_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '被关注人',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关注时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `from_uid_2` (`from_uid`,`to_uid`),
  KEY `from_uid` (`from_uid`),
  KEY `to_uid` (`to_uid`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yyx_follow
-- ----------------------------

-- ----------------------------
-- Table structure for `yyx_goods`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_goods`;
CREATE TABLE `yyx_goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `image` varchar(150) DEFAULT '' COMMENT '商品图片',
  `detail` text COMMENT '详细',
  `status` tinyint(1) DEFAULT '1' COMMENT '0：下架，1：上架，默认为1',
  `can_lottery` tinyint(1) DEFAULT '1' COMMENT '是否能抽奖 0:不能， 1:能， 默认为1',
  `lottery_count` smallint(4) unsigned NOT NULL DEFAULT '1' COMMENT '每个用户抽奖次数 0为不限',
  `lottery_credit` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '抽奖所需积分',
  `probability` double(8,8) NOT NULL DEFAULT '0.00000000' COMMENT '中奖概率',
  `can_exchange` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否能兑换 0:不能， 1:能， 默认为1',
  `money` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '兑换金币 0为免费',
  `money_limit` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户金币下限 0为不设限',
  `count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '库存数',
  `exchanges` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '中/兑奖次数',
  `sort_num` smallint(4) DEFAULT '0' COMMENT '排序',
  `summary` text NOT NULL,
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='商品表';

-- ----------------------------
-- Records of yyx_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `yyx_guess`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_guess`;
CREATE TABLE `yyx_guess` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT '坐庄用户',
  `custom` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '竟猜类型 0:系统玩法 1:自定义',
  `guess_point_id` int(11) DEFAULT '0' COMMENT '竞猜点ID',
  `cate_id` int(11) NOT NULL COMMENT '分类Id',
  `tax` double(3,3) NOT NULL COMMENT '系统税收比例',
  `title` varchar(150) NOT NULL DEFAULT '' COMMENT '标题',
  `play_start_time` int(10) NOT NULL COMMENT '参与竟猜开始时间',
  `play_deadline` int(10) NOT NULL COMMENT '参与竟猜截止时间',
  `odds_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '赔率类型 0未知赔率 1为固定 2为浮动 3为组合',
  `wealth_type` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '竟猜财富类型 1为金币 2为积分, 自定义竟猜见详细',
  `custom_type` varchar(50) NOT NULL DEFAULT '' COMMENT '自定义竟猜类型',
  `play_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '参与竟猜人数',
  `play_wealth` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '参与竟猜财富数',
  `keep_wealth` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '托管金额',
  `win_wealth` double(10,2) NOT NULL COMMENT '赢的金额',
  `play_datas` text COMMENT '多个竞猜玩法的数组数据(玩法ID,赔率类型，投注上下限,竞猜人数上限,赔率)',
  `parameter` text COMMENT '自定义竟猜的参数',
  `play_role` tinyint(1) NOT NULL DEFAULT '0' COMMENT '参与角色 0：所有人，1：好友',
  `summary` text COMMENT '竞猜简介',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '竟猜状态 0：待审核，1：审核通过 2:提交判定 3：结束 4:关闭',
  `create_time` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='竞猜';

-- ----------------------------
-- Records of yyx_guess
-- ----------------------------

-- ----------------------------
-- Table structure for `yyx_guess_category`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_guess_category`;
CREATE TABLE `yyx_guess_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `parent_id` int(11) DEFAULT '0' COMMENT '父分类',
  `play_ways` text COMMENT '竞猜玩法ID, 多个用,分隔',
  `parameter_count` smallint(2) NOT NULL DEFAULT '1' COMMENT '竞猜点参数个数',
  `fixed_odds` tinyint(1) DEFAULT '1' COMMENT '固定赔率状态 0：禁用，1：使用，默认为1',
  `float_odds` tinyint(1) DEFAULT '1' COMMENT '浮动赔率状态 0：禁用，1：使用，默认为1',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '分类使用状态 0：禁用，1：使用，默认为1',
  `sort_num` smallint(4) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='竞猜分类';

-- ----------------------------
-- Records of yyx_guess_category
-- ----------------------------
INSERT INTO `yyx_guess_category` VALUES ('1', '足球', '0', '1,2,3', '2', '1', '1', '1', '0');
INSERT INTO `yyx_guess_category` VALUES ('2', '财经', '0', '4,5,6,7', '1', '1', '1', '1', '0');
INSERT INTO `yyx_guess_category` VALUES ('3', '彩票', '0', '4,5,6,7', '1', '1', '1', '1', '0');
INSERT INTO `yyx_guess_category` VALUES ('4', '英超', '1', null, '2', '1', '1', '1', '0');
INSERT INTO `yyx_guess_category` VALUES ('5', '西甲', '1', null, '2', '1', '1', '1', '0');
INSERT INTO `yyx_guess_category` VALUES ('6', '中超', '1', null, '2', '1', '1', '1', '0');
INSERT INTO `yyx_guess_category` VALUES ('7', '上证', '2', null, '1', '1', '1', '1', '0');
INSERT INTO `yyx_guess_category` VALUES ('8', '深成', '2', null, '1', '1', '1', '1', '0');
INSERT INTO `yyx_guess_category` VALUES ('9', '恒生', '2', null, '1', '1', '1', '1', '0');
INSERT INTO `yyx_guess_category` VALUES ('10', '22选5', '3', null, '1', '1', '1', '1', '0');
INSERT INTO `yyx_guess_category` VALUES ('11', '双色球', '3', null, '1', '1', '1', '1', '0');
INSERT INTO `yyx_guess_category` VALUES ('12', '福彩3D', '3', null, '1', '1', '1', '1', '3');
INSERT INTO `yyx_guess_category` VALUES ('13', '欧冠', '1', null, '2', '1', '1', '1', '0');

-- ----------------------------
-- Table structure for `yyx_guess_point`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_guess_point`;
CREATE TABLE `yyx_guess_point` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cate_id` int(11) DEFAULT '0' COMMENT '分类Id',
  `title` varchar(150) NOT NULL DEFAULT '' COMMENT '竞猜点标题',
  `guess_count` int(11) NOT NULL DEFAULT '0' COMMENT '竞猜个数',
  `play_deadline` int(10) NOT NULL COMMENT '参与竟猜截止时间',
  `params` text COMMENT '参数数组',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '竞猜点状态 0：禁用，1：使用，默认为1',
  `create_time` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='竞猜点';

-- ----------------------------
-- Records of yyx_guess_point
-- ----------------------------

-- ----------------------------
-- Table structure for `yyx_invite`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_invite`;
CREATE TABLE `yyx_invite` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `inviter_id` int(11) unsigned NOT NULL COMMENT '邀请人ID',
  `invitee_id` int(11) unsigned NOT NULL COMMENT '被邀请人ID',
  `recharge_percent` double(3,3) NOT NULL DEFAULT '0.000' COMMENT '邀请充值提成比例',
  `integral` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '邀请用户注册赠送积分',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '邀请时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `inviter_id` (`inviter_id`,`invitee_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='邀请';

-- ----------------------------
-- Records of yyx_invite
-- ----------------------------

-- ----------------------------
-- Table structure for `yyx_io`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_io`;
CREATE TABLE `yyx_io` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '支出人ID, 0为系统',
  `to_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '收入人ID, 0为系统',
  `from_title` varchar(255) NOT NULL DEFAULT '' COMMENT '支出标题',
  `to_title` varchar(255) NOT NULL DEFAULT '' COMMENT '收入标题',
  `type` smallint(3) DEFAULT '0' COMMENT '收支类型,如充值，投资',
  `source_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '收支源ID',
  `wealth_type` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '财富类型 1为金币 2为积分',
  `wealth` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '财富数',
  `tax` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '税',
  `from_balance` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '支出人余额',
  `to_balance` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '收入人余额',
  `summary` text COMMENT '说明',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='收支';

-- ----------------------------
-- Records of yyx_io
-- ----------------------------

-- ----------------------------
-- Table structure for `yyx_lottery_record`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_lottery_record`;
CREATE TABLE `yyx_lottery_record` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `goods_id` int(11) unsigned NOT NULL COMMENT '商品',
  `user_id` int(11) unsigned NOT NULL COMMENT '用户',
  `count` smallint(4) DEFAULT '0' COMMENT '抽奖次数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='抽奖记录表';

-- ----------------------------
-- Records of yyx_lottery_record
-- ----------------------------

-- ----------------------------
-- Table structure for `yyx_makers_auth`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_makers_auth`;
CREATE TABLE `yyx_makers_auth` (
  `id` int(11) unsigned NOT NULL COMMENT '用户ID',
  `title` varchar(150) NOT NULL COMMENT '认证标题',
  `summary` text COMMENT '认证说明',
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '认证状态，0未处理 -1拒绝 1通过',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='庄家认证';

-- ----------------------------
-- Records of yyx_makers_auth
-- ----------------------------

-- ----------------------------
-- Table structure for `yyx_manager`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_manager`;
CREATE TABLE `yyx_manager` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `password` varchar(32) DEFAULT NULL COMMENT '密码',
  `mobile` varchar(15) DEFAULT NULL COMMENT '手机',
  `group_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '管理组ID',
  `allow_login` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许登陆 0：不允许 1：允许',
  `last_login_time` int(10) NOT NULL DEFAULT '0' COMMENT '上次登陆时间',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='系统管理员';

-- ----------------------------
-- Table structure for `yyx_manage_group`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_manage_group`;
CREATE TABLE `yyx_manage_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `permissions` text COMMENT '权限 Array序列化,　用动作标识作为下标,权限值作为值;其中权限值代表(0没权限 1：读 2：写 3：读写)',
  `summary` text COMMENT '简介',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理组';

-- ----------------------------
-- Records of yyx_manage_group
-- ----------------------------
INSERT INTO `yyx_manage_group` VALUES ('1', '超级管理员', 'a:4:{s:18:\"admin@config@index\";s:2:\"on\";s:19:\"admin@config@update\";s:2:\"on\";s:25:\"admin@emailTemplate@index\";s:2:\"on\";s:24:\"admin@emailTemplate@edit\";s:2:\"on\";}', '超级管理员拥有所有操作的权限', '0');

-- ----------------------------
-- Table structure for `yyx_menu`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_menu`;
CREATE TABLE `yyx_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `url` varchar(150) NOT NULL DEFAULT '' COMMENT '链接地址',
  `parent_id` int(11) DEFAULT '0' COMMENT '父菜单',
  `status` tinyint(1) DEFAULT '1' COMMENT '0：不显示，1：显示，默认为1',
  `is_system` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为系统内置，0否1是',
  `sort_num` smallint(4) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COMMENT='菜单表';

-- ----------------------------
-- Records of yyx_menu
-- ----------------------------
INSERT INTO `yyx_menu` VALUES ('1', '系统管理', '/admin/config/', '0', '1', '0', '0');
INSERT INTO `yyx_menu` VALUES ('2', '系统设置', '/admin/config/', '1', '1', '0', '0');
INSERT INTO `yyx_menu` VALUES ('3', '菜单管理', '/admin/menu/', '1', '1', '0', '0');
INSERT INTO `yyx_menu` VALUES ('4', '邮件模板', '/admin/emailTemplate/', '1', '1', '0', '0');
INSERT INTO `yyx_menu` VALUES ('5', '管理员管理', '/admin/manager/', '0', '1', '0', '0');
INSERT INTO `yyx_menu` VALUES ('6', '修改密码', '/admin/password/', '5', '1', '0', '0');
INSERT INTO `yyx_menu` VALUES ('7', '管理员', '/admin/manager/', '5', '1', '0', '0');
INSERT INTO `yyx_menu` VALUES ('8', '管理组', '/admin/manageGroup/', '5', '1', '0', '0');
INSERT INTO `yyx_menu` VALUES ('9', '商城管理', '/admin/exchange/', '0', '1', '0', '0');
INSERT INTO `yyx_menu` VALUES ('10', '兑换抽奖', '/admin/exchange/', '9', '1', '0', '0');
INSERT INTO `yyx_menu` VALUES ('11', '商品管理', '/admin/goods/', '9', '1', '0', '0');
INSERT INTO `yyx_menu` VALUES ('12', '用户管理', '/admin/user/', '0', '1', '0', '0');
INSERT INTO `yyx_menu` VALUES ('13', '用户', '/admin/user/', '12', '1', '0', '0');
INSERT INTO `yyx_menu` VALUES ('14', '充值', '/admin/recharge/', '12', '1', '0', '0');
INSERT INTO `yyx_menu` VALUES ('15', '竞猜管理', '/admin/guess/', '0', '1', '0', '0');
INSERT INTO `yyx_menu` VALUES ('16', '竞猜坐庄', '/admin/guess/', '15', '1', '0', '0');
INSERT INTO `yyx_menu` VALUES ('17', '竞猜分类', '/admin/guessCategory/', '15', '1', '0', '0');
INSERT INTO `yyx_menu` VALUES ('18', '竞猜点', '/admin/guessPoint/', '15', '1', '0', '0');
INSERT INTO `yyx_menu` VALUES ('19', '竞猜玩法', '/admin/playWay/', '15', '1', '0', '0');
INSERT INTO `yyx_menu` VALUES ('20', '文章管理', '/admin/news/', '0', '1', '0', '0');
INSERT INTO `yyx_menu` VALUES ('21', '文章管理', '/admin/news/', '20', '1', '0', '0');
INSERT INTO `yyx_menu` VALUES ('22', '分类管理', '/admin/newsCategory/', '20', '1', '0', '0');
INSERT INTO `yyx_menu` VALUES ('23', '庄家认证', '/admin/makersAuth', '12', '1', '0', '0');
INSERT INTO `yyx_menu` VALUES ('24', '微博管理', '/admin/weibo/', '1', '1', '0', '0');
INSERT INTO `yyx_menu` VALUES ('25', '自定义类型', '/admin/customType/', '15', '1', '0', '0');

-- ----------------------------
-- Table structure for `yyx_message`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_message`;
CREATE TABLE `yyx_message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发信人，0为系统',
  `to_uid` int(11) unsigned NOT NULL COMMENT '收信人',
  `reply_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '回复消息ID',
  `title` varchar(150) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text COMMENT '消息内容',
  `new` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否是新消息',
  `from_status` tinyint(1) NOT NULL DEFAULT '2' COMMENT '发信人消息状态  2：正常 1：删除 0：彻底删除',
  `to_status` tinyint(1) NOT NULL DEFAULT '2' COMMENT '收信人消息状态  2：正常 1：删除 0：彻底删除',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '发信时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='消息';

-- ----------------------------
-- Records of yyx_message
-- ----------------------------

-- ----------------------------
-- Table structure for `yyx_news`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_news`;
CREATE TABLE `yyx_news` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL DEFAULT '' COMMENT '标题',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '资讯类型',
  `cate_id` int(4) unsigned NOT NULL COMMENT '分类ID',
  `content` text COMMENT '内容',
  `views` int(11) NOT NULL DEFAULT '0' COMMENT '浏览数',
  `sort_num` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='资讯';

-- ----------------------------
-- Records of yyx_news
-- ----------------------------

-- ----------------------------
-- Table structure for `yyx_news_category`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_news_category`;
CREATE TABLE `yyx_news_category` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL DEFAULT '' COMMENT '名称',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '分类类型',
  `sort_num` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='资讯分类';

-- ----------------------------
-- Records of yyx_news_category
-- ----------------------------
INSERT INTO `yyx_news_category` VALUES ('1', '说明文档', '0', '0');
INSERT INTO `yyx_news_category` VALUES ('2', '关于我们', '0', '0');

-- ----------------------------
-- Table structure for `yyx_notice`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_notice`;
CREATE TABLE `yyx_notice` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '动作发起人 0为系统',
  `to_uid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '通知接收人',
  `type` varchar(20) NOT NULL DEFAULT '' COMMENT '通知类型',
  `new` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否是新通知',
  `notice` text NOT NULL COMMENT '通知',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '通知时间',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '0无效/1未响应/2通过/3拒绝',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yyx_notice
-- ----------------------------

-- ----------------------------
-- Table structure for `yyx_password_find`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_password_find`;
CREATE TABLE `yyx_password_find` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT '用户ID',
  `code` varchar(32) NOT NULL COMMENT '分配码',
  `deadline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '过期时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='找回密码';

-- ----------------------------
-- Records of yyx_password_find
-- ----------------------------

-- ----------------------------
-- Table structure for `yyx_play`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_play`;
CREATE TABLE `yyx_play` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL COMMENT '参与用户',
  `custom` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '竟猜类型 0:系统玩法 1:自定义',
  `guess_id` int(11) unsigned NOT NULL COMMENT '参与的竞猜',
  `wealth_type` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '竟猜财富类型 1为金币 2为积分, 自定义竟猜见详细',
  `wealth` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '总投注',
  `win_wealth` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '总赢财富',
  `play_datas` text COMMENT '竞猜数据 PlayData类型数组',
  `status` tinyint(1) unsigned DEFAULT '0' COMMENT '竞猜是否已判定 1:已判定 0:未判定',
  `create_time` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='竞猜参与';

-- ----------------------------
-- Records of yyx_play
-- ----------------------------

-- ----------------------------
-- Table structure for `yyx_play_way`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_play_way`;
CREATE TABLE `yyx_play_way` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL DEFAULT '' COMMENT '名称',
  `class` varchar(30) NOT NULL COMMENT '玩法类名，用与区别其它玩法,用于加载玩法解析器',
  `parameter` text COMMENT '玩法参数,序列化参数类',
  `summary` text COMMENT '玩法简介',
  `news_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '玩法说明资讯ID',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '玩法使用状态 0：禁用，1：使用，默认为0，一旦开启就无法修改、删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='竞猜玩法';

-- ----------------------------
-- Records of yyx_play_way
-- ----------------------------
INSERT INTO `yyx_play_way` VALUES ('1', '猜胜负玩法', 'WinOrLost', 'O:16:\"PlayWayParameter\":5:{s:22:\"\0PlayWayParameter\0name\";s:2:\"vd\";s:23:\"\0PlayWayParameter\0label\";s:6:\"胜负\";s:29:\"\0PlayWayParameter\0description\";N;s:25:\"\0PlayWayParameter\0options\";a:0:{}s:23:\"\0PlayWayParameter\0value\";N;}', '猜胜负玩法,适用于比赛类(如足球)', '1', '1');
INSERT INTO `yyx_play_way` VALUES ('2', '猜总进球数', 'TotalGoal', 'O:16:\"PlayWayParameter\":5:{s:22:\"\0PlayWayParameter\0name\";s:4:\"goal\";s:23:\"\0PlayWayParameter\0label\";s:12:\"总进球数\";s:29:\"\0PlayWayParameter\0description\";N;s:25:\"\0PlayWayParameter\0options\";a:5:{i:0;O:22:\"PlayWayParameterOption\":6:{s:29:\"\0PlayWayParameterOption\0label\";s:4:\"0球\";s:28:\"\0PlayWayParameterOption\0type\";s:4:\"text\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:1:\"0\";s:32:\"\0PlayWayParameterOption\0minValue\";N;s:32:\"\0PlayWayParameterOption\0maxValue\";N;}i:1;O:22:\"PlayWayParameterOption\":6:{s:29:\"\0PlayWayParameterOption\0label\";s:4:\"1球\";s:28:\"\0PlayWayParameterOption\0type\";s:4:\"text\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:1:\"1\";s:32:\"\0PlayWayParameterOption\0minValue\";N;s:32:\"\0PlayWayParameterOption\0maxValue\";N;}i:2;O:22:\"PlayWayParameterOption\":6:{s:29:\"\0PlayWayParameterOption\0label\";s:4:\"2球\";s:28:\"\0PlayWayParameterOption\0type\";s:4:\"text\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:1:\"2\";s:32:\"\0PlayWayParameterOption\0minValue\";N;s:32:\"\0PlayWayParameterOption\0maxValue\";N;}i:3;O:22:\"PlayWayParameterOption\":6:{s:29:\"\0PlayWayParameterOption\0label\";s:4:\"3球\";s:28:\"\0PlayWayParameterOption\0type\";s:4:\"text\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:1:\"3\";s:32:\"\0PlayWayParameterOption\0minValue\";N;s:32:\"\0PlayWayParameterOption\0maxValue\";N;}s:2:\"4-\";O:22:\"PlayWayParameterOption\":6:{s:29:\"\0PlayWayParameterOption\0label\";s:10:\"4球以上\";s:28:\"\0PlayWayParameterOption\0type\";s:5:\"range\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:2:\"4-\";s:32:\"\0PlayWayParameterOption\0minValue\";s:1:\"4\";s:32:\"\0PlayWayParameterOption\0maxValue\";N;}}s:23:\"\0PlayWayParameter\0value\";N;}', '猜总进球数玩法,适用于比赛类(如足球)', '0', '1');
INSERT INTO `yyx_play_way` VALUES ('3', '猜比分', 'Score', 'O:16:\"PlayWayParameter\":5:{s:22:\"\0PlayWayParameter\0name\";s:4:\"goal\";s:23:\"\0PlayWayParameter\0label\";s:12:\"总进球数\";s:29:\"\0PlayWayParameter\0description\";N;s:25:\"\0PlayWayParameter\0options\";a:0:{}s:23:\"\0PlayWayParameter\0value\";N;}', '猜比分,适用于比赛类(如足球)', '0', '1');
INSERT INTO `yyx_play_way` VALUES ('4', '末位单双', 'LastSingleOrDouble', 'O:16:\"PlayWayParameter\":5:{s:22:\"\0PlayWayParameter\0name\";s:2:\"sd\";s:23:\"\0PlayWayParameter\0label\";s:12:\"末位单双\";s:29:\"\0PlayWayParameter\0description\";N;s:25:\"\0PlayWayParameter\0options\";a:2:{i:1;O:22:\"PlayWayParameterOption\":6:{s:29:\"\0PlayWayParameterOption\0label\";s:6:\"单数\";s:28:\"\0PlayWayParameterOption\0type\";s:4:\"text\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:1:\"1\";s:32:\"\0PlayWayParameterOption\0minValue\";N;s:32:\"\0PlayWayParameterOption\0maxValue\";N;}i:2;O:22:\"PlayWayParameterOption\":6:{s:29:\"\0PlayWayParameterOption\0label\";s:6:\"双数\";s:28:\"\0PlayWayParameterOption\0type\";s:4:\"text\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:1:\"2\";s:32:\"\0PlayWayParameterOption\0minValue\";N;s:32:\"\0PlayWayParameterOption\0maxValue\";N;}}s:23:\"\0PlayWayParameter\0value\";N;}', '末位单双玩法,适用于财经或彩票', '0', '1');
INSERT INTO `yyx_play_way` VALUES ('5', '末位号码', 'LastNumber', 'O:16:\"PlayWayParameter\":5:{s:22:\"\0PlayWayParameter\0name\";s:2:\"sd\";s:23:\"\0PlayWayParameter\0label\";s:12:\"末位号码\";s:29:\"\0PlayWayParameter\0description\";N;s:25:\"\0PlayWayParameter\0options\";a:10:{i:0;O:22:\"PlayWayParameterOption\":6:{s:29:\"\0PlayWayParameterOption\0label\";s:1:\"0\";s:28:\"\0PlayWayParameterOption\0type\";s:4:\"text\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:1:\"0\";s:32:\"\0PlayWayParameterOption\0minValue\";N;s:32:\"\0PlayWayParameterOption\0maxValue\";N;}i:1;O:22:\"PlayWayParameterOption\":6:{s:29:\"\0PlayWayParameterOption\0label\";s:1:\"1\";s:28:\"\0PlayWayParameterOption\0type\";s:4:\"text\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:1:\"1\";s:32:\"\0PlayWayParameterOption\0minValue\";N;s:32:\"\0PlayWayParameterOption\0maxValue\";N;}i:2;O:22:\"PlayWayParameterOption\":6:{s:29:\"\0PlayWayParameterOption\0label\";s:1:\"2\";s:28:\"\0PlayWayParameterOption\0type\";s:4:\"text\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:1:\"2\";s:32:\"\0PlayWayParameterOption\0minValue\";N;s:32:\"\0PlayWayParameterOption\0maxValue\";N;}i:3;O:22:\"PlayWayParameterOption\":6:{s:29:\"\0PlayWayParameterOption\0label\";s:1:\"3\";s:28:\"\0PlayWayParameterOption\0type\";s:4:\"text\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:1:\"3\";s:32:\"\0PlayWayParameterOption\0minValue\";N;s:32:\"\0PlayWayParameterOption\0maxValue\";N;}i:4;O:22:\"PlayWayParameterOption\":6:{s:29:\"\0PlayWayParameterOption\0label\";s:1:\"4\";s:28:\"\0PlayWayParameterOption\0type\";s:4:\"text\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:1:\"4\";s:32:\"\0PlayWayParameterOption\0minValue\";N;s:32:\"\0PlayWayParameterOption\0maxValue\";N;}i:5;O:22:\"PlayWayParameterOption\":6:{s:29:\"\0PlayWayParameterOption\0label\";s:1:\"5\";s:28:\"\0PlayWayParameterOption\0type\";s:4:\"text\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:1:\"5\";s:32:\"\0PlayWayParameterOption\0minValue\";N;s:32:\"\0PlayWayParameterOption\0maxValue\";N;}i:6;O:22:\"PlayWayParameterOption\":6:{s:29:\"\0PlayWayParameterOption\0label\";s:1:\"6\";s:28:\"\0PlayWayParameterOption\0type\";s:4:\"text\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:1:\"6\";s:32:\"\0PlayWayParameterOption\0minValue\";N;s:32:\"\0PlayWayParameterOption\0maxValue\";N;}i:7;O:22:\"PlayWayParameterOption\":6:{s:29:\"\0PlayWayParameterOption\0label\";s:1:\"7\";s:28:\"\0PlayWayParameterOption\0type\";s:4:\"text\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:1:\"7\";s:32:\"\0PlayWayParameterOption\0minValue\";N;s:32:\"\0PlayWayParameterOption\0maxValue\";N;}i:8;O:22:\"PlayWayParameterOption\":6:{s:29:\"\0PlayWayParameterOption\0label\";s:1:\"8\";s:28:\"\0PlayWayParameterOption\0type\";s:4:\"text\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:1:\"8\";s:32:\"\0PlayWayParameterOption\0minValue\";N;s:32:\"\0PlayWayParameterOption\0maxValue\";N;}i:9;O:22:\"PlayWayParameterOption\":6:{s:29:\"\0PlayWayParameterOption\0label\";s:1:\"9\";s:28:\"\0PlayWayParameterOption\0type\";s:4:\"text\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:1:\"9\";s:32:\"\0PlayWayParameterOption\0minValue\";N;s:32:\"\0PlayWayParameterOption\0maxValue\";N;}}s:23:\"\0PlayWayParameter\0value\";N;}', '末位号码玩法,适用于财经或彩票', '0', '1');
INSERT INTO `yyx_play_way` VALUES ('6', '末位范围', 'LastRange', 'O:16:\"PlayWayParameter\":5:{s:22:\"\0PlayWayParameter\0name\";s:2:\"sd\";s:23:\"\0PlayWayParameter\0label\";s:12:\"末位范围\";s:29:\"\0PlayWayParameter\0description\";N;s:25:\"\0PlayWayParameter\0options\";a:2:{s:3:\"0-4\";O:22:\"PlayWayParameterOption\":6:{s:29:\"\0PlayWayParameterOption\0label\";s:3:\"0-4\";s:28:\"\0PlayWayParameterOption\0type\";s:5:\"range\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:3:\"0-4\";s:32:\"\0PlayWayParameterOption\0minValue\";s:1:\"0\";s:32:\"\0PlayWayParameterOption\0maxValue\";s:1:\"4\";}s:3:\"5-9\";O:22:\"PlayWayParameterOption\":6:{s:29:\"\0PlayWayParameterOption\0label\";s:3:\"5-9\";s:28:\"\0PlayWayParameterOption\0type\";s:5:\"range\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:3:\"5-9\";s:32:\"\0PlayWayParameterOption\0minValue\";s:1:\"5\";s:32:\"\0PlayWayParameterOption\0maxValue\";s:1:\"9\";}}s:23:\"\0PlayWayParameter\0value\";N;}', '末位范围玩法,适用于财经或彩票', '0', '1');
INSERT INTO `yyx_play_way` VALUES ('7', '首位号码玩法', 'FirstNumber', 'O:16:\"PlayWayParameter\":5:{s:22:\"\0PlayWayParameter\0name\";s:2:\"sd\";s:23:\"\0PlayWayParameter\0label\";s:12:\"首位号码\";s:29:\"\0PlayWayParameter\0description\";N;s:25:\"\0PlayWayParameter\0options\";a:10:{i:0;O:22:\"PlayWayParameterOption\":7:{s:29:\"\0PlayWayParameterOption\0label\";s:1:\"0\";s:28:\"\0PlayWayParameterOption\0type\";s:4:\"text\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:1:\"0\";s:32:\"\0PlayWayParameterOption\0minValue\";N;s:32:\"\0PlayWayParameterOption\0maxValue\";N;s:33:\"\0PlayWayParameterOption\0playCount\";i:0;}i:1;O:22:\"PlayWayParameterOption\":7:{s:29:\"\0PlayWayParameterOption\0label\";s:1:\"1\";s:28:\"\0PlayWayParameterOption\0type\";s:4:\"text\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:1:\"1\";s:32:\"\0PlayWayParameterOption\0minValue\";N;s:32:\"\0PlayWayParameterOption\0maxValue\";N;s:33:\"\0PlayWayParameterOption\0playCount\";i:0;}i:2;O:22:\"PlayWayParameterOption\":7:{s:29:\"\0PlayWayParameterOption\0label\";s:1:\"2\";s:28:\"\0PlayWayParameterOption\0type\";s:4:\"text\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:1:\"2\";s:32:\"\0PlayWayParameterOption\0minValue\";N;s:32:\"\0PlayWayParameterOption\0maxValue\";N;s:33:\"\0PlayWayParameterOption\0playCount\";i:0;}i:3;O:22:\"PlayWayParameterOption\":7:{s:29:\"\0PlayWayParameterOption\0label\";s:1:\"3\";s:28:\"\0PlayWayParameterOption\0type\";s:4:\"text\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:1:\"3\";s:32:\"\0PlayWayParameterOption\0minValue\";N;s:32:\"\0PlayWayParameterOption\0maxValue\";N;s:33:\"\0PlayWayParameterOption\0playCount\";i:0;}i:4;O:22:\"PlayWayParameterOption\":7:{s:29:\"\0PlayWayParameterOption\0label\";s:1:\"4\";s:28:\"\0PlayWayParameterOption\0type\";s:4:\"text\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:1:\"4\";s:32:\"\0PlayWayParameterOption\0minValue\";N;s:32:\"\0PlayWayParameterOption\0maxValue\";N;s:33:\"\0PlayWayParameterOption\0playCount\";i:0;}i:5;O:22:\"PlayWayParameterOption\":7:{s:29:\"\0PlayWayParameterOption\0label\";s:1:\"5\";s:28:\"\0PlayWayParameterOption\0type\";s:4:\"text\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:1:\"5\";s:32:\"\0PlayWayParameterOption\0minValue\";N;s:32:\"\0PlayWayParameterOption\0maxValue\";N;s:33:\"\0PlayWayParameterOption\0playCount\";i:0;}i:6;O:22:\"PlayWayParameterOption\":7:{s:29:\"\0PlayWayParameterOption\0label\";s:1:\"6\";s:28:\"\0PlayWayParameterOption\0type\";s:4:\"text\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:1:\"6\";s:32:\"\0PlayWayParameterOption\0minValue\";N;s:32:\"\0PlayWayParameterOption\0maxValue\";N;s:33:\"\0PlayWayParameterOption\0playCount\";i:0;}i:7;O:22:\"PlayWayParameterOption\":7:{s:29:\"\0PlayWayParameterOption\0label\";s:1:\"7\";s:28:\"\0PlayWayParameterOption\0type\";s:4:\"text\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:1:\"7\";s:32:\"\0PlayWayParameterOption\0minValue\";N;s:32:\"\0PlayWayParameterOption\0maxValue\";N;s:33:\"\0PlayWayParameterOption\0playCount\";i:0;}i:8;O:22:\"PlayWayParameterOption\":7:{s:29:\"\0PlayWayParameterOption\0label\";s:1:\"8\";s:28:\"\0PlayWayParameterOption\0type\";s:4:\"text\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:1:\"8\";s:32:\"\0PlayWayParameterOption\0minValue\";N;s:32:\"\0PlayWayParameterOption\0maxValue\";N;s:33:\"\0PlayWayParameterOption\0playCount\";i:0;}i:9;O:22:\"PlayWayParameterOption\":7:{s:29:\"\0PlayWayParameterOption\0label\";s:1:\"9\";s:28:\"\0PlayWayParameterOption\0type\";s:4:\"text\";s:35:\"\0PlayWayParameterOption\0description\";N;s:29:\"\0PlayWayParameterOption\0value\";s:1:\"9\";s:32:\"\0PlayWayParameterOption\0minValue\";N;s:32:\"\0PlayWayParameterOption\0maxValue\";N;s:33:\"\0PlayWayParameterOption\0playCount\";i:0;}}s:23:\"\0PlayWayParameter\0value\";N;}', '首位号码玩法,适用于财经或彩票', '0', '0');

-- ----------------------------
-- Table structure for `yyx_province`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_province`;
CREATE TABLE `yyx_province` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yyx_province
-- ----------------------------
INSERT INTO `yyx_province` VALUES ('1', '北京市');
INSERT INTO `yyx_province` VALUES ('2', '天津市');
INSERT INTO `yyx_province` VALUES ('3', '上海市');
INSERT INTO `yyx_province` VALUES ('4', '重庆市');
INSERT INTO `yyx_province` VALUES ('5', '河北省');
INSERT INTO `yyx_province` VALUES ('6', '山西省');
INSERT INTO `yyx_province` VALUES ('7', '台湾省');
INSERT INTO `yyx_province` VALUES ('8', '辽宁省');
INSERT INTO `yyx_province` VALUES ('9', '吉林省');
INSERT INTO `yyx_province` VALUES ('10', '黑龙江省');
INSERT INTO `yyx_province` VALUES ('11', '江苏省');
INSERT INTO `yyx_province` VALUES ('12', '浙江省');
INSERT INTO `yyx_province` VALUES ('13', '安徽省');
INSERT INTO `yyx_province` VALUES ('14', '福建省');
INSERT INTO `yyx_province` VALUES ('15', '江西省');
INSERT INTO `yyx_province` VALUES ('16', '山东省');
INSERT INTO `yyx_province` VALUES ('17', '河南省');
INSERT INTO `yyx_province` VALUES ('18', '湖北省');
INSERT INTO `yyx_province` VALUES ('19', '湖南省');
INSERT INTO `yyx_province` VALUES ('20', '广东省');
INSERT INTO `yyx_province` VALUES ('21', '甘肃省');
INSERT INTO `yyx_province` VALUES ('22', '四川省');
INSERT INTO `yyx_province` VALUES ('23', '贵州省');
INSERT INTO `yyx_province` VALUES ('24', '海南省');
INSERT INTO `yyx_province` VALUES ('25', '云南省');
INSERT INTO `yyx_province` VALUES ('26', '青海省');
INSERT INTO `yyx_province` VALUES ('27', '陕西省');
INSERT INTO `yyx_province` VALUES ('28', '广西壮族自治区');
INSERT INTO `yyx_province` VALUES ('29', '西藏自治区');
INSERT INTO `yyx_province` VALUES ('30', '宁夏回族自治区');
INSERT INTO `yyx_province` VALUES ('31', '新疆维吾尔自治区');
INSERT INTO `yyx_province` VALUES ('32', '内蒙古自治区');
INSERT INTO `yyx_province` VALUES ('33', '澳门特别行政区');
INSERT INTO `yyx_province` VALUES ('34', '香港特别行政区');

-- ----------------------------
-- Table structure for `yyx_recharge`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_recharge`;
CREATE TABLE `yyx_recharge` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `sn` varchar(20) NOT NULL COMMENT '充值编号',
  `user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `money` int(11) NOT NULL DEFAULT '0' COMMENT '充值的金额',
  `pay_type` varchar(20) NOT NULL COMMENT '支付类型, alipay:支付宝，bank:网银 offline:线下',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '充值状态 0:未支付 1：成功',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '注册时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='充值';

-- ----------------------------
-- Records of yyx_recharge
-- ----------------------------

-- ----------------------------
-- Table structure for `yyx_share`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_share`;
CREATE TABLE `yyx_share` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` smallint(4) NOT NULL COMMENT '分享类型 1:微博',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户',
  `share_id` int(11) NOT NULL DEFAULT '0' COMMENT '分享内容ID',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`,`user_id`,`share_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='分享记录';

-- ----------------------------
-- Records of yyx_share
-- ----------------------------

-- ----------------------------
-- Table structure for `yyx_user`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_user`;
CREATE TABLE `yyx_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `avatar` varchar(150) NOT NULL DEFAULT '' COMMENT '头像',
  `sex` tinyint(1) NOT NULL DEFAULT '1' COMMENT '性别 0:未知 1:男 2:女',
  `birthday_year` smallint(4) NOT NULL COMMENT '生日:年',
  `birthday_month` tinyint(2) NOT NULL DEFAULT '0' COMMENT '生日:月',
  `birthday_day` tinyint(2) NOT NULL DEFAULT '0' COMMENT '生日:日',
  `mobile` varchar(15) NOT NULL DEFAULT '' COMMENT '手机号码',
  `qq` varchar(15) NOT NULL DEFAULT '' COMMENT 'QQ号码',
  `province` varchar(50) DEFAULT NULL COMMENT '省份',
  `city` varchar(50) DEFAULT NULL COMMENT '城市',
  `area` varchar(50) DEFAULT NULL COMMENT '地区',
  `address` varchar(150) NOT NULL DEFAULT '' COMMENT '现居住地',
  `sign` text NOT NULL COMMENT '个性签名',
  `website` varchar(150) NOT NULL DEFAULT '' COMMENT '个性网址',
  `sina_weibo` varchar(150) NOT NULL DEFAULT '' COMMENT '新浪weibo',
  `qq_weibo` varchar(150) NOT NULL DEFAULT '' COMMENT '腾讯weibo',
  `available_money` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '可用金额',
  `freeze_money` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '冻结的金额',
  `available_integral` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '可用积分',
  `freeze_integral` double(10,2) NOT NULL DEFAULT '0.00' COMMENT '冻结的积分',
  `views` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '被查看次数',
  `makers_level` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '庄家级别',
  `guess_add_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '坐庄次数',
  `guess_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '竞猜次数',
  `accuracy` tinyint(2) unsigned NOT NULL DEFAULT '100' COMMENT '竞猜准确率',
  `fan_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '粉丝次数',
  `follow_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关注次数',
  `allow_login` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否允许登陆 0：不允许 1：允许',
  `last_login_time` int(10) NOT NULL DEFAULT '0' COMMENT '上次登陆时间',
  `configs` text NOT NULL COMMENT '个人设置,序列化',
  `register_time` int(10) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `friend` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Table structure for `yyx_user_guess`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_user_guess`;
CREATE TABLE `yyx_user_guess` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `from_uid` int(11) unsigned NOT NULL COMMENT '主动用户',
  `to_uid` int(11) unsigned NOT NULL COMMENT '被动用户',
  `guess_id` int(11) unsigned NOT NULL COMMENT '参与的竞猜',
  `type` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '关系类型 1:我关注的竞猜 2:邀请我参与的竞猜',
  `create_time` int(10) unsigned DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `to_uid` (`to_uid`,`guess_id`,`type`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='用户－竞猜对应表';

-- ----------------------------
-- Records of yyx_user_guess
-- ----------------------------

-- ----------------------------
-- Table structure for `yyx_weibo`
-- ----------------------------
DROP TABLE IF EXISTS `yyx_weibo`;
CREATE TABLE `yyx_weibo` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `logo` varchar(200) NOT NULL DEFAULT '' COMMENT 'logo图片',
  `type` varchar(50) DEFAULT NULL COMMENT '类型代码',
  `app_key` varchar(100) DEFAULT NULL COMMENT '应用KEY',
  `app_secret` varchar(100) DEFAULT NULL COMMENT '应用KEY',
  `url` varchar(200) NOT NULL DEFAULT '' COMMENT '链接地址',
  `sort_num` smallint(4) DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) DEFAULT '1' COMMENT '0：不显示，1：显示，默认为1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='微博';

-- ----------------------------
-- Records of yyx_weibo
-- ----------------------------
INSERT INTO `yyx_weibo` VALUES ('1', '新浪微博', '', 'sina', '', '', 'http://www.weibo.com', '1', '1');
INSERT INTO `yyx_weibo` VALUES ('2', '腾讯微博', '', 'qq', '', '', 't.qq.com', '0', '0');