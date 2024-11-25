<!doctype html>
<html lang="en">
<?php
require "./config.php";
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
        $profileImage = $user_data["profile_pic"];
        $_SESSION["pfp"] = $profileImage;
        $user_is_banned = $user_data["is_banned"];
        $role = $user_data["role"];
    }
} else {
    header("Location: ./index.php");
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
            echo '<div class="alert alert-success text-center" role="alert" id="alertMessage">Cập nhật email thành công</div>';

        } else {
            echo '<div class="alert alert-danger text-center" role="alert" id="alertMessage">Có lỗi xảy ra khi cập nhật email</div>';

        }
    } else {
        echo '<div class="alert alert-danger text-center" role="alert" id="alertMessage">Mật khẩu không đúng</div>';

    }
}
if (isset($_POST['doi_email'])) {
    $password = $_POST['password'];
    $newemail = $_POST['new_email'];
    changeEmail($user_id, $newemail, $password);
}

if(isset($_POST["doi_anh"])) {
    $file = $_FILES["img_files"];
    changepfp($file, $user_id);
}
function changePassword($user_id, $old_password, $new_password, $curr_password)
{
    global $conn;

    if ($new_password !== $curr_password) {
        echo '<div class="alert alert-danger text-center" role="alert" id="alertMessage">Mật khẩu mới không khớp</div>';
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
            echo '<div class="alert alert-success text-center" role="alert" id="alertMessage">Cập nhật mật khẩu thành công</div>';

        } else {
            echo '<div class="alert alert-danger text-center" role="alert" id="alertMessage">Có lỗi xảy ra khi cập nhật mật khẩu</div>';
        }
    } else {
        echo '<div class="alert alert-danger text-center" role="alert" id="alertMessage">Mật khẩu cũ không đúng</div>';

    }
}
if (isset($_POST['doi_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $curr_password = $_POST['curr_password'];
    changePassword($user_id, $old_password, $new_password, $curr_password);
}


function changeMajor($user_id, $major)
{
    global $conn;

    if ($major === "NULL") {
        $query = "UPDATE `Users` SET major = NULL WHERE user_id = '$user_id'";
    } else {
        $query = "UPDATE `Users` SET major = '$major' WHERE user_id = '$user_id'";
    }

    if (mysqli_query($conn, $query)) {
        echo '<div class="alert alert-success text-center" role="alert" id="alertMessage">Cập nhật khoa viện thành công</div>';
    } else {
        echo '<div class="alert alert-danger text-center" role="alert" id="alertMessage">Có lỗi xảy ra khi cập nhật khoa viện</div>';
    }
}
if (isset($_POST["doi_major"])) {
    $major = $_POST["major"];
    changeMajor($user_id, $major);
}
function changepfp($file, $user_id) {
    global $conn;
    global $profileImage;
    if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $file['tmp_name'];
        $fileName = $file['name'];
        $fileSize = $file['size'];
        $fileType = $file['type'];

        // $uploadFileDir = './images/userpfp/';
        $uploadFileDir = './images/userpfp/';
        $dest_path = $uploadFileDir . basename($fileName);

        $allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($fileType, $allowedFileTypes)) {
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $query = "UPDATE Users SET profile_pic = '$dest_path' WHERE user_id = $user_id";
                if (mysqli_query($conn, $query)) {
                    echo '<div class="alert alert-success text-center" role="alert" id="alertMessage">Đã cập nhật.</div>';
                    // Delete the old file because I don't want it to take many storage, refresh the page.
                    unlink($_SESSION["pfp"]);
                    header("Location: ./user.php");
                } else {
                    echo '<div class="alert alert-danger text-center" role="alert" id="alertMessage">Có lỗi xảy ra khi cập nhật ảnh</div>';
                }
            } else {
                echo '<div class="alert alert-danger text-center" role="alert" id="alertMessage">Có lỗi xảy ra khi di chuyển tệp</div>';

            }
        } else {
            echo '<div class="alert alert-danger text-center" role="alert" id="alertMessage">Định dạng tệp không hợp lệ</div>';
        }
    } else {
        echo '<div class="alert alert-danger text-center" role="alert" id="alertMessage">Có lỗi xảy ra khi tải lên tệp</div>';
    }
}
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title><?php if (!empty($username))
        echo $username;
    else
        echo "No user"; ?></title>
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

        .post_li {
            border-radius: 3px;
            padding: 10px;
            margin-left: 50px;
        }

        #alertMessage {
            position: fixed;
            top: 11%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1050;
            width: 300px;
        }
    </style>
</head>

<body>
    <?php session_commit();
    require "./header.php" ?>
    <div class="container-fluid mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="header-section d-flex justify-content-between align-items-center mb-4">
                        <span><a href="./index.php">Home <i class="bi bi-caret-left"></i> </a><a
                                href="./user.php">My Profile</a>
                            <h3>Accout Details</h3>
                    </div>

                    <table class="tb_profile">
                        <tr>
                            <td colspan="3">
                                <div class="profile-container">
                                    <img src="<?php echo $profileImage; ?>" class="rounded-circle" width="200"
                                    height="200">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <form class="d-flex flex-column" method="post" enctype="multipart/form-data">
                                <td>
                                    <input type="file" name="img_files">
                                </td>
                                <td>
                                    <input type="submit" class="btn btn-danger mt-1 mb-3" value="Change"
                                    name="doi_anh"></i>
                                </td>
                            </form> 
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Username: </td>
                            <td class="spec_td">
                                <?php echo $username ?>
                            </td>
                            <?php if ($user_is_banned): ?>
                                <td>
                                    <p class="btn-danger">Người dùng đã bị ban</p>
                                </td>
                            <?php endif; ?>
                            <?php if ($role != "user"): ?>
                                <td>
                                    <a href="./admin.php"><button class="btn btn-success" type="button">Đến trang quản trị: <?php echo $role;?></button></a>
                                    <a href="./admin_index.php"><button class="btn btn-success" type="button">Tạo Board / Category:</button></a>
                                </td>
                            <?php endif; ?>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Email: </td>
                            <td class="spec_td">
                                <?php if ($email != null) {
                                    echo $email;
                                } else {
                                    echo "Bạn chưa cập nhật email";
                                } ?>
                            </td>
                            <td>
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
                            } else {
                                echo "Chưa cập nhật khoa viện";
                            }
                            ?>
                            </td>
                            <td>
                                <button class="change_profile" type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#changeMajorModalLabel">
                                    Change
                                </button>
                            </td>
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
                            echo "<a href='./thread.php?id=" . $row["thread_id"] . "&post=" . $row["post_id"] . "'>" . "Post: " . nl2br(stripcslashes($row["content"])) . "</br>" . " Created At: " . $row["created_at"] . "</a>";
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
    <?php require "./footer.php"?>
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
        
    <div class="modal fade" id="changeMajorModalLabel" tabindex="-1" aria-labelledby="changeMajorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeEmailModalLabel">Đổi Khoa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <table>
                            <tr>
                                <td>Thay đổi chuyên ngành: </td>
                                <td>
                                    <select name="major" id="major" class="form-control form-control-lg">
                                        <option value="NULL">Chọn khoa</option>
                                        <?php
                                        $query = "SELECT * FROM Majors";
                                        $result = mysqli_query($conn, $query);
                                        if (!$result)
                                            die('<br> <b>Query failed</b>');
                                        if (mysqli_num_rows($result) != 0) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                echo "<option value='" . $row['major_id'] . "'>" . $row['major_name'] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" name="doi_major" value="Xác nhận"></input>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <div class="modal fade" id="changePasswordlModalLabel1" tabindex="-1"
            aria-labelledby="changePasswordlModalLabel1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changeAvatarModalLabel">Đổi ảnh</h5>
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
                                <input type="submit" class="btn btn-primary" name="doi_password"
                                    value="Xác nhận"></input>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            setTimeout(function () {
                var alertMessage = document.getElementById('alertMessage');
                alertMessage.style.display = 'none';
            }, 2000);
        </script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>