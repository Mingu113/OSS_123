<!doctype html>
<html lang="en">
<?php
session_start();
require "./config.php";
if (isset($_GET["id"]))
    $thread_id = $_GET["id"];
if (isset($_GET["post"]) && empty($_GET["page"])){
    $post_id = $_GET["post"];
    // Tính tổng số bài viết tới giới hạn = bài viết cần tìm
    $post_index = "SELECT COUNT(*) AS index_position
    FROM Posts
    WHERE thread_id = $thread_id AND post_id <= $post_id
    ORDER BY created_at ASC";
    $result_post_index = mysqli_query($conn, $post_index);
    $post_position = mysqli_fetch_assoc($result_post_index)['index_position'];

    // Số lượng threads mỗi trang
    $posts_per_page = 10;

    $page = ceil($post_position/$posts_per_page);
    header("Location: thread.php?id=".urlencode($thread_id)."&post=".urlencode($post_id)."&page=".urlencode($page)."");
    exit;
}elseif(isset($_GET["post"])){
    $post_id = $_GET["post"];
}
$user_id = $_SESSION["user_id"];
if (isset($user_id)) {
    $query_check = mysqli_query($conn, "SELECT is_banned FROM Users WHERE user_id = $user_id;");
    $user_is_banned = false;
    if ($result = $query_check->fetch_assoc()) {
        if ($result["is_banned"])
            $user_is_banned = true;
    }
}
// Function to upload image to posts
function uploadImages($image_files): ?string
{
    $uploadDirectory = './images/user_posts_img/';
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxFileSize = 2 * 1024 * 1024; // 2MB
    $totalFiles = count($image_files['name']);
    $post_images = [];
    for ($i = 0; $i < $totalFiles; $i++) {
        // Create unique name so the file won't have the same name (ko muon lam may cai lien quan den file nua)
        $fileName = uniqid(mt_rand(), true) . basename($image_files['name'][$i]);
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

        // Kiểm Tra các từ bị cấm từ file txt
        $file_banned_word = file('./list_banned_words.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $banned_word = false;
        foreach ($file_banned_word as $word) {
            $word = trim($word);
            if (stripos($post_content, $word) !== false) {
                $banned_word = $word;
                break;
            }
        }
        if ($banned_word) {
            echo "<script>
                    alert('Cảnh báo bài viết của bạn chứa từ cấm: \"$banned_word\". Hãy viết lại bài viết mới');
                    window.location.href = './thread.php?id=" . urlencode($thread_id) . "';
                  </script>";
            exit;
        } else {
            $user_id = $_SESSION["user_id"];
            $query = "INSERT INTO Posts (thread_id, user_id, content, created_at, post_images, reply_to) VALUES (?, ?, ?, NOW(), ?, ?) ;";
            $query_notify = "INSERT INTO Notifications (user_id, content, is_read, link, created_at) VALUES (?, ?, '0', ?, NOW()) ;";

            //
            $file = $_FILES["file_upload"];
            if ($file['error'][0] == UPLOAD_ERR_OK)
                $post_images = uploadImages($_FILES["file_upload"]);
            else
                $post_images = null;
            //

            if (!empty($_POST['reply_to'])) {
                $reply_to = $_POST['reply_to'];
                $notify_reply = "Có người đã trả lời bình luận của bạn";
            } else
                $reply_to = null;
            //
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iissi", $thread_id, $user_id, $post_content, $post_images, $reply_to);
            $update_thread_query = $conn->prepare("UPDATE `Threads` SET `newest_post_at` = NOW() WHERE `Threads`.`thread_id` = ?");
            $update_thread_query->bind_param("i", $thread_id);

            if ($stmt->execute()) {
                $update_thread_query->execute();
                // self reply will not create notification
                if ($reply_to != null && $_POST['replied_user_id'] != $user_id) {
                    $notify = $conn->prepare($query_notify);
                    $notify->bind_param("iss", $_POST["replied_user_id"], $notify_reply, $_POST['link']);
                    $notify->execute();
                }
                header("HTTP/1.1 303 See Other");
                $current_uri = $_SERVER["REQUEST_URI"];
                echo $current_uri;
                header("Location: $current_uri");
                // currently not working
                // Move the old place
                echo '<script>
                window.onload = function() {
                    const targetElement = document.getElementById("new-post");
                    targetElement.scrollIntoView({ behavior: "smooth" });
                };
                </script>';
            }
        }
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
   p.thread_id, u.username, p.post_id, p.content, p.post_images, p.created_at, p.reply_to, u.user_id, u.profile_pic, u.major, t.title as title, u.role, u.is_banned, u2.username AS reply_to_user
   FROM Posts p
   JOIN Users u ON u.user_id = p.user_id
   JOIN Threads t ON t.thread_id = p.thread_id
   LEFT JOIN Posts p2 ON p.reply_to = p2.post_id
   LEFT JOIN Users u2 ON p2.user_id = u2.user_id
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
            targetElement.classList.add("highlight");
            targetElement.scrollIntoView({ behavior: "smooth", block: "center" });
        };
        </script>';
    }
    // Tính tổng số trang
    $total_pages = ceil($total_post / $posts_per_page);
} else
    $thread_title = "Không có Thread";
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

        .highlight {
            animation: 2s highlight normal;
            border: 2px solid orangered;
        }

        @keyframes highlight {
            50% {
                border: 2px solid transparent;
            }

            100% {
                border: 2px solid orangered;
            }
        }
    </style>
</head>

<body>
    <?php session_abort();
    require("./header.php"); ?>
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
                                <a href="viewuser.php?user_id=<?php echo $post['user_id']; ?>">
                                    <img src="<?php echo ($post['profile_pic'] && realpath($post['profile_pic'])) == null ? "./images/default.jpg" : $post["profile_pic"]; ?>"
                                        alt="User avatar" style="width: 50px; height: 50px; border-radius: 50%;">
                                    <div class="post-username"><?php echo htmlspecialchars($post['username']); ?></div>
                                </a>
                                <?php if ($post["role"] != "user"): ?>
                                    <p class="user-role"><small><span
                                                style="color: green;"><?php echo $post["role"]; ?></small></span></p>
                                <?php else: ?>
                                    <p class="user-role"><small><span
                                                style="color: black;"><?php echo $post["role"]; ?></small></span></p>
                                <?php endif; ?>
                            </div>
                            <div class="post-content">
                                <!-- Reply to user  -->
                                <?php if ($post["reply_to"] != null): ?>
                                    <a href=" " id="reply_to_<?php echo $post['reply_to']; ?>"
                                        onclick="goToReply(<?php echo $post['reply_to']; ?>)">Đang trả lời:
                                        <?php echo $post['reply_to_user']; ?></a>
                                <?php endif; ?>
                                <!--  -->
                                <p><?php echo nl2br(stripcslashes($post['content'])); ?></p>
                                <p class="post-meta">Thời gian: <strong><?php echo $post['created_at']; ?></strong></p>
                                <div>
                                    <button type="button"
                                        onclick="setReplyTo(<?php echo $post['post_id']; ?>, '<?php echo $post['username']; ?>', <?php echo $post['user_id']; ?>)">Reply</button>
                                </div>
                                <?php if ($post["is_banned"] == 1): ?>
                                    <p><span style="color: red;"><small>Người dùng này đã bị ban</small></span></p>
                                <?php endif; ?>
                                <?php if (!empty($post['post_images'])): ?>
                                    <?php
                                    $post_images_list = explode(",", $post["post_images"]);
                                    ?>
                                    <div class="image_list">
                                        <?php foreach ($post_images_list as $image): ?>
                                            <a href="<?php echo $image; ?>" target="_blank" rel="noopener noreferrer"><img
                                                    src="<?php echo $image; ?>" alt="<?php echo "Ảnh của" . $post["username"] ?>"></a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
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
                            <input readonly type="hidden" name="reply_to" id="reply_to" value="">
                            <input type="hidden" name="replied_user_id" id="replied_user_id">
                            <input type="hidden" name="link" value="<?php echo $_SERVER['REQUEST_URI'] ?>">
                            <div><b>
                                    <p id="reply_to_user"></p><button id="cancel_reply" style="display: none;"
                                        onclick="stopReply()">Hủy</button>
                                </b></div>
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
                        <img align="center" src="./images/not_found.gif" alt="Image" width="60%">
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
    <script>
        function setReplyTo(post_id, username, replied_user_id) {
            document.getElementById("cancel_reply").style.display = "block";
            document.getElementById("reply_to").value = post_id;
            document.getElementById("replied_user_id").value = replied_user_id;
            document.getElementById("reply_to_user").innerText = "Đang trả lời " + username;
        }
        function stopReply() {
            document.getElementById("reply_to").value = null;
            document.getElementById("reply_to_user").innerText = "";
            document.getElementById("cancel_reply").style.display = "none";
        }
        function goToReply(post_id) {
            var reply_post = document.getElementById(post_id);
            var link = "./thread.php?id=<?php echo $thread_id; ?>";
            var id = "reply_to_" + post_id;
            if (reply_post == null) {
                // post reply is in another page
                link = link + "&post=" + post_id;
                document.getElementById(id).setAttribute('href', link);
            } else {
                document.getElementById(id).setAttribute('href', '#' + post_id);
                reply_post.scrollIntoView({ behavior: "smooth" });
            }
        }
    </script>
</body>

</html>