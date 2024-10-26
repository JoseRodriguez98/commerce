$(document).ready(function() {
    moment.locale('es');
    verificar_sesion();
    verificar_producto();
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
            }
        }); // Añadido punto y coma
    }

    async function verificar_producto() {
        funcion = 'verificar_producto';
        let data = await fetch('../Controllers/ProductoTiendaController.php',{
            method: 'POST',
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body: 'funcion='+funcion
        } )
        if(data.ok){
            let response = await data.text();
            //console.log(response);
            try {
                let producto = JSON.parse(response);
                console.log(producto);
                template = '';
                if(producto.imagenes.length>0){

                    template +=`
                        <div class="col-12">
                            <img id="imagen_principal" src="../Util/Img/Producto/${producto.imagenes[0].nombre}" class="img-fluid" alt="">
                        </div>
                        <div class="col-12 product-image-thumbs">
                        `;
                        producto.imagenes.forEach(imagen => {
                            template +=`
                                <button prod_img="${imagen.nombre}" class="imagen_pasarelas product-image-thumb">
                                    <img src="../Util/Img/Producto/${imagen.nombre}" class="img-fluid"
                                </button>
                            
                            `;
                        });
                    template +=`</div>`;

                }else{
                    template +=`
                        <div class="col-12">
                            <img id="imagen_principal" src="../Util/Img/Producto/${producto.imagen}" class="product-image img-fluid" alt="">
                        </div>
                        `;
                }
                $('#imagenes').html(template);
                $('#producto').text(producto.producto);
                $('#marca').text('Marca: '+producto.marca);
                $('#sku').text('SKU: '+producto.sku);
                let template1 = ''; 
                if(producto.calificacion!=0){
                    //template1 += `</br>`;
                    for (let index = 0; index < producto.calificacion   ; index++) {
                        template1 += `<i class="fas fa-star text-warning"></i>`;
                    }
                    let estrellas_faltantes = 5 - producto.calificacion;
                    for (let index = 0; index < estrellas_faltantes   ; index++) {
                        template1 += `<i class="far  fa-star text-warning"></i>`;
                    }
                    template1 += `</br>`;
                }
                if(producto.descuento!=0){
                    template1 += `
                        <span class="text-muted" style="text-decoration: line-through">$${producto.precio}</span>
                        <span class="text-muted">-${producto.descuento}%</span></br>
                        `;
                }
                template1 += `<h4 class="text-danger">$${producto.precio_descuento}</h4>`;
                $('#informacion_precios').html(template1);
                let template2 = '';
                if(producto.envio == 'gratis'){
                    template2 += `<i class="fas fa-truck-moving text-danger"></i>
                                <span class="ml-1"> Envío: </span>
                                <span class="badge bg-success">Envío gratis</span>`;     
                }
                else{
                    template2 += `<i class="fas fa-truck-moving text-danger"></i>
                                <span class="ml-1"> Envío: </span>
                                <span class="mr-1"> $3.000</span>`;
                    
                }
                template2 += `</br>`;
                template2 += `<i class="fas fa-store text-danger"></i>
                              <span class="ml-1"> Recógelo en: ${producto.direccion_tienda}</span>`;
                $('#informacion_envio').html(template2);
                $('#nombre_tienda').text(producto.tienda);
                $('#numero_resenas').text(producto.numero_resenas+' reseñas');
                $('#promedio_calificacion_tienda').text(producto.promedio_calificacion_tienda);
                $('#product-desc').text(producto.detalles);
                let template3 = '';
                let cont = 0;
                producto.caracteristicas.forEach(caracteristica => {
                    cont++; 
                    template3 += `
                                <tr>
                                    <td>${cont}</td>
                                    <td>${caracteristica.titulo}</td>
                                    <td>${caracteristica.descripcion}</td>
                                </tr>
                                `;
                });
                $('#caracteristicas').html(template3);
                let template4 = '';
                producto.resenas.forEach(resena => {
                    template4 +=`
                                <div class="card-comment">
                                
                                    <img class="img-circle img-sm" src="../Util/Img/Users/${resena.avatar}" alt="User Image">

                                    <div class="comment-text">
                                        <span class="username">
                                        ${resena.usuario}   
                                        `;

                    for (let index = 0; index < resena.calificacion   ; index++) {
                        template4 += `<i class="fas fa-star text-warning"></i>`;
                    }
                    let estrellas_faltantes = 5 - resena.calificacion;
                    for (let index = 0; index < estrellas_faltantes   ; index++) {
                        template4 += `<i class="far  fa-star text-warning"></i>`;
                    }

                    let fecha = moment(resena.fecha+' '+resena.hora, 'DD/MM/YYYY HH:mm:ss');
                    let horas = moment(resena.hora, 'HH:mm:ss');
                    let fecha_hora;
                    if(resena.hoy=='1'){
                        fecha_hora = horas.fromNow();
                    }else{
                        fecha_hora = fecha.format('LLL');
                    }


                    template4 +=`   
                                    <span class="text-muted float-right">${fecha_hora}</span>
                                    </span>
                                    ${resena.descripcion}
                                </div>

                            </div>    
                            `;
                
                });
               
                $('#resenas').html(template4);

            } catch (error) {
                console.error(error);
                console.log(response);
                if(response == 'error'){
                    location.href = '../index.php';
                }

            }
            

        }else{
            Swal.fire({
                icon: 'error',
                title: data.statusText,
                text: 'Hubo un conflicto de código: '+data.status,
                
              });

        }
    }
    $(document).on('click', '.imagen_pasarelas', (e) => {
        let elemento = $(this)[0].activeElement;
        let img = $(elemento).attr('prod_img');
        $('#imagen_principal').attr('src', '../Util/Img/Producto/'+img);
    });

})