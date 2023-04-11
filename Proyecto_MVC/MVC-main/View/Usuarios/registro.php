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

                <form role="form "action="<?= PATH ?>/Usuarios/registerUser" method="POST">
                <div class="row my-2">

                    <div class="form-group col-md-5 m-3">
                        <label for="nombres">Nombres</label>
                        <div class="input-group my-2">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-star-of-life"></i></span>
                            <input type="text" class="form-control" name="Nombres" id="Nombres" placeholder="Ingresa tus nombres" value="<?= isset($usuario)?$usuario['Nombres']:'' ?>">
                        </div>
                    </div>

                    <div class="form-group col-md-5 m-3">
                        <label for="apellidos">Apellidos</label>
                         <div class="input-group my-2">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-star-of-life"></i></span>
                            <input type="text" class="form-control" name="Apellidos" id="Apellidos" placeholder="Ingresa tus apellidos" value="<?= isset($usuario)?$usuario['Apellidos']:'' ?>"></input>
                        </div>
                    </div>


                    <div class="form-group col-md-5 m-3">
                        <label for="telefono">Telefono</label>
                        <div class="input-group my-2">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-phone"></i></span>
                            <input type="tel" class="form-control" name="Telefono" id="Telefono" placeholder="Ingresa tu telefono" value="<?= isset($usuario)?$usuario['Telefono']:'' ?>" >
                        </div>
                    </div>
    
                    <div class="form-group col-md-5 m-3">
                        <label for="correo">Correo</label>
                        <div class="input-group my-2">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" class="form-control" name="Correo" id="Correo" placeholder="correo electronico: name@example.com" value="<?= isset($usuario)?$usuario['Correo']:'' ?>">
                        </div>
                    </div>


                    <div class="form-group col-md-5 m-3">
                        <label for="direccion">Direccion</label>
                        <div class="input-group my-2">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-star-of-life"></i></span>
                            <input type="text" class="form-control" name="direccion" id="direccion" value="<?= isset($usuario)?$usuario['Direccion']:'' ?>">
                        </div>
                    </div>

                    <div class="form-group col-md-5 m-3">
                        <label for="dui">DUI</label>
                        <div class="input-group my-2">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-star-of-life"></i></span>
                            <input type="text" class="form-control" name="dui" id="dui" value="<?= isset($usuario)?$usuario['DUI']:'' ?>">
                        </div>
                    </div>
                    
                    <div class="form-group col-md-5 m-3">
                        <label for="contra">Contraseña</label>
                        <div class="input-group my-2">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" class="form-control" name="pass1" id="pass1" value="<?= isset($usuario)?$usuario['Pass']:'' ?>" >
                        </div>
                    </div>

                    <div class="form-group col-md-5 m-3">
                        <label for="correo">Confirmar Contraseña</label>
                        <div class="input-group my-2">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" class="form-control" name="pass2" id="pass2" value="<?= isset($usuario)?$usuario['Pass']:'' ?>">
                        </div>
                    </div>
                </div>

                <input type="submit" class="btn btn-primary" value="Guardar" name="Guardar">
                <a class="btn btn-danger" href="<?= PATH ?>/Usuarios/login">Cancelar</a>

                </form>
             </div>
             </div>

        </main>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</html>