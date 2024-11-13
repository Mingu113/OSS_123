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
          <form action="../../Code/authentication/register.php" method="post">
            <div class="divider">
              <p id="title_1" class="text-center fw-bold">NTUCHAN REGISTER</p>
            </div>
            <div class="divider d-flex align-items-center my-4">
              <p class="text-center fw-bold mx-3 mb-0">
                <a href="home.php"><img class="logo" src="images/Logo_NTU.png" alt=""></a>
              </p>
            </div>

            <!-- Username input -->
            <div data-mdb-input-init class="form-outline mb-4">
              <label class="form-label font-weight-bold" for="form3Example3">Username <span
                  class="text-danger">*</span></label>
              <input name="username" required type="text" id="form3Example3" class="form-control form-control-lg"
                placeholder="Nhập tài khoản" />
            </div>

            <div data-mdb-input-init class="form-outline mb-4">
              <label class="form-label font-weight-bold" for="form3Example3">Email</label>
              <input type="email" id="form3Example3" class="form-control form-control-lg" placeholder="Nhập email" />
            </div>

            <!-- Password input -->
            <div data-mdb-input-init class="form-outline mb-3">
              <label class="form-label font-weight-bold" for="form3Example4">Password <span
                  class="text-danger">*</span></label>
              <input type="password" required name="password" id="form3Example4" class="form-control form-control-lg"
                placeholder="Nhập mật khẩu" />
            </div>

            <div data-mdb-input-init class="form-outline mb-3">
              <label class="form-label font-weight-bold" for="form3Example4">Confirm Password <span
                  class="text-danger">*</span></label>
              <input type="password" required name="password-check" id="form3Example4" class="form-control form-control-lg"
                placeholder="Nhập lại mật khẩu" />
            </div>


            <div class="text-center text-lg-start mt-4 pt-2">
              <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg"
                style="padding-left: 2.5rem; padding-right: 2.5rem;">Đăng kí</button>
              <p class="small fw-bold mt-2 pt-1 mb-0">Trở về đăng nhập <a href="login.php" class="link-danger">Login</a>
              </p>
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