$(document).ready(function() {
    var funcion;
    bsCustomFileInput.init();
    verificar_sesion();
    obtener_datos();
    llenar_regiones();
    llenar_direcciones();
    console.log("Inicializando Select2")
    $('#region').select2({
        placeholder: 'Seleccione una región',
        language: {
            noResults: function(){
                return "No hay resultado";
            },
            searching: function(){
                return "Buscando...";
            }
        }
    });
    $('#provincia').select2({
        placeholder: 'Seleccione una provincia',
        language: {
            noResults: function(){
                return "No hay resultado";
            },
            searching: function(){
                return "Buscando...";
            }
        }
    });
    $('#comuna').select2({
        placeholder: 'Seleccione una comuna',
        language: {
            noResults: function(){
                return "No hay resultado";
            },
            searching: function(){
                return "Buscando...";
            }
        }
    });

    function llenar_direcciones() {
        funcion = "llenar_direcciones";
        $.post('../Controllers/UsuarioComunaController.php', {funcion}, (response) => {
            let contador = 0;
            let direcciones = JSON.parse(response);
            let template = '';
            direcciones.forEach(direccion=> {
                contador++;
                template += `
                    <div class="callout callout-info">
                        <div class="card-header">
                            <strong>
                                Direccion ${contador}
                            </strong>
                            <div class="card-tools">
                                <button dir_id="${direccion.id}" type="button" class="eliminar_direccion btn btn-tool">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <h2 class="lead"><b>${direccion.direccion}</b></h2>
                            <p class="text-muted text-sm"><b>Referencia: ${direccion.referencia} </p>
                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span> 
                                ${direccion.comuna} - ${direccion.provincia} - ${direccion.region}
                                </li>
                            </ul>
                        </div>
                    </div> 
                        `;
            });
            $('#direcciones').html(template);

        });
    }

    $(document).on('click', '.eliminar_direccion', (e) => {
        let elemento = $(this)[0].activeElement;
        let id = $(elemento).attr('dir_id');
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: "btn btn-success m-3",
              cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
          });
          swalWithBootstrapButtons.fire({
            title: "¿Desea borrar esta dirección?",
            text: "Su dirección desaparecerá si confirma!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Eliminar dirección!",
            cancelButtonText: "Cancelar",
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
              funcion = "eliminar_direccion";
              $.post('../Controllers/UsuarioComunaController.php', {funcion,id}, (response) => {
                    if(response=='success'){      
                        swalWithBootstrapButtons.fire({
                        title: "Dirección eliminada!",
                        text: "Tu dirección se borró con exito.",
                        icon: "success"
                        });
                        llenar_direcciones();

                    }else if(response=='error'){
                        swalWithBootstrapButtons.fire({
                        title: "No se borró",
                        text: "Hubo alteracion en la integridad de datos",
                        icon: "error"
                        });
              
                    }else{
                        swalWithBootstrapButtons.fire({
                        title: "No se ha borrado!",
                        text: "Tenemos problemas en el sistema",
                        icon: "error"
                        });

                    }
            });
           
            } else if (result.dismiss === Swal.DismissReason.cancel) {
              
            }
          });
    })  
    



    function verificar_sesion() {
        funcion = 'verificar_sesion';
        $.post('../Controllers/UsuarioController.php', {funcion}, (response) => {   
            console.log(response);
            if (response != '') {
                let sesion=JSON.parse(response);
                $('#nav_login').hide();
                $('#nav_register').hide();
                $('#usuario_nav').text(sesion.user + ' #'+sesion.id);
                $('#avatar_nav').attr('src', '../Util/Img/Users/'+sesion.avatar);
                $('#avatar_menu').attr('src', '../Util/Img/Users/'+sesion.avatar);
                $('#usuario_menu').text(sesion.user);
                
            }
            else{
                $('#nav_usuario').hide();
                location.href = 'login.php';
            }
        }); // Añadido punto y coma
    }

    function obtener_datos() {
        funcion = 'obtener_datos';
        $.post('../Controllers/UsuarioController.php', {funcion}, (response) => {   
            let usuario = JSON.parse(response);
            $('#username').text(usuario.username);  
            $('#tipo_usuario').text(usuario.tipo_usuario);  
            $('#nombres').text(usuario.nombres+' '+usuario.apellidos);  
            $('#avatar_perfil').attr('src', '../Util/Img/Users/' + usuario.avatar);
            $('#rut').text(usuario.rut);  
            $('#email').text(usuario.email);  
            $('#telefono').text(usuario.telefono);  
        }); // Añadido punto y coma$('#username').text(usuario.username);  
    }




    function llenar_regiones() {
        funcion = "llenar_regiones";
        $.post('../Controllers/RegionController.php', {funcion}, (response) => {
            let regiones = JSON.parse(response);
            let template = '';
            regiones.forEach(region=>{
                template += `<option value="${region.id}">${region.region}</option>`;
            });
            $('#region').html(template);
            $('#region').val('').trigger('change');
        });
    }
    $('#region').change(function() {
        let region_id = $(this).val();  
        funcion = "llenar_provincias";
        $.post('../Controllers/ProvinciaController.php', {funcion, region_id}, (response) => {
            let provincias = JSON.parse(response);
            let template = '';
            provincias.forEach(provincia=>{
                template += `<option value="${provincia.id}">${provincia.provincia}</option>`;
                    
            });
            $('#provincia').html(template);    
            $('#provincia').val('').trigger('change');
            
        })
    })
    $('#provincia').change(function() {
        let provincia_id = $(this).val();  
        funcion = "llenar_comunas";
        $.post('../Controllers/ComunaController.php', {funcion, provincia_id}, (response) => {
            let comunas = JSON.parse(response);
            let template = '';
            comunas.forEach(comuna=>{
                template += `<option value="${comuna.id}">${comuna.comuna}</option>`;
                    
            });
            $('#comuna').html(template);        
    })
    });


    $('#form-direccion').submit(e => {
        funcion = 'crear_direccion';
        let comuna_id = $('#comuna').val();
        let direccion = $('#direccion').val();
        let referencia = $('#referencia').val();
        $.post('../Controllers/UsuarioComunaController.php', {comuna_id, direccion, referencia, funcion}, (response) => {
            if (response=='success') {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Se ha registrado su dirección correctamente",
                    showConfirmButton: false,
                    timer: 1900
                  }).then(function(){
                    $('#form-direccion').trigger("reset");
                    $('#region').val('').trigger('change');
                    
                  })
            }else{
                Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Hubo un conflicto al crear la dirección, intentelo más tarde",
                        
                      });
            }
        });

        e.preventDefault();

    });

    $(document).on('click', '.editar_datos', (e) => {
        funcion = 'obtener_datos';
        $.post('../Controllers/UsuarioController.php', {funcion}, (response) => {   
            let usuario = JSON.parse(response); 
            $('#nombres_mod').val(usuario.nombres);
            $('#apellidos_mod').val(usuario.apellidos);
            $('#rut_mod').val(usuario.rut);
            $('#email_mod').val(usuario.email);
            $('#telefono_mod').val(usuario.telefono);
        });
        
    });

    $.validator.setDefaults({
        submitHandler: function () {
            funcion="editar_datos";
            let datos = new FormData($('#form-datos')[0]);
            datos.append('funcion', funcion);
            $.ajax({
                type: "POST",
                url: "../Controllers/UsuarioController.php",
                data: datos,
                cache: false,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response);
                    if(response="success"){
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "Se han editado sus datos correctamente",
                            showConfirmButton: false,
                            timer: 1900
                          }).then(function(){
                                verificar_sesion();
                                obtener_datos();
                          })

                    }else{
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Hubo un conflicto al editar sus datos",
                            
                          });

                    }
                    
                }
            })
        }
      });

    jQuery.validator.addMethod('letras',
        function(value, element) {
            let variable = value.replace(/ /g, "");
          return /^[A-Za-z\s]+$/.test(variable);
        },
        "*Este campo solo acepta letras"
      );
        $('#form-datos').validate({
          rules: {
            nombres_mod: {
              required: true,
              letras: true
            },
            apellidos_mod: {
              required: true,
              letras: true
            },
            rut_mod:{
              required: true,
              number: true,
              minlength: 8,
              maxlength: 9
            },
            email_mod: {
              required: true,
              email: true,
            },
            telefono_mod: {
              required: true,
              number: true,
              minlength: 8,
              maxlength: 8
            }
          },
          messages: {
            
            nombres_mod: {
              required: "*Este campo es obligatorio",
            },
            apellidos_mod: {
              required: "*Este campo es obligatorio",
            },
            rut_mod: {
              required: "*Este campo es obligatorio",
              number: "*Ingrese solo números",
              minlength: "*Su RUT debe tener al menos 8 caracteres",
              maxlength: "*Su RUT debe tener máximo 9 caracteres"
            },
            email_mod: {
              required: "*Por favor ingrese un correo electrónico",
              email: "Por favor ingrese un correo electrónico válido"
            },
            telefono_mod: {
              required: "*Este campo es obligatorio",
              number: "*Ingrese solo números",
              minlength: "*Su telefono debe tener al menos 8 caracteres",
              maxlength: "*Su telefono debe tener máximo 8 caracteres"
            },
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

        
    


}); // Añadido punto y coma y llave de cierre   