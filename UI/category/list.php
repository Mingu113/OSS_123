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

        <span><a href="../trangchu/home.php">Home <i class="bi bi-caret-left"></i> </a><a href="#">Category name?</a> </span>
        <!-- Thay bằng tên của Post -->
        <h3 class="">Category name?</h3>
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

            <button class="btn post_btn" data-toggle="modal" data-target="#postModal"><i class="bi bi-pencil"></i> Post
                Thread</button>
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
                    <li class="list-group-item d-flex">
                        <img src="..." alt="icon" class="my-1 mr-3">
                        <div class="content-wrapper ">
                            <a href="#" class="topic-name font-weight-bold">Wibu có phải là đáy xã hội? </a>
                            <div class=""> <span>username</span> | <span>time</span> | <span>categories</span></div>
                        </div>
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
                    <h4>Tổng Số Lượng Thread: 100</h4>
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
                    <h5 class="modal-title" id="postModalLabel">Tạo
                        bài viết mới</h5>
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