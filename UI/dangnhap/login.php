<?php
session_start();
session_unset();
// Kết nối tới cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ntuchan";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$error = "";  // Biến lưu thông báo lỗi

// Kiểm tra nếu form đã được gửi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];  // Chuyển 'name' thành 'username'
    $password = $_POST["password"];
    $password = hash("sha256", $password);
    // Truy vấn để kiểm tra thông tin đăng nhập
    $query = "SELECT * FROM Users WHERE username = ? AND password_hash = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);  
    $stmt->execute();
    $result = $stmt->get_result();

    // Kiểm tra nếu có bản ghi hợp lệ
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION["username"] = $user["username"];
        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["pfp"] = $user["profile_pic"];
        header("Location: ../trangchu/home.php");  // Điều hướng về home.php trong thư mục trang chủ
        exit();
    } else {
        $error = "Sai tài khoản hoặc mật khẩu!";
    }
}
$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
<section class="vh-100">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-4">
                <img src="images/forums_logo.png" class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <form action="login.php" method="post">
                    <div class="divider">
                        <p id="title_1" class="text-center fw-bold">NTUCHAN LOGIN</p>
                    </div>
                    <div class="divider d-flex align-items-center my-4">
                        <p class="text-center fw-bold mx-3 mb-0">
                            <a href="../trangchu/home.php"><img class="logo" src="images/Logo_NTU.png" alt=""></a>
                        </p>
                    </div>

                    <!-- Username input -->
                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label font-weight-bold" for="form3Example3">Username</label>
                        <input type="text" name="username" required id="form3Example3" class="form-control form-control-lg" placeholder="Nhập tài khoản" />
                    </div>

                    <!-- Password input -->
                    <div data-mdb-input-init class="form-outline mb-3">
                        <label class="form-label font-weight-bold" for="form3Example4">Password</label>
                        <input type="password" name="password" required id="form3Example4" class="form-control form-control-lg" placeholder="Nhập mật khẩu" />
                    </div>

                    <?php if (!empty($error)) : ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <div class="text-center text-lg-start mt-4 pt-2">
                        <button type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Đăng nhập</button>
                        <p class="small fw-bold mt-2 pt-1 mb-0">Chưa có tài khoản? <a href="register.php" class="link-danger">Đăng kí</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
