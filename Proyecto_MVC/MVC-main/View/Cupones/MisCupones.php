<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ménu</title>
    <link rel="stylesheet" type="text/css" href="<?=PATH?>/View/assets/css/Menu.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/jumbotron/">
    <?php
    include_once './View/cabecera.php';
    ?>
    <script src="https://kit.fontawesome.com/c01e7ddef6.js" crossorigin="anonymous"></script>

    <style>
        main{
            background-color: white;
        }
    </style>
</head>
<body>
    <header id="Home">
        <nav class="nav">
            <div class="logo mx-5">Cuponera</div>
            <ul class="menu">
                 <!--<li><a href="#Home">Home</a></li>
                 <li><a href="#Contacto">About</a></li>
                 <li><a href="#">Services</a></li>-->
                 <li style="margin: 10px;"><a href="<?=PATH?>/Cupones/index">Regresar</a></li>
                 <div class="dropdowm">
                    <button class="btnLogin-popup btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-regular fa-user"></i> <?=isset($_SESSION['login_data']['Nombres'])? $_SESSION['login_data']['Nombres']:' Cuenta' ?>
                    </button>
                    <ul class="dropdown-menu">
                    <?php
                    if(!isset($_SESSION['login_data']['Nombres'])){            
                    ?>
                    <li><a class="dropdown-item" href="<?= PATH ?>/Usuarios/login">Iniciar Sesion</a></li>
                    <li><a class="dropdown-item" href="<?= PATH ?>/Usuarios/verificar">Activar Cuenta</a></li>
                    <?php
                    } else{ ?>
                    <li><a class="dropdown-item" href="<?= PATH ?>/Usuarios/logout">Cerrar Session</a></li>
                    <?php
                    }
                    ?>
                    </ul>
                 </div>
            </ul>

        </nav>

        <div class="Contenido">
            <div class="p-5 mb-4 bg-light rounded-5 ">
                <div class="container-fluid py-5">
                    <h1 class="display-5 fw-bold">Cuponera de servicios, alimentos  y artículos promocionales.</h1>
                    <p class="col-md-8 fs-4">Contamos con variedad de productos y servicios de acuerdo a tus gustos y necesidades.
                    </p>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div clas="carrito">
            <div class ="row p-5">
            
            <div class="table-responsive">
            <table class="table align-middle" style="margin-top:20px;">
                <thead>
                    <th>Codigo</th>
                    <th>Titulo</th>
                    <th>Descripcion</th>
                    <th>Estado</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Accion</th>
                </thead>
                <tbody>
                    <?php
                    $_SESSION['Mis_Cupones'] = $cupones;
                    //var_dump($_SESSION['Mis_Cupones']);
                     foreach($cupones as $cupon){            
                     ?>
                     <tr>
                        <td><?=$cupon['ID_Cupon']?></td>               
                        <td><?=$cupon["Titulo_Oferta"]?></td>
                        <td><?=$cupon["Descripcion"]?></td>
                        <td><?=$cupon["Estado_Cupon"]?></td>
                        <td><?=$cupon["Cantidad"]?></td>
                        <td><?=$cupon["Total"]?></td>
                        <td>
                            <a type="submit" target="_blank" class="btn btn-danger  m-2" href="/Proyecto_MVC/MVC-main//Controller/fpdf-tutoriales-master/PruebaV.php?codigo=<?=$cupon['ID_Cupon']?>"><i class="fa-solid fa-file-pdf"></i> Generar PDF</a>
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
    </main>

    <footer id="Contacto" class="bg-dark text-white pt-5 pb-4">
    <div class="container text-center text-md-left">
            <div class="row text-center text-md-left">
             <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
              <h5 class="text-uppercase mb-4 font-weight-bold text-warning">CUPONERA</h5>
              <p>Contamos con variedad de productos y servicios de acuerdo a tus gustos y necesidades!</p>
              
            </div>
            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
               <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Productos</h5>
            <p>
                <a href="#" class="text-white" style="text-decoration:none ">Servicios</a>
            </p>
            <p>
                <a href="#" class="text-white" style="text-decoration:none ">Alimentos</a>
            </p>
            <p>
                <a href="#" class="text-white" style="text-decoration:none ">Descuentos</a>
            </p>
           

            </div>

            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Desarroladores</h5>
                <p>
                    <a href="#" class="text-white" style="text-decoration:none ">Serrano López, Marco Gerardo</a>
                </p>
                <p>
                    <a href="#" class="text-white" style="text-decoration:none ">Cerón López, Fernando Eriberto</a>
                </p>
                <p>
                    <a href="#" class="text-white" style="text-decoration:none ">Reyes Pineda, Daniel Alexander</a>
                </p>
            </div>

            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Contacto</h5>
                <p>
                    <i class="fas fa-home mr-3"></i>
                    ...
                </p>
                <p>
                    <i class="fas fa-envelope mr-3"></i>
                    ...
                </p>
                <p>
                    <i class="fas fa-phone mr-3"></i>
                    ...
                </p>
                <p>
                    <i class="fas fa-print mr-3"></i>
                    ...
                </p>

            </div>
 
            </div>
            <hr>
            <div class="row align-items-center">
                <div class="col-md-7 col-lg-8">
                    <p>Copyright 2023 All rights reserved by: 
                        <a href="#" style="text-decoration: none;">
                           <strong class="text-warning">The TheProviders</strong>
                        </a>
                    </p>

                </div>

                <div class="col-md-5 col-lg-4">
                    <div class="text-center text-md-right">
                        
                        <ul class="list-unstyled list-inline">
                            <li class="list-inline-item">
                                <a href="#" class="btn-floating btn-sm text-white" style="font-size:23px;">
                                <i class="fa-brands fa-facebook"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" class="btn-floating btn-sm text-white" style="font-size:23px;">
                                    <i class="fa-brands fa-twitter"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" class="btn-floating btn-sm text-white" style="font-size:23px;">
                                    <i class="fa-brands fa-google-plus"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" class="btn-floating btn-sm text-white" style="font-size:23px;">
                                    <i class="fa-brands fa-youtube"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
    
                </div>


            </div>

         </div>
    </footer>

    <script>
    $(document).ready(function () {
        $('#tabla').DataTable();
    });
    
    function detalles(id){
        $.ajax({
            url:"<?=PATH?>/Cupones/details/"+id,
            type:"GET",
            dataType:"JSON",
            success: function(datos){
                $('#nombre').text(datos.Titulo_Oferta);
                $('#precio_regular').text(datos.Precio_Regular);
                $('#precio_oferta').text(datos.Precio_Oferta);
                <?php
                foreach($empresas as $empresa){
                ?>
                if(datos.id_empresa == '<?=$empresa['ID_Empresa']?>'){
                  datos.id_empresa = '<?=$empresa['Nombre_Empresa']?>';               
                }
                <?php      
                }
                ?>
                $('#empresa').text(datos.id_empresa);
                if(datos.Cantidad_Cupones == null){
                  datos.Cantidad_Cupones = "Hasta terminar Fecha limite"
                }
                $('#existencias').text(datos.Cantidad_Cupones);
                $('#descripcion').text(datos.Descripcion);
                $('#modal').modal('show');
                $('.titulo-modal').text(datos.Titulo_Oferta);
            }
        })
    }
    </script>

    <?php
    include_once './View/Modales/VerCupon.php';
    ?>

    <script src="<?=PATH?>/View/assets/js/Menu.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
</body>
</html>