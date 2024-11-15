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
            position: relative;
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

        .timestamp {
            position: absolute;
            bottom: 10px;
            right: 15px;
            font-size: 0.8em;
            color: #6c757d;
        }

        .action-button {
            position: absolute;
            right: 15px;
            top: 15px;
        }

        a {
            display: block;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
        <a class="navbar-brand" href="#">NTUCHAN</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarSupportedContent">
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            <div>
                <a href="#" class="mr-3 text-decoration-none">
                    <img src="../images/default.jpg" class="rounded-circle" width="40" height="40">
                    <span class="font-weight-bold text-white">User123</span>
                </a>
                <a href="#" class="btn btn-secondary"><i class="fas fa-sign-out-alt"></i> Đăng Xuất</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5 flex-grow-1">
        <div class="flex-container">
            <div>
                <h3>Threads</h3>
                <div class="thread-item d-flex justify-content-between">
                    <div>
                        <h5>Thread Title 1</h5>
                        <div class="timestamp">2024-11-15</div>
                    </div>
                    <button class="btn btn-success action-button">Duyệt</button>
                </div>
                <div class="thread-item d-flex justify-content-between">
                    <div>
                        <h5>Thread Title 2</h5>
                        <div class="timestamp">2024-11-14</div>
                    </div>
                    <button class="btn btn-success action-button">Duyệt</button>
                </div>
                <div class="thread-item d-flex justify-content-between">
                    <div>
                        <h5>Thread Title 3</h5>
                        <div class="timestamp">2024-11-13</div>
                    </div>
                    <button class="btn btn-success action-button">Duyệt</button>
                </div>
            </div>

            <div>
                <h3>Posts</h3>
                <a href="#" class="post-item d-flex justify-content-between">
                    <div class="d-flex">
                        <img src="../images/default.jpg" class="post-avatar mr-3" alt="User Avatar">
                        <div class="flex-grow-1">
                            <h5><strong>Thread Title 1</strong></h5>
                            <h6>User456</h6>
                            <p>This is a sample post content related to thread 1. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            <div class="timestamp">2024-11-15</div>
                        </div>
                    </div>
                    <button class="btn btn-danger action-button">Xóa</button>
                </a>
                <a href="#" class="post-item d-flex justify-content-between">
                    <div class="d-flex">
                        <img src="../images/default.jpg" class="post-avatar mr-3" alt="User Avatar">
                        <div class="flex-grow-1">
                            <h5><strong>Thread Title 2</strong></h5>
                            <h6>User789</h6>
                            <p>Another sample post content related to thread 2. Curabitur vel libero nec leo dapibus bibendum.</p>
                            <div class="timestamp">2024-11-14</div>
                        </div>
                    </div>
                    <button class="btn btn-danger action-button">Xóa</button>
                </a>
                <a href="#" class="post-item d-flex justify-content-between">
                    <div class="d-flex">
                        <img src="../images/default.jpg" class="post-avatar mr-3" alt="User Avatar">
                        <div class="flex-grow-1">
                            <h5><strong>Thread Title 3</strong></h5>
                            <h6>User101</h6>
                            <p>Yet another post. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            <div class="timestamp">2024-11-13</div>
                        </div>
                    </div>
                    <button class="btn btn-danger action-button">Xóa</button>
                </a>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 NTUCHAN. All rights reserved.</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>