-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: database
-- Generation Time: Aug 20, 2024 at 08:54 AM
-- Server version: 11.5.2-MariaDB-ubu2404
-- PHP Version: 8.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `visit`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth`
--

CREATE TABLE `auth` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `updated` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auth`
--

INSERT INTO `auth` (`id`, `user_id`, `status`, `updated`, `created`) VALUES
(1, 1, 1, '2024-08-20 13:31:08', '2024-08-20 13:18:48');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `uuid` binary(20) NOT NULL,
  `user` varchar(100) NOT NULL,
  `name` varchar(200) NOT NULL,
  `contact` varchar(100) NOT NULL,
  `project` varchar(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `updated` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `uuid`, `user`, `name`, `contact`, `project`, `status`, `updated`, `created`) VALUES
(1, 0x65396137336538662d356563332d313165662d39, 'พี่อาร์ม', 'Point architect', '1169', 'Bali Villa @Samui', 1, '2024-08-20 15:15:31', '2024-08-20 14:14:59'),
(2, 0x64386262386233632d356563632d313165662d39, 'คุณเนี๊ยบ', 'So architect', '12312121', 'บ้านพักส่วนตัว ', 1, '2024-08-20 15:42:05', '2024-08-20 15:18:56'),
(3, 0x38303662396239382d356564312d313165662d39, 'คุณออม', 'greymatter', '123456', 'M level', 1, NULL, '2024-08-20 15:52:15');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `uuid` binary(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `level` int(1) NOT NULL DEFAULT 1,
  `status` int(1) NOT NULL DEFAULT 1,
  `updated` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `uuid`, `email`, `password`, `level`, `status`, `updated`, `created`) VALUES
(1, 0x30323133653763342d383961612d313165652d62, 'admin@test.com', '$2y$10$zgN7Tu3Yxcj/w0KCbhEBy.5EuYiJRPaDMd50CJ4L0D5a7pcVh/dgC', 9, 1, '2024-08-03 10:25:25', '2023-11-23 09:42:54');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `id` int(11) NOT NULL,
  `uuid` binary(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` int(1) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `reason` int(11) NOT NULL,
  `remark` mediumtext NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `updated` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`id`, `uuid`, `user_id`, `type`, `customer_id`, `reason`, `remark`, `latitude`, `longitude`, `status`, `updated`, `created`) VALUES
(1, 0x65396137653866612d356563332d313165662d39, 1, 1, 1, 1, 'Point architect พี่อาร์ม เข้าพบทีมสถาปนิกนำเสนอสินค้า \r\nและติดตามงานออกแบบ เบื้องต้นก่อนหน้านี้ใช้cotto เป็นหลัก \r\nพี่อาร์มให้ความสนใจจะส่งข้อมูล ให้เทียบ \r\nกำลังออกแบบวิลล่า7หลัง  Bali Villa @Samui \r\nและขอแผงตัวอย่าง กลุ่ม Artifact Stone 1 cm ด้วย', '13.7374995', '100.5570484', 1, '2024-08-20 14:40:21', '2024-08-20 14:14:59'),
(3, 0x34343237643734362d356564312d313165662d39, 1, 2, 2, 2, 'So architect พบคุณเนี๊ยบ คุยงานบ้านพักส่วนตัว เอากระเบื้องเทียบตามtive เข้ามาให้เลือก\r\nคุณเนี๊ยบจะเอาไปเสนอowner และจะพาทางownerเข้ามาดูกระเบื้องที่โชว์รูมอีกทีค่ะ', '13.7374995', '100.5570484', 1, NULL, '2024-08-20 15:50:34'),
(4, 0x38303662663133352d356564312d313165662d39, 1, 1, 3, 1, 'greymatter นำกระเบื้องฟูบอดี้เอามาให้คุณออมของโครงการ M level\r\nและนำตัวอย่างลาย terrazzo มาให้คุณมัดมี่ของโครงการ โรงแรมที่ภูเก็ตค่ะ', '13.7374995', '100.5570484', 1, NULL, '2024-08-20 15:52:15');

-- --------------------------------------------------------

--
-- Table structure for table `system`
--

CREATE TABLE `system` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_email` varchar(200) NOT NULL,
  `password_default` varchar(50) NOT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system`
--

INSERT INTO `system` (`id`, `name`, `email`, `password_email`, `password_default`, `updated`) VALUES
(1, 'Visit Plan', 'cpl.issue@gmail.com', 'wtubrchtfugusotb', 'testtest', '2024-08-20 08:47:54');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `contact` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `login`, `firstname`, `lastname`, `contact`) VALUES
(1, 1, 'Admin', 'Test', '-');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth`
--
ALTER TABLE `auth`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system`
--
ALTER TABLE `system`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth`
--
ALTER TABLE `auth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `system`
--
ALTER TABLE `system`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
