<?php require_once('./config.php') ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>
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
    background: rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    width: 100%;
    max-width: 500px;
    overflow: hidden;
  }

  .card-header {
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    text-align: center;
    padding: 15px;
    font-size: 1.5em;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
  }

  .card-body {
    padding: 20px 30px;
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



  .custom-file-label {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: #ccc;
    border-radius: 20px;
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
    color: #ddd;
  }

  #cimg {
    height: 100px;
    width: 100px;
    border-radius: 50%;
    object-fit: cover;
  }
</style>

<body class="">
  <div class="d-flex flex-column align-items-center justify-content-center w-100 h-100">
    <div class="card">
      <div class="card-header">
        Sign up
      </div>
      <div class="card-body">
        <form id="register-form" action="" method="post">
          <input type="hidden" name="id">
          <input type="hidden" name="type" value="2">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="firstname" class="control-label">First Name</label>
                <input type="text" class="form-control" required name="firstname" id="firstname"
                  placeholder="Enter your first name">
              </div>
              <div class="form-group">
                <label for="middlename" class="control-label">Middle Name</label>
                <input type="text" class="form-control" name="middlename" id="middlename"
                  placeholder="Enter your middle name">
              </div>
              <div class="form-group">
                <label for="lastname" class="control-label">Last Name</label>
                <input type="text" class="form-control" required name="lastname" id="lastname"
                  placeholder="Enter your last name">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="username" class="control-label">Username</label>
                <input type="text" class="form-control" required name="username" id="username"
                  placeholder="Choose a username">
              </div>
              <!-- <div class="form-group">
                <label for="email" class="control-label">Email</label>
                <input type="email" class="form-control" required name="email" id="email"
                  placeholder="Enter your email address">
              </div> -->
              <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <div class="input-group">
                  <input type="password" class="form-control" required name="password" id="password"
                    placeholder="Enter your password">
                  <button tabindex="-1" class="btn btn-outline-secondary pass_view" type="button"
                    style="border-radius:0 20px 20px 0 "><i class="fa fa-eye-slash"></i></button>
                </div>
              </div>
              <div class="form-group">
                <label for="cpassword" class="control-label">Confirm Password</label>
                <div class="input-group">
                  <input type="password" class="form-control" required id="cpassword"
                    placeholder="Confirm your password">
                  <button tabindex="-1" class="btn btn-outline-secondary pass_view" type="button"
                    style="border-radius:0 20px 20px 0"><i class="fa fa-eye-slash"></i></button>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group text-center">
            <label for="customFile" class="control-label">Avatar</label>
            <div class="custom-file">
              <input type="file" class="custom-file-input" id="customFile" name="img"
                onchange="displayImg(this, $(this))" accept="image/png, image/jpeg">
              <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
            <!-- <div class="mt-3">
              <img src="<?php echo validate_image('') ?>" alt="" id="cimg" class="img-thumbnail">
            </div> -->
          </div>
          <div class="form-group text-center">
            <button type="submit" class="btn btn-primary">Create Account</button>
          </div>
          <div class="text-center mt-3">
            <p>Already have an account? <a href="./login.php">Log in</a></p>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    function displayImg(input, _this) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
          $('#cimg').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
      } else {
        $('#cimg').attr('src', "<?php echo validate_image('') ?>");
      }
    }
    $(document).ready(function () {
      end_loader();
      $('.pass_view').click(function () {
        var input = $(this).siblings('input');
        var type = input.attr('type');
        if (type == 'password') {
          $(this).html('<i class="fa fa-eye"></i>');
          input.attr('type', 'text').focus();
        } else {
          $(this).html('<i class="fa fa-eye-slash"></i>');
          input.attr('type', 'password').focus();
        }
      });
      $('#register-form').submit(function (e) {
        e.preventDefault();
        var _this = $(this);
        var el = $('<div>');
        el.addClass('alert alert-danger err_msg');
        el.hide();
        $('.err_msg').remove();
        if ($('#password').val() != $('#cpassword').val()) {
          el.text('Password does not match');
          _this.prepend(el);
          el.show('slow');
          $('html, body').scrollTop(0);
          return false;
        }
        if (_this[0].checkValidity() == false) {
          _this[0].reportValidity();
          return false;
        }
        start_loader();
        $.ajax({
          url: _base_url_ + "classes/Users.php?f=registration",
          method: 'POST',
          data: new FormData($(this)[0]),
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
              location.href = ('./login.php');
            } else if (!!resp.msg) {
              el.html(resp.msg);
              el.show('slow');
              _this.prepend(el);
              $('html, body').scrollTop(0);
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