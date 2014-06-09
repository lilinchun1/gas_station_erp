-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- 主机: 127.0.0.1
-- 生成日期: 2013 年 12 月 20 日 04:12
-- 服务器版本: 5.5.32
-- PHP 版本: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `ky`
--
CREATE DATABASE IF NOT EXISTS `jnbizs` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `jnbizs`;

-- --------------------------------------------------------

--
-- 表的结构 `qd_agent`
--

CREATE TABLE IF NOT EXISTS `qd_agent` (
  `agent_id` int(10) NOT NULL AUTO_INCREMENT,
  `father_agentid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '如果是二级代理商，上级代理商ID',
  `agent_type` enum('area','trade') NOT NULL COMMENT '代理商类型',
  `agent_name` varchar(60) NOT NULL COMMENT '代理商名称',
  `companyAddr` varchar(60) DEFAULT NULL COMMENT '公司地址',
  `contract_number` varchar(50) DEFAULT NULL COMMENT '代理商合同编号',
  `legal` varchar(32) DEFAULT NULL COMMENT '法人代表',
  `tel` varchar(20) DEFAULT NULL COMMENT '公司电话',
  `legal_tel` varchar(20) NOT NULL COMMENT '法人电话',
  `agent_level` tinyint(3) unsigned NOT NULL COMMENT '代理商级别',
  `sub_agent_num` smallint(5) unsigned NOT NULL COMMENT '下属代理商数量',
  `channel_num` smallint(5) unsigned NOT NULL COMMENT '渠道商数量(包含下属代理商)',
  `place_num` smallint(5) unsigned NOT NULL COMMENT '下属网点数量',
  `device_num` int(10) unsigned NOT NULL COMMENT '终端数量(包括下级代理商终端)',
  `begin_time` int(10) unsigned DEFAULT NULL COMMENT '授权开始时间戳',
  `end_time` int(10) unsigned DEFAULT NULL COMMENT '授权结束时间戳',
  `forever_type` enum('1','0') NOT NULL DEFAULT '0' COMMENT '是否是永久代理商',
  `isDelete` tinyint(1) DEFAULT NULL COMMENT '是否删除',
  PRIMARY KEY (`agent_id`),
  UNIQUE KEY `agent_name` (`agent_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='代理商表' AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- 表的结构 `qd_agent_area`
--

CREATE TABLE IF NOT EXISTS `qd_agent_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `agent_id` int(10) unsigned NOT NULL,
  `area_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='代理区域表';

-- --------------------------------------------------------

--
-- 表的结构 `qd_channel`
--

CREATE TABLE IF NOT EXISTS `qd_channel` (
  `channel_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `channel_name` varchar(200) NOT NULL COMMENT '渠道商名称',
  `agent_id` int(10) unsigned NOT NULL COMMENT '隶属于哪个代理商',
  `contacts` varchar(20) NOT NULL COMMENT '联系人姓名',
  `contacts_tel` varchar(20) DEFAULT NULL COMMENT '联系人电话',
  `channel_tel` varchar(20) DEFAULT NULL COMMENT '渠道商电话',
  `channel_address` varchar(200) NOT NULL COMMENT '所在地址',
  `contract_number` varchar(50) NOT NULL COMMENT '合同编号',
  `place_num` smallint(5) unsigned NOT NULL COMMENT '下属网点数量',
  `device_num` smallint(6) NOT NULL COMMENT '终端数量',
  `begin_time` int(10) unsigned DEFAULT NULL COMMENT '合同开始时间戳',
  `end_time` int(10) unsigned DEFAULT NULL COMMENT '合同结束时间戳',
  `forever_type` enum('1','0') NOT NULL DEFAULT '0' COMMENT '是否是永久渠道商',
  `isDelete` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除',
  PRIMARY KEY (`channel_id`),
  UNIQUE KEY `channel_name` (`channel_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='渠道商表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qd_channel_area`
--

CREATE TABLE IF NOT EXISTS `qd_channel_area` (
  `channel_id` int(10) unsigned NOT NULL COMMENT '渠道商ID',
  `province` varchar(20) NOT NULL COMMENT '渠道商所在省',
  `city` varchar(30) NOT NULL COMMENT '渠道商所在市',
  UNIQUE KEY `channel_id` (`channel_id`,`province`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='渠道商所在区域表';

-- --------------------------------------------------------

--
-- 表的结构 `qd_channel_type`
--

CREATE TABLE IF NOT EXISTS `qd_channel_type` (
  `channel_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '渠道类型ID',
  `channel_type_father_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '渠道商类型上级类型ID',
  `channel_type_name` varchar(200) NOT NULL COMMENT '渠道类型名称',
  PRIMARY KEY (`channel_type_id`),
  UNIQUE KEY `channel_type_name` (`channel_type_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='渠道类型表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qd_channel_type_link`
--

CREATE TABLE IF NOT EXISTS `qd_channel_type_link` (
  `channel_id` int(10) unsigned NOT NULL COMMENT '渠道商ID',
  `channel_type_id` int(10) unsigned NOT NULL COMMENT '渠道类型ID',
  UNIQUE KEY `channel_id` (`channel_id`,`channel_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='渠道-类型对应表(多-多)';

-- --------------------------------------------------------

--
-- 表的结构 `qd_device`
--

CREATE TABLE IF NOT EXISTS `qd_device` (
  `device_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `device_no` varchar(20) NOT NULL COMMENT '设备编号',
  `MAC` varchar(17) NOT NULL COMMENT 'MAC地址',
  `place_id` int(11) unsigned NOT NULL COMMENT '网点ID',
  `channel_id` int(10) unsigned NOT NULL COMMENT '渠道商ID',
  `agent_id` int(10) unsigned NOT NULL COMMENT '代理商ID',
  `province` varchar(20) NOT NULL COMMENT '设备所在省',
  `city` varchar(50) NOT NULL COMMENT '设备所在市',
  `address` varchar(100) DEFAULT NULL COMMENT '设备所在详细地址',
  `status` varchar(20) DEFAULT NULL COMMENT '设备状态',
  `device_type` varchar(20) DEFAULT NULL COMMENT '设备型号',
  `begin_time` int(10) unsigned DEFAULT NULL COMMENT '启用时间',
  `deploy_time` int(10) unsigned DEFAULT NULL COMMENT '部署时间',
  `repair_user` varchar(12) DEFAULT NULL COMMENT '维护人',
  `repair_user_tel` varchar(20) DEFAULT NULL COMMENT '维护人电话',
  `power_on_time` int(11) DEFAULT NULL COMMENT '开机时间',
  `power_off_time` int(11) DEFAULT NULL COMMENT '关机时间',
  `power_on_duration` int(11) DEFAULT NULL COMMENT '开机时长',
  `description` varchar(100) DEFAULT NULL COMMENT '备注',
  `isDelete` tinyint(1) DEFAULT NULL COMMENT '是否删除',
  PRIMARY KEY (`device_id`),
  UNIQUE KEY `device_no` (`device_no`),
  UNIQUE KEY `MAC` (`MAC`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='渠道设备表';

-- --------------------------------------------------------

--
-- 表的结构 `qd_device_image`
--

CREATE TABLE IF NOT EXISTS `qd_device_image` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图片ID',
  `image_path` varchar(100) NOT NULL COMMENT '图片路径',
  `image_description` varchar(100) COMMENT '图片描述',
  `device_id` int(11) unsigned NOT NULL COMMENT '所属设备唯一ID',
  PRIMARY KEY (`image_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='设备图片表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qd_logs_device`
--

CREATE TABLE IF NOT EXISTS `qd_logs_device` (
  `logs_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `agent_id` int(10) unsigned DEFAULT NULL COMMENT '代理商ID(qd_agent表ID)',
  `channel_id` int(10) unsigned DEFAULT NULL COMMENT '渠道商ID(qd_channel表ID)',
  `place_id` int(11) unsigned DEFAULT NULL COMMENT '网点ID(qd_place表ID)',
  `device_id` int(11) unsigned DEFAULT NULL COMMENT '设备ID(qd_device表ID)',
  `begin_time` int(10) unsigned NOT NULL COMMENT '开始启用时间戳',
  `end_time` int(10) unsigned NOT NULL COMMENT '结束启用时间戳(0代表未停用)',
  PRIMARY KEY (`logs_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='设备启用结束日志表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qd_logs_option`
--

CREATE TABLE IF NOT EXISTS `qd_logs_option` (
  `logs_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(200) DEFAULT NULL COMMENT '操作对象(如代理商agent，渠道商channel，网点place，终端device等)',
  `option_id` varchar(50) DEFAULT NULL COMMENT '操作对象ID',
  `option_type` enum('add','del','change') DEFAULT NULL COMMENT '操作方法',
  `timestamp` int(10) unsigned NOT NULL COMMENT '操作时间戳',
  PRIMARY KEY (`logs_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='操作日志' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qd_logs_option_description`
--

CREATE TABLE IF NOT EXISTS `qd_logs_option_description` (
  `option_log_id` int(10) unsigned NOT NULL,
  `option_descrption` text NOT NULL COMMENT '操作描述(主要是修改的详细描述)'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='操作日志描述表(qd_logs_option从表)';

-- --------------------------------------------------------

--
-- 表的结构 `qd_place`
--

CREATE TABLE IF NOT EXISTS `qd_place` (
  `place_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `place_no` varchar(20) NOT NULL COMMENT '网点编号',
  `place_name` varchar(60) NOT NULL COMMENT '网点名称',
  `province` varchar(20) DEFAULT NULL COMMENT '网点所在省',
  `city` varchar(20) DEFAULT NULL COMMENT '网点所在市',
  `region` varchar(100) DEFAULT NULL COMMENT '网点所在详细地址',
  `place_tel` varchar(20) DEFAULT NULL COMMENT '网点电话',
  `contacts` varchar(20) NOT NULL COMMENT '联系人姓名',
  `contacts_tel` varchar(20) NOT NULL COMMENT '联系人电话',
  `status` varchar(20) DEFAULT NULL COMMENT '网点状态',
  `test_begin_time` int(11) DEFAULT NULL COMMENT '测试开始时间',
  `test_end_time` int(11) DEFAULT NULL COMMENT '测试结束时间',
  `channel_id` int(11) NOT NULL COMMENT '渠道合作伙伴ID，qd_channel表channel_id',
  `agent_id` int(10) unsigned DEFAULT NULL COMMENT '代理商id',
  `place_type_id` smallint(6) NOT NULL COMMENT '网点类型id',
  `device_num` int(10) unsigned NOT NULL COMMENT '终端数量',
  `begin_time` int(11) DEFAULT NULL COMMENT '启用时间',
  `end_time` int(11) DEFAULT NULL COMMENT '撤销时间',
  `power_on_time` int(11) DEFAULT NULL COMMENT '开机时间',
  `power_off_time` int(11) DEFAULT NULL COMMENT '关机时间',
  `power_on_duration` int(11) DEFAULT NULL COMMENT '开机时长',
  `sigh_time` int(11) DEFAULT NULL COMMENT '签订时间',
  `isDelete` tinyint(1) DEFAULT NULL COMMENT '是否删除',
  PRIMARY KEY (`place_id`),
  UNIQUE KEY `place_no` (`place_no`),
  UNIQUE KEY `placename` (`place_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='渠道网点表';


-- --------------------------------------------------------

--
-- 表的结构 `qd_place_image`
--

CREATE TABLE IF NOT EXISTS `qd_place_image` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图片ID',
  `image_path` varchar(100) NOT NULL COMMENT '图片路径',
  `image_description` varchar(100) COMMENT '图片描述',
  `place_id` int(11) unsigned NOT NULL COMMENT '所属网点唯一ID',
  PRIMARY KEY (`image_id`),
  KEY `place_id` (`place_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='网点图片表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qd_place_type`
--

CREATE TABLE IF NOT EXISTS `qd_place_type` (
  `place_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '网点类型ID',
  `place_type_name` varchar(200) NOT NULL COMMENT '网点类型名称',
  PRIMARY KEY (`place_type_id`),
  UNIQUE KEY `place_type_name` (`place_type_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='渠道类型表' AUTO_INCREMENT=1 ;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
