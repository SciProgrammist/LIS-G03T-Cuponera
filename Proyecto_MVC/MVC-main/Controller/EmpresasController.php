<?php
require_once 'Controller.php';
require_once './Core/validaciones.php';
require_once './Model/CuponesModel.php';
require_once './Model/EmpresaModel.php';
require_once './Model/RubrosModel.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';

class EmpresasController extends Controller{

    private $model;

    function __construct(){
        
        $this->model=new EmpresaModel();
       
    }

    public function index(){
        $rubros = new RubrosModel();
        $viewBag=array();
        $Empresas=$this->model->get();
        $viewBag['rubros']=$rubros->get();
        $viewBag['empresas']=$Empresas;
        //var_dump($viewBag);
        $this->render("index.php",$viewBag);
    }

    public function Admin(){
        $ofertas = new CuponesModel();
        $viewBag=array();
        $viewBag['ofertas']=$ofertas->OfertasEmpresa(($_SESSION['login_data']['ID_Empresa']));
        $this->render("VistaEmpresa.php",$viewBag);
    }
    public function Empleado(){
        $this->render("VistaEmpleado.php");
    }

    public function Cupon(){
        if(isset($_POST['Guardar'])){
            $cupon = new CuponesModel();
            extract($_POST);

            $errores=array();
            $viewBag=array();
            $viewBag['cupon']= !empty($cupon->CanjeCupon($ID_Cupon)[0])? $cupon->CanjeCupon($ID_Cupon)[0] : '';

            if(estaVacio($ID_Cupon)||!isset($ID_Cupon)){
                array_push($errores,'Debe ingresar el Cupon');
            }
            else if(empty($cupon->CanjeCupon($ID_Cupon))){
                array_push($errores,'Cupon no encontrado');
            }
            else if($viewBag['cupon']['ID_Empresa'] != $_SESSION['login_data']['id_empresa'] ){
                array_push($errores,'No Puede continuar con el proceso ya que el cupon no es de su empresa.');
            }

            if(count($errores)==0){
                $viewBag['cupones']=$cupon->CanjeCupon($ID_Cupon);
                $this->render("CanjeCupon.php",$viewBag);
            }else{
                $viewBag['errores']=$errores;
                $this->render("VistaEmpleado.php",$viewBag);
            }
        }

    }

    public function canjear($id){
        $cupon = new CuponesModel();
        $errores=array();
        $viewBag=array();
        $cup=array();
        $cup['ID_Cupon']=$id;
        $cup['Estado_Cupon']="Canjeado";
        $viewBag['cupon']= !empty($cupon->CanjeCupon($id)[0])? $cupon->CanjeCupon($id)[0] : '';

        if($viewBag['cupon']['Estado_Cupon'] ==  $cup['Estado_Cupon'] ){
            array_push($errores,'Cupon ya Canjeado');
        }

        if(count($errores)==0){
            $cupon->updateCupon($cup);
            header('location:' .PATH. '/Empresas/Empleado');
        }else{
            $viewBag['errores']=$errores;
            $viewBag['cupones']=$cupon->CanjeCupon($id);
            $this->render("CanjeCupon.php",$viewBag);
        }

    }

    public function Empleados(){
        $viewBag=array();
        $viewBag['empleados']=$this->model->getEmpleado(($_SESSION['login_data']['ID_Empresa']));
        //var_dump($viewBag);
        $this->render("DataEmpleados.php",$viewBag);
    }

    
    public function details($id){
        echo json_encode($this->model->get($id)[0]); //crea un json por medio de un arreglo
    }

    public function create(){
        $rubros = new RubrosModel();
        $viewBag['rubros']=$rubros->get();
        $this->render("new.php", $viewBag);
    }

    public function CreateEmpleado($id){
        $viewBag=array();
        $viewBag['empresa']=$this->model->get($id)[0];
        //var_dump($viewBag);
        $this->render("newEmpleado.php",$viewBag);

    }

    public function addEmpleados(){
        if(isset($_POST['Guardar'])){
            extract($_POST);

            $errores=array();
            $Empleado=array();
            $viewBag=array();

            $Empleado['ID_Empleado']= "";
            $Empleado['Nombres']=$Nombres;
            $Empleado['Apellidos']=$Apellidos;
            $Empleado['Correo']=$Correo;

            //Contraseña aleatoria
            $bytes = openssl_random_pseudo_bytes(4);
            $pass = bin2hex($bytes);
            $Empleado['Pass']=$pass;

            $Empleado['id_empresa']=$id_empresa;
            $Empleado['id_tipo_usuario']="3";

            if(estaVacio($Nombres)||!isset($Nombres)){
                array_push($errores,'Debes ingresar el nombre del Empleado');
            }
            if(estaVacio($Apellidos)||!isset($Apellidos)){
                array_push($errores,'Debes ingresar el apellido del Empleado');
            }
            if(estaVacio($Correo)||!isset($Correo)){
                array_push($errores,'Debes ingresar el Correo Electronico');
            }
            else if(!esMail($Correo)){
                array_push($errores,"formato del correo erroneo.");
            }

            if(count($errores)==0){
               
                $this->model->insertEmpleado($Empleado);
          
                $mail = new PHPMailer(true); //Envia un correo electronico hacia el correo colocado por el usuario con un codigo de activacion.

                try {
                    //Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'tekmo120@gmail.com';                     //SMTP username
                    $mail->Password   = 'ghehmaazpfrzucks';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                
                    //Recipients
                    $mail->setFrom('tekmo120@gmail.com', 'LIS');
                    $mail->addAddress("$Correo");     //Add a recipient
            
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Creaccion de Cuenta';
                    $mail->Body    = 'Su Contraseña es: '.$pass.'';
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                
                    $mail->send();
                    
                    echo "<script>alert('Su cueenta se creo Exitosamente');</script>";
                    header('location:' .PATH. '/Empresas/Empleados');
                    //session_destroy();
                } catch (Exception $e) {
                    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    echo "<script>alert('Hubo un problema volver a interntarlo');</script>";
                    header('location:' .PATH. '/Empresas/create');
                }

            }
            else{
                $viewBag['errores']=$errores;
                $viewBag['empleado']=$Empleado;
                $viewBag['empresa']=$this->model->get($id_empresa)[0];
                $this->render("newEmpleado.php",$viewBag);
            }

        }
    }

    public function add(){
        if(isset($_POST['Guardar'])){
            extract($_POST);
            $errores=array();
            $Empresa=array();
            $viewBag=array();

            $Empresa['ID_Empresa']=$ID_Empresa;
            $Empresa['Nombre_Empresa']=$Nombre_Empresa;
            $Empresa['Direccion']=$Direccion;
            $Empresa['Nombre_Contacto']=$Nombre_Contacto;
            $Empresa['Telefono']=$Telefono;
            $Empresa['Correo']=$Correo;

            //Contraseña aleatoria
            $bytes = openssl_random_pseudo_bytes(4);
            $pass = bin2hex($bytes);
            $Empresa['Pass']=$pass;

            $Empresa['Rubro']=$Rubro;
            $Empresa['Porcentaje_Comision']=$Porcentaje_Comision;
            $Empresa['id_tipo_usuario']= '2';

            if(estaVacio($ID_Empresa)||!isset($ID_Empresa)){
                array_push($errores,'Debes ingresar un codigo de la empresa EMP###');
            }elseif(!esCodigoEmpresa($ID_Empresa)){
                array_push($errores,'Formato Incorrecto del Codigo de la Empresa');
            }

            if(estaVacio($Nombre_Empresa)||!isset($Nombre_Empresa)){
                array_push($errores,'Debes ingresar el Nombre de la Empresa');
            }

            if(estaVacio($Direccion)||!isset($Direccion)){
                array_push($errores,'Debes ingresar la Direccion');
            }

            if(estaVacio($Nombre_Contacto)||!isset($Nombre_Contacto)){
                array_push($errores,'Debes ingresar el Nombre del Contacto');
            }

            if(estaVacio($Telefono)||!isset($Telefono)){
                array_push($errores,'Debes ingresar un numero Telefonico');
            }
            else if(!esTelefono($Telefono)){
                array_push($errores,"El telefono debe cumplir con el formato..");
            }

            if(estaVacio($Correo)||!isset($Correo)){
                array_push($errores,'Debes ingresar el Correo Electronico');
            }
            else if(!esMail($Correo)){
                array_push($errores,"formato del correo erroneo.");
            }

            if(estaVacio($Porcentaje_Comision)||!isset($Porcentaje_Comision)){
                array_push($errores,'Debes ingresar la Comision de la Empresa');
            }

            

            if(count($errores)==0){
               
                $this->model->insertEmpresa($Empresa);
          
                $mail = new PHPMailer(true); //Envia un correo electronico hacia el correo colocado por el usuario con un codigo de activacion.

                try {
                    //Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'tekmo120@gmail.com';                     //SMTP username
                    $mail->Password   = 'ghehmaazpfrzucks';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                
                    //Recipients
                    $mail->setFrom('tekmo120@gmail.com', 'LIS');
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
                    $mail->Body    = 'Su Contraseña es: '.$pass.'';
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                
                    $mail->send();
                    
                    echo "<script>alert('Su cueenta se creo Exitosamente');</script>";
                    header('location:' .PATH. '/Empresas/index');
                    //session_destroy();
                } catch (Exception $e) {
                    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    echo "<script>alert('Hubo un problema volver a interntarlo');</script>";
                    header('location:' .PATH. '/Empresas/create');
                }

            }
            else{
                $rubros = new RubrosModel();
                $viewBag['rubros']=$rubros->get();
                $viewBag['errores']=$errores;
                $viewBag['empresa']=$Empresa;
                $this->render("new.php",$viewBag);
            }


            
        }
    }

    public function edit($id){ //Funciona
        $rubros = new RubrosModel();
        $viewBag=array();
        $Empresa=$this->model->get($id);
        $viewBag['empresa']=$Empresa[0];
        $viewBag['rubros']=$rubros->get();
        $this->render("edit.php",$viewBag);
    }

    public function EditEmpleados($id){
        $viewBag=array();
        $viewBag['empleado']=$this->model->getEmpleado(($_SESSION['login_data']['ID_Empresa']))[0];
        //var_dump($viewBag);
        $this->render("EditEmpleado.php",$viewBag);
    }

    public function updateEmpleados(){
        if(isset($_POST['Guardar'])){
            extract($_POST);

            $errores=array();
            $Empleado=array();
            $viewBag=array();

            $Empleado['ID_Empleado']=$ID_Empleado;
            $Empleado['Nombres']=$Nombres;
            $Empleado['Apellidos']=$Apellidos;
            $Empleado['Correo']=$Correo;

            if(estaVacio($Nombres)||!isset($Nombres)){
                array_push($errores,'Debes ingresar el Nombre del Empleado');
            }
            if(estaVacio($Apellidos)||!isset($Apellidos)){
                array_push($errores,'Debes ingresar el Apellido del Empleado');
            }

            
            if(count($errores)==0){
                $this->model->updateEmpleado($Empleado);
                header('location:'.PATH.'/Empresas/Empleados');

            }
            else{
                $viewBag['empleado']=$Empleado;
                $viewBag['errores']=$errores;
                $this->render("EditEmpleado.php",$viewBag);
            }
        }
    }

    public function update($id){ //Funciona
        if(isset($_POST['Guardar'])){
            extract($_POST);
            $errores=array();
            $Empresa=array();
            $viewBag=array();

            $Empresa['ID_Empresa']=$ID_Empresa;
            $Empresa['Nombre_Empresa']=$Nombre_Empresa;
            $Empresa['Direccion']=$Direccion;
            $Empresa['Nombre_Contacto']=$Nombre_Contacto;
            $Empresa['Telefono']=$Telefono;
            $Empresa['Correo']=$Correo;
            $Empresa['Rubro']=$Rubro;
            $Empresa['Porcentaje_Comision']=$Porcentaje_Comision;

            if(estaVacio($Nombre_Empresa)||!isset($Nombre_Empresa)){
                array_push($errores,'Debes ingresar el Nombre de la Empresa');
            }

            if(estaVacio($Direccion)||!isset($Direccion)){
                array_push($errores,'Debes ingresar la Direccion');
            }

            if(estaVacio($Nombre_Contacto)||!isset($Nombre_Contacto)){
                array_push($errores,'Debes ingresar el Nombre del Contacto');
            }

            if(estaVacio($Telefono)||!isset($Telefono)){
                array_push($errores,'Debes ingresar un numero Telefonico');
            }
            else if(!esTelefono($Telefono)){
                array_push($errores,"El telefono debe cumplir con el formato..");
            }

            if(estaVacio($Correo)||!isset($Correo)){
                array_push($errores,'Debes ingresar el Correo Electronico');
            }
            else if(!esMail($Correo)){
                array_push($errores,"formato del correo erroneo.");
            }

            if(estaVacio($Porcentaje_Comision)||!isset($Porcentaje_Comision)){
                array_push($errores,'Debes ingresar la Comision de la Empresa');
            }




            if(count($errores)==0){
                $this->model->updateEmpresa($Empresa);
                header('location:'.PATH.'/Empresas/Index');

            }
            else{
                $rubros = new RubrosModel();
                $viewBag['empresa']=$Empresa;
                $viewBag['errores']=$errores;
                $viewBag['rubros']=$rubros->get();
                $this->render("edit.php",$viewBag);
            }


            
        }
    }
    
    public function removeEmpleado($id){
        $this->model->removeEmpleado($id);
        //var_dump($id);
        header('location:'.PATH.'/Empresas/Empleados');
    }

}