<!doctype html>
<html lang="en">

<head>
    <title>Đăng ký</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/style.css">
</head>
<?php
session_unset();
// Kết nối tới cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ntuchan";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
    $name = $password = $email = $password_check = $major = null;
    $msg = "";
// Kiểm tra nếu form đã được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $name = $_POST["name"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $password_check = $_POST["password_check"];
    $major = $_POST["major"];
    $valid = true;
    $email = ($email == '') ? null : $email;
    $major = ($major == '') ? null : $major;
    
    // Kiểm tra mật khẩu và xác nhận mật khẩu có trùng khớp không
    if ($password != $password_check) {
        $msg = "Mật khẩu và xác nhận mật khẩu không khớp.";
        $valid = false;
    }
    $query = "SELECT * FROM Users WHERE (username = '$name' OR email = '$email') AND email IS NOT NULL";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        if($row['username'] == $name) $msg = $msg . "Người dùng đã tồn tại";
        if($row['email'] == $email) $msg = $msg . "Email đã được sử dụng";
        $valid = false;
    }
    
    // Process
    if($valid) {
        $password = hash("sha256", $password);
        $query = "INSERT INTO Users (username, password_hash, email , major) VALUES (?,?,?,?)";
        $data = [$name, $password, $email, $major];
        $conn->prepare($query)->execute($data);
        if(!$conn) die ('<br> <b>Query failed</b>');
        else $msg = "Đăng kí tài khoản thành công"; 
    }
}
?>

<body>
<section class="vh-100">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-4">
                <img src="images/forums_logo.png" class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <form action="register.php" method="post">
                    <div class="divider">
                        <p id="title_1" class="text-center fw-bold">NTUCHAN REGISTER</p>
                    </div>
                    <div class="divider d-flex align-items-center my-4">
                        <p class="text-center fw-bold mx-3 mb-0">
                            <a href="./index.php"><img class="logo" src="images/Logo_NTU.png" alt=""></a>
                        </p>
                    </div>

                    <!-- Username input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label font-weight-bold" for="form3Example3">Username <span
                                    class="text-danger">*</span></label> <small>Chỉ các chữ cái tiếng Anh, không khoảng trắng hoặc kí tự đặc biệt</small>
                        <input name="name" required type="text" value="<?php echo $name ?>" id="form3Example3" class="form-control form-control-lg"
                               placeholder="Nhập tài khoản" pattern="^[A-Za-z0-9]+$" />
                    </div>

                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label font-weight-bold" for="form3Example3">Email</label>
                        <input name="email" type="email" id="form3Example3" value="<?php echo $email ?>" class="form-control form-control-lg" placeholder="Nhập email"/>
                    </div>

                    <!-- Password input -->
                    <div data-mdb-input-init class="form-outline mb-3">
                        <label class="form-label font-weight-bold" for="form3Example4">Password <span
                                    class="text-danger">*</span></label> <small>Chỉ các chữ cái tiếng Anh, không khoảng trắng hoặc kí tự đặc biệt</small>
                        <input type="password" required name="password" pattern="^[A-Za-z0-9]+$"  id="form3Example4" class="form-control form-control-lg"
                               placeholder="Nhập mật khẩu" />
                    </div>

                    <div data-mdb-input-init class="form-outline mb-3">
                        <label class="form-label font-weight-bold" for="form3Example4">Confirm Password <span
                                    class="text-danger">*</span></label> <small>Chỉ các chữ cái tiếng Anh, không khoảng trắng hoặc kí tự đặc biệt</small>
                        <input type="password" required name="password_check" pattern="^[A-Za-z0-9]+$" id="form3Example4" class="form-control form-control-lg"
                               placeholder="Nhập lại mật khẩu" />
                    </div>
                    <!-- Major select -->
                    <div data-mdb-input-init class="form-outline mb-3">
                        <label class="form-label font-weight-bold" for="major">Major</label>
                        <select name="major" id="major" class="form-control form-control-lg">
                            <option value="">Chọn khoa</option>
                            <?php
                            // Lấy danh sách chuyên ngành từ bảng majors
                            $query = "SELECT * FROM Majors";
                            $result = mysqli_query($conn, $query);
                            if (!$result) die('<br> <b>Query failed</b>');
                            // Lấy và hiển thị danh sách chuyên ngành
                            if (mysqli_num_rows($result) != 0) {
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<option value='" . $row['major_id'] . "'>" . $row['major_name'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="text-center text-lg-start mt-4 pt-2">
                        <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">Đăng kí</button>
                        <p class="small fw-bold mt-2 pt-1 mb-0">Trở về đăng nhập <a href="login.php" class="link-danger">Login</a>
                        </p>
                        <?php
                        echo "<h5 style=\"color:red\">$msg</h5>"
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
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
