<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.108.0">
    <title>TextilExport</title>
    
    <?php
    include_once './View/cabecera.php';
    ?>

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

    </style>

    
  </head>
  <body>
    
<main>
  <div class="container py-4">
    <header class="pb-3 mb-4 border-bottom">
      <div class="d-flex justify-content-around">

      
      <a href="#" class="d-flex align-items-center text-dark text-decoration-none">
        <img src="/Proyecto_MVC/MVC-main/View/img/Logo.png" alt="logo" width="50" height="50" class="me-2" viewBox="0 0 118 94">
        <span class="fs-4">Cuponera</span>
      </a>

      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-regular fa-user"></i> <?=isset($_SESSION['login_data']['Nombres'])? $_SESSION['login_data']['Nombres']:' Cuenta' ?>
        </button>
        <ul class="dropdown-menu dropdown-menu-dark">
        <?php
            if(!isset($_SESSION['login_data']['Nombres'])){            
            ?>
          <li><a class="dropdown-item" href="<?= PATH ?>/Usuarios/login">Iniciar Session</a></li>
          <?php
            } else{ ?>
          <li><a class="dropdown-item" href="<?= PATH ?>/Usuarios/logout">Cerrar Session</a></li>
          <?php
            }
          ?>
        </ul>
      </div>

      </div>
    </header>

    <div class="p-5 mb-4 bg-light rounded-3 ">
      <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Cuponera de servicios, alimentos  y artículos promocionales.</h1>
        <p class="col-md-8 fs-4">Contamos con variedad de productos y servicios de acuerdo a tus gustos y necesidades.
        </p>
      </div>
    </div>

    <div class="row align-items-md-stretch">

      <div class="col-md-12">
        <div class="h-100 p-5 text-bg-dark rounded-3 ">
          <center>
            <h1>Canjeo de Cupon</h1>
            <p>Bienvenido <?=$_SESSION['login_data']['Nombres']?>.</p>
            <a type="button" class="btn btn-light" href="<?=PATH?>/Empresas/Empleado"><i class="fa-solid fa-rotate-left fa-lg"></i>  Regresar</a>
          </center>
          <div class="d-flex justify-content-around">
          </div>
        </div>
      </div>
    
      <!--<div class="col-md-6">
        <div class="h-100 p-5 bg-light border rounded-3">
          <h2>Add borders</h2>
          <p>Or, keep it light and add a border for some added definition to the boundaries of your content. Be sure to look under the hood at the source HTML here as we've adjusted the alignment and sizing of both column's content for equal-height.</p>
          <button class="btn btn-outline-secondary" type="button">Example button</button>
        </div>
      </div>-->

    </div>

    <?php
    //var_dump($_SESSION['login_data']);
        if(isset($errores)){
            if(count($errores)>0){
                echo "<div class='my-5 p-5 mb-4 bg-danger rounded-3'><ul>";
                foreach ($errores as $error) {
                    echo "<li>$error</li>";
                }
                echo "</ul></div>";

            }
        }
    ?>

    <div class="row align-items-md-stretchS py-4">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover table-responsive table-condensed" id="tabla" style="margin-top:20px;">
                <thead>
                    <th>Cupon</th>
                    <th>Titulo</th>
                    <th>Descripcion</th>
                    <th>Empresa</th>
                    <th>Cliente</th>
                    <th>DUI</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Accion</th>
                </thead>
                <tbody>
                    
                    <?php
                    //var_dump($cupones);           
                    foreach($cupones as $cupon){             
                    ?>
                    <tr>
                        <td><?=$cupon['ID_Cupon']?></td>
                        <td><?=$cupon['Titulo_Oferta']?></td>
                        <td><?=$cupon['Descripcion']?></td>
                        <td><?=$cupon['Nombre_Empresa']?></td>
                        <td><?=$cupon['Nombres']?></td>
                        <td><?=$cupon['DUI']?></td>
                        <td><?=$cupon['Cantidad']?></td>
                        <td>$ <?=$cupon['Total']?></td>
                        <td>
                        <a type="button" class="btn btn-primary m-2" href="<?= PATH.'/Empresas/canjear/'.$cupon['ID_Cupon']?>"><i class="fa-solid fa-check fa-lg"></i> Canjear</a>
                        </td>               
                    </tr>
                    <?php         
                    }
                    ?>
                </tbody>
        </table>
      </div>
    </div>

 
    </div>

    <footer class="pt-3 mt-4 text-muted border-top">
      Marco Gerardo Serrano Lopez SL182556
    </footer>
  </div>
</main>

  <?php
    include_once './View/Modales/VerCupon.php';
  ?>



<script>
    $(document).ready(function () {
        $('#tabla').DataTable();
    });
</script>

  </body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>