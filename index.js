$(document).ready(function() {
    var funcion;
    verificar_sesion();
    llenar_productos();
    
    function verificar_sesion() {
        funcion = 'verificar_sesion';
        $.post('Controllers/UsuarioController.php', {funcion}, (response) => {   
            console.log(response);
            if (response != '') {
                let sesion=JSON.parse(response);
                $('#nav_login').hide();
                $('#nav_register').hide();
                $('#usuario_nav').text(sesion.user + ' #'+sesion.id);
                $('#avatar_nav').attr('src', 'Util/Img/Users/'+sesion.avatar);
                $('#avatar_menu').attr('src', 'Util/Img/Users/'+sesion.avatar);
                $('#usuario_menu').text(sesion.user);
                
            }
            else{
                $('#nav_usuario').hide();
            }
        }); // Añadido punto y coma
    }

    async function llenar_productos() {
        funcion = "llenar_productos";
        let data = await fetch('Controllers/ProductoTiendaController.php',{
            method: 'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body: 'funcion='+funcion
        } )
        if(data.ok){
            let response = await data.text();
            //console.log(response);
            try {
                let productos = JSON.parse(response);
                console.log(productos);
                
            } catch (error) {
                console.error(error);
                console.log(response);

            }
            

        }else{
            Swal.fire({
                icon: 'error',
                title: data.statusText,
                text: 'Hubo un conflicto de código: '+data.status,
                
              });

        }
    }

}); // Añadido punto y coma y llave de cierre   