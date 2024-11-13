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
session_start(); // Khởi động session để theo dõi trạng thái đăng nhập
if (!isset($_SESSION["user_id"])) {
    // die("Lỗi: Bạn cần đăng nhập để có thể đăng bài.");
}

$user_id = $_SESSION["user_id"];

require "../trangchu/config.php";
// Kiểm tra nếu người dùng đã đăng nhập
$isLoggedIn = isset($_SESSION["username"]);

if ($isLoggedIn) {
    $username = $_SESSION["username"];

    // Truy vấn để lấy thông tin người dùng (bao gồm ảnh đại diện nếu có)
    $query = "SELECT * FROM Users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $profileImage = !empty($user["profile_image"]) ? $user["profile_image"] : "images/default_avatar.png";
}
$thread_id = 1;
// Gửi bài post mới
if (isset($_POST['btn_post'])) {
    if (isset($_POST['postContent'])) {
        $post_content = mysqli_real_escape_string($conn, $_POST['postContent']);
        $user_id = $_SESSION["user_id"];
        echo "User id: " . $user_id;
        $query = "INSERT INTO Posts (thread_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iis", $thread_id, $user_id, $post_content);
        // Move the old place
    // PHP block to echo JavaScript
        echo '<script>
        window.onload = function() {
            const targetElement = document.getElementById("new-post");
            targetElement.scrollIntoView({ behavior: "smooth" });
        };
    </script>';

        if ($stmt->execute()) {
            echo "Bài viết đã được thêm thành công!";
        } else {
            echo "Lỗi khi thêm bài viết: " . $stmt->error;
        }
    } else {
        echo "Vui lòng điền đầy đủ thông tin.";
    }
}
// Truy vấn để lấy tất cả bài viết
    $query_posts = "
        SELECT *
        FROM Posts p, Users u, Threads t
        WHERE p.thread_id = $thread_id AND u.user_id = p.user_id
        ORDER BY p.created_at ASC
    ";
    $stmt_posts = $conn->prepare($query_posts);
    $stmt_posts->execute();
    $posts_result = $stmt_posts->get_result();


$query2 = "SELECT * FROM `Users`";
$result2 = mysqli_query($conn, $query2);
$sltv = mysqli_num_rows($result2);
/// TEST
$thread_id = 1;
$query_thread = "SELECT * FROM `Threads` WHERE thread_id = $thread_id";
$thread_rs = mysqli_query($conn, $query_thread);
$thread = mysqli_fetch_array($thread_rs);
///
?>

<body>
<div class="container mt-5">
    <div class="header-section d-flex justify-content-between align-items-center mb-4">
        <form action="" class="form-inline" method="post">
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
            <?php if ($isLoggedIn): ?>
                <!-- Hiển thị ảnh đại diện và tên tài khoản nếu đã đăng nhập -->
                <img src="<?php echo $profileImage; ?>" class="rounded-circle" width="40" height="40">
                <span><?php echo htmlspecialchars($username); ?></span>
                <a href="../dangnhap/logout.php" class="btn btn-secondary"><i class="fas fa-sign-out-alt"></i> Đăng Xuất</a>
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
            <!-- Hiển thị tất cả bài viết hoặc kết quả tìm kiếm -->
            <?php if (isset($posts_result) && mysqli_num_rows($posts_result) > 0): ?>
                <h3><?php echo $thread["title"] . $user_id ; ?></h3>
                <?php $post_index = 1; ?>
                <?php while ($post = mysqli_fetch_assoc($posts_result)): ?>
                    <div class="post">
                        <div class="post-number">#<?php echo $post_index++; ?></div>
                        <div class="post-content">
                            <div class="post-title"><?php echo htmlspecialchars($post['username']); ?></div>
                            <p><?php echo htmlspecialchars($post['content']); ?></p>
                            <p class="post-meta">Thời gian: <strong><?php echo $post['created_at']; ?></strong></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Không tìm thấy kết quả phù hợp.</p>
            <?php endif; ?>

            <?php if ($isLoggedIn): ?>
            <!-- Form gửi bài post mới -->
            <div class="new-post" id="new-post">
                <h2><?php echo $username; ?></h2>
                <h3>Viết Bài Post Mới</h3>
                <form method="post" action="">
                    <div class="form-group">
                        <textarea class="form-control" id="postContent" name="postContent" rows="4" placeholder="Nhập nội dung bài post..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="btn_post">Gửi Bài Post</button>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>