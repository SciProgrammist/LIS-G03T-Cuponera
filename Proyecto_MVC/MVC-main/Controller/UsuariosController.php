<?php
require_once 'Controller.php';
require_once './Model/UsuariosModel.php';
require_once './Core/validaciones.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
//require_once './Model/TipoUsuariosModel.php';

class UsuariosController extends Controller{

    function __construct(){
        
        $this->model=new UsuariosModel();
       
    }

  
    public function register(){ //Presenta la vista de la pagina para registrar usuarios.
        $this->render("registro.php");
    }

    public function registerUser(){ //Metodo para registrar los usuarios.
        if(isset($_POST['Guardar'])){
            extract($_POST);
            $errores=array();
            $usuario = array();
            $viewBag=array();
            $codigo = rand(1000,9999);

            $usuario['ID_Usuario'] = "";
            $usuario['Nombres'] = $Nombres;
            $usuario['Apellidos'] = $Apellidos;
            $usuario['Telefono'] = $Telefono;
            $usuario['Correo'] = $Correo;
            $usuario['Direccion'] = $direccion;
            $usuario['DUI'] = $dui;
            $usuario['Pass'] = $pass1;
            $usuario['Estado'] = "Inactivo";
            $usuario['Codigo'] = $codigo;
            //$usuario['Estado'] = "Activo";
            $usuario['id_tipo_usuario'] = 4;

            if(estaVacio($Nombres) || is_null($Nombres)){
                array_push($errores,"Debes ingresar su nombre.");

            }
            else if(!esTexto($Nombres)){
                array_push($errores,"Solo se permite Texto en el campo Nombre.");
            }
            
            if(estaVacio($Apellidos) || is_null($Apellidos)){
                array_push($errores,"Debes ingresar su apellido.");
            }
            else if(!esTexto($Apellidos)){
                array_push($errores,"Solo se permite Texto en el campo Apellido.");
            }

            if(estaVacio($Correo) || is_null($Correo)){
                array_push($errores,"Debes ingresar un correo.");
            }
            else if(!esMail($Correo)){
                array_push($errores,"formato del correo erroneo.");
            }

            if(estaVacio($direccion) || is_null($direccion)){
                array_push($errores,"Debes ingresar Una Direccion.");
            }

            if(estaVacio($dui) || is_null($dui)){
                array_push($errores,"Debes su DUI.");

            }
            else if(!esDui($dui)){
                array_push($errores,"Formato de DUI no es valido");
            }

            if(estaVacio($Telefono) || is_null($Telefono)){
                array_push($errores,"Debes ingresar Un numero de telefono.");
            }
            else if(!esTelefono($Telefono)){
                array_push($errores,"El telefono debe cumplir con el formato..");
            }

            if((estaVacio($pass1) || is_null($pass1)) || (estaVacio($pass2) || is_null($pass2)) ){
                array_push($errores,"Debe ingresar su contraseña");
            }elseif($pass1 != $pass2){
                array_push($errores,"Las contraseñas no coinciden ");
            }

            if(count($errores) == 0){

                $this->model->insertUsuario($usuario);

                $mensaje = '
                <html>
                    <head>
                        <meta charset="UTF-8"/>
                        <title>Registro</title>
                    </head>
                    <body>
                        <p>Tu codigo de verificacion es: </p>
                        <h2>'.$codigo.'</h2>
                    </body>
                </html>';
                        
                $mail = new PHPMailer(true); //Envia un correo electronico hacia el correo colocado por el usuario con un codigo de activacion.

                try {
                    //Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = '';                     //SMTP username
                    $mail->Password   = '';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                
                    //Recipients
                    $mail->setFrom('', 'LIS');
                    $mail->addAddress("$Correo");     //Add a recipient
                    //$mail->addAddress('ellen@example.com');               //Name is optional
                    //$mail->addReplyTo('info@example.com', 'Information');
                    //$mail->addCC('cc@example.com');
                    //$mail->addBCC('bcc@example.com');
                
                    //Attachments
                    //$mail->addAttachment('PDF/Prueba.pdf');         //Add attachments
                    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
                
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Creaccion de Cuenta';
                    $mail->Body    = 'Su codigo de verificacion es: '.$codigo.'';
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                
                    $mail->send();
                    
                    echo "<script>alert('Su cueenta se creo Exitosamente');</script>";
                    header('location:' .PATH. '/Usuarios/login');
                    //session_destroy();
                } catch (Exception $e) {
                    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    echo "<script>alert('Hubo un problema volver a interntarlo');</script>";
                    header('location:' .PATH. '/Usuarios/register');
                }
            }
            else{
                $viewBag['errores']=$errores;
                $viewBag['usuario']=$usuario;
                $this->render("registro.php",$viewBag);
            }
        }
    }

    public function verificar(){ //Funcion encargada de presentar la pagina de activacion de cuenta.
        $this->render("verificacion.php");
    }

    public function ActivarUser(){ //Metodo para activar la cuenta
        if(isset($_POST['Guardar'])){
            $model=new UsuariosModel();
            $codigo=$_POST['codigo'];

            $errores=array();   
            $viewBag=array();
            $usuario = array();

            if(!empty($model->CodigoUser($codigo))){
                $estadus_data = $model->CodigoUser($codigo);
                //var_dump($estadus_data);
                if($estadus_data[0]['Estado'] == 'Inactivo'){
                    $usuario['ID_Usuario']  = $estadus_data[0][0];
                    $usuario['Estado']  = 'Activo';
                    $usuario['Codigo']  = $estadus_data[0][2];  
                    //var_dump($usuario);
                    $this->model->ActivarUsuario($usuario);
                    $this->render("login.php");
                }else{
                    array_push($errores,"Su cuenta ya se encuentra Activa");
                    $viewBag['errores']=$errores;
                    $this->render("verificacion.php",$viewBag);
                }
                //var_dump($estadus_data[0]['Estado']);

            }else{
                array_push($errores,"Codigo no encontrado");
                $viewBag['errores']=$errores;
                $this->render("verificacion.php",$viewBag);
            }
        }
    }


    public function login(){ // Vista de la pagina de Inicion de sesion.
        $this->render("login.php");
    }

    public function logout(){ //Metodo para cerrar sesion.
        session_unset();
        session_destroy();
        header('location:'.PATH.'/Cupones/index');
    }
    public function validate(){ //Metodo para confirmar el inicio de session
        $model=new UsuariosModel();

        $correo=$_POST['Correo'];
        $pass=$_POST['pass1'];

        $errores=array();
        $viewBag=array();
        
        if(!empty($model->validateUser($correo,$pass))){
            $login_data=$model->validateUser($correo,$pass);
            $login_data=$login_data[0];
            //var_dump($login_data);
            //var_dump($_SESSION['login_data']); //Variable de session que captura los datos del usuario.
            //var_dump($_SESSION['login_data'][0]['id_tipo_usuario']);
            if($login_data['id_tipo_usuario'] == 4 && $login_data['Estado'] == "Activo" ){
                $_SESSION['login_data']=$login_data; //Variable de session que captura los datos del usuario.
                header('location:'.PATH.'/Cupones/index');
            }elseif($login_data['id_tipo_usuario'] == 1 && $login_data['Estado'] == "Activo" ){
                $_SESSION['login_data']=$login_data; //Variable de session que captura los datos del usuario.
                header('location:'.PATH.'/Cupones/Admin');
            }elseif($login_data['id_tipo_usuario'] == 2 && $login_data['Estado'] == "Activo" ){
                echo "<script>alert('Usuario Ingreso con exito');</script>";
            }else{
                array_push($errores,"Su usuario no esta Activo.");
                $viewBag['errores']=$errores;
                $this->render("login.php",$viewBag);
            }
            
            
        }
        else{
            array_push($errores,"Usuario no Registrado.");
            $viewBag['errores']=$errores;
            $this->render("login.php",$viewBag);
        }
    }
}