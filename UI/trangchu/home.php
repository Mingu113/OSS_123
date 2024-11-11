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
?>

<?php
    $query = "SELECT * FROM `majors`";
    $result = mysqli_query($conn,$query);
    $query1 = "SELECT * FROM `users`";
    $result1 = mysqli_query($conn,$query1);
    $sltv=mysqli_num_rows($result1);
?>
<div class="container mt-5">
    <div class="header-section d-flex justify-content-between align-items-center mb-4">
        <form class="form-inline">
            <div class="input-group">
                <input class="form-control" type="search" placeholder="Tìm kiếm..." aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-outline-success" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
        <div>
            <a href="#" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Đăng Nhập</a>
            <a href="#" class="btn btn-secondary"><i class="fas fa-sign-out-alt"></i> Đăng Xuất</a>
        </div>
    </div>

    <h1 class="text-center">Diễn Đàn Hỏi Đáp</h1>

    <div class="row">
        <div class="col-lg-8">
        <?php
            while ($row = mysqli_fetch_array($result))
            {
                echo "<h2>";
                echo $row["major_info"];
                echo "</h2>";
                echo "
                    <div class=\"list-group mb-4\">
                    <a href=\"#\" class=\"list-group-item list-group-item-action\">Mục 1: Hỏi Đáp về Công Nghệ</a>
                    <a href=\"#\" class=\"list-group-item list-group-item-action\">Mục 2: Hỏi Đáp về Cuộc Sống</a>
                    <a href=\"#\" class=\"list-group-item list-group-item-action\">Mục 3: Hỏi Đáp về Du Lịch</a>
                    <a href=\"#\" class=\"list-group-item list-group-item-action\">Mục 4: Hỏi Đáp về Sức Khỏe</a>
                    <a href=\"#\" class=\"list-group-item list-group-item-action\">Mục 5: Hỏi Đáp về Học Tập</a>
                    </div>
                ";
            }
        ?>
        </div>

        <div class="col-lg-4">
            <div class="sidebar">
                <h3>Tổng Số Người Sử Dụng</h3>
                <?php echo "<p>".$sltv." Thành viên </p>" ?>
                <h3>Bình Luận Mới Nhất</h3>
                <ul class="list-unstyled">
                    <li>Người dùng 1: Câu hỏi về công nghệ.</li>
                    <li>Người dùng 2: Câu hỏi về sức khỏe.</li>
                    <li>Người dùng 3: Câu hỏi về du lịch.</li>
                    <li>Người dùng 4: Câu hỏi về công nghệ.</li>
                    <li>Người dùng 5: Câu hỏi về sức khỏe.</li>
                    <li>Người dùng 6: Câu hỏi về du lịch.</li>
                </ul>

                <h3>Kết Nối Với Chúng Tôi</h3>
                <div>
                    <a href="#"><img src="https://img.icons8.com/ios-filled/24/000000/facebook-new.png" alt="Facebook"/></a>
                    <a href="#"><img src="https://img.icons8.com/ios-filled/24/000000/zalo.png" alt="Zalo"/></a>
                    <a href="#"><img src="https://img.icons8.com/ios-filled/24/000000/twitter.png" alt="Twitter"/></a>
                    <a href="#"><img src="https://img.icons8.com/ios-filled/24/000000/instagram-new.png" alt="Instagram"/></a>
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