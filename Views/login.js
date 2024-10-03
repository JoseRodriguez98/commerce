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

    $('#form-login').submit(e => {
        funcion = 'login';
        let user = $('#user').val();
        let pass = $('#pass').val();
        $.post('../Controllers/UsuarioController.php', {user, pass, funcion}, (response) => {
            if (response == 'logueado') {
                toastr.success('Bienvenido!');

                // Insertar un retraso de 1.7 segundos
                setTimeout(() => {
                    location.href = '../index.php';
                }, 1500);

            } else {
                toastr.error('Credenciales incorrectas');
            }
        });

        e.preventDefault();
    });
}); // Añadido punto y coma y llave de cierre