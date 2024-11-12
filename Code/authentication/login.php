<?php
require "../config.php";
$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];
$query = "SELECT * FROM `Users` WHERE username = '$username'; ";
$accounts = mysqli_query($connect, $query);
$password = hash("sha256", $password + $username);
// Vi cac tai khoan la UNIQUE theo username nen lay cai rows dau tien
if(mysqli_num_rows($accounts) < 1) {
    echo "Tài khoản không tồn tại, hoặc nhập sai tên người dùng";
} else {
    $row = mysqli_fetch_array($accounts);
    if($row['password_hash'] == $password) {
        $_SESSION('username') = $username;
    }
}
if ($result) {
    echo "<h1>Đăng nhập thành công</h1>";
    header("../../UI/home.php");
}
mysqli_close($connect);
?>
