<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register | CarPerformance</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <link rel="stylesheet" href="../Util/Css/css/all.min.css">
  
  <link rel="stylesheet" href="../Util/Css/adminlte.min.css">

  <link rel="stylesheet" href="../Util/Css/toastr.min.css">

</head>
<body class="hold-transition login-page">
<div class="mt-5">
  <div class="login-logo">
    <img src="../Util/Img/logo.png" class="profile-user-img img-fluid img-circle">
    <a href="../index.php"><b>Car</b>Performance</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Registrate aquí</p>

        <form id="form-register">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" name="username" class="form-control" id="username" placeholder="Ingrese su nombre de usuario">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="pass">Contraseña</label>
                <input type="password" name="pass" class="form-control" id="pass" placeholder="Ingrese su contraseña">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="pass_repeat">Repite la contraseña</label>
                <input type="password" name="pass_repeat" class="form-control" id="pass_repeat" placeholder="Confirme su contraseña">
              </div>
            </div>
          </div>
            <div class="card-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
              </div>
              <div class="form-group mb-0">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="terms" class="custom-control-input" id="exampleCheck1">
                  <label class="custom-control-label" for="exampleCheck1">I agree to the <a href="#">terms of service</a>.</label>
                </div>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>

      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../Util/Js/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../Util/Js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../Util/js/adminlte.min.js"></script>

<script src="../Util/Js/toastr.min.js"></script>

<script src="../Util/Js/jquery.validate.min.js"></script>

<script src="../Util/Js/additional-methods.min.js"></script>

<script src="register.js"></script>
</body>
</html>

<script>
$(function () {
  $.validator.setDefaults({
    submitHandler: function () {
      alert( "Form successful submitted!" );
    }
  });
  $('#form-register').validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
        minlength: 5
      },
      terms: {
        required: true
      },
    },
    messages: {
      email: {
        required: "Please enter a email address",
        email: "Please enter a vaild email address"
      },
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long"
      },
      terms: "Please accept our terms"
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>