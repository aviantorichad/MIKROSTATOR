-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2016 at 06:46 AM
-- Server version: 5.5.32
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wk_mikrostator`
--
CREATE DATABASE IF NOT EXISTS `wk_mikrostator` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `wk_mikrostator`;

-- --------------------------------------------------------

--
-- Table structure for table `wk_config`
--

CREATE TABLE IF NOT EXISTS `wk_config` (
  `config_id` int(8) NOT NULL AUTO_INCREMENT,
  `config_mt_host` varchar(255) NOT NULL,
  `config_mt_port` varchar(10) NOT NULL,
  `config_mt_username` varchar(255) NOT NULL,
  `config_mt_password` varchar(255) NOT NULL,
  `config_wk_interval` int(8) NOT NULL DEFAULT '300' COMMENT 'in second',
  `config_wk_autobackup` int(11) DEFAULT '1',
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `wk_config`
--

INSERT INTO `wk_config` (`config_id`, `config_mt_host`, `config_mt_port`, `config_mt_username`, `config_mt_password`, `config_wk_interval`, `config_wk_autobackup`) VALUES
(1, '192.168.88.1', '8728', 'admin', '', 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `wk_forum`
--

CREATE TABLE IF NOT EXISTS `wk_forum` (
  `forum_id` int(8) NOT NULL AUTO_INCREMENT,
  `forum_user` varchar(255) NOT NULL,
  `forum_username` varchar(255) NOT NULL,
  `forum_message` varchar(2048) NOT NULL,
  `forum_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `forum_notes` varchar(255) NOT NULL,
  `forum_deleted` int(11) NOT NULL,
  PRIMARY KEY (`forum_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wk_hotspot_active`
--

CREATE TABLE IF NOT EXISTS `wk_hotspot_active` (
  `active_id` int(8) NOT NULL AUTO_INCREMENT,
  `active_user` varchar(255) NOT NULL,
  `active_address` varchar(255) NOT NULL,
  `active_mac_address` varchar(255) NOT NULL,
  `active_uptime_batas` varchar(255) NOT NULL,
  `active_uptime_dipakai` varchar(255) NOT NULL,
  `active_session_time_left_sisa` varchar(255) NOT NULL,
  `active_uptime_aktif` varchar(255) NOT NULL,
  `active_bytes_in` varchar(255) NOT NULL,
  `active_bytes_out` varchar(255) NOT NULL,
  `active_last_seen` varchar(255) NOT NULL,
  `active_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`active_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wk_hotspot_user`
--

CREATE TABLE IF NOT EXISTS `wk_hotspot_user` (
  `user_id` int(8) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `user_profile` varchar(255) NOT NULL,
  `user_limit_uptime` varchar(255) NOT NULL,
  `user_uptime` varchar(255) NOT NULL,
  `user_bytes_in` varchar(255) NOT NULL,
  `user_bytes_out` varchar(255) NOT NULL,
  `user_waktu_awal` varchar(255) NOT NULL,
  `user_waktu_akhir` varchar(255) NOT NULL,
  `user_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_operator` varchar(255) NOT NULL,
  `user_tipe_tambah` varchar(255) NOT NULL,
  `user_tambah` varchar(255) NOT NULL,
  `user_status_update` varchar(255) NOT NULL,
  `user_notes` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wk_list`
--

CREATE TABLE IF NOT EXISTS `wk_list` (
  `list_id` int(8) NOT NULL AUTO_INCREMENT,
  `list_name` varchar(255) NOT NULL,
  `list_value` varchar(255) NOT NULL,
  `list_note` varchar(255) NOT NULL,
  `list_icon` varchar(255) NOT NULL,
  `list_etc` varchar(255) NOT NULL,
  `list_type` varchar(255) NOT NULL,
  `list_order` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`list_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `wk_list`
--

INSERT INTO `wk_list` (`list_id`, `list_name`, `list_value`, `list_note`, `list_icon`, `list_etc`, `list_type`, `list_order`) VALUES
(1, 'LAPTOP', 'pc', '(2500/jam)', 'glyphicon-blackboard', '2500', 'select_gadget', 0),
(2, 'HP', 'hp', '(2000/jam)', 'glyphicon-phone', '2000', 'select_gadget', 0),
(3, 'TRANSFER', 'trf', '(pindah menit)', 'glyphicon-transfer', '', 'select_gadget', 0),
(4, 'UANG', 'rupiah', '(rupiah)', 'glyphicon-usd', '', 'select_type', 0),
(5, 'WAKTU', 'menit', '(menit)', 'glyphicon-time', '', 'select_type', 0);

-- --------------------------------------------------------

--
-- Table structure for table `wk_log`
--

CREATE TABLE IF NOT EXISTS `wk_log` (
  `log_id` int(8) NOT NULL AUTO_INCREMENT,
  `log_notes` varchar(2048) NOT NULL,
  `log_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wk_log_mikrotik`
--

CREATE TABLE IF NOT EXISTS `wk_log_mikrotik` (
  `log_mikrotik_id` int(8) NOT NULL AUTO_INCREMENT,
  `log_mikrotik_time` varchar(255) NOT NULL,
  `log_mikrotik_topics` varchar(255) NOT NULL,
  `log_mikrotik_message` varchar(255) NOT NULL,
  `log_mikrotik_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `log_mikrotik_.id` varchar(255) NOT NULL,
  PRIMARY KEY (`log_mikrotik_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wk_mac`
--

CREATE TABLE IF NOT EXISTS `wk_mac` (
  `mac_id` int(11) NOT NULL AUTO_INCREMENT,
  `mac_address` varchar(50) NOT NULL,
  `mac_bgcolor` varchar(50) NOT NULL,
  `mac_note` varchar(100) NOT NULL,
  PRIMARY KEY (`mac_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `wk_mac`
--

INSERT INTO `wk_mac` (`mac_id`, `mac_address`, `mac_bgcolor`, `mac_note`) VALUES
(1, 'F4:EC:38:8E:7C:EF', '#ffdddd', '//ip24-merah'),
(2, 'E8:DE:27:A3:B4:D0', '#ffffb3', '//ip25-kuning'),
(3, '30:B5:C2:1B:5A:CE', '#ddffdd', '//ip26-hijau'),
(4, '00:12:0E:62:8A:92', '#ccebff', '//ip28-biru');

-- --------------------------------------------------------

--
-- Table structure for table `wk_member`
--

CREATE TABLE IF NOT EXISTS `wk_member` (
  `member_id` int(8) NOT NULL AUTO_INCREMENT,
  `member_name` varchar(255) NOT NULL,
  `member_username` varchar(20) NOT NULL,
  `member_password` varchar(255) NOT NULL,
  `member_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `member_lastlogin` datetime NOT NULL,
  `member_notes` varchar(255) NOT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `wk_member`
--

INSERT INTO `wk_member` (`member_id`, `member_name`, `member_username`, `member_password`, `member_registered`, `member_lastlogin`, `member_notes`) VALUES
(4, 'Administator', 'admin', 'YWRtaW5pc3RyYXRvcg==', '2016-05-23 04:06:36', '2016-05-25 11:29:45', 'admin MIKROSTATOR');

-- --------------------------------------------------------

--
-- Table structure for table `wk_menu`
--

CREATE TABLE IF NOT EXISTS `wk_menu` (
  `menu_id` int(8) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) NOT NULL,
  `menu_link` varchar(255) NOT NULL,
  `menu_note` varchar(255) NOT NULL,
  `menu_icon` varchar(255) NOT NULL,
  `menu_etc` varchar(255) NOT NULL,
  `menu_order` int(8) NOT NULL DEFAULT '0',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `wk_menu`
--

INSERT INTO `wk_menu` (`menu_id`, `menu_name`, `menu_link`, `menu_note`, `menu_icon`, `menu_etc`, `menu_order`) VALUES
(1, 'Beranda / Billing', '/MIKROSTATOR/', '', 'glyphicon-time', '', 10),
(7, '***', '', '', '', '', 100),
(8, 'Ngobrolin', 'http://localhost/NET/chat', '', 'glyphicon-comment', 'target="_blank"', 110),
(9, 'Tentang MIKROSTATOR', '/MIKROSTATOR/help/about_mikrostator', '', 'glyphicon-heart', '', 160),
(10, 'Konfigurasi', '/MIKROSTATOR/setting', '', 'glyphicon-cog', '', 60),
(11, 'Sembunyikan / Tampilkan', 'javascript:void(0)', '', 'glyphicon-eye-close', 'onclick="showhidekiri()"', 170),
(13, '***', '', '', '', '', 150),
(14, 'Hotspot', '/MIKROSTATOR/hotspot', '', 'glyphicon-user', '', 20),
(21, 'Bantuan', '/MIKROSTATOR/help', '', 'glyphicon-question-sign', '', 70),
(22, 'Laporan', '/MIKROSTATOR/report', '', 'glyphicon-print', '', 40),
(23, 'Voucher', '/MIKROSTATOR/voucher', '', 'glyphicon-barcode', '', 30);

-- --------------------------------------------------------

--
-- Table structure for table `wk_visitor`
--

CREATE TABLE IF NOT EXISTS `wk_visitor` (
  `visitor_id` int(8) NOT NULL AUTO_INCREMENT,
  `visitor_ip` varchar(255) NOT NULL,
  `visitor_ip2` varchar(255) NOT NULL,
  `visitor_mac` varchar(255) NOT NULL,
  `visitor_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`visitor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wk_voucher`
--

CREATE TABLE IF NOT EXISTS `wk_voucher` (
  `voucher_id` int(11) NOT NULL AUTO_INCREMENT,
  `voucher_name` varchar(255) NOT NULL,
  `voucher_username` varchar(255) NOT NULL,
  `voucher_password_type` varchar(2) NOT NULL COMMENT 'at=automatic, mt=manual',
  `voucher_password` varchar(255) NOT NULL,
  `voucher_qty` int(11) NOT NULL,
  `voucher_user_profile` varchar(255) NOT NULL,
  `voucher_limit_uptime` varchar(255) NOT NULL,
  `voucher_status` varchar(255) NOT NULL,
  PRIMARY KEY (`voucher_id`),
  UNIQUE KEY `voucher_username` (`voucher_username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
