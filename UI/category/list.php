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

        .header-section {
            margin-bottom: 20px;
        }

        .list-group-item img {
            width: 35px;
            height: 35px;
            margin-right: 10px;
        }

        .list-group-item a {
            text-decoration: none;
            color: #000;
        }

        .content-wrapper {
            display: flex;
            flex-direction: column;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .content-wrapper a {
            color: #479fdf;
        }

        .content-wrapper a.topic-name:hover {
            color: orange;
        }

        .post_btn {
            margin-left: auto;
            margin-right: 0;
            background-color: orange;
            color: white;
            height: 40px;

        }

        .filter_btn {
            border: none;
            background-color: #f1f8fd;
        }

        .dropdown-menu {
            position: absolute;
            background-color: white;
            margin-right: 600px;
            border-top: 5px solid cyan;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);
        }

        .li_nav {
            background-color: #f1f8fd;
        }

        .post-input {
            width: 100%;
        }
    </style>
</head>

<body>
    <?php
    require "./config.php";

    session_start();
    $isLoggedIn = isset($_SESSION["user_id"]);
    if ($isLoggedIn) {
        $username = $_SESSION["username"];
        $user_id = $_SESSION["user_id"];

        $query_check = mysqli_query($conn, "SELECT is_banned FROM Users WHERE user_id = $user_id;");
        $user_is_banned = false;
        if ($result = $query_check->fetch_assoc()) {
            if ($result["is_banned"])
                $user_is_banned = true;
        }
    }


    // Post thread function
    if (isset($_POST["post-thread"]) && isset($_SESSION["user_id"])) {
        $category_id = $_POST["category_id"];
        $title = $_POST["thread_title"];
        $content = $_POST["post_content"];
        $user_id = $_SESSION["user_id"];

        $query_thread =
            "INSERT INTO Threads (`title`, `category_id`, `created_at`) 
        VALUES ('$title', '$category_id', current_timestamp()) ;";
        mysqli_query($conn, $query_thread);
        $new_thread_id = mysqli_insert_id($conn);
        $query_post_thread = "INSERT INTO Posts (`thread_id`, `user_id`, `content`, `created_at`) VALUES ('$new_thread_id', '$user_id', '$content', current_timestamp()) ;";
        $result_post = mysqli_query($conn, $query_post_thread);
        if (!$result_post) {
            // Thong bao ra cho nguoi dung
            echo "Khong thanh cong";
        } else {
            header("Location: ../threads/thread.php?id=$new_thread_id");
        }
    }



    $name = $_GET["name"];
    $category_id = $_GET['category_id'];

    // Tìm kiếm trong bảng categories
    $search_ca = "SELECT * FROM `Categories` WHERE `name` LIKE '%$name%'";
    $result_categories = mysqli_query($conn, $search_ca);
    $category = mysqli_fetch_assoc($result_categories);
    $category_id = $category["category_id"];


    // Đếm tổng số threads thuộc category này
    $count_th_ca_query = "SELECT COUNT(*) as total FROM `Threads` WHERE `category_id` = $category_id";
    $count_th_ca_result = mysqli_query($conn, $count_th_ca_query);
    $total_threads = mysqli_fetch_assoc($count_th_ca_result)['total'];

    // Số lượng threads mỗi trang
    $threads_per_page = 10;

    // Số trang hiện tại từ URL hoặc mặc định là 1
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    if ($page < 1)
        $page = 1;

    // Tính vị trí cho LIMIT
    $offset = ($page - 1) * $threads_per_page;

    // Truy vấn threads theo giới hạn
    $search_th_ca =
        "SELECT t.thread_id, t.title, t.category_id, t.created_at, t.newest_post_at, t.posts_count, t.is_pinned, u.profile_pic, u.username
    FROM Threads t
    LEFT JOIN 
    Posts p ON t.thread_id = p.thread_id
    LEFT JOIN 
    Users u ON p.user_id = u.user_id
    WHERE 
    p.post_id = (
        SELECT MIN(p2.post_id) 
        FROM Posts p2 
        WHERE p2.thread_id = t.thread_id
    )
    AND t.category_id = $category_id
    LIMIT $offset, $threads_per_page";

    $result_threads_ca = mysqli_query($conn, $search_th_ca);
    $threads_ca = [];
    while ($thread = mysqli_fetch_assoc($result_threads_ca)) {
        $threads_ca[] = $thread;
    }

    // Tính tổng số trang
    $total_pages = ceil($total_threads / $threads_per_page);


    ?>
    <?php session_abort();
    require "../trangchu/header.php" ?>
    <div class="container mt-5">

        <span><a href="../trangchu/home.php">Home <i class="bi bi-caret-left"></i> </a><a
                href="#"><?php echo $name; ?></a>
        </span>
        <!-- Thay bằng tên của Post -->
        <h3 class=""><?php echo $name; ?></h3>
        <div class="d-flex">
            <!-- Liên kết phân trang -->
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link"
                                href="./list.php?name=<?php echo urlencode($name); ?>&category_id=<?php echo urlencode($category_id); ?>&page=<?php echo $page - 1; ?>">Trang
                                trước</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php if ($i == $page)
                            echo 'active'; ?>">
                            <a class="page-link"
                                href="./list.php?name=<?php echo urlencode($name); ?>&category_id=<?php echo urlencode($category_id); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link"
                                href="./list.php?name=<?php echo urlencode($name); ?>&category_id=<?php echo urlencode($category_id); ?>&page=<?php echo $page + 1; ?>">Trang
                                sau</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <?php if ($isLoggedIn): ?>
                <?php if (!$user_is_banned): ?>
                    <button class="btn post_btn" data-toggle="modal" data-target="#postModal"><i class="bi bi-pencil"></i> Post
                        Thread</button>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <?php if (isset($name) && isset($category_id)): ?>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-end li_nav">
                            <div class="dropdown">
                                <button class="dropdown-toggle filter_btn" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Sort
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <button class="dropdown-item">Bài đăng mới nhất</button>
                                    <button class="dropdown-item">Bình luận mới nhất</button>
                                </div>
                            </div>
                        </li>
                        <?php foreach ($threads_ca as $value): ?>
                            <li class="list-group-item d-flex">
                                <img src="<?php echo !empty($value["profile_pic"]) ? $value["profile_pic"] : "../images/default.jpg"; ?>"
                                    class="rounded-circle" width="40" height="40" alt="icon" class="my-1 mr-3">
                                <div class="content-wrapper ">
                                    <a href="../threads/thread.php?id=<?php echo $value["thread_id"]; ?>"
                                        class="topic-name font-weight-bold"><?php echo htmlspecialchars($value['title']); ?></a>
                                    <div><span> <?php echo $value["username"] ?></span> |
                                        <span><?php echo htmlspecialchars($value['created_at']); ?></span>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach ?>
                    </ul>
                    <h3></h3>
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link"
                                        href="./list.php?name=<?php echo urlencode($name); ?>&category_id=<?php echo urlencode($category_id); ?>&page=<?php echo $page - 1; ?>">Trang
                                        trước</a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php if ($i == $page)
                                    echo 'active'; ?>">
                                    <a class="page-link"
                                        href="./list.php?name=<?php echo urlencode($name); ?>&category_id=<?php echo urlencode($category_id); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link"
                                        href="./list.php?name=<?php echo urlencode($name); ?>&category_id=<?php echo urlencode($category_id); ?>&page=<?php echo $page + 1; ?>">Trang
                                        sau</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php else: ?>
                    <div style="text-align: center;">
                        <img src="../images/not_found.gif" alt="Image" width="60%">
                        <h1>Không có bài thread này, có thể đã bị xóa hoặc không tồn tại</h1>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-4">
                <div class="sidebar">
                    <h4><?php echo "Tổng Số Lượng Thread: " . $total_threads; ?></h4>
                    </ul>
                    <h4>Kết Nối Với Chúng Tôi</h4>
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
    <div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="postModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="postModalLabel">Tạo bài viết mới</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div class="form-group">
                            <input hidden name="category_id" value="<?php echo $category_id; ?>">
                            <label for="title">Tiêu đề</label>
                            <input type="text" class="form-control" required id="title" name="thread_title"
                                placeholder="Nhập tiêu đề">
                        </div>
                        <div class="form-group">
                            <textarea id="post-input" class="post-input" name="post_content" required
                                placeholder="Nhập nội dung bài viết" rows="4"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" name="post-thread" class="btn btn-primary">Đăng
                                bài</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>