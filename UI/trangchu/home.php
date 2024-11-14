<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Trang Chủ Diễn Đàn</title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .header-section {
            margin-bottom: 20px;
        }

        .user_avatar {
            background-color: antiquewhite;
            padding: 0px 5px 0px 5px;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <?php
    require "config.php";
    session_start(); // start session
    $isLoggedIn = isset($_SESSION["username"], $_SESSION["user_id"]);
    if ($isLoggedIn) {
        $username = $_SESSION["username"];
        $user_id = $_SESSION["user_id"];
    } else {
        $username = "";
    }
    $profileImage = !empty($_SESSION["pfp"]) ? $_SESSION["pfp"] : "../images/default.jpg";
    ?>

    <?php
    $query = "SELECT * FROM `Boards`";
    $result = mysqli_query($conn, $query);

    $query1 = "SELECT * FROM `Categories`";
    $result1 = mysqli_query($conn, $query1);


    $query2 = "SELECT * FROM `Users`";
    $result2 = mysqli_query($conn, $query2);
    $sltv = mysqli_num_rows($result2);

    $query3 = "SELECT * FROM `Threads` ORDER BY created_at DESC LIMIT 5";
    $result3 = mysqli_query($conn, $query3);
    if (isset($_GET['logout'])) {
        logout();
    }
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
        <a class="navbar-brand" href="../trangchu/home.php">NTUCHAN</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarSupportedContent">
            <form class="form-inline">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
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
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8">
                <?php
                while ($row = mysqli_fetch_array($result)) {
                    echo "<h2>";
                    echo $row["board_name"];
                    echo "</h2>";
                    echo "<div class=\"list-group mb-4\">";
                    mysqli_data_seek($result1, 0);
                    while ($row1 = mysqli_fetch_array($result1)) {
                        if ($row["board_id"] == $row1["board_id"]) {
                            echo "<a href='../category/list.php?name=" . urlencode($row1["name"]) ."&category_id=" . urlencode($row1["category_id"])."' class=\"list-group-item list-group-item-action\">";
                            echo $row1["name"];
                            echo "</a>";
                        }

                    }
                    echo "</div>";
                }
                ?>
            </div>

            <div class="col-lg-4">
                <div class="sidebar">
                    <h3>Tổng Số Người Sử Dụng</h3>
                    <?php echo "<p>" . $sltv . " Thành viên </p>" ?>
                    <h3>Bài viết mới nhất</h3>
                    <ul class="list-unstyled">
                        <?php
                        while ($row = mysqli_fetch_array($result3)) {
                            echo "<li>";
                            echo $row["title"];
                            echo "</li>";
                        }
                        ?>
                    </ul>

                    <h3>Kết Nối Với Chúng Tôi</h3>
                    <div>
                        <a href="#"><img src="https://img.icons8.com/ios-filled/24/000000/facebook-new.png"
                                alt="Facebook" /></a>
                        <a href="#"><img src="https://img.icons8.com/ios-filled/24/000000/zalo.png" alt="Zalo" /></a>
                        <a href="#"><img src="https://img.icons8.com/ios-filled/24/000000/twitter.png"
                                alt="Twitter" /></a>
                        <a href="#"><img src="https://img.icons8.com/ios-filled/24/000000/instagram-new.png"
                                alt="Instagram" /></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="text-center text-lg-start mt-5 bg-dark">
        <div class="text-center text-white p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2024 Copyright:
            <a class="text-white" href="#">NTUCHAN</a>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>