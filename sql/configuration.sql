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
-- 表的结构 `bi_user`
--

CREATE TABLE IF NOT EXISTS `bi_user` (
  `uid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL COMMENT '登录名',
  `password` varchar(30) NOT NULL COMMENT '密码',
  `telphone` varchar(30) NOT NULL COMMENT '电话',
  `email` varchar(40) DEFAULT NULL COMMENT '邮箱',
  `realname` varchar(30) DEFAULT NULL COMMENT '真实姓名',
  `grade` tinyint(3) unsigned NOT NULL COMMENT '用户等级',
  `adduserid` int(11) unsigned NOT NULL COMMENT '创建人UID(0为root)',
  `adddate` int(11) unsigned NOT NULL COMMENT '创建时间',
  `modifyuserid` int(11) unsigned COMMENT '修改人UID(0为root)',
  `modifydate` int(11) unsigned COMMENT '修改时间',
  `orgid` int(11) unsigned DEFAULT NULL COMMENT '组织结构ID',
  `lastlogintime` int(10) unsigned NOT NULL COMMENT '最后一次登录时间戳',
  `memo` varchar(100) NOT NULL COMMENT '备注',
  `del_flag` tinyint(1) unsigned NOT NULL COMMENT '是否激活(0激活1失效)',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户表' AUTO_INCREMENT=27 ;


--
-- 表的结构 `bi_role`
--

CREATE TABLE IF NOT EXISTS `bi_role` (
  `roleid` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色ID',
  `rolename` varchar(30) NOT NULL COMMENT '角色名称',
  `memo` varchar(100) NOT NULL COMMENT '备注',
  `adduserid` int(11) unsigned NOT NULL COMMENT '创建人UID(0为root)',
  `adddate` int(11) unsigned NOT NULL COMMENT '创建时间',
  `modifyuserid` int(11) unsigned COMMENT '修改人UID(0为root)',
  `modifydate` int(11) unsigned COMMENT '修改时间',
  `del_flag` tinyint(1) unsigned NOT NULL COMMENT '删除标志(0未删除1删除)',
  PRIMARY KEY (`roleid`),
  UNIQUE KEY `rolename` (`rolename`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户角色表' AUTO_INCREMENT=7 ;


--
-- 表的结构 `bi_user_role`
--

CREATE TABLE IF NOT EXISTS `bi_user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `userid` int(11) NOT NULL,
  `roleid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户角色对应表';


--
-- 表的结构 `bi_menu`
--

CREATE TABLE IF NOT EXISTS `bi_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '菜单ID',
  `menuname` varchar(30) NOT NULL COMMENT '菜单名称',
  `url` varchar(100) NOT NULL COMMENT 'url链接地址',
  `pid` int(11) NOT NULL,
  PRIMARY KEY (`menu_id`),
  UNIQUE KEY `menuname` (`menuname`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='菜单表' AUTO_INCREMENT=7 ;


--
-- 表的结构 `bi_role_menu`
--

CREATE TABLE IF NOT EXISTS `bi_role_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色菜单对应表';


--
-- 表的结构 `bi_province`
--

CREATE TABLE IF NOT EXISTS `bi_province` (
  `prov_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `prov_name` varchar(32) NOT NULL COMMENT '省名称',
  PRIMARY KEY (`prov_id`),
  UNIQUE KEY `prov_name` (`prov_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='省表' AUTO_INCREMENT=7 ;


--
-- 表的结构 `bi_city`
--

CREATE TABLE IF NOT EXISTS `bi_city` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `city_name` varchar(32) NOT NULL COMMENT '市名称',
  `prov_id` int(11) NOT NULL,
  PRIMARY KEY (`city_id`),
  UNIQUE KEY `city_name` (`city_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='市表' AUTO_INCREMENT=7 ;


--
-- 表的结构 `bi_area`
--

CREATE TABLE IF NOT EXISTS `bi_area` (
  `area_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '区域ID',
  `area_name` varchar(32) NOT NULL COMMENT '区域名称',
  `pid` int(11) NOT NULL,
  `memo` varchar(100) NOT NULL COMMENT '备注',
  PRIMARY KEY (`area_id`),
  UNIQUE KEY `area_name` (`area_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='区域表' AUTO_INCREMENT=7 ;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
