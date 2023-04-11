<!DOCTYPE HTML>
<html>
    <head>
    <?php
    include_once './View/cabecera.php';
    ?>
    </head>

    <body>
        <main>
            <div class="container p-5">
                <header class="d-flex justify-content-around">
                    <div class="d-flex align-items-center text-dark text-decoration-none">
                        <img src="" alt="logo.png">
                        <spam clas="fs-4">Cuponera [Nombre]</spam>
                    </div>
                </header>
            </div>

            <?php
                if(isset($errores)){
                    if(count($errores)>0){
                        echo "<div class='m-5'><div class='p-5 mb-4 bg-danger rounded-3'><ul>";
                        foreach ($errores as $error) {
                            echo "<li>$error</li>";
                        }
                    echo "</ul></div></div>";            
                    }
                }
            ?>


            <div class = "p-5 m-5">
            <div class="row align-items-center p-5 rounded border border-black">

                <form role="form "action="<?= PATH ?>/Usuarios/ActivarUser" method="POST">
                
                <div class="row my-2">
                    <center>
                    <div class="form-group col-md-5 m-3">
                        <label for="codigo">Codigo de Verificacion</label>
                        <div class="input-group my-2">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-star-of-life"></i></span>
                            <input type="text" class="form-control" name="codigo" id="codigo"  value="<?= isset($usuario)?$usuario['Nombres']:'' ?>">
                        </div>
                    </div>
                    </center>
                    
                </div>

                <center>
                <input type="submit" class="btn btn-primary" value="Guardar" name="Guardar">
                <a class="btn btn-danger" href="<?= PATH ?>/Usuarios/login">Cancelar</a>
                </center>

                </form>
             </div>
             </div>

        </main>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</html>