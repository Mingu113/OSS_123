<?php
require "../config.php";
$username = $_POST["username"];
$password = $_POST["password"];
$email = $_POST["email"];
$major = $_POST["major"];
$password = hash("sha256", $password + $username);
$query = "INSERT INTO `Users` (`user_id`, `username`, `password_hash`, `email`, `major`, `profile_pic`, `created_at`, `last_logon`) VALUES (NULL, '$username', '$password', '$email', '$major', NULL, current_timestamp(), NULL) ";
$result = mysqli_query($connect, $query);
if ($result) {
    echo "<h1>Dang ki thanh cong</h1>";
    header ("../authentication/login.php");
}
?>