<!doctype html>
<html lang="en">
<?php
require "./config.php";
$query_check = $conn->prepare("SELECT * FROM Users WHERE Users.role = 'admin';");
$query_check->execute();
$result = $query_check->get_result();
session_start();
$is_admin = false;
while($user_check = $result->fetch_assoc()) {
    if($user_check['user_id'] == $_SESSION["user_id"]) {
        $is_admin = true;
    }
}
if(!$is_admin) header("Location: ./index.php");
session_abort();
if(isset($_GET["ban_user"])) {
    $query_ban_user = $conn->prepare("UPDATE `Users` SET `is_banned` = ? WHERE `Users`.`user_id` = ? ;"); 
    $query_ban_user->bind_param("ii", $_GET["ban_user"],$_GET["user-id"]);
    $query_ban_user->execute();
}
$query = $conn->prepare("SELECT u.*, m.major_name FROM Users u LEFT JOIN Majors m ON m.major_id = u.major WHERE u.role = 'user'; ");
$query->execute();
$result = $query->get_result();
?>
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
    <?php require "./header.php" ?>
    <div class="container mt-5 flex-grow-1">
        <a href="./admin_thread.php"><button class="btn-success" >Chuyển sang danh sách bài viết</button></a>
        <h3>Danh Sách Người Dùng</h3>
        <?php while ($row = $result->fetch_assoc()): ?>
            <form action="" method="get">
            <div class="user-item">
                <img src="./images/default.jpg" class="user-avatar" alt="User Avatar">
                <div class="user-info">
                <?php if($row["is_banned"]) echo '<small style="color: red;">Người dùng đã bị ban</small>'; else echo ""; ?>
                    <h5><?php echo $row["username"]; ?></h5>
                    <p>Email: <?php echo $row["email"]; ?></p>
                    <p>Khoa: <?php echo $row["major_name"]; ?></p>
                </div>
                <input type="hidden" name="user-id" value="<?php echo $row["user_id"] ;?>">
                <?php if($row["is_banned"] == 0):?>
                <button type="submit" name="ban_user" value="1" class="btn btn-danger ban-button">Ban người dùng</button>
                <?php else: ?>
                <button type="submit" name="ban_user" value="0" class="btn btn-success ban-button">Unban người dùng</button>
                <?php endif;?>
            </div>
            </form>
        <?php endwhile; ?>
    </div>

    <div class="footer">
        <p>&copy; 2024 NTUCHAN. All rights reserved.</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<?php $result->close(); ?>

</html>