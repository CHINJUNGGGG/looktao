-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2020 at 09:17 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `price` double(15,2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `invoice` varchar(255) NOT NULL,
  `type` int(1) NOT NULL DEFAULT 0,
  `list` longtext NOT NULL,
  `price` varchar(255) NOT NULL,
  `slip` varchar(255) DEFAULT NULL,
  `shipping_id` int(1) DEFAULT NULL,
  `tracking_number` text DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT '0',
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `mem_id` int(11) NOT NULL,
  `mem_firstname` varchar(255) NOT NULL,
  `mem_lastname` varchar(255) NOT NULL,
  `mem_username` varchar(255) DEFAULT NULL,
  `mem_password` varchar(255) NOT NULL,
  `mem_email` varchar(255) DEFAULT NULL,
  `mem_address` text DEFAULT NULL,
  `mem_tel` varchar(255) DEFAULT NULL,
  `mem_level` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`mem_id`, `mem_firstname`, `mem_lastname`, `mem_username`, `mem_password`, `mem_email`, `mem_address`, `mem_tel`, `mem_level`) VALUES
(1, 'Panupong', 'Klueakaew', 'looktao', '$2y$10$8L5VbTNMXOUjPAuzeZiON.ttkU02k09HdMpogo0B/HklQJN8mnSEO', 'ch.chinjung@gmail.com', '24/100 Moo 2 Banklang Muang Pathumtani 120001', '0945467731', 0),
(4, 'Test1', 'User1', NULL, '$2y$10$hI619XF8GEnWbu451.GZceVRvG0TvJMKvHPfVBObBr7hE./ijHzCS', 'test@user.com', '24/150 Pathumtani 120001', '09454677312', 0),
(5, 'reewqe', 'wqewqewq', NULL, '$2y$10$ALHynIRKbIygdobXEDScNegkbFCFFUUjuaMZrBCEDHnxV/VW9LHCi', 'test1@user.com', 'test@user.com', '0945467731', 0),
(6, 'ffff', 'ffff', NULL, '$2y$10$q0llE4oe12pkZF6I4nQOUOKakPEaxpwYblWUsVb0w7dhOZV/39QkS', '1234@test.com', 'sdsdsd', '0123456789', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `pro_id` int(11) NOT NULL,
  `pro_name` varchar(100) NOT NULL,
  `pro_price` double(15,2) NOT NULL,
  `pro_quantity` varchar(100) NOT NULL,
  `pro_number` varchar(100) DEFAULT NULL,
  `pro_type` int(11) NOT NULL,
  `pro_detail` varchar(100) NOT NULL,
  `pro_img` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`pro_id`, `pro_name`, `pro_price`, `pro_quantity`, `pro_number`, `pro_type`, `pro_detail`, `pro_img`) VALUES
(1, 'เครื่องชั่ง', 400.00, '11', NULL, 1, 'เป็นเครื่องมือที่ใช้วัดน้ำหนักของวัตถุหรือสิ่งของต่างๆ ซึ่งสามารถแสดงหน่วยวัดได้หลากหลาย', 'img_202010231909835354.png'),
(2, 'แป้นหมุนเค้ก', 200.00, '9', NULL, 2, 'แป้นหมุนสำหรับแต่งหน้าเค้ก แบบพลาสติก ABS Food Grade\r\nทำจากวัสดุ พลาสติกอย่างดี หน้ากว้าง 28 ซ.ม. แป', 'img_202010232006878084.png'),
(3, 'ไม้นวดแป้ง', 150.00, '20', NULL, 3, 'ไม้นวดแป้ง สำหรับคลึงแป้งโดว์ ไอซิ่ง พิซซ่า หรือพาสต้า', 'img_202010231237280634.png'),
(4, 'เตาอบแก๊ส', 5000.00, '20', NULL, 4, 'เตาอบแก๊สรุ่นนี้เป็นเตาอบที่ผลิตภายในประเทศ เหมาะสำหรับผู้ประกอบการธุรกิจขนาดใหญ่ กลาง เล็ก ธุรกิจ S', 'img_202010232076401485.png');

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `shipping_id` int(11) NOT NULL,
  `shipping_name` varchar(255) NOT NULL,
  `price` double(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shipping`
--

INSERT INTO `shipping` (`shipping_id`, `shipping_name`, `price`) VALUES
(1, 'Best Express', 150.00);

-- --------------------------------------------------------

--
-- Table structure for table `tracking`
--

CREATE TABLE `tracking` (
  `id` int(11) NOT NULL,
  `tracking` varchar(255) NOT NULL,
  `price` double(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(255) NOT NULL,
  `type_img` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`type_id`, `type_name`, `type_img`) VALUES
(1, 'Measure', NULL),
(2, 'Decorate', NULL),
(3, 'Mix', NULL),
(4, 'Baked', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`mem_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`pro_id`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`shipping_id`);

--
-- Indexes for table `tracking`
--
ALTER TABLE `tracking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `mem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `pro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `shipping_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tracking`
--
ALTER TABLE `tracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
