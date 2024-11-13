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

        .thread-title {
            border-bottom: 2px solid #007bff;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .post {
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            align-items: start;
            position: relative;
        }

        .post-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .post-content {
            flex-grow: 1;
        }

        .post-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .post-meta {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .post-number {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 1.2rem;
            font-weight: bold;
            color: #007bff;
        }

        .sidebar {
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .thread-meta {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .new-post {
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 5px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .new-post h3 {
            margin-bottom: 15px;
        }

        .new-post textarea {
            resize: none;
        }

        .new-post .btn {
            width: 100%;
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>
<?php
    require "../trangchu/config.php";

?>

<?php
    $query2 = "SELECT * FROM `users`";
    $result2 = mysqli_query($conn, $query2);
    $sltv = mysqli_num_rows($result2);

    $query3 = "SELECT * FROM `threads` ORDER BY created_at DESC LIMIT 5";
    $result3 = mysqli_query($conn, $query3);
?>
<body>
    <div class="container mt-5">
        <div class="header-section d-flex justify-content-between align-items-center mb-4">
            <form action="../Home/search.php" class="form-inline" method="post">
                <div class="input-group">
                    <input class="form-control" type="search" name="search" placeholder="Tìm kiếm..." aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-outline-success" type="submit" name="btn_search">
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
                <div class="thread-title">
                    <h2>Tiêu đề Thread</h2>
                    <p class="thread-meta">
                        <span>Loại: <strong>Category Name</strong></span> | 
                        <span>Thời gian: <strong>2024-11-13 10:00</strong></span>
                    </p>
                </div>

                <div class="post">
                    <div class="post-number">#1</div>
                    <img src="https://via.placeholder.com/50" alt="Avatar" class="post-avatar">
                    <div class="post-content">
                        <div class="post-title">Nguyễn Văn A</div>
                        <p>Nội dung bài post 1. Đây là nơi người dùng có thể chia sẻ ý kiến hoặc câu trả lời của họ.</p>
                        <p class="post-meta">Thời gian: <strong>2024-11-13 12:00</strong></p>
                    </div>
                </div>

                <div class="post">
                    <div class="post-number">#2</div>
                    <img src="https://via.placeholder.com/50" alt="Avatar" class="post-avatar">
                    <div class="post-content">
                        <div class="post-title">Trần Thị B</div>
                        <p>Nội dung bài post 2. Thông tin bổ sung hoặc phản hồi từ người dùng khác có thể được hiển thị ở đây.</p>
                        <p class="post-meta">Thời gian: <strong>2024-11-13 12:30</strong></p>
                    </div>
                </div>

                <div class="post">
                    <div class="post-number">#3</div>
                    <img src="https://via.placeholder.com/50" alt="Avatar" class="post-avatar">
                    <div class="post-content">
                        <div class="post-title">Lê Văn C</div>
                        <p>Nội dung bài post 3. Bạn có thể thêm nhiều nội dung khác nhau để phong phú diễn đàn.</p>
                        <p class="post-meta">Thời gian: <strong>2024-11-13 13:00</strong></p>
                    </div>
                </div>

                <div class="new-post">
                    <h3>Viết Bài Post Mới</h3>
                    <form>
                        <div class="form-group">
                            <label for="postContent">Nội dung bài post</label>
                            <textarea class="form-control" id="postContent" rows="4" placeholder="Nhập nội dung bài post..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Gửi Bài Post</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sidebar">
                    <h3>Tổng Số Người Sử Dụng</h3>
                    <?php echo "<p>" . $sltv . " Thành viên </p>" ?>
                    <h3>Bình Luận Mới Nhất</h3>
                    <ul class="list-unstyled">
                        <?php
                        while ($row = mysqli_fetch_array($result3)) {
                            echo "<li>";
                            echo $row["Title"];
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