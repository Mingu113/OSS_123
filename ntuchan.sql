-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 21, 2024 at 06:04 PM
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
  `post_images` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `Posts`
--

INSERT INTO `Posts` (`post_id`, `thread_id`, `user_id`, `content`, `post_images`, `created_at`) VALUES
(1, 1, 1, 'Test', NULL, '2024-11-11 12:14:58'),
(2, 1, 36, 'Tét 1', NULL, '2024-11-13 12:47:30'),
(3, 1, 37, 'askdjhsakdjsadkj h', NULL, '2024-11-13 12:47:46'),
(10, 1, 37, 'こんにちは', NULL, '2024-11-13 13:33:20'),
(12, 1, 37, 'ssladkj als\\r\\n', NULL, '2024-11-14 03:15:35'),
(13, 1, 37, 'Test message', NULL, '2024-11-14 03:15:47'),
(14, 1, 37, '2', NULL, '2024-11-14 03:16:37'),
(15, 1, 37, '1111', NULL, '2024-11-14 03:16:40'),
(16, 1, 37, 'ấds', NULL, '2024-11-14 03:16:43'),
(17, 1, 37, 'https://www.youtube.com/watch?v=2sbYlr0L4L0&list=RD_YnwnxSE2UA&index=3\\r\\n', NULL, '2024-11-14 03:16:53'),
(18, 1, 37, 'https://www.youtube.com/watch?v=2sbYlr0L4L0&list=RD_YnwnxSE2UA&index=3', NULL, '2024-11-14 03:17:04'),
(19, 1, 37, 'dsaodjaslkdj salkd\\r\\naoskdnasldksand\\\'sak nsald\\r\\n', NULL, '2024-11-14 03:17:12'),
(20, 1, 37, 'sao lại có escape characters\\r\\n', NULL, '2024-11-14 03:17:29'),
(21, 1, 37, 'sao lại có escape characters\\r\\n', NULL, '2024-11-14 03:17:45'),
(22, 1, 37, 'asdasd asdadas d', NULL, '2024-11-14 03:18:02'),
(23, 1, 37, 'Một hai ba\\r\\nBốn năm sáu', NULL, '2024-11-14 03:18:14'),
(24, 1, 37, 'bảy', NULL, '2024-11-14 03:18:22'),
(25, 1, 37, 'test', NULL, '2024-11-14 03:19:12'),
(26, 1, 37, 'test', NULL, '2024-11-14 03:19:23'),
(27, 1, 37, 'test', NULL, '2024-11-14 03:20:19'),
(28, 6, 36, 'ssss', NULL, '2024-11-14 11:45:34'),
(36, 1, 36, 'aaa', NULL, '2024-11-14 11:50:06'),
(37, 1, 36, 'sdd', NULL, '2024-11-14 11:50:09'),
(39, 1, 36, 'dddd', NULL, '2024-11-14 11:50:31'),
(40, 1, 36, 'ssaa', NULL, '2024-11-14 11:50:58'),
(41, 1, 36, 'dd', NULL, '2024-11-14 11:53:20'),
(42, 1, 36, 'dd', NULL, '2024-11-14 11:53:25'),
(50, 13, 36, 'hello', NULL, '2024-11-15 23:51:40'),
(51, 13, 36, 'xin chao', NULL, '2024-11-15 23:51:46'),
(59, 14, 36, 'PHP quá khốn nạn, tại sao không cần init vẫn có thể dùng, mà trên linux thì display_error = off là mặc định', NULL, '2024-11-17 15:10:59'),
(60, 14, 37, 'Hay quá bạn ơi, bạn nói chuẩn', NULL, '2024-11-17 15:13:14'),
(61, 14, 36, 'Mình cảm ơn bạn', NULL, '2024-11-17 15:16:41'),
(62, 14, 36, 'ありがとうございました、minh123さん', NULL, '2024-11-17 15:31:01'),
(63, 15, 36, 'Như tiêu đề', NULL, '2024-11-17 15:46:34'),
(65, 14, 36, 'aaasdsadsada', NULL, '2024-11-19 02:26:09'),
(68, 1, 36, 'alo', NULL, '2024-11-20 13:30:51'),
(69, 1, 36, 'hello', NULL, '2024-11-20 13:30:58'),
(70, 1, 36, 'cyka', NULL, '2024-11-20 13:31:12'),
(71, 1, 36, 'hello', NULL, '2024-11-20 13:33:20');

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
(14, 'PHP quá khốn nạn', 3, '2024-11-17 15:10:59', '2024-11-21 16:44:20', NULL, 0),
(15, 'Nếu có 10 tỉ trong tay, tôi sẽ gacha 10 triệu', 4, '2024-11-17 15:46:34', '2024-11-21 16:52:18', NULL, 0),
(16, 'Thread test', 4, '2024-11-21 12:21:22', '2024-11-21 12:22:55', NULL, 0),
(17, 'thread test 2 ', 4, '2024-11-21 12:27:31', '2024-11-21 12:45:33', NULL, 0),
(18, 'thread test', 4, '2024-11-21 12:47:09', NULL, NULL, 0);

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
(36, 'minh', 'admin', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', NULL, 3, 0, '../images/userpfp/1728702329847875.png', '2024-11-13 12:26:10', '2024-11-21 12:58:42'),
(37, 'minh123', 'user', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 'mingu@yandex.ru', NULL, 0, NULL, '2024-11-13 12:26:22', NULL),
(44, 'test', 'user', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 'test@example.com', NULL, 1, NULL, '2024-11-17 15:00:32', '2024-11-21 12:46:59'),
(45, 'minhtest', 'user', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', NULL, NULL, 0, NULL, '2024-11-20 10:42:06', NULL);

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
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `Threads`
--
ALTER TABLE `Threads`
  MODIFY `thread_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

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
