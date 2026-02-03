<?php require_once('../config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>

<body class="hold-transition login-page">
  <script>
    start_loader()
  </script>
  <style>
    body {
      background: linear-gradient(135deg, #222831, #DDDDDD);
      color: #ffffff;
      font-family: 'Arial', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .card {
      width: 360px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 20px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
      padding: 20px 30px;
    }

    .login-box-msg {
      color: #ddd;
      font-size: 1.1em;
      text-align: center;
      margin-bottom: 20px;
      border-radius: 20px;
    }


    .form-control {
      background: rgba(255, 255, 255, 0.2);
      border: none;
      color: #fff;
      border-radius: 20px;
      padding: 10px;
    }

    .form-control::placeholder {
      color: #ccc;
    }

    .input-group-text {
      background: rgba(255, 255, 255, 0.2);
      border: none;
      color: #fff;
      border-radius: 0 20px 20px 0;
    }



    .btn-primary {
      background-color: #F05454;
      border: none;
      width: 100%;
      border-radius: 20px;
      padding: 10px;
      font-size: 1em;
      margin-left: 80px;
    }

    .btn-primary:hover {
      background-color: rgb(48, 71, 94);
    }

    .text-center a {
      color: #fff;
      text-decoration: underline;
    }

    .text-center a:hover {
      color: #DDDDDD;
    }
  </style>
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-navy my-2">
      <div class="card-body">
        <p class="login-box-msg">Sign in to your account
        </p>
        <form id="login-frm" action="" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="username" autofocus placeholder="Username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <!-- <div class="row">
            <div class="col-8">
              <a href="<?php echo base_url ?>">Go to Website</a>
            </div> -->
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
      </div>
      </form>
      <!-- /.social-auth-links -->

      <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p> -->

    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>

  <script>
    $(document).ready(function () {
      end_loader();
    })
  </script>
</body>

</html>