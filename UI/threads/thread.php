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
    die("Lỗi: Bạn cần đăng nhập để có thể đăng bài.");
}

$user_id = $_SESSION["user_id"];

require "../trangchu/config.php";
// Kiểm tra nếu người dùng đã đăng nhập
$isLoggedIn = isset($_SESSION["username"]);

if ($isLoggedIn) {
    $username = $_SESSION["username"];

    // Truy vấn để lấy thông tin người dùng (bao gồm ảnh đại diện nếu có)
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $profileImage = !empty($user["profile_image"]) ? $user["profile_image"] : "images/default_avatar.png";
}

// Khởi tạo biến để lưu kết quả tìm kiếm
$search_result = null;

// Kiểm tra nếu form được gửi để thực hiện chức năng tìm kiếm hoặc đăng bài
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tìm kiếm
    if (isset($_POST['btn_search']) && isset($_POST['search'])) {
        $search = mysqli_real_escape_string($conn, $_POST['search']);
        $search_query = "
            SELECT p.post_id, p.content, p.created_at, u.username 
            FROM posts p 
            JOIN users u ON p.user_id = u.user_id 
            WHERE u.username LIKE ?
        ";
        $stmt_search = $conn->prepare($search_query);
        $search_param = "%" . $search . "%";
        $stmt_search->bind_param("s", $search_param);
        $stmt_search->execute();
        $search_result = $stmt_search->get_result();
    }
}

// Truy vấn để lấy tất cả bài viết nếu không có tìm kiếm
if (!$search_result) {
    $query_posts = "
        SELECT p.post_id, p.content, p.created_at, u.username 
        FROM posts p 
        JOIN users u ON p.user_id = u.user_id 
        ORDER BY p.created_at DESC
    ";
    $stmt_posts = $conn->prepare($query_posts);
    $stmt_posts->execute();
    $posts_result = $stmt_posts->get_result();
} else {
    $posts_result = $search_result; // Sử dụng kết quả tìm kiếm nếu có
}
// Gửi bài post mới
if (isset($_POST['btn_post'])) {
    if (isset($_POST['thread_id']) && isset($_POST['postContent'])) {
        $thread_id = mysqli_real_escape_string($conn, $_POST['thread_id']);
        $post_content = mysqli_real_escape_string($conn, $_POST['postContent']);
        $user_id = $_SESSION['user_id'];

        $query = "INSERT INTO posts (thread_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iis", $thread_id, $user_id, $post_content);

        if ($stmt->execute()) {
            echo "Bài viết đã được thêm thành công!";
        } else {
            echo "Lỗi khi thêm bài viết: " . $stmt->error;
        }
    } else {
        echo "Vui lòng điền đầy đủ thông tin.";
    }
}
$query2 = "SELECT * FROM `users`";
$result2 = mysqli_query($conn, $query2);
$sltv = mysqli_num_rows($result2);

$query3 = "SELECT * FROM `threads` ORDER BY created_at DESC LIMIT 5";
$result3 = mysqli_query($conn, $query3);
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
                <!-- Hi ển nút Đăng Nhập nếu chưa đăng nhập -->
                <a href="../dangnhap/login.php" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Đăng Nhập</a>
                <a href="#" class="btn btn-secondary"><i class="fas fa-sign-out-alt"></i> Đăng Xuất</a>
            <?php endif; ?>
        </div>
    </div>

    <h1 class="text-center">Diễn Đàn Hỏi Đáp</h1>

    <div class="row">
        <div class="col-lg-8">
            <!-- Hiển thị tất cả bài viết hoặc kết quả tìm kiếm -->
            <?php if (isset($posts_result) && mysqli_num_rows($posts_result) > 0): ?>
                <h3>Tất cả bài viết:</h3>
                <?php while ($post = mysqli_fetch_assoc($posts_result)): ?>
                    <div class="post">
                        <div class="post-number">#<?php echo $post['post_id']; ?></div>
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

            <!-- Form gửi bài post mới -->
            <div class="new-post">
                <h3>Viết Bài Post Mới</h3>
                <form method="post" action="">
                    <input type="hidden" name="thread_id" value="1"> <!-- Đặt thread_id = 1 -->
                    <div class="form-group">
                        <label for="postContent">Nội dung bài post</label>
                        <textarea class="form-control" id="postContent" name="postContent" rows="4" placeholder="Nhập nội dung bài post..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="btn_post">Gửi Bài Post</button>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="sidebar">
                <h3>Tổng Số Người Sử Dụng</h3>
                <?php echo "<p>" . $sltv . " Thành viên </p>" ?>
                <h3>Bình Luận Mới Nhất</h3>
                <ul class="list-unstyled">
                    <?php while ($row = mysqli_fetch_array($result3)): ?>
                        <li><?php echo $row["Title"]; ?></li>
                    <?php endwhile; ?>
                </ul>
                <h3>Kết Nối Với Chúng Tôi</h3>
                <div>
                    <a href="#"><img src="https://img.icons8.com/ios-filled/24/000000/facebook-new.png" alt="Facebook" /></a>
                    <a href="#"><img src="https://img.icons8.com/ios-filled/24/000000/zalo.png" alt="Zalo" /></a>
                    <a href="#"><img src="https://img.icons8.com/ios-filled/24/000000/twitter.png" alt="Twitter" /></a>
                    <a href="#"><img src="https://img.icons8.com/ios-filled/24/000000/instagram-new.png" alt="Instagram" /></a>
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