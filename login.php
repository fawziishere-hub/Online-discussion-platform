<?php require_once('./config.php') ?>
<?php require_once('inc/sess_auth.php') ?>
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

    .login-box {
      width: 360px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 20px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
      padding: 20px 30px;
    }

    .login-box-msg {
      color: #fff;
      font-size: 1.1em;
      text-align: center;
      margin-bottom: 20px;
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

    #remember-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: 15px 0;
    }

    #remember-container a {
      color: #ccc;
      font-size: 0.9em;
    }
  </style>

  <div class="login-box">
    <div class="login-box-msg">Sign in to your account</div>
    <form id="ulogin-form" action="" method="post">
      <div class="input-group mb-3">
        <input type="text" class="form-control" name="username" placeholder="Username" required>
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-user"></span>
          </div>
        </div>
      </div>
      <div class="input-group mb-3">
        <input type="password" class="form-control" name="password" placeholder="Password" required>
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fas fa-lock"></span>
          </div>
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Login to your account</button>
      <div class="text-center mt-3">
        <p>New here? <a href="<?php echo base_url ?>register.php">Sign up</a></p>
      </div>
    </form>
  </div>

  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>

  <script>
    $(document).ready(function () {
      end_loader();
      $('#ulogin-form').submit(function (e) {
        e.preventDefault();
        var _this = $(this);
        var el = $('<div>');
        el.addClass('alert alert-danger err_msg');
        el.hide();
        $('.err_msg').remove();
        if (_this[0].checkValidity() == false) {
          _this[0].reportValidity();
          return false;
        }
        start_loader();
        $.ajax({
          url: _base_url_ + "classes/Login.php?f=login_user", // Backend URL
          method: 'POST',
          data: new FormData(_this[0]),
          dataType: 'json',
          cache: false,
          processData: false,
          contentType: false,
          error: err => {
            console.log(err);
            alert('An error occurred');
            end_loader();
          },
          success: function (resp) {
            if (resp.status == 'success') {
              location.href = './';
            } else if (!!resp.msg) {
              el.html(resp.msg);
              el.show('slow');
              _this.prepend(el);
            } else {
              alert('An error occurred');
              console.log(resp);
            }
            end_loader();
          }
        });
      });
    });
  </script>
</body>

</html>