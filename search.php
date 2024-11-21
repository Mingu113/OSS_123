<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Trang Chủ Diễn Đàn</title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .list-group {
            width: 1200px;
            margin: 0 auto;
            padding: 0;
            list-style: none;
        }

        .list-group-item {
            display: flex;
            align-items: flex-start;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #ffffff;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .list-group-item img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            flex-shrink: 0;
            margin-right: 15px;
        }

        .content-wrapper {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .content-wrapper .topic-name {
            font-size: 1.1rem;
            font-weight: bold;
            color: #479fdf;
            text-decoration: none;
        }

        .content-wrapper .topic-name:hover {
            color: orange;
        }

        .content-wrapper div {
            font-size: 0.9rem;
            color: #666;
        }

        .content-wrapper span {
            font-size: 0.9rem;
            color: #888;
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

        .highlight {
            background-color: yellow;
            /* Màu nền cho phần tìm thấy */
            font-weight: bold;
            /* Đậm chữ */
        }
    </style>
</head>

<body>
    <?php
    require "./config.php";
    session_start(); // start session
    $isLoggedIn = isset($_SESSION["username"], $_SESSION["user_id"]);
    if ($isLoggedIn) {
        $username = $_SESSION["username"];
        $user_id = $_SESSION["user_id"];
    } else {
        $username = "";
    }
    $profileImage = !empty($_SESSION["pfp"]) ? $_SESSION["pfp"] : "./images/default.jpg";
    ?>
    <?php
    // Lấy dữ liệu từ form hoặc URL
    $key = $_POST['search'] ?? $_GET['search'] ?? null;
    // Chống tấn công SQL Injection
    if ($key) {
        $key = addslashes($key);
    } else {
        echo "<script>alert('Lỗi: Dữ liệu nhập không hợp lệ. Vui lòng nhập lại.'); window.history.back();</script>";
        exit();
    }
    // Highlight các từ khóa tìm kiếm
    function highlight($text, $key)
    {
        return preg_replace('/(' . preg_quote($key, '/') . ')/i', '<span class="highlight">$1</span>', $text);
    }

    // Đếm tổng sô search có trong Threads và Posts
    $total_search_query = "SELECT COUNT(DISTINCT Threads.thread_id) AS total
        FROM Threads 
        LEFT JOIN Posts ON Threads.thread_id = Posts.thread_id 
        WHERE Threads.title LIKE '%$key%' OR Posts.content LIKE '%$key%'";
    $total_search_results = mysqli_query($conn, $total_search_query);
    $total_search = mysqli_fetch_assoc($total_search_results)['total'];

    // Số lượng threads mỗi trang
    $search_per_page = 10;

    // Số trang hiện tại từ URL hoặc mặc định là 1
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    if ($page < 1)
        $page = 1;

    // Tính vị trí cho giới hạn phân trang
    $offset = ($page - 1) * $search_per_page;

    // Truy vấn lấy dữ liệu theo title có key của các threads mà trong đó không có posts nào chứa key
    $threads_no_posts = "SELECT 
        Threads.thread_id, 
        Threads.Title, 
        Threads.category_id, 
        Threads.created_at AS thread_created_at, 
        Threads.newest_post_at, 
        Threads.posts_count, 
        Threads.is_pinned, 
        (SELECT post_id FROM Posts WHERE thread_id = Threads.thread_id LIMIT 1) AS post_id,
        (SELECT user_id FROM Posts WHERE thread_id = Threads.thread_id LIMIT 1) AS user_id,
        (SELECT content FROM Posts WHERE thread_id = Threads.thread_id LIMIT 1) AS post_content,
        (SELECT created_at FROM Posts WHERE thread_id = Threads.thread_id LIMIT 1) AS post_created_at,
        (SELECT profile_pic FROM Users WHERE user_id = (SELECT user_id FROM Posts WHERE thread_id = Threads.thread_id LIMIT 1)) AS profile_pic,
        (SELECT username FROM Users WHERE user_id = (SELECT user_id FROM Posts WHERE thread_id = Threads.thread_id LIMIT 1)) AS username
    FROM Threads
    WHERE Threads.title LIKE '%$key%'
    AND Threads.thread_id NOT IN (
        SELECT Threads.thread_id
        FROM Threads 
        JOIN Posts ON Threads.thread_id = Posts.thread_id
        WHERE Posts.content LIKE '%$key%'
    )";
    // Truy vấn tất cả các posts
    $all_posts = "SELECT 
        Threads.thread_id, 
        Threads.Title, 
        Threads.category_id, 
        Threads.created_at AS thread_created_at, 
        Threads.newest_post_at, 
        Threads.posts_count, 
        Threads.is_pinned, 
        Posts.post_id,
        Posts.user_id, 
        Posts.content AS post_content, 
        Posts.created_at AS post_created_at,
        Users.profile_pic,
        Users.username
    FROM Threads 
    JOIN Posts ON Threads.thread_id = Posts.thread_id 
    JOIN Users ON Posts.user_id = Users.user_id
    WHERE Posts.content LIKE '%$key%'";
    // Gộp 2 bảng làm 1 và phân trang
    $search_query = "($threads_no_posts) UNION ALL ($all_posts)
    ORDER BY post_created_at DESC
    LIMIT $offset, $search_per_page;";

    $se_result = mysqli_query($conn, $search_query);
    $search_results = [];
    while ($row = mysqli_fetch_assoc($se_result)) {
        $search_results[] = $row;
    }

    // Tính tổng số trang
    $total_pages = ceil($total_search / $search_per_page);
    if (isset($_GET['logout'])) {
        session_unset();
    }
    ?>
    <?php session_abort();
    require "./header.php" ?>
    <div class="container mt-5">

        <span><h3>Từ Khóa tìm kiếm : <?php echo $key; ?></h3>
        </span>

        <div class="d-flex">
            <!-- Liên kết phân trang -->
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link"
                                href="search.php?search=<?php echo urlencode($key); ?>&page=<?php echo $page - 1; ?>">Trang
                                trước</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php if ($i == $page)
                            echo 'active'; ?>">
                            <a class="page-link"
                                href="search.php?search=<?php echo urlencode($key); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link"
                                href="search.php?search=<?php echo urlencode($key); ?>&page=<?php echo $page + 1; ?>">Trang
                                sau</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        <div class="row">

            <ul class="list-group">
                <?php foreach ($search_results as $value): ?>
                    <li class="list-group-item d-flex">
                        <img src="<?php echo (!empty($value["profile_pic"]) && realpath($value["profile_pic"])) ? $value["profile_pic"] : "./images/default.jpg"; ?>"
                            class="rounded-circle" width="40" height="40" alt="icon" class="my-1 mr-3">
                        <div class="content-wrapper ">
                            <a href="./thread.php?id=<?php echo urlencode($value['thread_id']); ?>&post=<?php echo urldecode($value['post_id']) ?>"
                                class="topic-name font-weight-bold"><?php echo highlight(htmlspecialchars($value['Title']), $key); ?></a>
                            <span><?php echo htmlspecialchars($value['post_content']); ?></span>
                            <div><span><?php echo $value['username'] ?></span> |
                                <span><?php echo highlight(htmlspecialchars($value['post_created_at']), $key); ?></span>
                            </div>
                        </div>
                    </li>
                <?php endforeach ?>
            </ul>
            <h3></h3>
        </div>
        <div class="d-flex">
            <!-- Liên kết phân trang -->
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link"
                                href="search.php?search=<?php echo urlencode($key); ?>&page=<?php echo $page - 1; ?>">Trang
                                trước</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php if ($i == $page)
                            echo 'active'; ?>">
                            <a class="page-link"
                                href="search.php?search=<?php echo urlencode($key); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link"
                                href="search.php?search=<?php echo urlencode($key); ?>&page=<?php echo $page + 1; ?>">Trang
                                sau</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>