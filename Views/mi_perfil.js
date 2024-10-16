$(document).ready(function() {
    var funcion;
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
            let direcciones = JSON.parse(response);
            let template = '';
            
        });
    }
    
    
    function verificar_sesion() {
        funcion = 'verificar_sesion';
        $.post('../Controllers/UsuarioController.php', {funcion}, (response) => {   
            console.log(response);
            if (response != '') {
                let sesion=JSON.parse(response);
                $('#nav_login').hide();
                $('#nav_register').hide();
                $('#usuario_nav').text(sesion.user + ' #'+sesion.id);
                $('#avatar_nav').attr('src', '../Util/Img/'+sesion.avatar);
                $('#avatar_menu').attr('src', '../Util/Img/'+sesion.avatar);
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
            $('#avatar_perfil').attr('src', '../Util/Img/' + usuario.avatar);
            $('#rut').text(usuario.rut);  
            $('#email').text(usuario.email);  
            $('#telefono').text(usuario.telefono);  
        }); // Añadido punto y coma$('#username').text(usuario.username);  
    }


}); // Añadido punto y coma y llave de cierre   

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