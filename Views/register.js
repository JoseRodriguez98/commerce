$(document).ready(function() {
    var funcion;
    verificar_sesion();
    
    function verificar_sesion() {
        funcion = 'verificar_sesion';
        $.post('../Controllers/UsuarioController.php', {funcion}, (response) => {
            if (response != '') {
                location.href = '../index.php';
            }
        }); // Añadido punto y coma
    }

    $.validator.setDefaults({
        submitHandler: function () {
           let username = $('#username').val();
           let pass = $('#pass').val();
           let nombres = $('#nombres').val();
           let apellidos = $('#apellidos').val();
           let rut = $('#rut').val();
           let email = $('#email').val();
           let telefono = $('#telefono').val();
           funcion = 'registrar_usuario';
           $.post('../Controllers/UsuarioController.php', {username, pass, nombres, apellidos, rut, email, telefono, funcion}, (response) => {
                if(response="success"){
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Se ha registrado correctamente",
                        showConfirmButton: false,
                        timer: 1900
                      }).then(function(){
                        $('#form-register').trigger("reset");
                        location.href = "../Views/login.php";
                      })
                }else{
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Hubo un conflicto al registrarse, intentelo de nuevo y si el problema persiste comuniquese con el área de sistemas",
                        
                      });

                }
        })
        }
      });

      jQuery.validator.addMethod('usuario_existente',
        function(value,element){
            let funcion = "verificar_usuario";
            let bandera;
            $.ajax({
                type: "POST",
                url: "../Controllers/UsuarioController.php",
                data: 'funcion='+funcion+'&&value='+value,
                async: false,
                success: function(response){
                    if(response == "success"){
                        bandera = false;
                
                    }else{
                        bandera = true;
                    }
                }
            })
        return bandera;
    
       },"*El usuario ya existe, intente con otro nombre de usuario");   
       
 
    jQuery.validator.addMethod('letras',
      function(value, element) {
        let variable = value.replace(/ /g, "");
        return /^[A-Za-z\s]+$/.test(variable);
      },
      "*Este campo solo acepta letras"
    );



      $('#form-register').validate({
        rules: {
          nombres: {
            required: true,
            letras: true
          },
          apellidos: {
            required: true,
            letras: true
          },
          username: {
            required: true,
            minlength: 7,
            maxlength: 20,
            usuario_existente: true
          },
          pass: {
            required: true,
            minlength: 8,
            maxlength: 20
          },
          pass_repeat: {
            required: true,
            equalTo: "#pass"
          },
          rut:{
            required: true,
            number: true,
            minlength: 8,
            maxlength: 9
          },
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
          telefono: {
            required: true,
            number: true,
            minlength: 8,
            maxlength: 8
          }
        },
        messages: {
          username: {
            required: "*Este campo es obligatorio",
            minlength: "*Su nombre de usuario debe tener al menos 7 caracteres",
            maxlength: "*Su nombre de usuario debe tener menos de 20 caracteres"
          },
          pass: {
            required: "*Este campo es obligatorio",
            minlength: "*Su contraseña debe tener al menos 8 caracteres",
            maxlength: "*Su contraseña debe tener menos de 20 caracteres"
          },
          pass_repeat: {
            required: "*Este campo es obligatorio",
            equalTo: "*Las contraseñas no coinciden"
          },
          nombres: {
            required: "*Este campo es obligatorio",
          },
          apellidos: {
            required: "*Este campo es obligatorio",
          },
          rut: {
            required: "*Este campo es obligatorio",
            number: "*Ingrese solo números",
            minlength: "*Su RUT debe tener al menos 8 caracteres",
            maxlength: "*Su RUT debe tener máximo 9 caracteres"
          },
          email: {
            required: "*Por favor ingrese un correo electrónico",
            email: "Por favor ingrese un correo electrónico válido"
          },
          password: {
            required: "Please provide a password",
            minlength: "Your password must be at least 5 characters long"
          },
          telefono: {
            required: "*Este campo es obligatorio",
            number: "*Ingrese solo números",
            minlength: "*Su telefono debe tener al menos 8 caracteres",
            maxlength: "*Su telefono debe tener máximo 8 caracteres"
          },
          terms: "*Por favor acepte los términos y condiciones"
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
          $(element).removeClass('is-valid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
          $(element).addClass('is-valid');
        }
      });
});