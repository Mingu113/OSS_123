<!doctype html>
<html lang="en">

<?php
session_start();
require "../trangchu/config.php";
if (isset($_GET["id"]))
    $thread_id = $_GET["id"];
if (isset($_GET["post"])) {
    $post_id = $_GET["post"];
}
$user_id = $_SESSION["user_id"];
$query_check = mysqli_query($conn, "SELECT is_banned FROM Users WHERE user_id = $user_id;");
$user_is_banned = false;
if ($result = $query_check->fetch_assoc()) {
    if ($result["is_banned"])
        $user_is_banned = true;
}
// Function to upload image to posts
function uploadImages($image_files): ?string
{
    $uploadDirectory = '../images/user_posts_img/';
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxFileSize = 2 * 1024 * 1024; // 2MB
    $totalFiles = count($image_files['name']);
    $post_images = [];
    for ($i = 0; $i < $totalFiles; $i++) {
        // Create unique name so the file won't have the same name (ko muon lam may cai lien quan den file nua)
        $fileName = uniqid(mt_rand(), true) . basename($image_files['name'][$i]) ;
        $fileType = $image_files['type'][$i];
        $fileSize = $image_files['size'][$i];
        $targetFilePath = $uploadDirectory . $fileName;
        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxFileSize) {
            if (move_uploaded_file($image_files['tmp_name'][$i], $targetFilePath)) {
                $post_images[] = $targetFilePath;
            }
        }
    }
    $images_list_string = implode(",", $post_images);
    return $images_list_string;
}
// Gửi bài post mới
if (isset($_POST['btn_post'])) {
    if (isset($_POST['postContent'])) {
        $post_content = mysqli_real_escape_string($conn, $_POST['postContent']);
        $post_content = htmlspecialchars($post_content);
        $user_id = $_SESSION["user_id"];
        $query = "INSERT INTO Posts (thread_id, user_id, content, created_at, post_images) VALUES (?, ?, ?, NOW(), ?) ;";
        //
        $file = $_FILES["file_upload"];
        if($file['error'][0] == UPLOAD_ERR_OK) $post_images = uploadImages($_FILES["file_upload"]);
        else $post_images = null ;
        //
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiss", $thread_id, $user_id, $post_content, $post_images);
        $update_thread_query = $conn->prepare("UPDATE `Threads` SET `newest_post_at` = NOW() WHERE `Threads`.`thread_id` = ?");
        $update_thread_query->bind_param("i", $thread_id);
        // Move the old place
        echo '<script>
        window.onload = function() {
            const targetElement = document.getElementById("new-post");
            targetElement.scrollIntoView({ behavior: "smooth" });
        };
        </script>';

        if ($stmt->execute())
            $update_thread_query->execute();
    } else {
        echo "Vui lòng điền đầy đủ thông tin.";
    }
}
if (isset($thread_id)) {
    // Đếm tổng số post thuộc threads
    $total_post_query = "SELECT COUNT(DISTINCT Posts.post_id) AS total
   FROM Posts
   WHERE Posts.thread_id = $thread_id";

    $total_post_results = mysqli_query($conn, $total_post_query);
    $total_post = mysqli_fetch_assoc($total_post_results)['total'];
    // Số lượng threads mỗi trang
    $posts_per_page = 10;

    // Số trang hiện tại từ URL hoặc mặc định là 1
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    if ($page < 1)
        $page = 1;

    // Tính vị trí cho giới hạn phân trang
    $offset = ($page - 1) * $posts_per_page;
    // Truy vấn để lấy tất cả bài viết
    $query_posts = "SELECT DISTINCT 
   p.thread_id, u.username, p.post_id, p.content, p.post_images, p.created_at, u.user_id, u.profile_pic, u.major, t.title as title, u.role, u.is_banned
   FROM Posts p
   JOIN Users u ON u.user_id = p.user_id
   JOIN Threads t ON t.thread_id = p.thread_id
   WHERE p.thread_id = $thread_id
   ORDER BY p.created_at ASC
   LIMIT $offset, $posts_per_page;";
    $stmt_posts = $conn->prepare($query_posts);
    $stmt_posts->execute();
    $posts_result = $stmt_posts->get_result();
    if (mysqli_num_rows($posts_result) == 0) {
        $thread_title = "Không có Thread";
        $thread_is_available = false;
    } else {
        $thread_title = $posts_result->fetch_assoc()["title"];
        $thread_is_available = true;
    }

    $query2 = "SELECT * FROM `Users`";
    $result2 = mysqli_query($conn, $query2);
    $sltv = mysqli_num_rows($result2);
    // move to the post in the GET request
    if (isset($post_id)) {
        echo '<script>
        window.onload = function() {
            const targetElement = document.getElementById("' . $post_id . '");
            targetElement.scrollIntoView({ behavior: "smooth" });
        };
        </script>';
    }
    // Tính tổng số trang
    $total_pages = ceil($total_post / $posts_per_page);
} else
    $thread_title = "Không có Thread";
$conn->close();
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title><?php echo $thread_title ?></title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .header-section {
            margin-bottom: 20px;
        }

        .thread-title {
            border-bottom: 2px solid #007bff;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .post {
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            align-items: start;
            position: relative;
        }

        .post-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .post-content {
            flex-grow: 1;
        }

        .post-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .post-meta {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .post-number {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 1.2rem;
            font-weight: bold;
            color: #007bff;
        }

        .sidebar {
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .thread-meta {
            font-size: 0.9rem;
            color: #6c757d;
        }

        .new-post {
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 5px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .new-post h3 {
            margin-bottom: 15px;
        }

        .new-post textarea {
            resize: none;
        }

        .new-post .btn {
            width: 100%;
            padding: 10px;
            font-size: 16px;
        }

        .user-role {
            border: solid 1px;
            padding: 2px;
            display: inline-block;
        }

        .image_list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }

        .image_list img {
            max-width: 200px;
            max-height: 200px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <?php session_abort();
    require("../trangchu/header.php"); ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8">
                <!-- Hiển thị tất cả bài viết-->
                <?php if (isset($posts_result) && mysqli_num_rows($posts_result) > 0): ?>
                    <h3><?php echo $thread_title; ?></h3>
                    <?php $post_index = $offset + 1;
                    mysqli_data_seek($posts_result, 0); ?>
                    <?php while ($post = mysqli_fetch_assoc($posts_result)): ?>
                        <div class="post" id="<?php echo $post["post_id"] ?>">
                            <div class="post-number">#<?php echo $post_index++; ?></div>
                            <div style="margin: 10px; margin-right: 25px">
                                <img src="<?php echo ($post['profile_pic'] && realpath($post['profile_pic'])) == null ? "../images/default.jpg" : $post["profile_pic"]; ?>"
                                    alt="User avatar" style="width: 50px; height: 50px; border-radius: 50%;">
                                <div class="post-username"><?php echo htmlspecialchars($post['username']); ?></div>
                                <?php if ($post["role"] != "user"): ?>
                                    <p class="user-role"><small><span
                                                style="color: green;"><?php echo $post["role"]; ?></small></span></p>
                                <?php else: ?>
                                    <p class="user-role"><small><span
                                                style="color: black;"><?php echo $post["role"]; ?></small></span></p>
                                <?php endif; ?>
                            </div>
                            <div class="post-content">
                                <p><?php echo nl2br(stripcslashes($post['content'])); ?></p>
                                <p class="post-meta">Thời gian: <strong><?php echo $post['created_at']; ?></strong></p>
                                <?php if ($post["is_banned"] == 1): ?>
                                    <p><span style="color: red;"><small>Người dùng này đã bị ban</small></span></p>
                                <?php endif; ?>
                                <?php if(!empty($post['post_images'])):?>
                                    <?php
                                        $post_images_list = explode(",", $post["post_images"]);
                                    ?>
                                    <div class="image_list">
                                        <?php foreach($post_images_list as $image):?>
                                        <a href="<?php echo $image;?>" target="_blank" rel="noopener noreferrer" ><img src="<?php echo $image; ?>" alt="<?php echo"Ảnh của" . $post["username"] ?>"></a>
                                        <?php endforeach;?>
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>

                    <?php endwhile; ?>
                <?php endif; ?>
                <div class="d-flex">
                    <!-- Liên kết phân trang -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link"
                                        href="thread.php?id=<?php echo urlencode($thread_id); ?>&page=<?php echo $page - 1; ?>">Trang
                                        trước</a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php if ($i == $page)
                                    echo 'active'; ?>">
                                    <a class="page-link"
                                        href="thread.php?id=<?php echo urlencode($thread_id); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link"
                                        href="thread.php?id=<?php echo urlencode($thread_id); ?>&page=<?php echo $page + 1; ?>">Trang
                                        sau</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
                <?php if ($user_is_banned): ?>
                    <h1 align="center">Không thể đăng bài viết<br>Bạn đã bị ban</h1>
                <?php elseif ($isLoggedIn && isset($thread_id) && $thread_is_available): ?>
                    <!-- Form gửi bài post mới -->
                    <div class="new-post" id="new-post">
                        <h2>Người dùng: <?php echo $username; ?></h2>
                        <h3>Viết Bài Post Mới</h3>
                        <form method="post" action="" enctype="multipart/form-data">
                            <div class="form-group">
                                <textarea required class="form-control" id="postContent" name="postContent" rows="4"
                                    placeholder="Nhập nội dung bài post..."></textarea>
                            </div>
                            <input type="file" name="file_upload[]" id="file_input" multiple accept="image/*">
                            <div class="image_list" id="image_list"></div>
                            <button type="submit" class="btn btn-primary" name="btn_post">Đăng</button>
                        </form>
                    </div>
                <?php elseif ($thread_is_available): ?>
                    <h1 align="center">Đăng nhập để đăng bài viết</h1>
                <?php endif; ?>
                <?php if (!$thread_is_available): ?>
                    <div style="text-align: center;">
                        <img align="center" src="../images/not_found.gif" alt="Image" width="60%">
                        <h1 align="center">Không có bài thread này, có thể đã bị xóa hoặc không tồn tại</h1>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- upload images -->
    <script>
        const file_input = document.getElementById('file_input');
        const image_list = document.getElementById('image_list');
        // const upload_button = document.getElementsByName('btn_post');
        let selectedFiles = [];

        file_input.addEventListener('change', (event) => {
            const files = event.target.files;
            if (files.length > 5) {
                alert("Bạn chỉ được phép đăng 5 hình ảnh cùng một lúc.");
                document.getElementsByName("btn_post")[0].disabled = true;
                return;
            }
            document.getElementsByName("btn_post")[0].disabled = false;
            selectedFiles = Array.from(files);
            image_list.innerHTML = '';

            selectedFiles.forEach(file => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    image_list.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
</body>

</html>