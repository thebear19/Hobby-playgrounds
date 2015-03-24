-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 21, 2012 at 03:03 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pro`
--

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `role` enum('admin','user') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user',
  `DOR` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`),
  KEY `username_2` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`id`, `username`, `password`, `firstname`, `lastname`, `address`, `email`, `tel`, `role`, `DOR`) VALUES
('0', 'bafapa', '67f43efc5701784db1504e4993d7e393', 'bafapa', 'bafapa', 'bafapa', 'bafapa@hotmail.com', '0000000', 'admin', '2012-03-07 14:54:51'),
('1', 'test', '4da2620db61b4254a336ded63100cf5d', 'testfirst', 'testlast', 'testaddress', 'tmail', '123456', 'user', '2012-03-09 22:10:09');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `no` int(11) NOT NULL,
  `order_id` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `product_id` varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cost` float(9,2) NOT NULL,
  `amount` int(4) NOT NULL,
  `order_status` enum('wait','submit','paid','completed') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'wait',
  `order_date` datetime NOT NULL,
  PRIMARY KEY (`no`),
  KEY `product_id` (`product_id`(255)),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `payment_id` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `order_id` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `cost` float(9,2) NOT NULL,
  `bank` enum('kasikorn','scb') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `payment_check` enum('no','yes') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  PRIMARY KEY (`payment_id`),
  KEY `order_id` (`order_id`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE IF NOT EXISTS `store` (
  `no` int(11) NOT NULL,
  `product_id` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `product_img` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `product_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `product_amount` int(4) NOT NULL,
  `product_cost` float(9,2) NOT NULL,
  `product_type` enum('clothing','shoes') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `product_detail` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  UNIQUE KEY `product_name` (`product_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`no`, `product_id`, `product_img`, `product_name`, `product_amount`, `product_cost`, `product_type`, `product_detail`) VALUES
(1, '@CL001', '00001.jpg', 'Flying on Sunset Dress', 3, 1890.00, 'clothing', 'ผ้าชีฟองริ้วอย่างดีไม่ยับง่าย\r\nลายขนนกน่ารักๆ บนสีพื้นครีม+ส้ม+น้ำตาล\r\nดีเทลคอเว้นหยดน้ำติดกระดุมมุก \r\nและรอบคอติดลูกไม้และลูกปักมุก เย็บทีละชิ้นเลยค่ะ\r\n\r\nแบบสูง 160cm ค่ะ\r\n\r\nSize :อก/เอว/สะโพก\r\nS : 34/free/free\r\nM: 36/free/free\r\nL: 38/free/free \r\nไหล่ 14"/ วงแขน 18"/ ชุดยาว 38"\r\nไหล่ถึงเอว 15.5"/แขนยาว 21 /รอบปลายแขน 7\r\n(ข้อมือกระดุมมุกกรอบทอง)'),
(10, '@CL0010', '00010.jpg', 'Just a piece of cake(Polka dot)', 1, 1890.00, 'clothing', 'เป็นทรงแขนเลยใส่ตัวหลวมค่ะ\r\nsize S = อก 35"\r\nsize M = อก 37"\r\nsize L = อก 39"\r\nยาวเดรส 35" ไหล่ถึงเอว 17" เอวยางยืด/สะโพก ฟรีไซส์ตามสัดส่วน\r\n\r\nผ้าเครปญี่ปุ่น เนื้อไม่ยับง่าย ตัดต่อผ้าสีดำรอบตัว แต่งริบบิ้น ซับกระโปรงค่ะ'),
(11, '@CL0011', '00011.jpg', ' Peach Passion Dress', 4, 1990.00, 'clothing', 'เดรสผ้าชีน่่าร์สีชมพูพีช โทนพาสเทล ผ้าชีน่าร์เนื้อไม่ยับ สีชมพูอ่อน ดีเทลกุ๊นขอบสีม่วงเข้ม เดินไหมสีชมพูบานเย็น สวยหวานมากค่ะ ดีเทลเว้าโค้งที่แขนและชายกระโปรงด้านข้าง\r\nได้ลุคสไตล์คุณหนููู^^ ด้านหน้าตีเกล็ดละเอียดเล็ก ซับในกระโปรง เป็นชุดตัวหลวมค่ะ ใส่สบายๆค่ะ\r\n\r\n**ดีเทลกุ๊นขอบและเดินไหม งานเนี๊ยบมากค่ะ**\r\n\r\nsize S = 34 / 24-34 / F length 34" shoulder to waist 17"\r\nsize M = 36 / 26-36 / F length 34" shoulder to waist 17"'),
(2, '@CL002', '00002.jpg', 'Blue Blythe Dress', 3, 1890.00, 'clothing', 'เดรสผ้าสังเคราะห์เนื้อดี ผิวกึ่งเงา เนื้อไม่ยับ เป็นผ้าสต็อคญี่ปุ่นค่ะ \r\nเอวยางยืด ซับกระโปรง กระดุมทองด้านหลังเป็นลายเกลียวเชือก \r\nทรงแขนเลยผ่าโชว์ไหล่ เซ็กซี่เล็กๆ ใส่แล้วดูเหมือนตุ๊กตาเลยจ๊ะ\r\n\r\nFree size: S/M'),
(3, '@CL003', '00003.jpg', 'City Tribe Dress', 2, 1990.00, 'clothing', 'ชุดเดรสผ้าป่านปักลาย ต่อลายอย่างปรานีต\r\ndetail ตรงหน้าอกซ่อนด้ายตามลายปักละเอียดมากค่ะ\r\nทรงเอ แขนกระดิ่ง ผ้าเนื้อดีใส่สบายมาก \r\nซับในผ้าป่านเนื้อบางทั้งตัว เหมาะกับอากาศบ้านเรา :) \r\nใส่กับกางเกงขาสั้น หรือ legging สีดำก็ได้ค่ะ \r\nแนะนำรองเท้าส้นสูงค่ะ\r\n\r\nมีให้เลือก 2 สี เหลือง/ดำ | ขาว/น้ำเงิน\r\n\r\nsize S: bust 34 Length 32\r\nsize M: bust 36 Length 33\r\nsize L: bust 38 Length 34'),
(4, '@CL004', '00004.jpg', 'Wild Flower Dress', 1, 1490.00, 'clothing', 'เดรสคอตตอนผสม คอวี แขนเลย \r\nลายในตัวเป็นลาย mini polka dotสีแดง \r\nโดดเด่นด้วยดอกไม้สีเทอควอยส์ \r\nไล่เฉดลกราฟฟิคลายจุดสีแดงช่วงบ่าและปลายกระโปรงค่ะ \r\nเอวยางยืดพร้อมสายผูกโบว์ ^^\r\n\r\n**** สี charcoal black (ออกสีเทา ไม่ดำสนิทนะคะ)****\r\n\r\nFree size: S/M'),
(5, '@CL005', '00005.jpg', 'Sense of Romance Dress', 5, 2290.00, 'clothing', 'ชุดเดรสที่ออกแบบและตัดเย็บอย่างปรานีตโดยทีมนักออกแบบของเราเอง\r\nผ้าซุปเปอร์แบล็ค ด้านหน้าตกแต่งระบายเป็น V-shape \r\nดีเทลคอโค้ง กระดุมสไตล์วินเทจมุกกรอบทอง \r\nกระโปรงจับจีบเล็กรอบตัว ไม่พองค่ะ เอวยางยืด ซับในกระโปรง\r\n\r\nมี 2 สี สีชมพูกะปิ และเขียวเทอควอยส์พาสเทลค่ะ\r\n\r\nsize S: bust 32, Length 34\r\nsize M: bust 34, Length 35\r\nsize L: bust 36, Length 36'),
(6, '@CL006', '00006.jpg', ' LINE on my LANE Dress', 1, 2290.00, 'clothing', 'เดรสลายทางขาวดำสุดชิคต่อลาย คอบัว ซิปหลัง ซับกระโปรง\r\nเทคเจอร์ผ้า polyester อย่างดี คอบัวขาวเหลือบเงาเล็กน้อยดูหรูค่ะ\r\nวางผ้าตัดเย็บแบบต่อลายให้ค่ะ\r\n\r\nsize S: bust 32, Length 34\r\nsize M: bust 34, Length 35\r\nsize L: bust 36, Length 36'),
(7, '@CL007', '00007.jpg', 'Desire in Design Dress', 2, 1290.00, 'clothing', 'ผ้าคอตตอนนิ่ม ใส่สบาย สีสดสวยค่ะ คอวี\r\nซิปหลัง มีสายผูกโบว์ มีซับกระโปรง\r\n\r\nFree size S/M ช่วงหน้าอกตึงสุดได้ถึง 38"\r\nความยาว 35"'),
(8, '@CL008', '00008.jpg', 'When we were young dress', 2, 1890.00, 'clothing', 'ผ้าชีฟองสีครีม ivory ตัดต่อผ้้าลายทาง+ดอกไม้จิ๋วๆโทนสีน้ำตาล\r\nสีเหมือนช็อคโกแลตรสครีมถั่ว :))\r\nด้านหน้าตีเกล็ดเล็ก ซับกระโปรง\r\n\r\nSize S =อก 35"\r\nSize M=อก 37"\r\nSize L =อก 39"\r\n\r\nเป็นเสื้อทรงแขนเลยค่ะ ใส่แบบตัวหลวม ไม่เข้ารูป\r\nเอว-สะโพกฟรีไซส์'),
(9, '@CL009', '00009.jpg', 'Oblique Dress', 1, 1890.00, 'clothing', 'ผ้าเนื้อเหลือบเงา เล็กน้อยเป็นประกายเล็กน้อย ต่อลายทั้งตัว \r\nช่วงตัวลายขวาง กระโปรงต่อลายผ้าเฉียง \r\nซับในทั้งตัวเป็นผ้าเครปนอกเนื้อเงา ใส่สบายมากค่ะ \r\nซิปหลัง เป็นชุดใส่พอดีตัวค่ะ\r\n\r\nsize S = 32 / 26 / F length 34" shoulder to waist 15"\r\nsize M = 34 / 28 / F length 35" shoulder to waist 15"\r\n\r\nมี 2 สี โทนเขียว-ครีมทอง และม่วง-ครีมทอง');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`username`) REFERENCES `members` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`username`) REFERENCES `members` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
