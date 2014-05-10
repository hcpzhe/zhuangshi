/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : fangyi

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2014-05-10 11:44:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `site_admanage`
-- ----------------------------
DROP TABLE IF EXISTS `site_admanage`;
CREATE TABLE `site_admanage` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `classid` smallint(5) unsigned NOT NULL,
  `parentid` smallint(5) unsigned NOT NULL,
  `parentstr` varchar(80) NOT NULL,
  `title` varchar(30) NOT NULL,
  `admode` char(10) NOT NULL,
  `picurl` varchar(100) NOT NULL,
  `adtext` text NOT NULL,
  `linkurl` varchar(255) NOT NULL,
  `orderid` smallint(5) unsigned NOT NULL,
  `posttime` int(10) unsigned NOT NULL,
  `checkinfo` enum('true','false') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_admanage
-- ----------------------------

-- ----------------------------
-- Table structure for `site_admin`
-- ----------------------------
DROP TABLE IF EXISTS `site_admin`;
CREATE TABLE `site_admin` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` char(32) NOT NULL,
  `loginip` char(20) NOT NULL,
  `logintime` int(10) unsigned NOT NULL,
  `levelname` tinyint(1) unsigned NOT NULL,
  `checkadmin` enum('true','false') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_admin
-- ----------------------------
INSERT INTO `site_admin` VALUES ('1', 'admin', 'c3284d0f94606de1fd2af172aba15bf3', '127.0.0.1', '1399690393', '0', 'true');

-- ----------------------------
-- Table structure for `site_adtype`
-- ----------------------------
DROP TABLE IF EXISTS `site_adtype`;
CREATE TABLE `site_adtype` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` smallint(5) unsigned NOT NULL,
  `parentstr` varchar(50) NOT NULL,
  `classname` varchar(30) NOT NULL,
  `width` smallint(5) unsigned NOT NULL,
  `height` smallint(5) unsigned NOT NULL,
  `orderid` smallint(5) unsigned NOT NULL,
  `checkinfo` enum('true','false') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_adtype
-- ----------------------------

-- ----------------------------
-- Table structure for `site_diyfield`
-- ----------------------------
DROP TABLE IF EXISTS `site_diyfield`;
CREATE TABLE `site_diyfield` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `infotype` tinyint(1) unsigned NOT NULL COMMENT '所属模型',
  `fieldname` varchar(30) NOT NULL COMMENT '字段名称',
  `fieldtitle` varchar(30) NOT NULL COMMENT '字段标题',
  `fielddesc` varchar(255) NOT NULL COMMENT '字段提示',
  `fieldtype` varchar(30) NOT NULL COMMENT '字段类型',
  `fieldlong` varchar(10) NOT NULL COMMENT '字段长度',
  `fieldsel` varchar(255) NOT NULL COMMENT '字段选项值',
  `fieldcheck` varchar(80) NOT NULL COMMENT '校验正则',
  `fieldcback` varchar(30) NOT NULL COMMENT '未通过提示',
  `orderid` smallint(6) NOT NULL COMMENT '排列排序',
  `checkinfo` enum('true','false') NOT NULL COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_diyfield
-- ----------------------------
INSERT INTO `site_diyfield` VALUES ('16', '2', 'sjfg', '设计风格', '装修设计风格, 非 \"装修案例\" 忽略此选项', 'select', '50', '现代简约=1,简欧=2,田园=3,地中海=4,欧式=5,中式=6,后现代=7,美式=8,简美=9,其他=10', '', '', '7', 'true');
INSERT INTO `site_diyfield` VALUES ('17', '2', 'kjxg', '空间效果', '装修空间效果图, 非 \"装修案例\" 忽略此选项', 'select', '50', '小户型=1,二居=2,三居=3,复式=4,大户型=5,样板间=6,商业空间=7,其他=8', '', '', '8', 'true');
INSERT INTO `site_diyfield` VALUES ('18', '2', 'zxmj', '装修面积', '非 \"装修案例\" 忽略此选项', 'select', '50', '80㎡以下=1,80-120㎡=2,120-180㎡=3,180-250㎡=4,250-500㎡=5,500㎡以上=6', '', '', '9', 'true');
INSERT INTO `site_diyfield` VALUES ('19', '2', 'bssj', '别墅设计', '非 \"装修案例\" 忽略此选项', 'select', '50', '中式典雅=1,北美风情=2,欧陆传奇=3,现代奢华=4,东南亚自然之美他=5', '', '', '10', 'true');
INSERT INTO `site_diyfield` VALUES ('13', '1', 'mianji', '面积', '', 'varchar', '255', '', '', '', '5', 'true');
INSERT INTO `site_diyfield` VALUES ('14', '1', 'yusuan', '预算', '', 'varchar', '255', '', '', '', '6', 'true');

-- ----------------------------
-- Table structure for `site_diymenu`
-- ----------------------------
DROP TABLE IF EXISTS `site_diymenu`;
CREATE TABLE `site_diymenu` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` smallint(5) unsigned NOT NULL,
  `classname` varchar(30) NOT NULL,
  `linkurl` varchar(255) NOT NULL,
  `orderid` smallint(5) unsigned NOT NULL,
  `checkinfo` enum('true','false') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_diymenu
-- ----------------------------
INSERT INTO `site_diymenu` VALUES ('1', '0', '留言模块管理', '', '0', 'false');
INSERT INTO `site_diymenu` VALUES ('2', '1', '留言管理', 'message.php', '1', 'true');
INSERT INTO `site_diymenu` VALUES ('3', '1', '添加留言', 'message_add.php', '2', 'true');
INSERT INTO `site_diymenu` VALUES ('4', '0', '友情链接管理', '', '3', 'false');
INSERT INTO `site_diymenu` VALUES ('5', '4', '友情链接管理', 'weblink.php', '4', 'true');
INSERT INTO `site_diymenu` VALUES ('6', '4', '友情链接添加', 'weblink_add.php', '5', 'true');
INSERT INTO `site_diymenu` VALUES ('7', '0', '广告模块管理', '', '6', 'false');
INSERT INTO `site_diymenu` VALUES ('8', '7', '广告管理', 'admanage.php', '7', 'true');
INSERT INTO `site_diymenu` VALUES ('9', '7', '添加广告', 'admanage_add.php', '8', 'true');
INSERT INTO `site_diymenu` VALUES ('10', '0', '会员模块管理', '', '9', 'false');
INSERT INTO `site_diymenu` VALUES ('11', '10', '会员管理', 'member.php', '10', 'true');
INSERT INTO `site_diymenu` VALUES ('12', '10', '添加会员', 'member_add.php', '11', 'true');
INSERT INTO `site_diymenu` VALUES ('13', '0', '招聘信息管理', '', '12', 'false');
INSERT INTO `site_diymenu` VALUES ('14', '13', '招聘管理', 'job.php', '13', 'true');
INSERT INTO `site_diymenu` VALUES ('15', '13', '添加招聘', 'job_add.php', '14', 'true');

-- ----------------------------
-- Table structure for `site_failedlogin`
-- ----------------------------
DROP TABLE IF EXISTS `site_failedlogin`;
CREATE TABLE `site_failedlogin` (
  `username` char(30) NOT NULL,
  `ip` char(15) NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `num` tinyint(1) NOT NULL,
  `isadmin` tinyint(1) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_failedlogin
-- ----------------------------

-- ----------------------------
-- Table structure for `site_getmode`
-- ----------------------------
DROP TABLE IF EXISTS `site_getmode`;
CREATE TABLE `site_getmode` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `classname` varchar(30) NOT NULL,
  `orderid` smallint(5) unsigned NOT NULL,
  `checkinfo` enum('true','false') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_getmode
-- ----------------------------

-- ----------------------------
-- Table structure for `site_goods`
-- ----------------------------
DROP TABLE IF EXISTS `site_goods`;
CREATE TABLE `site_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `classid` smallint(5) unsigned NOT NULL,
  `parentid` smallint(5) unsigned NOT NULL,
  `parentstr` varchar(80) NOT NULL,
  `brandid` smallint(5) NOT NULL,
  `brandpid` smallint(5) NOT NULL,
  `brandpstr` varchar(80) NOT NULL,
  `title` varchar(80) NOT NULL,
  `colorval` char(10) NOT NULL,
  `boldval` char(10) NOT NULL,
  `flag` varchar(30) NOT NULL,
  `goodsid` varchar(30) NOT NULL,
  `payfreight` enum('0','1') NOT NULL,
  `weight` varchar(10) NOT NULL,
  `attrid` varchar(50) NOT NULL,
  `attrvalue` varchar(200) NOT NULL,
  `marketprice` char(10) NOT NULL,
  `salesprice` char(10) NOT NULL,
  `memberprice` char(10) NOT NULL,
  `housenum` smallint(5) unsigned NOT NULL,
  `housewarn` enum('true','false') NOT NULL,
  `warnnum` smallint(5) unsigned NOT NULL,
  `integral` char(10) NOT NULL,
  `author` varchar(30) NOT NULL,
  `linkurl` varchar(255) NOT NULL,
  `keywords` varchar(30) NOT NULL,
  `description` varchar(255) NOT NULL,
  `content` mediumtext NOT NULL,
  `picurl` varchar(100) NOT NULL,
  `picarr` text NOT NULL,
  `hits` int(10) unsigned NOT NULL,
  `orderid` int(10) unsigned NOT NULL,
  `posttime` int(10) unsigned NOT NULL,
  `checkinfo` enum('true','false') NOT NULL,
  `delstate` set('true') NOT NULL,
  `deltime` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `site_goodsattr`
-- ----------------------------
DROP TABLE IF EXISTS `site_goodsattr`;
CREATE TABLE `site_goodsattr` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `classname` varchar(30) NOT NULL,
  `orderid` mediumint(8) unsigned NOT NULL,
  `checkinfo` enum('true','false') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_goodsattr
-- ----------------------------

-- ----------------------------
-- Table structure for `site_goodsbrand`
-- ----------------------------
DROP TABLE IF EXISTS `site_goodsbrand`;
CREATE TABLE `site_goodsbrand` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` mediumint(8) unsigned NOT NULL,
  `parentstr` varchar(50) NOT NULL,
  `classname` varchar(30) NOT NULL,
  `picurl` varchar(100) NOT NULL,
  `linkurl` varchar(255) NOT NULL,
  `orderid` mediumint(10) unsigned NOT NULL,
  `checkinfo` enum('true','false') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_goodsbrand
-- ----------------------------

-- ----------------------------
-- Table structure for `site_goodsflag`
-- ----------------------------
DROP TABLE IF EXISTS `site_goodsflag`;
CREATE TABLE `site_goodsflag` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `flag` varchar(30) NOT NULL,
  `flagname` varchar(30) NOT NULL,
  `orderid` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_goodsflag
-- ----------------------------
INSERT INTO `site_goodsflag` VALUES ('1', 'c', '推荐', '0');
INSERT INTO `site_goodsflag` VALUES ('2', 'f', '幻灯', '1');
INSERT INTO `site_goodsflag` VALUES ('3', 'a', '特推', '2');
INSERT INTO `site_goodsflag` VALUES ('4', 't', '特价', '3');
INSERT INTO `site_goodsflag` VALUES ('5', 'h', '热卖', '4');

-- ----------------------------
-- Table structure for `site_goodsorder`
-- ----------------------------
DROP TABLE IF EXISTS `site_goodsorder`;
CREATE TABLE `site_goodsorder` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `attrvalue` text,
  `truename` varchar(30) DEFAULT NULL,
  `cardtype` enum('0','1','2') NOT NULL,
  `cardnum` varchar(30) NOT NULL,
  `telephone` varchar(30) NOT NULL,
  `zipcode` varchar(30) NOT NULL,
  `province` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `address` varchar(80) NOT NULL,
  `postid` varchar(50) NOT NULL,
  `postarea` mediumint(8) NOT NULL,
  `postmode` smallint(5) NOT NULL,
  `cost` int(10) NOT NULL,
  `paymode` smallint(5) NOT NULL,
  `getmode` smallint(5) NOT NULL,
  `weight` varchar(10) NOT NULL,
  `orderamount` int(10) NOT NULL,
  `moneytyle` int(10) NOT NULL,
  `integral` smallint(5) unsigned NOT NULL,
  `buyremark` text,
  `sendremark` text,
  `posttime` int(10) unsigned NOT NULL,
  `orderid` mediumint(10) unsigned NOT NULL,
  `checkinfo` varchar(255) NOT NULL,
  `core` set('true') NOT NULL,
  `delstate` set('true') NOT NULL,
  `deltime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_goodsorder
-- ----------------------------

-- ----------------------------
-- Table structure for `site_goodsreview`
-- ----------------------------
DROP TABLE IF EXISTS `site_goodsreview`;
CREATE TABLE `site_goodsreview` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `goodsid` int(10) unsigned NOT NULL,
  `nickname` varchar(30) NOT NULL,
  `content` text NOT NULL,
  `ip` char(20) NOT NULL,
  `orderid` mediumint(8) unsigned NOT NULL,
  `posttime` int(10) unsigned NOT NULL,
  `checkinfo` enum('true','false') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_goodsreview
-- ----------------------------

-- ----------------------------
-- Table structure for `site_goodstype`
-- ----------------------------
DROP TABLE IF EXISTS `site_goodstype`;
CREATE TABLE `site_goodstype` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` mediumint(8) unsigned NOT NULL,
  `parentstr` varchar(50) NOT NULL,
  `classname` varchar(30) NOT NULL,
  `attrstr` varchar(50) NOT NULL,
  `picurl` varchar(255) DEFAULT NULL,
  `linkurl` varchar(255) DEFAULT NULL,
  `orderid` mediumint(8) unsigned NOT NULL,
  `checkinfo` enum('true','false') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_goodstype
-- ----------------------------

-- ----------------------------
-- Table structure for `site_info`
-- ----------------------------
DROP TABLE IF EXISTS `site_info`;
CREATE TABLE `site_info` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `classid` smallint(5) unsigned NOT NULL,
  `mainid` smallint(5) NOT NULL,
  `picurl` varchar(100) NOT NULL,
  `content` mediumtext NOT NULL,
  `posttime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_info
-- ----------------------------

-- ----------------------------
-- Table structure for `site_infoclass`
-- ----------------------------
DROP TABLE IF EXISTS `site_infoclass`;
CREATE TABLE `site_infoclass` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` smallint(5) unsigned NOT NULL,
  `parentstr` varchar(50) NOT NULL,
  `infotype` tinyint(1) unsigned NOT NULL,
  `classname` varchar(30) NOT NULL,
  `linkurl` varchar(255) NOT NULL,
  `picurl` varchar(100) NOT NULL,
  `seotitle` varchar(80) NOT NULL,
  `keywords` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `orderid` smallint(5) unsigned NOT NULL,
  `checkinfo` enum('true','false') NOT NULL,
  `adminmenu` set('true') NOT NULL,
  `menulevel` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_infoclass
-- ----------------------------
INSERT INTO `site_infoclass` VALUES ('1', '0', '0,', '0', '关于我们', '', '', '', '', '', '1', 'true', 'true', '0');
INSERT INTO `site_infoclass` VALUES ('2', '0', '0,', '2', '装修设计', '', '', '', '', '', '2', 'true', 'true', '0');
INSERT INTO `site_infoclass` VALUES ('3', '0', '0,', '2', '施工工艺', '', '', '', '', '', '3', 'true', 'true', '0');
INSERT INTO `site_infoclass` VALUES ('4', '0', '0,', '1', '装修入门', '', '', '', '', '', '4', 'true', 'true', '0');
INSERT INTO `site_infoclass` VALUES ('5', '1', '0,1,', '0', '方艺简介', '', '', '', '', '', '5', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('6', '1', '0,1,', '1', '材料推荐', '', '', '', '', '', '6', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('7', '1', '0,1,', '1', '家具百科', '', '', '', '', '', '7', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('8', '1', '0,1,', '0', '在线投诉', '', '', '', '', '', '8', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('9', '2', '0,2,', '2', '装修案例', '', '', '', '', '', '9', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('10', '2', '0,2,', '2', '设计团队', '', '', '', '', '', '10', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('11', '2', '0,2,', '2', '设计风格', '', '', '', '', '', '11', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('12', '2', '0,2,', '2', '户型搜索', '', '', '', '', '', '12', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('13', '3', '0,3,', '2', '施工管理', '', '', '', '', '', '13', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('14', '3', '0,3,', '1', '在建工地', '', '', '', '', '', '14', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('15', '3', '0,3,', '2', '工艺图解', '', '', '', '', '', '15', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('16', '3', '0,3,', '2', '装修日记', '', '', '', '', '', '16', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('17', '4', '0,4,', '1', '装修准备', '', '', '', '', '', '17', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('18', '4', '0,4,', '1', '设计规划', '', '', '', '', '', '18', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('19', '4', '0,4,', '1', '选材规划', '', '', '', '', '', '19', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('20', '4', '0,4,', '1', '施工验收', '', '', '', '', '', '20', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('21', '0', '0,', '0', '在线互动', '', '', '', '', '', '21', 'true', 'true', '0');
INSERT INTO `site_infoclass` VALUES ('22', '21', '0,21,', '0', '在线咨询', '', '', '', '', '', '22', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('23', '21', '0,21,', '0', '常见问题', '', '', '', '', '', '23', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('24', '21', '0,21,', '0', '在线报修', '', '', '', '', '', '24', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('25', '21', '0,21,', '2', '最新优惠', '', '', '', '', '', '25', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('26', '0', '0,', '2', '户型解析', '', '', '', '', '', '26', 'true', 'true', '0');
INSERT INTO `site_infoclass` VALUES ('27', '0', '0,', '1', '最新订单', '', '', '', '', '', '27', 'true', 'true', '0');
INSERT INTO `site_infoclass` VALUES ('28', '15', '0,3,15,', '2', '水电工艺规范', '', '', '', '', '', '28', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('29', '15', '0,3,15,', '2', '泥工工艺规范', '', '', '', '', '', '29', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('30', '15', '0,3,15,', '2', '木工工艺规范', '', '', '', '', '', '30', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('31', '15', '0,3,15,', '2', '油漆工艺规范', '', '', '', '', '', '31', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('32', '0', '0,', '1', '业主评价', '', '', '', '', '', '32', 'true', 'true', '0');
INSERT INTO `site_infoclass` VALUES ('33', '0', '0,', '2', '合作品牌', '', '', '', '', '', '33', 'true', 'true', '0');
INSERT INTO `site_infoclass` VALUES ('34', '0', '0,', '0', '联系我们', '', '', '', '', '', '34', 'true', 'true', '0');
INSERT INTO `site_infoclass` VALUES ('35', '9', '0,2,9,', '2', '别墅设计', '', '', '', '', '', '35', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('36', '9', '0,2,9,', '2', '家庭住宅', '', '', '', '', '', '36', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('37', '9', '0,2,9,', '2', '精品样板房', '', '', '', '', '', '37', 'true', '', '0');
INSERT INTO `site_infoclass` VALUES ('38', '9', '0,2,9,', '2', '商业空间', '', '', '', '', '', '38', 'true', '', '0');

-- ----------------------------
-- Table structure for `site_infoflag`
-- ----------------------------
DROP TABLE IF EXISTS `site_infoflag`;
CREATE TABLE `site_infoflag` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `flag` varchar(30) NOT NULL,
  `flagname` varchar(30) NOT NULL,
  `orderid` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_infoflag
-- ----------------------------
INSERT INTO `site_infoflag` VALUES ('1', 'h', '头条', '0');
INSERT INTO `site_infoflag` VALUES ('2', 'c', '推荐', '1');
INSERT INTO `site_infoflag` VALUES ('3', 'f', '幻灯', '2');
INSERT INTO `site_infoflag` VALUES ('4', 'a', '特荐', '3');
INSERT INTO `site_infoflag` VALUES ('5', 's', '滚动', '4');
INSERT INTO `site_infoflag` VALUES ('6', 'j', '跳转', '5');

-- ----------------------------
-- Table structure for `site_infoimg`
-- ----------------------------
DROP TABLE IF EXISTS `site_infoimg`;
CREATE TABLE `site_infoimg` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `classid` smallint(5) unsigned NOT NULL,
  `parentid` smallint(5) unsigned NOT NULL,
  `parentstr` varchar(80) NOT NULL,
  `mainid` smallint(5) NOT NULL,
  `mainpid` smallint(5) NOT NULL,
  `mainpstr` varchar(80) NOT NULL,
  `title` varchar(80) NOT NULL,
  `colorval` char(10) NOT NULL,
  `boldval` char(10) NOT NULL,
  `flag` varchar(30) NOT NULL,
  `size` char(20) NOT NULL,
  `price` char(10) NOT NULL,
  `author` varchar(50) NOT NULL,
  `linkurl` varchar(255) NOT NULL,
  `keywords` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `content` mediumtext NOT NULL,
  `picurl` varchar(100) NOT NULL,
  `picarr` text NOT NULL,
  `hits` mediumint(8) unsigned NOT NULL,
  `orderid` int(10) unsigned NOT NULL,
  `posttime` int(10) NOT NULL,
  `checkinfo` enum('true','false') NOT NULL,
  `delstate` set('true') NOT NULL DEFAULT '',
  `deltime` int(10) unsigned NOT NULL,
  `sjfg` varchar(50) NOT NULL,
  `kjxg` varchar(50) NOT NULL,
  `zxmj` varchar(50) NOT NULL,
  `bssj` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_infoimg
-- ----------------------------
INSERT INTO `site_infoimg` VALUES ('1', '9', '2', '0,2,', '-1', '-1', '', '创展国际', '', '', '', '', '10万', '小风', '', '', '', '', 'uploads/image/20140426/1398507017.jpg', '', '122', '1', '1398497083', 'true', '', '0', '1', '1', '1', '1');
INSERT INTO `site_infoimg` VALUES ('2', '10', '2', '0,2,', '-1', '-1', '', '王晓锋', '', '', '', '首席设计师', '', '', '', '', '', '', 'uploads/image/20140426/1398505814.jpg', '', '165', '2', '1398498328', 'true', '', '0', '', '', '', '');
INSERT INTO `site_infoimg` VALUES ('3', '10', '2', '0,2,', '-1', '-1', '', '刘少瑞', '', '', '', '首席设计师', '', '', '', '', '', '', 'uploads/image/20140426/1398507763.jpg', '', '73', '3', '1398498374', 'true', '', '0', '', '', '', '');
INSERT INTO `site_infoimg` VALUES ('4', '10', '2', '0,2,', '-1', '-1', '', '李哲', '', '', '', '首席设计师', '', '', '', '', '', '', 'uploads/image/20140426/1398504042.jpg', '', '103', '4', '1398498393', 'true', '', '0', '', '', '', '');
INSERT INTO `site_infoimg` VALUES ('5', '10', '2', '0,2,', '-1', '-1', '', '兔子', '', '', '', '首席设计师', '', '', '', '', '', '', 'uploads/image/20140426/1398505181.jpg', '', '118', '5', '1398498408', 'true', '', '0', '', '', '', '');
INSERT INTO `site_infoimg` VALUES ('6', '26', '0', '0,', '-1', '-1', '', '户型解析户型解析户型解析户型解析', '', '', '', '', '', 'admin', '', '', '', '', 'uploads/image/20140426/1398505123.jpg', '', '58', '6', '1398498981', 'true', '', '0', '', '', '', '');
INSERT INTO `site_infoimg` VALUES ('7', '26', '0', '0,', '-1', '-1', '', '户型解析测试,记得删除', '', '', '', '', '', 'admin', '', '', '', '', 'uploads/image/20140509/1399613006.jpg', '', '116', '7', '1399603445', 'true', '', '0', '', '', '', '');

-- ----------------------------
-- Table structure for `site_infolist`
-- ----------------------------
DROP TABLE IF EXISTS `site_infolist`;
CREATE TABLE `site_infolist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `classid` smallint(5) unsigned NOT NULL,
  `parentid` smallint(5) unsigned NOT NULL,
  `parentstr` varchar(80) NOT NULL,
  `mainid` smallint(5) NOT NULL,
  `mainpid` smallint(5) NOT NULL,
  `mainpstr` varchar(80) NOT NULL,
  `title` varchar(80) NOT NULL,
  `colorval` char(10) NOT NULL,
  `boldval` char(10) NOT NULL,
  `flag` varchar(30) NOT NULL,
  `author` varchar(50) NOT NULL,
  `linkurl` varchar(255) NOT NULL,
  `keywords` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `content` mediumtext NOT NULL,
  `picurl` varchar(100) NOT NULL,
  `picarr` text NOT NULL,
  `hits` mediumint(8) unsigned NOT NULL,
  `orderid` int(10) unsigned NOT NULL,
  `posttime` int(10) NOT NULL,
  `checkinfo` enum('true','false') NOT NULL,
  `delstate` set('true') NOT NULL,
  `deltime` int(10) unsigned NOT NULL,
  `mianji` varchar(255) NOT NULL,
  `yusuan` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_infolist
-- ----------------------------

-- ----------------------------
-- Table structure for `site_job`
-- ----------------------------
DROP TABLE IF EXISTS `site_job`;
CREATE TABLE `site_job` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL COMMENT '位岗名称',
  `jobplace` varchar(80) NOT NULL COMMENT '工作地点',
  `jobdescription` varchar(50) NOT NULL COMMENT '工作性质',
  `employ` smallint(5) unsigned NOT NULL COMMENT '招聘人数',
  `jobsex` enum('0','1','2') NOT NULL COMMENT '性别要求',
  `treatment` varchar(50) NOT NULL COMMENT '工资待遇',
  `usefullife` varchar(50) NOT NULL COMMENT '有效期',
  `experience` varchar(50) NOT NULL COMMENT '工作经验',
  `education` varchar(80) NOT NULL COMMENT '学历要求',
  `joblang` varchar(50) NOT NULL COMMENT '言语能力',
  `content` mediumtext NOT NULL COMMENT '详细内容',
  `orderid` mediumint(8) unsigned NOT NULL COMMENT '排列排序',
  `posttime` int(10) unsigned NOT NULL COMMENT '更新时间',
  `checkinfo` enum('true','false') NOT NULL COMMENT '审核状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_job
-- ----------------------------

-- ----------------------------
-- Table structure for `site_lnk`
-- ----------------------------
DROP TABLE IF EXISTS `site_lnk`;
CREATE TABLE `site_lnk` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `lnkname` varchar(30) NOT NULL,
  `lnklink` varchar(50) NOT NULL,
  `lnkico` varchar(50) NOT NULL,
  `orderid` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_lnk
-- ----------------------------
INSERT INTO `site_lnk` VALUES ('1', '栏目管理', 'infoclass.php', 'templets/images/infoclass_ico.png', '1');
INSERT INTO `site_lnk` VALUES ('2', '列表管理', 'infolist.php', 'templets/images/infolist_ico.png', '2');
INSERT INTO `site_lnk` VALUES ('3', '图片管理', 'infoimg.php', 'templets/images/infoimg_ico.png', '3');
INSERT INTO `site_lnk` VALUES ('4', '商品管理', 'goods.php', 'templets/images/goods_ico.gif', '4');

-- ----------------------------
-- Table structure for `site_maintype`
-- ----------------------------
DROP TABLE IF EXISTS `site_maintype`;
CREATE TABLE `site_maintype` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` smallint(5) unsigned NOT NULL,
  `parentstr` varchar(50) NOT NULL,
  `classname` varchar(30) NOT NULL,
  `orderid` smallint(5) unsigned NOT NULL,
  `checkinfo` enum('true','false') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_maintype
-- ----------------------------
INSERT INTO `site_maintype` VALUES ('1', '0', '0,', '中文', '1', 'true');
INSERT INTO `site_maintype` VALUES ('2', '0', '0,', 'English', '2', 'true');

-- ----------------------------
-- Table structure for `site_member`
-- ----------------------------
DROP TABLE IF EXISTS `site_member`;
CREATE TABLE `site_member` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` char(32) NOT NULL,
  `truename` varchar(30) NOT NULL,
  `sex` enum('0','1') NOT NULL,
  `birthdate` date DEFAULT NULL,
  `province` varchar(30) NOT NULL,
  `city` varchar(30) NOT NULL,
  `address` varchar(50) NOT NULL,
  `telephone` varchar(30) NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `cardtype` enum('0','1') NOT NULL,
  `cardnum` varchar(30) NOT NULL,
  `showinfo` varchar(100) DEFAULT NULL,
  `picurl` varchar(100) NOT NULL,
  `level` smallint(5) unsigned NOT NULL,
  `integral` smallint(5) unsigned NOT NULL,
  `regtime` int(10) unsigned NOT NULL,
  `regip` char(20) NOT NULL,
  `logintime` int(10) unsigned NOT NULL,
  `loginip` char(20) NOT NULL,
  `checkinfo` enum('true','false') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_member
-- ----------------------------

-- ----------------------------
-- Table structure for `site_message`
-- ----------------------------
DROP TABLE IF EXISTS `site_message`;
CREATE TABLE `site_message` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(30) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `htop` set('true') NOT NULL,
  `rtop` set('true') NOT NULL,
  `ip` char(20) NOT NULL,
  `recont` text NOT NULL,
  `retime` int(10) unsigned NOT NULL,
  `orderid` mediumint(8) unsigned NOT NULL,
  `posttime` int(10) unsigned NOT NULL,
  `checkinfo` enum('true','false') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_message
-- ----------------------------

-- ----------------------------
-- Table structure for `site_nav`
-- ----------------------------
DROP TABLE IF EXISTS `site_nav`;
CREATE TABLE `site_nav` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` smallint(5) unsigned NOT NULL,
  `parentstr` varchar(50) NOT NULL,
  `classname` varchar(30) NOT NULL,
  `linkurl` varchar(255) NOT NULL,
  `relinkurl` varchar(255) NOT NULL,
  `picurl` varchar(100) NOT NULL,
  `orderid` smallint(5) unsigned NOT NULL,
  `checkinfo` enum('true','false') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_nav
-- ----------------------------

-- ----------------------------
-- Table structure for `site_paymode`
-- ----------------------------
DROP TABLE IF EXISTS `site_paymode`;
CREATE TABLE `site_paymode` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `classname` varchar(30) NOT NULL,
  `orderid` smallint(5) unsigned NOT NULL,
  `checkinfo` enum('true','false') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_paymode
-- ----------------------------

-- ----------------------------
-- Table structure for `site_postarea`
-- ----------------------------
DROP TABLE IF EXISTS `site_postarea`;
CREATE TABLE `site_postarea` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` int(10) unsigned NOT NULL,
  `parentstr` varchar(50) NOT NULL,
  `classname` varchar(30) NOT NULL,
  `freight` float NOT NULL,
  `orderid` int(10) unsigned NOT NULL,
  `checkinfo` enum('true','false') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_postarea
-- ----------------------------

-- ----------------------------
-- Table structure for `site_postmode`
-- ----------------------------
DROP TABLE IF EXISTS `site_postmode`;
CREATE TABLE `site_postmode` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `classname` varchar(30) NOT NULL,
  `orderid` smallint(5) unsigned NOT NULL,
  `checkinfo` enum('true','false') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_postmode
-- ----------------------------

-- ----------------------------
-- Table structure for `site_soft`
-- ----------------------------
DROP TABLE IF EXISTS `site_soft`;
CREATE TABLE `site_soft` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `classid` smallint(5) unsigned NOT NULL,
  `parentid` smallint(5) unsigned NOT NULL,
  `parentstr` varchar(80) NOT NULL,
  `mainid` smallint(5) NOT NULL,
  `mainpid` smallint(5) NOT NULL,
  `mainpstr` varchar(80) NOT NULL,
  `title` varchar(80) NOT NULL,
  `colorval` char(10) NOT NULL,
  `boldval` char(10) NOT NULL,
  `flag` varchar(30) NOT NULL,
  `filetype` char(4) NOT NULL,
  `softtype` char(10) NOT NULL,
  `language` char(10) NOT NULL,
  `accredit` char(10) NOT NULL,
  `softsize` varchar(10) NOT NULL,
  `unit` char(4) NOT NULL,
  `runos` varchar(50) NOT NULL,
  `website` varchar(255) NOT NULL,
  `demourl` varchar(255) NOT NULL,
  `dlurl` varchar(255) NOT NULL,
  `author` varchar(50) NOT NULL,
  `linkurl` varchar(255) NOT NULL,
  `keywords` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `content` mediumtext NOT NULL,
  `picurl` varchar(100) NOT NULL,
  `picarr` text NOT NULL,
  `hits` mediumint(8) unsigned NOT NULL,
  `orderid` int(10) unsigned NOT NULL,
  `posttime` int(10) unsigned NOT NULL,
  `checkinfo` enum('true','false') NOT NULL,
  `delstate` set('true') NOT NULL DEFAULT '',
  `deltime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_soft
-- ----------------------------

-- ----------------------------
-- Table structure for `site_uploads`
-- ----------------------------
DROP TABLE IF EXISTS `site_uploads`;
CREATE TABLE `site_uploads` (
  `id` mediumint(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `path` varchar(100) NOT NULL,
  `size` int(10) NOT NULL,
  `type` enum('image','soft','media') NOT NULL,
  `posttime` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_uploads
-- ----------------------------
INSERT INTO `site_uploads` VALUES ('1', '1398507017.jpg', 'uploads/image/20140426/1398507017.jpg', '580377', 'image', '1398497134');
INSERT INTO `site_uploads` VALUES ('2', '1398505814.jpg', 'uploads/image/20140426/1398505814.jpg', '580377', 'image', '1398498357');
INSERT INTO `site_uploads` VALUES ('3', '1398507763.jpg', 'uploads/image/20140426/1398507763.jpg', '580377', 'image', '1398498388');
INSERT INTO `site_uploads` VALUES ('4', '1398504042.jpg', 'uploads/image/20140426/1398504042.jpg', '580377', 'image', '1398498400');
INSERT INTO `site_uploads` VALUES ('5', '1398505181.jpg', 'uploads/image/20140426/1398505181.jpg', '580377', 'image', '1398498417');
INSERT INTO `site_uploads` VALUES ('6', '1398505123.jpg', 'uploads/image/20140426/1398505123.jpg', '580377', 'image', '1398498991');
INSERT INTO `site_uploads` VALUES ('7', '1399613006.jpg', 'uploads/image/20140509/1399613006.jpg', '397564', 'image', '1399603565');

-- ----------------------------
-- Table structure for `site_vote`
-- ----------------------------
DROP TABLE IF EXISTS `site_vote`;
CREATE TABLE `site_vote` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `content` text NOT NULL,
  `starttime` int(10) unsigned NOT NULL,
  `endtime` int(10) unsigned NOT NULL,
  `isguest` enum('true','false') NOT NULL,
  `isview` enum('true','false') NOT NULL,
  `intval` int(10) unsigned NOT NULL,
  `isradio` tinyint(1) unsigned NOT NULL,
  `orderid` smallint(5) unsigned NOT NULL,
  `posttime` int(10) unsigned NOT NULL,
  `checkinfo` enum('true','false') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_vote
-- ----------------------------

-- ----------------------------
-- Table structure for `site_votedata`
-- ----------------------------
DROP TABLE IF EXISTS `site_votedata`;
CREATE TABLE `site_votedata` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `voteid` smallint(6) unsigned NOT NULL COMMENT '投票id',
  `optionid` text NOT NULL COMMENT '选票id',
  `userid` int(10) unsigned NOT NULL COMMENT '投票人id',
  `posttime` int(10) unsigned NOT NULL COMMENT '投票时间',
  `ip` varchar(30) NOT NULL COMMENT '投票ip',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_votedata
-- ----------------------------

-- ----------------------------
-- Table structure for `site_voteoption`
-- ----------------------------
DROP TABLE IF EXISTS `site_voteoption`;
CREATE TABLE `site_voteoption` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '投票选项id',
  `voteid` smallint(6) unsigned NOT NULL COMMENT '投票id',
  `options` varchar(30) NOT NULL COMMENT '投票选项',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_voteoption
-- ----------------------------

-- ----------------------------
-- Table structure for `site_webconfig`
-- ----------------------------
DROP TABLE IF EXISTS `site_webconfig`;
CREATE TABLE `site_webconfig` (
  `varname` varchar(50) NOT NULL DEFAULT '',
  `varinfo` varchar(80) NOT NULL DEFAULT '',
  `vargroup` smallint(5) unsigned NOT NULL DEFAULT '0',
  `vartype` char(10) NOT NULL DEFAULT 'string',
  `varvalue` text,
  `orderid` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`varname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_webconfig
-- ----------------------------
INSERT INTO `site_webconfig` VALUES ('cfg_webname', '网站名称', '0', 'string', '河南方艺装饰工程有限公司', '1');
INSERT INTO `site_webconfig` VALUES ('cfg_weburl', '网站地址', '0', 'string', 'http://127.0.0.1', '2');
INSERT INTO `site_webconfig` VALUES ('cfg_webpath', '网站目录', '0', 'string', '/fangyi', '3');
INSERT INTO `site_webconfig` VALUES ('cfg_author', '网站作者', '0', 'string', '', '4');
INSERT INTO `site_webconfig` VALUES ('cfg_generator', '程序引擎', '0', 'string', 'UaPlus', '5');
INSERT INTO `site_webconfig` VALUES ('cfg_keyword', '关键字设置', '0', 'string', '网站', '6');
INSERT INTO `site_webconfig` VALUES ('cfg_description', '网站描述', '0', 'bstring', '', '7');
INSERT INTO `site_webconfig` VALUES ('cfg_copyright', '版权信息', '0', 'bstring', 'Copyright © 2010 - 2012 All Rights Reserved', '8');
INSERT INTO `site_webconfig` VALUES ('cfg_hotline', '客服热线', '0', 'string', '400-800-8888', '9');
INSERT INTO `site_webconfig` VALUES ('cfg_icp', '备案编号', '0', 'string', '', '10');
INSERT INTO `site_webconfig` VALUES ('cfg_maintype', '二级类别开关', '0', 'bool', 'N', '11');
INSERT INTO `site_webconfig` VALUES ('cfg_webswitch', '网站开关', '0', 'bool', 'Y', '12');
INSERT INTO `site_webconfig` VALUES ('cfg_switchshow', '关闭说明', '0', 'bstring', '对不起，网站维护，请稍后登陆。<br />网站维护期间对您造成的不便，请谅解！', '13');
INSERT INTO `site_webconfig` VALUES ('cfg_upload_img_type', '上传图片类型', '1', 'string', 'gif|png|jpg|bmp', '23');
INSERT INTO `site_webconfig` VALUES ('cfg_upload_soft_type', '上传软件类型', '1', 'string', 'zip|gz|rar|iso|doc|xls|ppt|wps|txt', '24');
INSERT INTO `site_webconfig` VALUES ('cfg_upload_media_type', '上传媒体类型', '1', 'string', 'swf|flv|mpg|mp3|rm|rmvb|wmv|wma|wav', '25');
INSERT INTO `site_webconfig` VALUES ('cfg_max_file_size', '上传文件大小', '1', 'string', '2097152', '26');
INSERT INTO `site_webconfig` VALUES ('cfg_countcode', '流量统计代码', '1', 'bstring', '', '27');
INSERT INTO `site_webconfig` VALUES ('cfg_qqcode', '在线QQ　<br />(多个用\",\"分隔)', '1', 'bstring', '', '28');
INSERT INTO `site_webconfig` VALUES ('cfg_qqcodeimg', '在线QQ图片ID', '1', 'number', '41', '29');
INSERT INTO `site_webconfig` VALUES ('cfg_mysql_type', '数据库类型(支持mysql和mysqli)', '2', 'string', 'mysqli', '40');
INSERT INTO `site_webconfig` VALUES ('cfg_pagenum', '每页显示记录数', '2', 'string', '20', '41');
INSERT INTO `site_webconfig` VALUES ('cfg_timezone', '服务器时区设置', '2', 'string', '8', '42');
INSERT INTO `site_webconfig` VALUES ('cfg_typefold', '类别页是否折叠', '2', 'bool', 'Y', '43');
INSERT INTO `site_webconfig` VALUES ('cfg_diserror', 'PHP错误显示', '2', 'bool', 'Y', '44');
INSERT INTO `site_webconfig` VALUES ('cfg_isreurl', '是否启用伪静态', '3', 'bool', 'N', '60');
INSERT INTO `site_webconfig` VALUES ('cfg_reurl_index', '首页规则', '3', 'string', 'index.html', '61');
INSERT INTO `site_webconfig` VALUES ('cfg_reurl_about', '关于我们页', '3', 'string', '{about}-{id}-{page}.html', '62');
INSERT INTO `site_webconfig` VALUES ('cfg_reurl_news', '新闻中心页', '3', 'string', '{news}-{cid}-{page}.html', '63');
INSERT INTO `site_webconfig` VALUES ('cfg_reurl_newsshow', '新闻内容页', '3', 'string', '{newsshow}-{cid}-{id}-{page}.html', '64');
INSERT INTO `site_webconfig` VALUES ('cfg_reurl_product', '产品展示页', '3', 'string', '{product}-{cid}-{page}.html', '65');
INSERT INTO `site_webconfig` VALUES ('cfg_reurl_productshow', '产品内容页', '3', 'string', '{productshow}-{cid}-{id}-{page}.html', '66');
INSERT INTO `site_webconfig` VALUES ('cfg_reurl_case', '案例展示页', '3', 'string', '{case}-{cid}-{page}.html', '67');
INSERT INTO `site_webconfig` VALUES ('cfg_reurl_caseshow', '案例内容页', '3', 'string', '{caseshow}-{cid}-{id}-{page}.html', '68');
INSERT INTO `site_webconfig` VALUES ('cfg_reurl_join', '人才招聘页', '3', 'string', '{join}-{page}.html', '69');
INSERT INTO `site_webconfig` VALUES ('cfg_reurl_joinshow', '招聘内容页', '3', 'string', '{joinshow}-{id}.html', '70');
INSERT INTO `site_webconfig` VALUES ('cfg_reurl_message', '客户留言页', '3', 'string', '{message}-{page}.html', '71');
INSERT INTO `site_webconfig` VALUES ('cfg_reurl_contact', '联系我们页', '3', 'string', '{contact}-{id}-{page}.html', '72');
INSERT INTO `site_webconfig` VALUES ('cfg_reurl_soft', '软件下载页', '3', 'string', '{soft}-{cid}-{page}.html', '73');
INSERT INTO `site_webconfig` VALUES ('cfg_reurl_softshow', '软件内容页', '3', 'string', '{softshow}-{cid}-{id}-{page}.html', '74');
INSERT INTO `site_webconfig` VALUES ('cfg_reurl_vote', '投票内容页', '3', 'string', '{vote}-{id}.html', '75');
INSERT INTO `site_webconfig` VALUES ('cfg_reurl_custom', '自定义规则', '3', 'string', '{file}.html', '76');

-- ----------------------------
-- Table structure for `site_weblink`
-- ----------------------------
DROP TABLE IF EXISTS `site_weblink`;
CREATE TABLE `site_weblink` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `classid` smallint(5) unsigned NOT NULL,
  `parentid` smallint(5) unsigned NOT NULL,
  `parentstr` varchar(80) NOT NULL,
  `webname` varchar(30) NOT NULL,
  `webnote` varchar(200) NOT NULL,
  `picurl` varchar(100) NOT NULL,
  `linkurl` varchar(255) NOT NULL,
  `orderid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `posttime` int(10) unsigned NOT NULL,
  `checkinfo` enum('true','false') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_weblink
-- ----------------------------

-- ----------------------------
-- Table structure for `site_weblinktype`
-- ----------------------------
DROP TABLE IF EXISTS `site_weblinktype`;
CREATE TABLE `site_weblinktype` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` smallint(5) unsigned NOT NULL,
  `parentstr` varchar(50) NOT NULL,
  `classname` varchar(30) NOT NULL,
  `orderid` smallint(5) unsigned NOT NULL,
  `checkinfo` enum('true','false') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of site_weblinktype
-- ----------------------------
INSERT INTO `site_weblinktype` VALUES ('1', '0', '0,', '中文分类', '1', 'true');
INSERT INTO `site_weblinktype` VALUES ('2', '0', '0,', 'English Category', '1', 'true');
