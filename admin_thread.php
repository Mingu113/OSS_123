<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Quản lý thread và bài viết</title>
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
            height: 120px; /* Chiều cao cố định */
            overflow: hidden; /* Ẩn nội dung tràn */
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
            z-index: 1; /* Đảm bảo nút nằm trên cùng */
        }

        .thread-item .flex-grow-1 {
            padding-right: 50px; /* Để tạo khoảng trống cho nút */
        }

        a {
            display: block;
        }
    </style>
</head>
<?php 
    require "./config.php";
    
    if(isset($_POST["thread"]))
    {
        $thread = $_POST["thread"];
        $query_delete_thread = "DELETE FROM `Threads` WHERE thread_id = $thread";
        $query_delete_post = "DELETE FROM `Posts` WHERE thread_id = $thread";
        mysqli_query($conn, $query_delete_thread);
        mysqli_query($conn, $query_delete_post);
    }

    if(isset($_POST["post"]))
    {
        $post = $_POST["post"];
        $query_delete_post = "DELETE FROM `Posts` WHERE post_id = $post";
        mysqli_query($conn, $query_delete_post);
    }


    $query1 = "SELECT * FROM `Threads`";
    $result1 = mysqli_query($conn, $query1);

    $query2 = "SELECT Posts.*, Users.profile_pic, Users.username, Threads.title
        FROM Posts
        JOIN Users ON Posts.user_id = Users.user_id 
        JOIN Threads ON Posts.thread_id = Threads.thread_id";
    $result2 = mysqli_query($conn, $query2);
?>

<body>
    <?php session_abort(); require "./header.php";?>

    <div class="container mt-5 flex-grow-1">
    <a href="./user.php"><button class="btn-success" >Chuyển sang danh sách người dùng</button></a>
        <div class="flex-container">
            <div>
                <h3>Threads</h3>
                <?php
                while ($row1 = mysqli_fetch_array($result1)) {
                    echo '<form method="POST" action="">'; // Hành động đến trang hiện tại
                    echo '<div class="thread-item d-flex justify-content-between align-items-start">';
                    echo '<div class="flex-grow-1">';
                    echo '<h5>' . $row1["title"] . '</h5>'; 
                    echo '<div class="timestamp">' . $row1["created_at"] . '</div>';
                    echo '</div>';
                    echo '<button type="submit" name="thread" value="' . $row1['thread_id'] . '" class="btn btn-danger action-button">Xóa</button>'; // Nút submit
                    echo '</div>';
                    echo '</form>';
                }
                ?>
            </div>

            <div>
                <h3>Posts</h3>
                <?php
                    while ($row2 = mysqli_fetch_array($result2)) {
                        echo '<form method="POST" action="">'; // Hành động đến trang hiện tại
                        echo '<div class="post-item d-flex justify-content-between">';
                        echo '<div class="d-flex">';
                        echo '<img src="../images/' . ($row2["profile_pic"] ?? "default.jpg") . '" class="post-avatar mr-3" alt="User Avatar">';
                        echo '<div class="flex-grow-1">';
                        echo '<h5><strong>' . $row2["title"] . '</strong></h5>'; // Không sử dụng htmlspecialchars()
                        echo '<h6>' . $row2["username"] . '</h6>';
                        echo '<small>' . $row2["created_at"] . '</small>';
                        echo '<p>' . $row2["content"] . '</p>'; // Không sử dụng highlight
                        echo '<div class="timestamp">' . $row2["created_at"] . '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '<button type="submit" name="post" value="' . $row2['post_id'] . '" class="btn btn-danger action-button">Xóa</button>'; // Nút submit
                        echo '</div>';
                        echo '</form>';
                    }
                ?>
            </div>
            <!-- <a href="#" class="post-item d-flex justify-content-between">
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
                </a>-->
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>