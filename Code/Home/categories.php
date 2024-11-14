<?php 
session_start(); // Khởi tạo session
require "../config.php";

if(isset($_GET["name"])){
    // Lấy dữ liệu từ URL
    $name = $_GET["name"];

    // Tìm kiếm trong bảng categories
    $search_ca = "SELECT * FROM `Categories` WHERE `name` LIKE '%$name%'";
    $result_categories = mysqli_query($conn, $search_ca);
    $category = mysqli_fetch_assoc($result_categories);
    $ca = $category["category_id"];

    // Chuyển hướng 
    header("Location:../trangchu/threads.php?name=$name&category_id=$ca");
    exit();
}
?>