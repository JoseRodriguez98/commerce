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

  <link rel="stylesheet" href="../Util/Css/sweetalert2.min.css">

</head>
<div class="modal fade" id="terminos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="card card-success">
        <div class="card-header">
          <h1 class="card-title fs-5">Términos y condiciones</h1>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="card-body">
          * utilizaremos sus datos para generar publicidad de acuerdo a sus preferencias<br>
          * no compartiremos su información con terceros<br>
          * no almacenaremos su información en cookies<br>
         
        </div>
        <div class="card-footer">
          <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div>
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
              <div class="form-group">
                <label for="nombres">Nombres</label>
                <input type="text" name="nombres" class="form-control" id="nombres" placeholder="Ingrese su nombre">
              </div>
              <div class="form-group">
                <label for="rut">RUT</label>
                <input type="text" name="rut" class="form-control" id="rut" placeholder="Ingrese su RUT completo (sin puntos ni guión)">
              </div>
              <div class="form-group">
                <label for="telefono">Telefono</label>
                <input type="text" name="telefono" class="form-control" id="telefono" placeholder="Ingrese su telefono celular">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="pass_repeat">Repite la contraseña</label>
                <input type="password" name="pass_repeat" class="form-control" id="pass_repeat" placeholder="Confirme su contraseña">
              </div>
              <div class="form-group">
                <label for="apellidos">Apellidos</label>
                <input type="text" name="apellidos" class="form-control" id="apellidos" placeholder="Ingrese sus apellidos">
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" class="form-control" id="email" placeholder="Ingrese su email">
              </div>
            </div>
            <div class="col-sm-12">
              <div class="form-group mb-0">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" name="terms" class="custom-control-input" id="terms">
                  <label class="custom-control-label" for="terms">Estoy de acuerdo con los<a href="#" data-toggle="modal" data-target="#terminos"> Términos de servicio</a>.</label>
                </div>
              </div>
            </div>
          </div>
            
            <!-- /.card-body -->
            <div class="card-footer text-center ellow">
              <button type="submit" class="btn btn-lg bg-gradient-primary">Registrarme</button>
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

<script src="../Util/Js/sweetalert2.min.js"></script>

<script src="register.js"></script>


</body>
</html>

