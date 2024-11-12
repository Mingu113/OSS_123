<?php
require "../config.php";
$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];
$major = $_POST["major"];
$password = hash("sha256", $password + $username);
$query_check = "SELECT * FROM `Users` WHERE username = $username; ";
// Kiem tra xem thu tai khoan dinh dang ky da ton tai hay chua
$result = mysqli_query(mysql: $connect, query: $query_check);
if($result) {
    echo "Tài khoản đã tồn tại";
    $result = null;
    header("../authentication/register.php");
}
// neu chua thi xac nhan them vao db
$query = "INSERT INTO `Users` (`user_id`, `username`, `password_hash`, `email`, `major`, `profile_pic`, `created_at`, `last_logon`) VALUES (NULL, '$username', '$password', '$email', '$major', NULL, current_timestamp(), NULL); ";
$result = mysqli_query(mysql: $connect, query: $query);
if ($result) {
    echo "<h1>Đăng ký thành công</h1>";
    header ("../authentication/login.php");
} else {
    echo mysqli_connect_error();
}
mysqli_close($connect);
?>
