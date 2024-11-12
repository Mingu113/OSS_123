<?php
require "../config.php";
$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];
$query = "SELECT * FROM `Users` WHERE username = '$username' ";
$accounts = mysqli_query($connect, $query);
$password = hash("sha256", $password + $username);
// Vi cac tai khoan la UNIQUE theo username nen lay cai rows dau tien
if(mysqli_num_rows($accounts) = 0) {
    echo "Tai khoan khong ton tai, hoac nhap sai username";
} else {
    $row = mysqli_fetch_array($accounts);
    if($row['password_hash'] == $password) {
        $_SESSION('username') = $username;
        header("../../UI/home.php");
    }
}
$result = mysqli_query($connect, $query);
if ($result) {
    echo "<h1>Dang nhap thanh cong</h1>";
}
?>