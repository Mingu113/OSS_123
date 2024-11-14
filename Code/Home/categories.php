<?php 
session_start(); // Khởi tạo session
require "../config.php";

if(isset($_GET["name"])){
    // Lấy dữ liệu từ URL
    $name = $_GET["name"];

    // Tìm kiếm trong bảng categories
    $search_ca = "SELECT * FROM `categories` WHERE `name` LIKE '%$name%'";
    $result_categories = mysqli_query($conn, $search_ca);
    $category = mysqli_fetch_assoc($result_categories);
    $ca = $category["category_id"];

    // Đếm tổng số threads thuộc category này
    $count_th_ca_query = "SELECT COUNT(*) as total FROM `threads` WHERE `category_id` = $ca";
    $count_th_ca_result = mysqli_query($conn, $count_th_ca_query);
    $total_threads = mysqli_fetch_assoc($count_th_ca_result)['total'];

    // Số lượng threads mỗi trang
    $threads_per_page = 10;

    // Số trang hiện tại từ URL hoặc mặc địn là 1
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if($page<1) $page = 1;

    // Tính vị trí cho LIMIT
    $offset = ($page -1) * $threads_per_page;

    // Truy vấn threads theo giới hạn
    $search_th_ca = "SELECT * FROM `threads` WHERE `category_id` = $ca LIMIT $offset, $threads_per_page";
    $result_threads_ca = mysqli_query($conn, $search_th_ca);
    $threads_ca = [];
    while($thread = mysqli_fetch_assoc($result_threads_ca)){
        $threads_ca[] = $thread;
    }

    // Lưu kết quả vào sesion   
    $_SESSION['categories_results'] = [ 
        'threads_ca' => $threads_ca,
        'name' => $name,
        'total_threads' => $total_threads,
        'thread_per_page' => $threads_per_page,
        'current_page' => $page
     ];

    // Chuyển hướng 
    header("Location:../category/list.php");
    exit();
}
?>