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
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header-section {
            margin-bottom: 20px;
        }

        .user_avatar {
            background-color: antiquewhite;
            padding: 0px 5px;
            border-radius: 10px;
        }

        .thread-item,
        .post-item {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #ffffff;
            text-decoration: none;
            color: inherit;
            transition: background-color 0.2s;
        }

        .thread-item:hover,
        .post-item:hover {
            background-color: #f1f1f1;
        }

        .post-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        .flex-container {
            display: flex;
            justify-content: space-between;
        }

        .flex-container > div {
            flex: 1;
            margin: 0 10px;
        }

        .footer {
            background-color: #000;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: auto;
        }

        a {
            display: block;
        }

        .highlight {
            background-color: yellow; /* Màu nền cho phần tìm thấy */
            font-weight: bold; /* Đậm chữ */
        }
    </style>
</head>

<body>
    <?php
    require "../trangchu/config.php";
    session_start();
    $isLoggedIn = isset($_SESSION["username"], $_SESSION["user_id"]);
    $username = $isLoggedIn ? $_SESSION["username"] : "";
    $profileImage = !empty($_SESSION["pfp"]) ? $_SESSION["pfp"] : "../images/default.jpg";

    function highlight($text, $search) {
        return preg_replace('/(' . preg_quote($search, '/') . ')/i', '<span class="highlight">$1</span>', $text);
    }

    $search = "";
    if (isset($_POST["search"])) {
        $search = mysqli_real_escape_string($conn, $_POST["search"]);
    }

    $query1 = "SELECT * FROM `Threads` WHERE `Title` LIKE '%$search%'";
    $result1 = mysqli_query($conn, $query1);

    $query2 = "SELECT Posts.*, Users.profile_pic, Users.username, Threads.title
        FROM Posts
        JOIN Users ON Posts.user_id = Users.user_id 
        JOIN Threads ON Posts.thread_id = Threads.thread_id
        WHERE Posts.content LIKE '%$search%'";
    $result2 = mysqli_query($conn, $query2);
    ?>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
        <a class="navbar-brand" href="../trangchu/home.php">NTUCHAN</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarSupportedContent">
            <?php require "../search/tool.php"; ?>
            <div>
                <?php if (!empty($username)): ?>
                    <a href="../nguoidung/user.php" class="mr-3 text-decoration-none">
                        <img src="<?php echo $profileImage; ?>" class="rounded-circle" width="40" height="40">
                        <span class="font-weight-bold text-white"><?php echo $username; ?></span>
                    </a>
                <?php else: ?>
                    <a href="../dangnhap/login.php"><button class="btn btn-primary">Login</button></a>
                <?php endif; ?>
                <a href="?logout" class="btn btn-secondary"><i class="fas fa-sign-out-alt"></i> Đăng Xuất</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5 flex-grow-1">
        <div class="flex-container">
            <div>
                <h3>Threads</h3>
                <?php
                while ($row1 = mysqli_fetch_array($result1)) {
                    $highlightedTitle = highlight($row1["Title"], $search);
                    echo "<a href=\"../threads/thread.php?id=" . $row1['thread_id'] . "\" class=\"thread-item\">";
                    echo "<h5>" . $highlightedTitle . "</h5>";
                    echo "<small>" . $row1["created_at"] . "</small>";
                    echo "</a>";
                }
                ?>
            </div>

            <div>
                <h3>Posts</h3>
                <?php
                while ($row2 = mysqli_fetch_array($result2)) {
                    $highlightedContent = highlight($row2["content"], $search);
                    echo "<a href=\"../threads/thread.php?id=" . $row2['thread_id'] ."&post=".$row2["post_id"] ."\" class=\"post-item d-flex\">";
                    echo "<img src=\"../images/" . ($row2["profile_pic"] ?? "default.jpg") . "\" class=\"post-avatar mr-3\" alt=\"User Avatar\">";
                    echo "<div><h5><strong>";
                    echo $row2["title"];
                    echo "</strong></h5>";
                    echo "<h5>" . $row2["username"] . "</h5>";
                    echo "<small>" . $row2["created_at"] . "</small>";
                    echo "<p>" . $highlightedContent . "</p>";
                    echo "</div></a>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- import footer -->
    <?php require "../trangchu/footer.php" ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>