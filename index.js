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
                //console.log(productos);
                let template = ``;
                productos.forEach(producto => {
                    template +=`
                    <div class="col-sm-2">
                        <div class="card">
                        <div class="card-body">
                            <div class="row">
                            <div class="col-sm-12">
                                <img src="Util/Img/Producto/${producto.imagen}" class="img-fluid" alt="">
                            </div>
                            <div class="col-sm-12">
                                <span class="text-muted float-left">${producto.marca}</span></br>
                                <a class="titulo_producto" href="Views/descripcion.php?name=${producto.producto}&&id=${producto.id}">${producto.producto}</a>`;
                    if(producto.envio == 'gratis'){
                        template += `</br>`;
                        template += `<span class="badge bg-success">Envio gratis</span>`;
                        
                    }
                    if(producto.calificacion!=0){
                        template += `</br>`;
                        for (let index = 0; index < producto.calificacion   ; index++) {
                            template += `<i class="fas fa-star text-warning"></i>`;
                        }
                        let estrellas_faltantes = 5 - producto.calificacion;
                        for (let index = 0; index < estrellas_faltantes   ; index++) {
                            template += `<i class="far  fa-star text-warning"></i>`;
                        }
                        template += `</br>`;
                    }
                    if(producto.descuento!=0){
                        template += `
                            <span class="text-muted" style="text-decoration: line-through">$${producto.precio}</span>
                            <span class="text-muted">-${producto.descuento}%</span></br>
                            `;
                    }
                        template += `       
                                        
                                        <h4 class="text-danger">$${producto.precio_descuento}</h4>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>`
                });
                $('#productos').html(template);


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