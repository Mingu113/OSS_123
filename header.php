<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <style>
        .navbar {
            position: sticky;
            top: 0;
            z-index: 1020;
        }
    </style>
</head>
<body>
<?php
session_start();
$isLoggedIn = isset($_SESSION["username"], $_SESSION["user_id"]);
if ($isLoggedIn) {
    $username = $_SESSION["username"];
    $user_id = $_SESSION["user_id"];
} else {
    $username = "";
}
$profileImage = (!empty($_SESSION["pfp"]) && realpath($_SESSION["pfp"])) ? $_SESSION["pfp"] : "./images/default.jpg";
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
    <a class="navbar-brand" href="./index.php">NTUCHAN</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarSupportedContent">
        <?php require "./tool.php" ?>
        <div>
            <?php if (!empty($username)): ?>
                <!-- Dropdown -->
                <div class="dropdown">
                    <a href="#" id="dropdownMenuButton" class="d-flex align-items-center text-decoration-none dropdown-toggle"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="<?php echo $profileImage; ?>" class="rounded-circle" width="40" height="40" alt="Profile">
                        <span class="font-weight-bold text-white ml-2"><?php echo htmlspecialchars($username); ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="./user.php">
                            <i class="fas fa-user-circle"></i> Trang cá nhân
                        </a>
                        <a class="dropdown-item" href="./login.php">
                            <i class="fas fa-sign-out-alt"></i> Đăng Xuất
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <a href="./login.php">
                    <button class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Đăng Nhập</button>
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>
</body>
</html>
