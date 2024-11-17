<?php 
    session_start();
    $isLoggedIn = isset($_SESSION["username"], $_SESSION["user_id"]);
    if ($isLoggedIn) {
        $username = $_SESSION["username"];
        $user_id = $_SESSION["user_id"];
    } else {
        $username = "";
    }
    $profileImage = !empty($_SESSION["pfp"]) ? $_SESSION["pfp"] : "../images/default.jpg";
    ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
        <a class="navbar-brand" href="../trangchu/home.php">NTUCHAN</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarSupportedContent">
            <?php require "../search/tool.php" ?>
            <div>
                <?php if (!empty($username)): ?>
                    <a href="../nguoidung/user.php" class="mr-3 text-decoration-none">
                        <img src="<?php echo $profileImage; ?>" class="rounded-circle" width="40" height="40">
                        <span class="font-weight-bold text-white"><?php echo htmlspecialchars($username); ?></span>
                    </a>
                <?php else: ?>
                    <a href="../dangnhap/login.php"><button class="btn btn-primary">Login</button></a>
                <?php endif; ?>
                <a href="?logout" class="btn btn-secondary"><i class="fas fa-sign-out-alt"></i> Đăng Xuất</a>
            </div>
        </div>
    </nav>