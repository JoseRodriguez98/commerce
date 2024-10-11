$(document).ready(function() {
    var funcion;
    verificar_sesion();
    obtener_datos();
    
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