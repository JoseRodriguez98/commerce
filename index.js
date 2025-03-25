$(document).ready(function() {
    moment.locale('es');
    var funcion;
    verificar_sesion();
    llenar_productos();

    async function read_notificaciones() {
        funcion = 'read_notificaciones';
        let data = await fetch('Controllers/NotificacionController.php',{
            method: 'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body: 'funcion=' + funcion       
        } )
        if(data.ok){
            let response = await data.text();
            //console.log(response);
            try {
                let notificaciones = JSON.parse(response);
                console.log(notificaciones);
                let template1 = '';
                let template2 = ''; 
                if(notificaciones.length==0){
                    template1 += 
                    `
                    <i class="far fa-bell"></i>

                    `;
                    template2 += 
                    `
                    Notificaciones

                    `;
                }else{
                    template1 += 
                    `
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">${notificaciones.length}</span>

                    `;
                    template2 += 
                    `
                    Notificaciones <span class="badge badge-warning right">${notificaciones.length}</span>

                    `;
                }
                $('#numero_notificacion').html(template1);
                $('#nav_cont_noti').html(template2);    
                let template = '';
                if (notificaciones.length === 1) {
                    template += 
                        `
                        <span class="dropdown-item dropdown-header">1 Notificación</span>
                        `;
                } else {
                    template += 
                        `
                        <span class="dropdown-item dropdown-header">${notificaciones.length} Notificaciones</span>
                        `;
                }
                notificaciones.forEach(notificacion => {
                    let fecha = moment(notificacion.fecha+' '+notificacion.hora, 'DD/MM/YYYY HH:mm:ss');
                    let horas = moment(notificacion.hora, 'HH:mm:ss');
                    let fecha_hora;
                    if(notificacion.hoy=='1'){
                        fecha_hora = horas.fromNow();
                    }else{
                        fecha_hora = fecha.format('LLL');
                    }
                    template += 
                        `
                        <div class="dropdown-divider"></div>
                            <a href="${notificacion.url_1}&&noti=${notificacion.id}" class="dropdown-item">
                                <div class="media">
                                    <img src="Util/Img/Producto/${notificacion.imagen}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            ${notificacion.titulo}
                                        </h3>
                                        <p class="text-sm">${notificacion.asunto}</p>
                                        <p class="text-sm text-muted">${notificacion.contenido}</p>
                                        <span class="float-right text-muted text-sm">${fecha_hora}</span>
                                    </div>
                                </div>
                            </a>
                        <div class="dropdown-divider"></div>
                        `;
                });
                template += 
                        `
                        <a href="Views/notificaciones.php" class="dropdown-item dropdown-footer">Ver todas las notificaciones</a>
                        `;
                $('#notificaciones').html(template);    
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

    async function read_favoritos() {
        funcion = 'read_favoritos';
        let data = await fetch('Controllers/FavoritoController.php',{
            method: 'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body: 'funcion=' + funcion 
        } )
        if(data.ok){
            let response = await data.text();
            //console.log(response);
            try {
                let favoritos = JSON.parse(response);
                console.log(favoritos);
                let template1 = '';
                let template2 = ''; 
                if(favoritos.length==0){
                    template1 += 
                    `
                    <i class="far fa-heart"></i>

                    `;
                    template2 += 
                    `
                    Favoritos

                    `;
                }else{
                    template1 += 
                    `
                        <i class="far fa-heart"></i>
                        <span class="badge badge-warning navbar-badge">${favoritos.length}</span>

                    `;
                    template2 += 
                    `
                    Favoritos <span class="badge badge-warning right">${favoritos.length}</span>

                    `;
                }
                $('#numero_favorito').html(template1);
                $('#nav_cont_fav').html(template2);
                let template = '';
                if (notificaciones.length === 1) {
                    template += 
                        `
                        <span class="dropdown-item dropdown-header">1 Notificación</span>
                        `;
                } else {
                    template += 
                        `
                        <span class="dropdown-item dropdown-header">${favoritos.length} Favoritos</span>
                        `;
                }
                favoritos.forEach(favorito => {
                    

                    template += 
                        `
                        <div class="dropdown-divider"></div>
                            <a href="${favorito.url}" class="dropdown-item">
                                <div class="media">
                                    <img src="Util/Img/Producto/${favorito.imagen}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            ${favorito.titulo}
                                        </h3>
                                        
                                        <p class="text-sm text-muted">${favorito.precio}</p>
                                        <span class="float-right text-muted text-sm">${favorito.fecha_creacion}</span>
                                    </div>
                                </div>
                            </a>
                        <div class="dropdown-divider"></div>
                        `;
                });
                template += 
                        `
                        <a href="Views/favoritos.php" class="dropdown-item dropdown-footer">Ver todos tus favoritos</a>    
                        `;
                $('#favoritos').html(template);    
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
                read_notificaciones();
                $('#notificacion').show();
                $('#nav_notificaciones').show();
                read_favoritos();
                $('#favorito').show();
                $('#nav_favorito').show();
            }
            else{
                $('#nav_usuario').hide();
                $('#notificacion').hide();
                $('#nav_notificaciones').hide();
                $('#favorito').hide();
                $('#nav_favoritos').hide();
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