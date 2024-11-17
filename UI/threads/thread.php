<!doctype html>
<html lang="en">

<?php
session_start();
require "../trangchu/config.php";
if (isset($_GET["id"]))
    $thread_id = $_GET["id"];
if (isset($_GET["post"])) {
    $post_id = $_GET["post"];
}

// Gửi bài post mới
if (isset($_POST['btn_post'])) {
    if (isset($_POST['postContent'])) {
        $post_content = mysqli_real_escape_string($conn, $_POST['postContent']);
        $post_content = htmlspecialchars($post_content);
        $user_id = $_SESSION["user_id"];
        $query = "INSERT INTO Posts (thread_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iis", $thread_id, $user_id, $post_content);
        // Move the old place
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
if (isset($thread_id)) {
    // Truy vấn để lấy tất cả bài viết
    $query_posts = "
        SELECT DISTINCT p.thread_id, u.username, p.post_id, p.content, p.created_at, u.user_id, u.profile_pic, u.major, t.title as title
        FROM Posts p
        JOIN Users u ON u.user_id = p.user_id
        JOIN Threads t ON t.thread_id = p.thread_id
        WHERE p.thread_id = $thread_id
        ORDER BY p.created_at ASC
    ";
    $stmt_posts = $conn->prepare($query_posts);
    $stmt_posts->execute();
    $posts_result = $stmt_posts->get_result();
    if (mysqli_num_rows($posts_result) == 0) {
        $thread_title = "Không có Thread";
        $thread_is_available = false;
    } else {
        $thread_title = $posts_result->fetch_assoc()["title"];
        $thread_is_available = true;
    }

    $query2 = "SELECT * FROM `Users`";
    $result2 = mysqli_query($conn, $query2);
    $sltv = mysqli_num_rows($result2);
    // move to the post in the GET request
    if (isset($post_id)) {
        echo '<script>
        window.onload = function() {
            const targetElement = document.getElementById("' . $post_id . '");
            targetElement.scrollIntoView({ behavior: "smooth" });
        };
        </script>';
    }
} else
    $thread_title = "Không có Thread";

?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title><?php echo $thread_title ?></title>
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

<body>
    <?php session_abort();
    require("../trangchu/header.php"); ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8">
                <!-- Hiển thị tất cả bài viết-->
                <?php if (isset($posts_result) && mysqli_num_rows($posts_result) > 0): ?>
                    <h3><?php echo $thread_title; ?></h3>
                    <?php $post_index = 1;
                    mysqli_data_seek($posts_result, 0); ?>
                    <?php while ($post = mysqli_fetch_assoc($posts_result)): ?>
                        <div class="post" id="<?php echo $post["post_id"] ?>">
                            <div class="post-number">#<?php echo $post_index++; ?></div>
                            <div style="margin: 10px; margin-right: 25px">
                                <img src="<?php echo ($post['profile_pic']) == null ? "../images/default.jpg" : $post["profile_pic"]; ?>"
                                    alt="User avatar" style="width: 50px; height: 50px; border-radius: 50%;">
                                <div class="post-username"><?php echo htmlspecialchars($post['username']); ?></div>
                            </div>
                            <div class="post-content">
                                <p><?php echo nl2br(stripcslashes($post['content'])); ?></p>
                                <p class="post-meta">Thời gian: <strong><?php echo $post['created_at']; ?></strong></p>
                            </div>
                        </div>

                    <?php endwhile; ?>
                <?php endif; ?>

                <?php if ($isLoggedIn && isset($thread_id) && $thread_is_available): ?>
                    <!-- Form gửi bài post mới -->
                    <div class="new-post" id="new-post">
                        <h2>Người dùng: <?php echo $username; ?></h2>
                        <h3>Viết Bài Post Mới</h3>
                        <form method="post" action="">
                            <div class="form-group">
                                <textarea class="form-control" id="postContent" name="postContent" rows="4"
                                    placeholder="Nhập nội dung bài post..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" name="btn_post">Đăng</button>
                        </form>
                    </div>
                <?php elseif($thread_is_available): ?>
                    <h1>Đăng nhập để đăng bài viết</h1>
                <?php endif; ?>
                <?php if (!$thread_is_available): ?>
                    <div style="text-align: center;">
                        <img src="../images/not_found.gif" alt="Image" width="60%">
                        <h1>Không có bài thread này, có thể đã bị xóa hoặc không tồn tại</h1>
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