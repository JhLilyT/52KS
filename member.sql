-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- 主機: localhost
-- 建立日期: Jun 08, 2011, 01:31 PM
-- 伺服器版本: 6.0.4
-- PHP 版本: 6.0.0-dev

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE DATABASE `member` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `member`;

-- --------------------------------------------------------

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(10) NOT NULL DEFAULT '',
  `password` varchar(10) NOT NULL DEFAULT '',
  `name` varchar(10) NOT NULL DEFAULT '',
  `sex` char(2) NOT NULL DEFAULT '',
  `year` tinyint(4) NOT NULL DEFAULT '0',
  `month` tinyint(4) NOT NULL DEFAULT '0',
  `day` tinyint(4) NOT NULL DEFAULT '0',
  `cellphone` varchar(20) NOT NULL DEFAULT '',
  `address` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;



INSERT INTO `users` VALUES (1, 'guest', 'guest', '陳俊榮', '男', 66, 6, 13,  '(0968) 568-854', '台北市大安區師大路 20 號', 'rongchen@ms17.url.com.tw');
