<?php


if (isset($_POST["add_board"])) {
    $board_name = $_POST["board_name"];
    $query = "INSERT INTO `Boards` (`board_id`, `board_name`) VALUES (NULL, '$board_name')";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Error: ");
    } else {
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
        if (isset($_GET['success'])) {
            echo "<div class='alert alert-success'>Thêm board thành công!</div>";
        }
        exit();
    }
}






if (isset($_POST["add_category"])) {
    $board_id = mysqli_real_escape_string($conn, $_POST["board_select"]);
    $category_name = mysqli_real_escape_string($conn, $_POST["category_name"]);
    $des = mysqli_real_escape_string($conn, $_POST["des"]);

    $query = "INSERT INTO `Categories` (`category_id`, `board_id`, `name`, `description`) VALUES (NULL, '$board_id', '$category_name', '$des')";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Error: ");
    } else {
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=1");
        if (isset($_GET['success'])) {
            echo "<div class='alert alert-success'>Thêm board thành công!</div>";
        }
        exit();
    }
}


?>




<!-- Admin Boards -->
<div class="modal fade" id="boardModal" tabindex="-1" role="dialog" aria-labelledby="boardModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="boardModalLabel">Tạo bảng mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="form-group">
                        <label for="title">Tiêu đề</label>
                        <input type="text" class="form-control" required id="title" name="board_name"
                            placeholder="Nhập tiêu đề">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" name="add_board" class="btn btn-primary">Tạo
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Admin Category -->
<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categotyModalLabel">Tạo bài viết mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post">
                    <div class="form-group">
                        <label for="title">Board Name</label>
                        <select name="board_select" class="form-control">
                            <?php
                            $query = "SELECT * FROM Boards ORDER BY board_name";
                            $result = mysqli_query($conn, $query);
                            if (!$result) {
                                die("Query failed: " . mysqli_error($conn));
                            }
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['board_id'] . "'>" . htmlspecialchars($row['board_name']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group ">
                        <label for="title">Category Name</label>
                        <input type="text" class="form-control" required id="title" name="category_name"
                            placeholder="Nhập tiêu đề">
                    </div>
                    <div class="form-group ">
                        <label for="title">Description</label>
                        <input type="text" class="form-control" required id="title" name="des"
                            placeholder="Nhập mô tả">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" name="add_category" class="btn btn-primary">Thêm Category
                          </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>