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

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .header-section {
            margin-bottom: 20px;
        }

        .tb_profile table tr {
            font-size: 20px;
        }

        table td {
            padding: 5px 10px 0px 0px;
        }

        .spec_td {
            color: green;
            font-weight: bold;
        }

        .change_profile {
            margin-left: 10px;
            border: none;
            border-radius: 5px;
            background-color: #eaebec;
            color: #42628d;
        }
    </style>
</head>

<body>
    <?php
    require "../trangchu/config.php";
    session_start(); // start session
    $isLoggedIn = isset($_SESSION["user_id"]);
    if ($isLoggedIn) {
        $user_id = $_SESSION["user_id"];
        $query = "SELECT * FROM `Users` WHERE user_id = $user_id";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            $username = $user_data["username"];
            $email = $user_data["email"];
            $major = $user_data["major"];
        }
        $profileImage = !empty($_SESSION["pfp"]) ? $_SESSION["pfp"] : "../images/default.jpg";
    } else {
        header("Location: ../trangchu/home.php");
    }
    
    

    global $user_id;
    function changeEmail($user_id, $newemail, $password)
    {
        global $conn;
        $query = "SELECT password_hash FROM `Users` WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && hash("sha256", $password) === $user['password_hash']) {
            $updateQuery = "UPDATE `Users` SET email = ? WHERE user_id = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("si", $newemail, $user_id);
            if ($stmt->execute()) {
                echo "<script>alert('Cập nhật email thành công'); window.location.href='user.php';</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra khi cập nhật email'); window.location.href='user.php';</script>";
            }
        } else {
            echo "<script>alert('Mật khẩu không đúng'); window.location.href='user.php';</script>";
        }
    }
    if (isset($_POST['doi_email'])) {
        $password = $_POST['password'];
        $newemail = $_POST['new_email'];
        changeEmail($user_id, $newemail, $password);
    }

    function changePassword($user_id, $old_password, $new_password, $curr_password)
    {
        global $conn;
        if ($new_password !== $curr_password) {
            echo "<script>alert('Mật khẩu mới không khớp'); window.location.href='user.php';</script>";
            return;
        }
        $query = "SELECT password_hash FROM `Users` WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && hash("sha256", $old_password) === $user['password_hash']) {
            $new_password_hash = hash("sha256", $new_password);
            $updateQuery = "UPDATE `Users` SET password_hash = ? WHERE user_id = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param("si", $new_password_hash, $user_id);

            if ($stmt->execute()) {
                echo "<script>alert('Cập nhật mật khẩu thành công'); window.location.href='user.php';</script>";
            } else {
                echo "<script>alert('Có lỗi xảy ra khi cập nhật mật khẩu'); window.location.href='user.php';</script>";
            }
        } else {
            echo "<script>alert('Mật khẩu cũ không đúng'); window.location.href='user.php';</script>";
        }
    }
    if (isset($_POST['doi_password'])) {
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $curr_password = $_POST['curr_password'];
        changePassword($user_id, $old_password, $new_password, $curr_password);
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
                <a href="" class="mr-3 text-decoration-none">
                    <img src="<?php echo $profileImage; ?>" class="rounded-circle" width="40" height="40">
                    <span class="font-weight-bold text-white"><?php echo htmlspecialchars($username); ?></span>
                </a>
                <a href="?logout" class="btn btn-secondary"><i class="fas fa-sign-out-alt"></i> Đăng Xuất</a>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="header-section d-flex justify-content-between align-items-center mb-4">
            <span><a href="../trangchu/home.php">Home <i class="bi bi-caret-left"></i> </a><a
                    href="../nguoidung/user.php">My Profile</a>
                <h3>Accout Details</h3>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <table class="tb_profile">
                    <tr>
                        <td colspan="2"><img src="<?php echo $profileImage; ?>" class="rounded-circle" width="200"
                                height="200"></td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Username: </td>
                        <td class="spec_td">
                            <?php echo $username ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Email: </td>
                        <td class="spec_td"><?php echo $email ?>
                            <button class="change_profile" type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#changeEmailModalLabel">
                                Change
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-weight-bold">Khoa viện: </td>
                        <td class="spec_td"><?php
                        $query = "SELECT major_name
                                FROM `Users` u
                                JOIN Majors m ON u.major = m.major_id
                                WHERE u.user_id = $user_id";
                        $result = mysqli_query($conn, $query);
                        if ($result && mysqli_num_rows($result) > 0) {
                            $major_data = mysqli_fetch_assoc($result);
                            echo $major_data["major_name"];
                        }
                        ?></td>
                    </tr>
                </table>
                <div class="mt-3">
                    <button class="btn btn-danger" type="button" data-toggle="modal"
                        data-target="#changePasswordlModalLabel">Đổi mật khẩu</button>
                </div>
            </div>
        </div>
    </div>
    <footer class="text-center text-lg-start mt-5 bg-dark">
        <div class="text-center text-white p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2024 Copyright:
            <a class="text-white" href="#">NTUCHAN</a>
        </div>
    </footer>


    <div class="modal fade" id="changeEmailModalLabel" tabindex="-1" aria-labelledby="changeEmailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeEmailModalLabel">Đổi email</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <table>
                            <tr>
                                <td>Nhập email mới: </td>
                                <td>
                                    <input type="email" name="new_email" id="" required>
                                </td>
                            </tr>
                            <tr>
                                <td>Nhập mật khẩu: </td>
                                <td>
                                    <input type="password" name="password" id="" required>
                                </td>
                            </tr>
                        </table>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" name="doi_email" value="Xác nhận"></input>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade" id="changePasswordlModalLabel" tabindex="-1" aria-labelledby="changePasswordlModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordlModalLabel">Đổi mật khẩu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <table>
                            <tr>
                                <td>Nhập mật khẩu cũ: </td>
                                <td>
                                    <input type="password" name="old_password" id="" required>
                                </td>
                            </tr>
                            <tr>
                                <td>Nhập mật khẩu mới: </td>
                                <td>
                                    <input type="password" name="new_password" id="" required>
                                </td>
                            </tr>
                            <tr>
                                <td>Nhập lại mật khẩu mới: </td>
                                <td>
                                    <input type="password" name="curr_password" id="" required>
                                </td>
                            </tr>
                        </table>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" name="doi_password" value="Xác nhận"></input>
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