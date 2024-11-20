-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 20, 2024 at 05:18 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ntuchan`
--

-- --------------------------------------------------------

--
-- Table structure for table `Boards`
--

CREATE TABLE `Boards` (
  `board_id` int(11) NOT NULL,
  `board_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Boards`
--

INSERT INTO `Boards` (`board_id`, `board_name`) VALUES
(1, '63CNTT-1'),
(2, '63CNTT-2'),
(3, '63CNTT-3'),
(4, '63CNTT-4'),
(5, '63CNTT-5');

-- --------------------------------------------------------

--
-- Table structure for table `Categories`
--

CREATE TABLE `Categories` (
  `category_id` int(11) NOT NULL,
  `board_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Categories`
--

INSERT INTO `Categories` (`category_id`, `board_id`, `name`, `description`) VALUES
(1, 1, 'Thông báo', 'Thông báo'),
(2, 1, 'Thảo luận linh tinh', 'Thảo luận tùm lum'),
(3, 1, 'Lập trình', 'Thảo luận lập trình'),
(4, 1, 'Giải trí', 'Giải trí, game,...'),
(6, 2, 'Thông báo lớp 63CNTT2', ''),
(7, 2, 'Lập trình', 'Lập trình');

-- --------------------------------------------------------

--
-- Table structure for table `Majors`
--

CREATE TABLE `Majors` (
  `major_id` int(11) NOT NULL,
  `major_name` varchar(100) NOT NULL,
  `major_info` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Majors`
--

INSERT INTO `Majors` (`major_id`, `major_name`, `major_info`) VALUES
(1, 'Công nghệ thông tin', 'Khoa Công nghệ thông tin'),
(3, 'Công nghệ thực phẩm', 'Khoa Công nghệ thực phẩm'),
(4, 'Kĩ thuật', 'Khoa Kĩ thuật');

-- --------------------------------------------------------

--
-- Table structure for table `Notifications`
--

CREATE TABLE `Notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Posts`
--

CREATE TABLE `Posts` (
  `post_id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Posts`
--

INSERT INTO `Posts` (`post_id`, `thread_id`, `user_id`, `content`, `created_at`) VALUES
(1, 1, 1, 'Test', '2024-11-11 12:14:58'),
(2, 1, 36, 'Tét 1', '2024-11-13 12:47:30'),
(3, 1, 37, 'askdjhsakdjsadkj h', '2024-11-13 12:47:46'),
(10, 1, 37, 'こんにちは', '2024-11-13 13:33:20'),
(11, 2, 1, 'aaaaa', '2024-11-13 13:46:19'),
(12, 1, 37, 'ssladkj als\\r\\n', '2024-11-14 03:15:35'),
(13, 1, 37, 'Test message', '2024-11-14 03:15:47'),
(14, 1, 37, '2', '2024-11-14 03:16:37'),
(15, 1, 37, '1111', '2024-11-14 03:16:40'),
(16, 1, 37, 'ấds', '2024-11-14 03:16:43'),
(17, 1, 37, 'https://www.youtube.com/watch?v=2sbYlr0L4L0&list=RD_YnwnxSE2UA&index=3\\r\\n', '2024-11-14 03:16:53'),
(18, 1, 37, 'https://www.youtube.com/watch?v=2sbYlr0L4L0&list=RD_YnwnxSE2UA&index=3', '2024-11-14 03:17:04'),
(19, 1, 37, 'dsaodjaslkdj salkd\\r\\naoskdnasldksand\\\'sak nsald\\r\\n', '2024-11-14 03:17:12'),
(20, 1, 37, 'sao lại có escape characters\\r\\n', '2024-11-14 03:17:29'),
(21, 1, 37, 'sao lại có escape characters\\r\\n', '2024-11-14 03:17:45'),
(22, 1, 37, 'asdasd asdadas d', '2024-11-14 03:18:02'),
(23, 1, 37, 'Một hai ba\\r\\nBốn năm sáu', '2024-11-14 03:18:14'),
(24, 1, 37, 'bảy', '2024-11-14 03:18:22'),
(25, 1, 37, 'test', '2024-11-14 03:19:12'),
(26, 1, 37, 'test', '2024-11-14 03:19:23'),
(27, 1, 37, 'test', '2024-11-14 03:20:19'),
(28, 6, 36, 'ssss', '2024-11-14 11:45:34'),
(29, 7, 36, 'hello', '2024-11-14 11:46:36'),
(30, 8, 36, 'hello', '2024-11-14 11:46:57'),
(31, 9, 36, 'sssssdddd', '2024-11-14 11:47:12'),
(32, 10, 36, 'sd', '2024-11-14 11:48:36'),
(33, 11, 36, 'asdasd', '2024-11-14 11:49:30'),
(34, 11, 36, 'Hello', '2024-11-14 11:49:34'),
(35, 11, 36, 'Hello', '2024-11-14 11:49:38'),
(36, 1, 36, 'aaa', '2024-11-14 11:50:06'),
(37, 1, 36, 'sdd', '2024-11-14 11:50:09'),
(38, 11, 36, 'sASA', '2024-11-14 11:50:18'),
(39, 1, 36, 'dddd', '2024-11-14 11:50:31'),
(40, 1, 36, 'ssaa', '2024-11-14 11:50:58'),
(41, 1, 36, 'dd', '2024-11-14 11:53:20'),
(42, 1, 36, 'dd', '2024-11-14 11:53:25'),
(43, 11, 36, 'dd', '2024-11-14 12:04:41'),
(44, 2, 36, 'cccc', '2024-11-14 12:06:53'),
(45, 2, 36, 'cccc', '2024-11-14 12:07:06'),
(46, 2, 36, 'ssadas', '2024-11-14 12:07:45'),
(47, 2, 36, 'xxxx', '2024-11-14 12:08:34'),
(48, 2, 36, ' ccc', '2024-11-14 12:08:45'),
(49, 12, 36, 'ccccccc', '2024-11-14 12:14:21'),
(50, 13, 36, 'hello', '2024-11-15 23:51:40'),
(51, 13, 36, 'xin chao', '2024-11-15 23:51:46'),
(52, 2, 36, 'hello\\r\\n', '2024-11-17 13:44:01'),
(53, 2, 36, 'hello \\r\\n', '2024-11-17 13:46:36'),
(54, 2, 36, 'hello\\r\\n', '2024-11-17 13:48:36'),
(55, 2, 36, 'Hello \\r\\n', '2024-11-17 13:51:05'),
(56, 2, 36, 'Hello \r\n', '2024-11-17 13:52:41'),
(57, 2, 36, 'Hello \\r\\n\\r\\n', '2024-11-17 13:55:08'),
(58, 2, 36, 'Hello\\r\\n\\r\\n\\r\\n', '2024-11-17 13:55:31'),
(59, 14, 36, 'PHP quá khốn nạn, tại sao không cần init vẫn có thể dùng, mà trên linux thì display_error = off là mặc định', '2024-11-17 15:10:59'),
(60, 14, 37, 'Hay quá bạn ơi, bạn nói chuẩn', '2024-11-17 15:13:14'),
(61, 14, 36, 'Mình cảm ơn bạn', '2024-11-17 15:16:41'),
(62, 14, 36, 'ありがとうございました、minh123さん', '2024-11-17 15:31:01'),
(63, 15, 36, 'Như tiêu đề', '2024-11-17 15:46:34'),
(64, 15, 36, '4 năm đóng đầy đủ bảo hiểm, chưa một lần đi khám trĩ', '2024-11-17 15:47:19'),
(65, 14, 36, 'aaasdsadsada', '2024-11-19 02:26:09');

-- --------------------------------------------------------

--
-- Table structure for table `Threads`
--

CREATE TABLE `Threads` (
  `thread_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `newest_post_at` timestamp NULL DEFAULT NULL,
  `posts_count` int(11) DEFAULT NULL,
  `is_pinned` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Threads`
--

INSERT INTO `Threads` (`thread_id`, `title`, `category_id`, `created_at`, `newest_post_at`, `posts_count`, `is_pinned`) VALUES
(1, 'Thread test', 1, '2024-11-11 12:13:43', NULL, NULL, 1),
(2, 'Thread test số 2', 1, '2024-11-13 13:45:48', NULL, NULL, 0),
(7, 'test', 1, '2024-11-14 11:46:36', NULL, NULL, 0),
(8, 'test', 1, '2024-11-14 11:46:57', NULL, NULL, 0),
(9, 'aaasss', 1, '2024-11-14 11:47:12', NULL, NULL, 0),
(10, 'aa', 1, '2024-11-14 11:48:36', NULL, NULL, 0),
(11, 'test', 1, '2024-11-14 11:49:30', NULL, NULL, 0),
(12, 'cccc', 1, '2024-11-14 12:14:21', NULL, NULL, 0),
(14, 'PHP quá khốn nạn', 3, '2024-11-17 15:10:59', NULL, NULL, 0),
(15, 'Nếu có 10 tỉ trong tay, tôi sẽ gacha 10 triệu', 4, '2024-11-17 15:46:34', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `role` varchar(10) DEFAULT 'user',
  `password_hash` varchar(64) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `major` int(11) DEFAULT NULL,
  `is_banned` tinyint(1) DEFAULT 0,
  `profile_pic` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_logon` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='User table';

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`user_id`, `username`, `role`, `password_hash`, `email`, `major`, `is_banned`, `profile_pic`, `created_at`, `last_logon`) VALUES
(1, 'mingu', 'user', 'admin', NULL, NULL, 0, NULL, '2024-11-11 12:14:41', NULL),
(36, 'minh', 'admin', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', NULL, 3, 0, NULL, '2024-11-13 12:26:10', '2024-11-20 04:16:16'),
(37, 'minh123', 'user', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 'mingu@yandex.ru', NULL, 0, NULL, '2024-11-13 12:26:22', NULL),
(44, 'test', 'user', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 'test@example.com', NULL, 1, NULL, '2024-11-17 15:00:32', '2024-11-20 04:10:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Boards`
--
ALTER TABLE `Boards`
  ADD PRIMARY KEY (`board_id`);

--
-- Indexes for table `Categories`
--
ALTER TABLE `Categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `board_id` (`board_id`);

--
-- Indexes for table `Majors`
--
ALTER TABLE `Majors`
  ADD PRIMARY KEY (`major_id`),
  ADD UNIQUE KEY `major_name` (`major_name`);

--
-- Indexes for table `Notifications`
--
ALTER TABLE `Notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `Posts`
--
ALTER TABLE `Posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `thread_id` (`thread_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `Threads`
--
ALTER TABLE `Threads`
  ADD PRIMARY KEY (`thread_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `created_at` (`created_at`),
  ADD KEY `newest_post_at` (`newest_post_at`),
  ADD KEY `posts_count` (`posts_count`),
  ADD KEY `is_pinned` (`is_pinned`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `major` (`major`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Boards`
--
ALTER TABLE `Boards`
  MODIFY `board_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `Categories`
--
ALTER TABLE `Categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `Majors`
--
ALTER TABLE `Majors`
  MODIFY `major_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Notifications`
--
ALTER TABLE `Notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Posts`
--
ALTER TABLE `Posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `Threads`
--
ALTER TABLE `Threads`
  MODIFY `thread_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Categories`
--
ALTER TABLE `Categories`
  ADD CONSTRAINT `category_board_fk` FOREIGN KEY (`board_id`) REFERENCES `Boards` (`board_id`);

--
-- Constraints for table `Notifications`
--
ALTER TABLE `Notifications`
  ADD CONSTRAINT `notification_user_fk` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`);

--
-- Constraints for table `Posts`
--
ALTER TABLE `Posts`
  ADD CONSTRAINT `post_user_fk` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`);

--
-- Constraints for table `Threads`
--
ALTER TABLE `Threads`
  ADD CONSTRAINT `thread_category_fk` FOREIGN KEY (`category_id`) REFERENCES `Categories` (`category_id`);

--
-- Constraints for table `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `user_major_fk` FOREIGN KEY (`major`) REFERENCES `Majors` (`major_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
