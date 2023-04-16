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
</head>
<body>
    <header id="Home">
        <nav class="nav">
            <div class="logo mx-5">Cuponera</div>
            <ul class="menu">
                 <!--<li><a href="#Home">Home</a></li>
                 <li><a href="#Contacto">About</a></li>-->
                 <li style="margin: 10px;"><a href="<?=PATH?>/Cupones/VerCupones">Mis Cupones</a></li>
                 <li style="margin: 10px;"><a href="<?=PATH?>/Cupones/VerCarrito">Carrito</a></li>
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
            <p>
                
            </p>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos,
                 corporis saepe! Autem rem officiis eos natus. Dolorem, soluta modi doloremque
                  aspernatur itaque molestiae minima placeat nam sit ipsum impedit similique?
            </p>


        </div>
    </header>

    <main>
        <div clas="container">
            <div class ="row row-cols-lg-3 p-5">
                <?php
                foreach($cupones as $cupon){

                ?>
                <div class="col">
                    <div class="card mb-3 ">
                        <img src="<?=PATH?>/View/img/<?=$cupon['Imagen']?>" width="100%" height="500px" class="card-img-top" alt="Promo.jpg">
                            <div class="card-body">
                                <h5 class="card-title"><?=$cupon['Titulo_Oferta']?></h5>
                                <p class="card-text"><?=$cupon['Descripcion']?></p>
                                <p class="card-text">Fecha inicial: <?=$cupon['Fecha_Inicio_Oferta']?>  Fecha Final: <?=$cupon['Fecha_Fin_Oferta']?></small></p>
                                <p class="card-text">Precio Regular: $<?=$cupon['Precio_Regular']?>  Precio en Oferta: $<?=$cupon['Precio_Oferta']?> </p>
                                <?php
                                if(isset($_SESSION['login_data'])){
                                ?>
                                <center>
                                <form role="form "action="<?= PATH ?>/Cupones/Carrito" method="POST">
                                    <input type="hidden" name="ID_Oferta" value="<?=$cupon['ID_Oferta']?>">
                                    <input type="hidden" name="Titulo_Oferta" value="<?=$cupon['Titulo_Oferta']?>">
                                    <input type="hidden" name="Precio_Regular" value="<?=$cupon['Precio_Regular']?>">
                                    <input type="hidden" name="Precio_Oferta" value="<?=$cupon['Precio_Oferta']?>">
                                    <input type="hidden" name="id_empresa" value="<?=$cupon['id_empresa']?>">
                                    <label for="cantidad">Cantidad:</label>
                                    <input type="number"  class="form-control" name="Cantidad" value="1" min="1">
                                    <input type="submit" class="btn btn-danger m-3" value="Carrito" name="Guardar">
                                </form>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal" href="javascript:void(0)" onclick="detalles('<?=$cupon['ID_Oferta']?>')">
                                <i class="fa-regular fa-eye"></i> Ver mas    
                                </button>
                                </center>
                                <?php
                                 }else{
                                ?>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal" href="javascript:void(0)" onclick="detalles('<?=$cupon['ID_Oferta']?>')">
                                <i class="fa-regular fa-eye"></i> Ver mas    
                                </button>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                </div>
                <?php
                }
                ?>

                

            </div>

        </div>
    </main>

    <footer id="Contacto" class="bg-dark text-white pt-5 pb-4">
        <div class="container text-center text-md-left">
            <div class="row text-center text-md-left">
             <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
              <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Company Name</h5>
              <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Voluptate numquam ex beatae,
                 veritatis fugiat non optio neque odit explicabo doloribus maxime molestias ipsam fugit deleniti, 
                 eveniet in dolore repudiandae quia!</p>
              
            </div>
            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
               <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Products</h5>
            <p>
                <a href="#" class="text-white" style="text-decoration:none ">TheProviders</a>
            </p>
            <p>
                <a href="#" class="text-white" style="text-decoration:none ">Creativity</a>
            </p>
            <p>
                <a href="#" class="text-white" style="text-decoration:none ">SourceFiles</a>
            </p>
            <p>
                <a href="#" class="text-white" style="text-decoration:none ">Bootstrap</a>
            </p>

            </div>

            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Useful links</h5>
                <p>
                    <a href="#" class="text-white" style="text-decoration:none ">Your Account</a>
                </p>
                <p>
                    <a href="#" class="text-white" style="text-decoration:none ">Become an Affiliates</a>
                </p>
                <p>
                    <a href="#" class="text-white" style="text-decoration:none ">Shipping Rates</a>
                </p>
                <p>
                    <a href="#" class="text-white" style="text-decoration:none ">Help</a>
                </p>
            </div>

            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-warning">Contact</h5>
                <p>
                    <i class="fas fa-home mr-3"></i>
                    New york, NY 2333, US
                </p>
                <p>
                    <i class="fas fa-envelope mr-3"></i>
                    ismaelmarin380@gmail.com
                </p>
                <p>
                    <i class="fas fa-phone mr-3"></i>
                    -98 34256889
                </p>
                <p>
                    <i class="fas fa-print mr-3"></i>
                    +01 335 654 99
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
    /*$(document).ready(function () {
        $('#tabla').DataTable();
    });*/
    
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