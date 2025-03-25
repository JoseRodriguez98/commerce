<?php
    include_once 'Layouts/general/header.php';
?>

    <title>Favoritos | Fibra Parts Chile</title>
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Favoritos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Favoritos</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

  
    <section class="content">
      <div class="card">
        <div class="card-body"> 
          <table id="fav" class="table table-hover">
            <thead>
              <tr>
                <th>Favoritos</th>
              </tr>

            </thead> 
            <tbody>

            </tbody>

          </table>
        </div>
        <div class="card-footer">
          Footer
        </div>  
      </div>
    </section>
 


<?php
    include_once 'Layouts/general/footer.php';
?>

<script src="favoritos.js"></script>