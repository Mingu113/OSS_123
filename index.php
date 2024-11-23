<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Trang Chủ Diễn Đàn</title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .header-section {
            margin-bottom: 20px;
        }

        .user_avatar {
            background-color: antiquewhite;
            padding: 0px 5px 0px 5px;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <?php
    require "./config.php";
    session_start(); // start session
    $isLoggedIn = isset($_SESSION["username"], $_SESSION["user_id"]);
    if ($isLoggedIn) {
        $username = $_SESSION["username"];
        $user_id = $_SESSION["user_id"];
    } else {
        $username = "";
    }
    $profileImage = !empty($_SESSION["pfp"]) ? $_SESSION["pfp"] : "./images/default.jpg";
    ?>

    <?php
    $query = "SELECT * FROM `Boards`";
    $result = mysqli_query($conn, $query);

    $query1 = "SELECT * FROM `Categories`";
    $result1 = mysqli_query($conn, $query1);


    $query2 = "SELECT * FROM `Users`";
    $result2 = mysqli_query($conn, $query2);
    $sltv = mysqli_num_rows($result2);

    $query3 = "SELECT * FROM `Threads` ORDER BY created_at DESC LIMIT 5";
    $result3 = mysqli_query($conn, $query3);
    if (isset($_GET['logout'])) {
        session_unset();
    }
    $query4 = "SELECT * FROM Posts ORDER BY created_at DESC LIMIT 5";
    $result4 = mysqli_query($conn, $query4);
    ?>
    <?php session_abort();
    require "./header.php" ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8">
                <?php
                while ($row = mysqli_fetch_array($result)) {
                    echo "<h2>";
                    echo $row["board_name"];
                    echo "</h2>";
                    echo "<div class=\"list-group mb-4\">";
                    mysqli_data_seek($result1, 0);
                    while ($row1 = mysqli_fetch_array($result1)) {
                        if ($row["board_id"] == $row1["board_id"]) {
                            echo "<a href='./category.php?name=" . urlencode($row1["name"]) . "&category_id=" . urlencode($row1["category_id"]) . "&sort=thread" . "' class=\"list-group-item list-group-item-action\">";
                            echo $row1["name"];
                            echo "</a>";
                        }

                    }
                    echo "</div>";
                }
                ?>
            </div>

            <div class="col-lg-4">
                <div class="sidebar">
                    <h3>Tổng Số Người Sử Dụng</h3>
                    <?php echo "<p>" . $sltv . " Thành viên </p>" ?>
                    <h3>Thread mới nhất</h3>
                    <ul class="list-unstyled">
                        <?php
                        while ($row = mysqli_fetch_array($result3)) {
                            echo "<li>";
                            echo '<a href="./thread.php?id=' . urlencode($row["thread_id"]) . '">' . $row["title"] . "</a>";
                            echo "</li>";
                        }
                        ?>
                    </ul>
                </div>
                <div class="sidebar">
                    <h3>Bình luận mới nhất</h3>
                    <ul class="list-unstyled">
                        <?php
                        while ($row = mysqli_fetch_array($result4)) {
                            echo "<li>";
                            if(strlen($row["content"]) > 30) {
                                $post_content = substr($row["content"], 0, 30) . "...";
                            } else $post_content = $row["content"];
                            echo '<a href="./thread.php?id=' . urlencode($row["thread_id"]) . '&post='.urlencode($row["post_id"]).'">' .nl2br(stripcslashes($post_content)) . "</a>";
                            echo "</li>";
                        }
                        ?>
                    </ul>
                </div>
                <div>
                    <!--Begin thoitiet.vn Weather Widget -->
                    <iframe
                        src="https://thoitiet.vn/embed/wvrvhpduxgk?days=3&hC=%23ffffff&hB=%23FF0000&tC=%23848484&bC=%23FF0000&lC=%23dddddd"
                        id="widgeturl" width="100%" height="297" scrolling="no" frameborder="0" allowtransparency="true"
                        style="border:none;overflow:hidden;">

                    </iframe>
                    <!-- End Widget -->
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>