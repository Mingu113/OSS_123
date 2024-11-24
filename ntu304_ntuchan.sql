-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th10 24, 2024 lúc 08:03 PM
-- Phiên bản máy phục vụ: 10.6.19-MariaDB-cll-lve
-- Phiên bản PHP: 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `ntu304_ntuchan`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `Boards`
--

CREATE TABLE `Boards` (
  `board_id` int(11) NOT NULL,
  `board_name` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `Boards`
--

INSERT INTO `Boards` (`board_id`, `board_name`) VALUES
(1, '63CNTT-1'),
(2, '63CNTT-2'),
(3, '63CNTT-3'),
(4, '63CNTT-4'),
(5, '63CNTT-5');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `Categories`
--

CREATE TABLE `Categories` (
  `category_id` int(11) NOT NULL,
  `board_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `Categories`
--

INSERT INTO `Categories` (`category_id`, `board_id`, `name`, `description`) VALUES
(2, 1, 'Thảo luận linh tinh', 'Thảo luận tùm lum'),
(3, 1, 'Lập trình', 'Thảo luận lập trình'),
(4, 1, 'Giải trí', 'Giải trí, game,...'),
(6, 2, 'Thông báo lớp 63CNTT2', ''),
(7, 2, 'Lập trình', 'Lập trình'),
(8, 1, 'Thông báo', 'Thông báo lớp 63CNTT-1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `Majors`
--

CREATE TABLE `Majors` (
  `major_id` int(11) NOT NULL,
  `major_name` varchar(100) NOT NULL,
  `major_info` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `Majors`
--

INSERT INTO `Majors` (`major_id`, `major_name`, `major_info`) VALUES
(1, 'Công nghệ thông tin', 'Khoa Công nghệ thông tin'),
(3, 'Công nghệ thực phẩm', 'Khoa Công nghệ thực phẩm'),
(4, 'Kĩ thuật', 'Khoa Kĩ thuật');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `Notifications`
--

CREATE TABLE `Notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` mediumtext DEFAULT NULL,
  `link` text DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `Notifications`
--

INSERT INTO `Notifications` (`notification_id`, `user_id`, `content`, `link`, `is_read`, `created_at`) VALUES
(1, 47, 'Có người đã trả lời bình luận của bạn', '/thread.php?id=21', 0, '2024-11-24 13:02:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `Posts`
--

CREATE TABLE `Posts` (
  `post_id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` mediumtext NOT NULL,
  `post_images` mediumtext DEFAULT NULL,
  `reply_to` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `Posts`
--

INSERT INTO `Posts` (`post_id`, `thread_id`, `user_id`, `content`, `post_images`, `reply_to`, `created_at`) VALUES
(59, 14, 36, 'PHP quá khốn nạn, tại sao không cần init vẫn có thể dùng, mà trên linux thì display_error = off là mặc định', NULL, NULL, '2024-11-17 15:10:59'),
(60, 14, 37, 'Hay quá bạn ơi, bạn nói chuẩn', NULL, NULL, '2024-11-17 15:13:14'),
(61, 14, 36, 'Mình cảm ơn bạn', NULL, NULL, '2024-11-17 15:16:41'),
(62, 14, 36, 'ありがとうございました、minh123さん', NULL, NULL, '2024-11-17 15:31:01'),
(63, 15, 36, 'Như tiêu đề', NULL, NULL, '2024-11-17 15:46:34'),
(65, 14, 36, 'aaasdsadsada', NULL, NULL, '2024-11-19 02:26:09'),
(158, 14, 36, 'xin chào', NULL, NULL, '2024-11-22 10:07:46'),
(159, 14, 36, 'Đăng hình ảnh', './images/user_posts_img/14619316466740580e0f7094.88477310Screenshot_20240927_222209.png', NULL, '2024-11-22 10:08:14'),
(160, 19, 36, 'Trọng chưa có công ty đi thực tập', NULL, NULL, '2024-11-22 10:11:58'),
(161, 19, 36, 'test', './images/user_posts_img/86184330467405a1f87da88.26641380Screenshot_20241001_220003.png,./images/user_posts_img/42770953667405a1f881d93.05129479Screenshot_20241001_222024.png,./images/user_posts_img/175675502767405a1f88f760.57861100Screenshot_20241001_172205.png,./images/user_posts_img/42325230967405a1f892a68.77489202Screenshot_20241001_215911.png', NULL, '2024-11-22 10:17:03'),
(162, 20, 46, 'Chào mọi người nha', NULL, NULL, '2024-11-22 10:27:13'),
(163, 14, 47, 'Toi ghet php', NULL, NULL, '2024-11-22 10:28:27'),
(164, 14, 47, 'Toi ghet php', NULL, NULL, '2024-11-22 10:28:30'),
(165, 14, 47, 'Toi ghet php', NULL, NULL, '2024-11-22 10:28:40'),
(166, 20, 36, 'Chào bạn Chánh', NULL, NULL, '2024-11-22 10:29:17'),
(167, 14, 47, 'Toi ghet php', NULL, NULL, '2024-11-22 10:29:33'),
(168, 20, 46, 'Chào bạn minh\\r\\n', NULL, NULL, '2024-11-22 10:29:45'),
(169, 20, 47, 'hello', NULL, NULL, '2024-11-22 10:30:10'),
(170, 20, 47, 'hello', NULL, NULL, '2024-11-22 10:30:18'),
(171, 21, 47, 'Sắp tới noel mà chưa có bồ', NULL, NULL, '2024-11-22 10:32:14'),
(172, 19, 49, 'hả', NULL, NULL, '2024-11-22 13:52:05'),
(173, 21, 47, '.', NULL, NULL, '2024-11-22 15:18:43'),
(174, 19, 36, 't muốn chơi GFL 2 nhưng mà game lại chặn vùng Việt Nam trong khi cả ĐNÁ đều chơi được', './images/user_posts_img/9444280466740a17b2437e7.474334711731790079112064.jpg', NULL, '2024-11-22 15:21:31'),
(175, 20, 36, 'hú', NULL, NULL, '2024-11-23 12:07:33'),
(176, 22, 36, 'Dùng đi, ok lắm', NULL, NULL, '2024-11-23 12:43:01'),
(177, 22, 36, 'Bình luận trên NTUCHAN', NULL, NULL, '2024-11-23 14:35:04'),
(178, 22, 51, 'Xin chào', NULL, NULL, '2024-11-23 14:41:16'),
(179, 20, 52, 'Hello', NULL, NULL, '2024-11-23 14:55:50'),
(180, 20, 36, 'Lô', NULL, NULL, '2024-11-23 15:17:31'),
(181, 22, 47, '.', NULL, NULL, '2024-11-24 06:56:49'),
(182, 21, 36, 'Nói sao buồn dữ Bảo', './images/user_posts_img/128139397674323d2e10a35.52226266ngt8nb4hf4j21-4117496169.png', 173, '2024-11-24 13:02:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `Threads`
--

CREATE TABLE `Threads` (
  `thread_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `newest_post_at` timestamp NULL DEFAULT NULL,
  `posts_count` int(11) DEFAULT NULL,
  `is_pinned` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `Threads`
--

INSERT INTO `Threads` (`thread_id`, `title`, `category_id`, `created_at`, `newest_post_at`, `posts_count`, `is_pinned`) VALUES
(14, 'PHP quá khốn nạn', 3, '2024-11-17 15:10:59', '2024-11-22 10:29:33', NULL, 0),
(15, 'Nếu có 10 tỉ trong tay, tôi sẽ gacha 10 triệu', 4, '2024-11-17 15:46:34', '2024-11-21 16:52:18', NULL, 0),
(19, 'Thằng Trọng có bạn gái', 6, '2024-11-22 10:11:58', '2024-11-22 15:21:31', NULL, 0),
(20, 'Xin chào ', 2, '2024-11-22 10:27:13', '2024-11-23 15:17:31', NULL, 0),
(21, 'Nơi lạnh nhất lúc này: NTU', 4, '2024-11-22 10:32:14', '2024-11-24 13:02:10', NULL, 0),
(22, 'Dùng Thunderbird để xem, viết và gửi email', 3, '2024-11-23 12:43:01', '2024-11-24 06:56:49', NULL, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `Users`
--

CREATE TABLE `Users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `role` varchar(10) DEFAULT 'user',
  `password_hash` varchar(64) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `major` int(11) DEFAULT NULL,
  `is_banned` tinyint(1) DEFAULT 0,
  `profile_pic` mediumtext DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_logon` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='User table';

--
-- Đang đổ dữ liệu cho bảng `Users`
--

INSERT INTO `Users` (`user_id`, `username`, `role`, `password_hash`, `email`, `major`, `is_banned`, `profile_pic`, `created_at`, `last_logon`) VALUES
(36, 'minh', 'admin', '28a79a4d92dbed3387cb7c8a717a14d429ed1ef02d487be9641ea043ae935d50', NULL, 1, 0, './images/userpfp/Akarin.jpg', '2024-11-13 12:26:10', '2024-11-24 13:00:57'),
(37, 'minh123', 'user', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 'mingu@yandex.ru', NULL, 0, './images/userpfp/default.jpg', '2024-11-13 12:26:22', '2024-11-23 10:56:44'),
(44, 'test', 'user', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 'test@example.com', NULL, 1, NULL, '2024-11-17 15:00:32', '2024-11-24 06:51:16'),
(45, 'minhtest', 'user', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', NULL, NULL, 1, NULL, '2024-11-20 10:42:06', NULL),
(46, 'chanhle', 'user', '1df1854015e31ca286d015345eaff29a6c6073f70984a3a746823d4cac16b075', 'congchanh2017@gmail.com', 1, 0, './images/userpfp/banner1.png', '2024-11-22 10:23:36', '2024-11-22 10:25:29'),
(47, 'bao', 'user', '2e95ac47e6fc00030224e20194ce3a9bfa03717c32b5fa2e95b111d7053916a6', 'bao@ntu', 1, 0, './images/userpfp/forums_logo.png', '2024-11-22 10:27:01', '2024-11-24 13:02:55'),
(48, 'clone', 'user', 'b5d61dc89a35d2c924b28c9760765da94039e94184c50f87dde54532f126b4ac', 'clone@clone', 3, 0, NULL, '2024-11-22 10:33:17', '2024-11-22 10:33:21'),
(49, 'Linh', 'user', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'hutt@ntu.edu.vn', 1, 0, NULL, '2024-11-22 13:51:12', '2024-11-24 12:40:41'),
(50, 'Bitadeptraivodich', 'user', '63014b21fca1e9e5e20d0e4a2e1d45e6da1d734a8549c6c56cec2843169a3965', 'duykhanh41hg@gmail.com', 1, 0, NULL, '2024-11-23 11:03:55', '2024-11-23 11:04:20'),
(51, 'user', 'user', 'e606e38b0d8c19b24cf0ee3808183162ea7cd63ff7912dbb22b5e803286b4446', NULL, 1, 0, NULL, '2024-11-23 14:40:58', '2024-11-23 14:41:05'),
(52, 'Trong', 'user', 'dd130a849d7b29e5541b05d2f7f86a4acd4f1ec598c1c9438783f56bc4f0ff80', 'damtrongj095@gmail.com', 1, 0, './images/userpfp/people.jpg', '2024-11-23 14:54:16', '2024-11-23 14:54:27');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `Boards`
--
ALTER TABLE `Boards`
  ADD PRIMARY KEY (`board_id`);

--
-- Chỉ mục cho bảng `Categories`
--
ALTER TABLE `Categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `board_id` (`board_id`);

--
-- Chỉ mục cho bảng `Majors`
--
ALTER TABLE `Majors`
  ADD PRIMARY KEY (`major_id`),
  ADD UNIQUE KEY `major_name` (`major_name`);

--
-- Chỉ mục cho bảng `Notifications`
--
ALTER TABLE `Notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `Posts`
--
ALTER TABLE `Posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `thread_id` (`thread_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `Threads`
--
ALTER TABLE `Threads`
  ADD PRIMARY KEY (`thread_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `created_at` (`created_at`),
  ADD KEY `newest_post_at` (`newest_post_at`),
  ADD KEY `posts_count` (`posts_count`),
  ADD KEY `is_pinned` (`is_pinned`);

--
-- Chỉ mục cho bảng `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `major` (`major`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `Boards`
--
ALTER TABLE `Boards`
  MODIFY `board_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `Categories`
--
ALTER TABLE `Categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `Majors`
--
ALTER TABLE `Majors`
  MODIFY `major_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `Notifications`
--
ALTER TABLE `Notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `Posts`
--
ALTER TABLE `Posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=183;

--
-- AUTO_INCREMENT cho bảng `Threads`
--
ALTER TABLE `Threads`
  MODIFY `thread_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `Users`
--
ALTER TABLE `Users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `Categories`
--
ALTER TABLE `Categories`
  ADD CONSTRAINT `category_board_fk` FOREIGN KEY (`board_id`) REFERENCES `Boards` (`board_id`);

--
-- Các ràng buộc cho bảng `Notifications`
--
ALTER TABLE `Notifications`
  ADD CONSTRAINT `notification_user_fk` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`);

--
-- Các ràng buộc cho bảng `Posts`
--
ALTER TABLE `Posts`
  ADD CONSTRAINT `post_user_fk` FOREIGN KEY (`user_id`) REFERENCES `Users` (`user_id`);

--
-- Các ràng buộc cho bảng `Threads`
--
ALTER TABLE `Threads`
  ADD CONSTRAINT `thread_category_fk` FOREIGN KEY (`category_id`) REFERENCES `Categories` (`category_id`);

--
-- Các ràng buộc cho bảng `Users`
--
ALTER TABLE `Users`
  ADD CONSTRAINT `user_major_fk` FOREIGN KEY (`major`) REFERENCES `Majors` (`major_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
