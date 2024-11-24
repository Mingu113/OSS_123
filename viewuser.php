<!doctype html>
<html lang="en"></html>


<?php
    session_start();
    if(isset($_SESSION["user_id"]) && isset($_GET['user_id'])){
        if($_SESSION['user_id'] == $_GET['user_id']){
            header('Location: user.php');
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
    </style>
</head>

<body>
    <?php
    session_commit();
    require "./config.php";
    require "./header.php" ;
    if (isset($_GET["user_id"])) {
        $user_id = $_GET["user_id"];
        $query = "SELECT * FROM `Users` WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            $username = $user_data["username"];
            $email = $user_data["email"];
            $major = $user_data["major"];
            $profileImage = $user_data["profile_pic"];
            $user_is_banned = $user_data["is_banned"];
            $role = $user_data["role"];
        }
        else {
            echo '<div><h2>Không tìm thấy Người dùng</h2></div>';
            require "./footer.php";
            exit();
        }
    } else {
        echo '<div><h2>Không tìm thấy Người dùng</h2></div>';
        require "./footer.php";
        exit();
    }
    ?>
    <div class="container-fluid mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="header-section d-flex justify-content-between align-items-center mb-4">
                        <span><a href="./index.php">Home <i class="bi bi-caret-left"></i> </a><a href="./viewuser.php?user_id=<?php echo $user_id?>">
                                User Profile</a>
                            <h3>Accout Details</h3>
                    </div>

                    <table class="tb_profile">
                        <tr>
                            <td colspan="3">
                                <div class="profile-container">
                                    <img src="<?php if ($profileImage != NULL){echo $profileImage;} else {echo "./images/default.jpg";} ?>" class="rounded-circle" width="200"
                                        height="200">
                                </div>
                            </td>
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
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Email: </td>
                            <td class="spec_td">
                                <?php if ($email != null) {
                                    echo $email;
                                } else {
                                    echo "Người dùng chưa cập nhật email";
                                } ?>
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
                                echo "Người dùng Chưa cập nhật khoa viện";
                            }
                            ?>
                            </td>
                        </tr>
                    </table>
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
    <?php require "./footer.php";?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>