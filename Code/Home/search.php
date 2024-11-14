<?php 
session_start(); // Khởi tạo session
require "../config.php";

if (isset($_POST["search"]) && !empty($_POST["search"]) || isset($_GET["search"])) {
    // Lấy dữ liệu từ form
    $key = addslashes($_POST["search"]);
    if($key==NULL){
        $key = addslashes($_GET['search']);
    }

    // Đếm tổng sô search có trong Threads và Posts
    $total_search_query = "SELECT COUNT(DISTINCT Threads.thread_id) AS total
        FROM Threads 
        LEFT JOIN Posts ON Threads.thread_id = Posts.thread_id 
        WHERE Threads.title LIKE '%$key%' OR Posts.content LIKE '%$key%'";
    $total_search_results = mysqli_query($conn, $total_search_query);
    $total_search = mysqli_fetch_assoc($total_search_results)['total'];

    // Số lượng threads mỗi trang
    $search_per_page = 10;

    // Số trang hiện tại từ URL hoặc mặc định là 1
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if($page<1) $page = 1;

    // Tính vị trí cho LIMIT
    $offset = ($page -1) * $search_per_page;

    // Truy vấn dữ liệu theo giới hạn để phân trang
    $search_query = "SELECT 
            Threads.thread_id, 
            Threads.Title, 
            Threads.category_id, 
            Threads.created_at AS thread_created_at, 
            Threads.newest_post_at, 
            Threads.posts_count, 
            Threads.is_pinned, 
            Posts.post_id, 
            Posts.user_id, 
            Posts.content AS post_content, 
            Posts.created_at AS post_created_at
        FROM Threads 
        LEFT JOIN Posts ON Threads.thread_id = Posts.thread_id 
        WHERE Threads.title LIKE '%$key%' OR Posts.content LIKE '%$key%'
        ORDER BY Threads.created_at DESC
        LIMIT $offset, $search_per_page";

    $se_result = mysqli_query($conn, $search_query);
    $search_results = [];
    while ($row = mysqli_fetch_assoc($se_result)) {
        $search_results[] = $row;
    }

    // Lưu kết quả vào session
    $_SESSION['search_results'] = $search_results;
    $_SESSION['total_search'] = $total_search;
    $_SESSION['search_per_page'] = $search_per_page;
    $_SESSION['search'] = $key;
    $_SESSION['current_page'] = $page;


    // Chuyển hướng 
    header("Location:../trangchu/categories.php");
    exit();
} elseif(isset($_POST["search"])) {
    echo "<script>alert('Lỗi: Dữ liệu nhập không hợp lệ. Vui lòng nhập lại.'); window.history.back();</script>";
    exit();
}
?>
