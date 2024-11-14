<?php 
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $db = "ntuchan";
    $conn = mysqli_connect($hostname,$username,$password,$db);
    if(!$conn) {
        die("Error: ". mysqli_connect_error());
    }
    function logout()
    {
        $_SESSION = array();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }
        session_destroy();
        header("Location: ../dangnhap/login.php");
        exit();
    }
?>