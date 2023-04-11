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
            $_SESSION['login_data']=$login_data; //Variable de session que captura los datos del usuario.
            //var_dump($_SESSION['login_data'][0]['id_tipo_usuario']);
            if($_SESSION['login_data']['id_tipo_usuario'] == 4 && $_SESSION['login_data']['Estado'] == "Activo" ){
                echo "<script>alert('Usuario Ingreso con exito');</script>";
            //header('location:'.PATH.'/Productos/index');
            }elseif($_SESSION['login_data']['id_tipo_usuario'] == 1 && $_SESSION['login_data']['Estado'] == "Activo" ){
                echo "<script>alert('Usuario Ingreso con exito');</script>";
            }elseif($_SESSION['login_data']['id_tipo_usuario'] == 2 && $_SESSION['login_data']['Estado'] == "Activo" ){
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