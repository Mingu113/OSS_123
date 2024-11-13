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
    </style>
</head>

<body>
    <?php
    require "config.php";
    session_start(); // start session
    $isLoggedIn = isset($_SESSION["username"], $_SESSION["user_id"]);
    if($isLoggedIn) {
        $username = $_SESSION["username"];
        $user_id = $_SESSION["user_id"];
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

    ?>
    <div class="container mt-5">
        <div class="header-section d-flex justify-content-between align-items-center mb-4">
            <form action="../Home/search.php" class="form-inline" method="post">
                <div class="input-group">
                    <input class="form-control" type="search" name="search" placeholder="Tìm kiếm..."
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-outline-success" type="submit" name="btn_search">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            <div>
                <?php if ($isLoggedIn): ?>
                    <!-- Hiển thị ảnh đại diện và tên tài khoản nếu đã đăng nhập -->
                    <img src="<?php echo $profileImage; ?>" class="rounded-circle" width="40" height="40">
                    <span><?php echo htmlspecialchars($username); ?></span>
                    <a href="../dangnhap/logout.php" class="btn btn-secondary"><i class="fas fa-sign-out-alt"></i> Đăng
                        Xuất</a>
                <?php else: ?>
                    <!-- Hiển nút Đăng Nhập nếu chưa đăng nhập -->
                    <a href="../dangnhap/login.php" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Đăng Nhập</a>
                    <a href="#" class="btn btn-secondary"><i class="fas fa-sign-out-alt"></i> Đăng Xuất</a>
                <?php endif; ?>
            </div>
        </div>

        <h1 class="text-center">NTUCHAN</h1>

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
                            echo "<a href='../Home/search.php?name=" . urlencode($row1["name"]) . "' class=\"list-group-item list-group-item-action\">";
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>