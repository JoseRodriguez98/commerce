<?php
if(!empty($_GET['id'])&& $_GET['name']){
    session_start();
    $_SESSION['product-verification'] = $_GET['id'];
    //echo $_SESSION['product-verification'];
    include_once 'Layouts/general/header.php';

?>

    <title><?php echo $_GET['name'] ?> | Fibra Parts Chile</title>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $_GET['name'] ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?php echo $_GET['name'] ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body">
          <div class="row">
            <div id="imagenes" class="col-12 col-sm-6">
              
            </div>
            <div class="col-12 col-sm-6">
              <h3 id="producto" class="my-3">LOWA Men’s Renegade GTX Mid Hiking Boots Review</h3>
                <span id="marca" ></span><br>
                <span id="sku"></span>
                <div id="informacion_precios">

                </div>
              <hr>
              <div class="card card-light">
                <div id="informacion_envio" class="card-body">

                </div>
              </div>
              <h4>Enviado y vendido por:</h4>

              
              <div class="bg-light py-2 px-3 mt-4 border">
                <h2 class="mb-0">
                  <button class="btn btn-primary">
                    <i class="fas fa-star text-warning mr-1"></i><span id="promedio_calificacion_tienda">4.5</span>
                  </button>
                  <span id="nombre_tienda" class="text-muted ml-1">nombre de tienda</span>
                </h2>
                <h4 class="mt-0">
                  <small id="numero_resenas">250 reseñas </small>
                </h4>
                <div class="mt-2 product-share">
                    <a href="#" class="text-gray">
                    <i class="fab fa-facebook-square fa-2x"></i>
                    </a>
                    <a href="#" class="text-gray">
                    <i class="fab fa-twitter-square fa-2x"></i>
                    </a>
                    <a href="#" class="text-gray">
                    <i class="fas fa-envelope-square fa-2x"></i>
                    </a>
                    <a href="#" class="text-gray">
                    <i class="fas fa-rss-square fa-2x"></i>
                    </a>
                </div>

              </div>

              <div class="mt-4">
                <div class="d-flex justify-content-between">
                    <div class="flex-fill mr-2">
                        <select id="cantidad_producto" class="form-control">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="flex-fill mx-2">
                        <button class="btn btn-success btn-block">
                            <i class="fas fa-cart-plus fa-lg mr-2"></i>
                            Agregar al carrito
                        </button>
                    </div>
                    <div class="flex-fill ml-2">
                        <button class="btn btn-default btn-block">
                            <i class="fas fa-heart fa-lg mr-2 text-danger"></i>
                            Agregar a favoritos
                        </button>
                    </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-4">
            <nav class="w-100">
              <div class="nav nav-tabs" id="product-tab" role="tablist">
                <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="true">Descripcion</a>
                <a class="nav-item nav-link" id="product-caract-tab" data-toggle="tab" href="#product-caract" role="tab" aria-controls="product-caract" aria-selected="false">Caracteristicas</a>
                <a class="nav-item nav-link" id="product-rese-tab" data-toggle="tab" href="#product-rese" role="tab" aria-controls="product-rese" aria-selected="false">Reseñas</a>
              </div>
            </nav>
            <div class="tab-content p-3" id="nav-tabContent">
              <div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab">
                Descripcion
            </div>
              <div class="tab-pane fade" id="product-caract" role="tabpanel" aria-labelledby="product-caract-tab">
                <table class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Característica</th>
                            <th scope="col">Descripción</th>
                            
                        </tr>
                    </thead>
                        
                    <tbody id="caracteristicas">

                    </tbody>
                </table>
            </div>
              <div class="tab-pane fade" id="product-rese" role="tabpanel" aria-labelledby="product-rese-tab">
                <div id="resenas" class="card-footer card-comments">
                </div>
            </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>


<?php
    include_once 'Layouts/general/footer.php';
}
else{
    header('Location: ../index.php');
}
?>
<script src="descripcion.js"></script>