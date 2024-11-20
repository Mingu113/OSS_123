<!doctype html>
<html lang="en">
    <?php
    require "../trangchu/config.php";
    session_start(); // start session
    $isLoggedIn = isset($_SESSION["user_id"]);
    if ($isLoggedIn) {
        $user_id = $_SESSION["user_id"];
        $username = $_SESSION["username"];

        $query = "SELECT * FROM `Users` WHERE user_id = $user_id";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            $username = $user_data["username"];
            $email = $user_data["email"];
            $major = $user_data["major"];
            $user_is_banned = $user_data["is_banned"];
        }
    } else {
        header("Location: ../trangchu/home.php");
    }

    global $user_id;
    function changeEmail($user_id, $newemail, $password)
    {
        global $conn;

        $user_id = mysqli_real_escape_string($conn, $user_id);
        $query = "SELECT password_hash FROM `Users` WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);

        if ($user && hash("sha256", $password) === $user['password_hash']) {
            $newemail = mysqli_real_escape_string($conn, $newemail);
            $updateQuery = "UPDATE `Users` SET email = '$newemail' WHERE user_id = '$user_id'";

            if (mysqli_query($conn, $updateQuery)) {
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
        $user_id = mysqli_real_escape_string($conn, $user_id);
        $query = "SELECT password_hash FROM `Users` WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);

        if ($user && hash("sha256", $old_password) === $user['password_hash']) {
            $new_password_hash = hash("sha256", $new_password);
            $new_password_hash = mysqli_real_escape_string($conn, $new_password_hash);
            $updateQuery = "UPDATE `Users` SET password_hash = '$new_password_hash' WHERE user_id = '$user_id'";

            if (mysqli_query($conn, $updateQuery)) {
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
    ?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title><?php if(!empty($username)) echo $username; else echo "No user"; ?></title>
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

        .col_right {
        }
        .post_li {
            border-radius: 3px;
            padding: 10px;
            margin-left: 50px;
        }
    </style>
</head>

<body>
    <?php session_abort(); require "../trangchu/header.php" ?>
    <div class="container-fluid mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="header-section d-flex justify-content-between align-items-center mb-4">
                        <span><a href="../trangchu/home.php">Home <i class="bi bi-caret-left"></i> </a><a
                                href="../nguoidung/user.php">My Profile</a>
                            <h3>Accout Details</h3>
                    </div>
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
                            <?php if($user_is_banned): ?>
                                <td>
                                <p class="btn-danger">Người dùng đã bị ban</p>
                                </td>
                            <?php endif;?>
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
                <div class="col-lg-4 col_right">
                <div class="header-section d-flex justify-content-between align-items-center mb-4">
                        
                    </div>
                    <h3>Các bài đăng gần đây</h3>
                    <?php
                    $query = "SELECT thread_id, post_id, content, created_at FROM Posts WHERE user_id = '$user_id' ORDER BY created_at DESC LIMIT 5";
                    $result = mysqli_query($conn, $query);
                    if (!$result)
                        die('<br> <b>Query failed</b>');
                    $num_files = mysqli_num_fields($result);
                    if (mysqli_num_rows($result) != 0) {
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<ul class='list-group'>";
                            echo "<li class='post_li mt-3'>";
                            echo "<a href='../threads/thread.php?id=".$row["thread_id"]."&post=".$row["post_id"]."'>" . "Post: ". nl2br(stripcslashes($row["content"])). "</br>" ." Created At: ".$row["created_at"]. "</a>";
                            echo "</li>";
                            echo "</ul>";
                        }
                    } else {
                        echo 'Không có bài viết nào';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>


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