<?php 
session_start(); // Khởi tạo session
require "../config.php";

if (isset($_POST["search"]) && !empty($_POST["search"])) {
    $key = addslashes($_POST["search"]);

    // Tìm kiếm trong bảng threads
    $search_th = "SELECT * FROM `threads` WHERE `title` LIKE '%$key%'";
    $result_threads = mysqli_query($conn, $search_th);
    $threads = [];
    while ($thread = mysqli_fetch_assoc($result_threads)) {
        $threads[] = $thread;
    }

    // Tìm kiếm trong bảng posts
    $search_po = "SELECT * FROM `posts` WHERE `content` LIKE '%$key%'";
    $result_posts = mysqli_query($conn, $search_po);
    $posts = [];
    while ($post = mysqli_fetch_assoc($result_posts)) {
        $posts[] = $post;
    }

    // Lưu kết quả vào session
    $_SESSION['search_results'] = [
        'threads' => $threads,
        'posts' => $posts
    ];

    // Chuyển hướng đến file search_results.php
    header("Location:../authentication/login.php");
    exit();
} else {
    echo "<script>alert('Lỗi: Dữ liệu nhập không hợp lệ. Vui lòng nhập lại.'); window.history.back();</script>";
    exit();
}
?>
