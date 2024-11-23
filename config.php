<?php 
    // $hostname = "localhost:3306";
    // $username = "ntu304@localhost";
    // $password = "";
    // $db = "ntu304_ntuchan";
    // $conn = mysqli_connect($hostname,$username,$password,$db);
    // if(!$conn) {
    //     die("Error: ". mysqli_connect_error());
    //}
?>

<?php 
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $db = "ntuchan";
    $conn = mysqli_connect($hostname,$username,$password,$db);
    if(!$conn) {
        die("Error: ". mysqli_connect_error());
    }
?>