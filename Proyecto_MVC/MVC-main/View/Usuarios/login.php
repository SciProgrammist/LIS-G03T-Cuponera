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
            <form role="form "action="<?= PATH ?>/Usuarios/validate" method="POST">

            <div class="row my-2">

                <div class="form-group col-md-10 m-3">
                    <label for="correo">Correo</label>
                    <div class="input-group my-2">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" class="form-control" name="Correo" id="Correo" placeholder="correo electronico: name@example.com" value="<?= isset($usuario)?$usuario['Correo']:'' ?>">
                    </div>
                </div>

                <div class="form-group col-md-10 m-3">
                    <label for="contra">Contraseña</label>
                    <div class="input-group my-2">
                        <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" class="form-control" name="pass1" id="pass1" value="<?= isset($usuario)?$usuario['Pass']:'' ?>" >
                    </div>
                </div>
            </div>

            
            <div  class="list-group my-2">
                <a href="<?= PATH ?>/Usuarios/register" class="list-group-item list-group-item-action list-group-item-danger">No dispones de una Cuenta ? Registrate con nosotros.</a>
            </div>
            <input type="submit" class="btn btn-primary" value="Iniciar Sesion" name="Guardar">
            <a class="btn btn-danger" href="<?= PATH ?>/Cupones/index">Cancelar</a>

            </form>
        </div>
        </div>
        </main>
    </body>
</html>