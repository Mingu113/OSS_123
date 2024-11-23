<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
        .scrollable-div {
            max-height: 700px;
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 10px;
            scrollbar-width: thin;
            scrollbar-color: #888 #f1f1f1;
        }

        .scrollable-div::-webkit-scrollbar {
            width: 5px;
        }

        .scrollable-div::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .scrollable-div::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 5px;
        }

        .scrollable-div::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>

<body>
    <?php
    require "./config.php";
    require "./header.php";
    require "./modal.php";
    $isLoggedIn = isset($_SESSION["username"], $_SESSION["user_id"]);
    if ($isLoggedIn) {
        $username = $_SESSION["username"];
        $user_id = $_SESSION["user_id"];
        $query2 = "SELECT * FROM `Users` WHERE user_id = '$user_id'";
        $result2 = mysqli_query($conn, $query2);
        if ($result2 && mysqli_num_rows($result2) > 0) {
            $user_data = mysqli_fetch_assoc($result2);
            $user_role = $user_data["role"];
        }
        $query = "SELECT * FROM `Boards`";
        $result_boards = mysqli_query($conn, $query);

        $query1 = "SELECT * FROM `Categories`";
        $result_categories = mysqli_query($conn, $query1);

    } else {
        echo '<div>Bạn không có quyền truy cập vào trang này!!!
        <a href="./index.php">Trở về trang chủ</a>
        </div>';
        exit();
    }
    ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="scrollable-div">
                    <div class="d-flex justify-content-end">
                    <?php
                        if ($user_role == "admin") {
                            echo '<button class="btn btn-primary mr-3" data-toggle="modal" data-target="#boardModal"><i
                            class="bi bi-pencil"></i> Thêm
                        Boards</button>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#categoryModal"><i
                            class="bi bi-pencil"></i> Thêm
                        Categories</button>';
                        }
                    ?>
                    </div>
                        
                    <?php
                        while ($row = mysqli_fetch_array($result_boards)) {
                            echo "<h2>";
                            echo $row["board_name"];
                            echo "</h2>";
                            echo "<div class=\"list-group mb-4\">";
                            mysqli_data_seek($result_categories, 0);
                            while ($row1 = mysqli_fetch_array($result_categories)) {
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

            </div>
            <div class="col-lg-4"></div>
        </div>
    </div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>

</html>