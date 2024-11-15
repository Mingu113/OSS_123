<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Danh Sách Người Dùng</title>
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

        .user-item {
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #ffffff;
            display: flex;
            align-items: center;
            position: relative;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .user-info {
            flex-grow: 1;
        }

        .ban-button {
            position: absolute;
            right: 15px;
            top: 15px;
        }

        .footer {
            background-color: #000;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: auto;
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
        <h3>Danh Sách Người Dùng</h3>
        <div class="user-item">
            <img src="../images/default.jpg" class="user-avatar" alt="User Avatar">
            <div class="user-info">
                <h5>User123</h5>
                <p>Email: user123@example.com</p>
                <p>Khoa: Khoa Công Nghệ Thông Tin</p>
            </div>
            <button class="btn btn-danger ban-button">Ban User</button>
        </div>
        <div class="user-item">
            <img src="../images/default.jpg" class="user-avatar" alt="User Avatar">
            <div class="user-info">
                <h5>User456</h5>
                <p>Email: user456@example.com</p>
                <p>Khoa: Khoa Kinh Tế</p>
            </div>
            <button class="btn btn-danger ban-button">Ban User</button>
        </div>
        <div class="user-item">
            <img src="../images/default.jpg" class="user-avatar" alt="User Avatar">
            <div class="user-info">
                <h5>User789</h5>
                <p>Email: user789@example.com</p>
                <p>Khoa: Khoa Ngoại Ngữ</p>
            </div>
            <button class="btn btn-danger ban-button">Ban User</button>
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