-- phpMyAdmin SQL Dump
-- version 3.5.9-dev
-- http://www.phpmyadmin.net
--
-- 主机: 10.0.1.31
-- 生成日期: 2014 年 06 月 18 日 16:08
-- 服务器版本: 5.5.9
-- PHP 版本: 5.2.17p1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `dinner`
--

-- --------------------------------------------------------

--
-- 表的结构 `liv_announcement`
--

CREATE TABLE IF NOT EXISTS `liv_announcement` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL COMMENT '公告内容',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `order_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='公告信息' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `liv_complain`
--

CREATE TABLE IF NOT EXISTS `liv_complain` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL,
  `content` text NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='吐槽表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `liv_config`
--

CREATE TABLE IF NOT EXISTS `liv_config` (
  `name` varchar(20) NOT NULL,
  `start_time` varchar(20) NOT NULL,
  `end_time` varchar(20) NOT NULL,
  `is_open` tinyint(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `dinner_time` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订餐时间配置';


INSERT INTO `liv_config` (`name`, `start_time`, `end_time`, `is_open`) VALUES
('dinner_time', '09:00:00', '13:30:00', 1);

-- --------------------------------------------------------

--
-- 表的结构 `liv_food_order`
--

CREATE TABLE IF NOT EXISTS `liv_food_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) NOT NULL COMMENT '该订单所属哪家店',
  `order_number` varchar(20) NOT NULL COMMENT '订单编号',
  `product_info` text NOT NULL COMMENT '商品信息',
  `pay_time` int(10) NOT NULL DEFAULT '0' COMMENT '付款时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '订单状态',
  `food_user_id` int(10) NOT NULL COMMENT '用户id',
  `total_price` float(7,1) unsigned NOT NULL DEFAULT '0.0',
  `create_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='订单' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `liv_food_order_log`
--

CREATE TABLE IF NOT EXISTS `liv_food_order_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `food_order_id` varchar(60) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='订单动态' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `liv_food_sort`
--

CREATE TABLE IF NOT EXISTS `liv_food_sort` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `fid` int(10) NOT NULL,
  `depath` int(10) NOT NULL,
  `order_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='分类表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `liv_material`
--

CREATE TABLE IF NOT EXISTS `liv_material` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL COMMENT '图片名称',
  `filepath` varchar(100) NOT NULL COMMENT '原图的存储路径',
  `filename` varchar(40) NOT NULL COMMENT '文件名称',
  `type` varchar(30) NOT NULL COMMENT '图片类型',
  `mark` varchar(30) NOT NULL COMMENT '附件标记 img doc real',
  `imgwidth` smallint(4) NOT NULL DEFAULT '0' COMMENT '图片宽度',
  `imgheight` smallint(4) NOT NULL DEFAULT '0' COMMENT '图片高度',
  `filesize` int(10) NOT NULL COMMENT '图片大小',
  `create_time` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `liv_members`
--

CREATE TABLE IF NOT EXISTS `liv_members` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `salt` varchar(6) NOT NULL,
  `sex` tinyint(1) NOT NULL DEFAULT '0',
  `avatar` varchar(512) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `balance` float(7,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '账户余额',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  `order_id` int(10) NOT NULL DEFAULT '0' COMMENT '排序id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='前台会员表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `liv_menus`
--

CREATE TABLE IF NOT EXISTS `liv_menus` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '菜名',
  `index_pic` int(10) NOT NULL DEFAULT '0',
  `sort_id` int(10) NOT NULL DEFAULT '0' COMMENT '所属菜系',
  `shop_id` int(10) NOT NULL DEFAULT '0' COMMENT '所属商家id',
  `price` float(7,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '价格',
  `unit` varchar(10) DEFAULT NULL COMMENT '价格单位',
  `brief` text COMMENT '简介',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '菜的状态',
  `create_time` int(10) NOT NULL,
  `order_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='菜单表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `liv_record_money`
--

CREATE TABLE IF NOT EXISTS `liv_record_money` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型0扣款1充值',
  `money` float(7,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '金额',
  `create_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户扣款充值记录' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `liv_shops`
--

CREATE TABLE IF NOT EXISTS `liv_shops` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '商户名',
  `district_id` int(10) NOT NULL DEFAULT '0' COMMENT '所属地区id',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `address` varchar(1024) DEFAULT NULL COMMENT '详细地址',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `update_time` int(10) NOT NULL COMMENT '修改时间',
  `logo` varchar(250) DEFAULT NULL COMMENT '商家logo',
  `tel` varchar(50) DEFAULT NULL COMMENT '联系电话',
  `linkman` varchar(20) DEFAULT NULL COMMENT '联系人',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `url` varchar(128) NOT NULL COMMENT '商家url',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商家基本信息' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `liv_user`
--

CREATE TABLE IF NOT EXISTS `liv_user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL,
  `password` varchar(60) NOT NULL,
  `salt` varchar(10) NOT NULL,
  `create_time` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='后台用户表' AUTO_INCREMENT=1 ;

INSERT INTO `liv_user` (`id`, `username`, `password`, `salt`, `create_time`, `order_id`) VALUES
(1, 'admin', '6b3e3f74a9ec2fbc517f50b483c5d4fa', 'aqdlt', 1398517782, 1);

-- --------------------------------------------------------

--
-- 表的结构 `liv_message`
--

CREATE TABLE IF NOT EXISTS `liv_message` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) NOT NULL DEFAULT '0',
  `content` text NOT NULL COMMENT '留言内容',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '留言状态',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '留言时间',
  `user_id` int(10) NOT NULL DEFAULT '0',
  `order_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='留言表' AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- 表的结构 `liv_reply`
--

CREATE TABLE IF NOT EXISTS `liv_reply` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `message_id` int(10) NOT NULL DEFAULT '0',
  `create_time` int(10) NOT NULL DEFAULT '0',
  `user_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='回复表' AUTO_INCREMENT=1 ;

--
-- 表的结构 `liv_user_login`
--

CREATE TABLE IF NOT EXISTS `liv_user_login` (
  `user_id` int(10) NOT NULL DEFAULT '0',
  `username` varchar(60) NOT NULL,
  `token` char(32) NOT NULL,
  `login_time` int(11) NOT NULL DEFAULT '0',
  `ip` char(30) DEFAULT NULL,
  `visit_client` tinyint(1) DEFAULT '0' COMMENT '登录客户端标识0：ios 1：安卓',
  PRIMARY KEY (`token`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COMMENT='用户登录记录';


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
