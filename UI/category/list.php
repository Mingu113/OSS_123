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
            min-height: 100vh;
            margin: 0;
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
            margin-left: 435px;
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
    </style>
</head>

<body>
    <?php
    require "../trangchu/config.php";
    session_start();
    $isLoggedIn = isset($_SESSION["user_id"], $_SESSION["username"]);
    if ($isLoggedIn) {
        $username = $_SESSION["username"];
        $user_id = $_SESSION["user_id"];
    } else {
        $username = "";
    }
    $profileImage = !empty($_SESSION["pfp"]) ? $_SESSION["pfp"] : "../images/default.jpg";


    if (isset($_GET['category_id']) and isset($_GET['category_name'])) {
        $category_id = $_GET['category_id'];
        $category_name = $_GET['category_name'];
    } else {
        header("Location: ../trangchu/home.php");
    }
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
        <span><a href="../trangchu/home.php">Home <i class="bi bi-caret-left"></i>
            </a><span><?php echo $category_name ?></span>
        </span>
        <h3 class=""><?php echo $category_name; ?></h3>
        <div class="d-flex">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <?php
            if ($username != null) {
                echo '<button class="btn post_btn" data-toggle="modal" data-target="#postModal"><i class="bi bi-pencil"></i> Đăng bài</button>';
            } else {
                echo '<button class="btn post_btn"><i class="bi bi-pencil"></i> Chưa Login</button>';
            }
            ?>
        </div>
        <div class="row">
            <div class="col-lg-8">
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
                    <li class="list-group-item d-flex align-items-center">
                        <?php
                        $query = "SELECT * FROM `Threads` WHERE category_id = '$category_id'";
                        $result = mysqli_query($conn, $query);
                        if (!$result)
                            die('<br> <b>Query failed</b>');
                        $num_files = mysqli_num_fields($result);
                        if (mysqli_num_rows($result) != 0) {
                            while ($row = mysqli_fetch_array($result)) {
                                echo '<li class="list-group-item d-flex align-items-center">
                                        <img src="../images/default.jpg" alt="icon" class="my-1 mr-3 rounded-circle">
                                        <div class="content-wrapper">
                                            <a href="#" class="topic-name font-weight-bold">' . htmlspecialchars($row['Title']) . '</a>
                                            <div>
                                                <span>' . "Username?" . '</span> |
                                                <span>' . date('d/m/Y H:i', strtotime($row['created_at'])) . '</span>
                                            </div>
                                        </div>
                                    </li>';
                            }
                        } else {
                            echo '<li class="list-group-item text-center">
                                    <span class="font-weight-bold text-danger">' . "Chưa có bài nào được đăng" . '</span>
                                  </li>';
                        }
                        ?>
                    </li>
                </ul>
                <h3></h3>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-4">
                <div class="sidebar">

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
                    <form>
                        <div class="form-group">
                            <label for="title">Tiêu đề</label>
                            <input type="text" class="form-control" id="title" placeholder="Nhập tiêu đề">
                        </div>
                        <div class="form-group">
                            <label for="title">Chủ đề</label>
                            <select name="" id="">
                                <option value="">Lấy giá trị từ db</option>
                                <option value="">Lấy giá trị từ db</option>
                                <option value="">Lấy giá trị từ db</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Đăng
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