<?php
require_once 'Controller.php';
require_once './Model/OrdenesModel.php';
require_once './Core/validaciones.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';

class OrdenesController extends Controller{

    private $model;

    function __construct(){
        
        $this->model=new OrdenesModel();
       
    }

    public function add(){
        if(isset($_POST['Guardar'])){

            extract($_POST);
            $errores=array();
            $orden=array();
            $orden['ID_Orden'] = "";
            $orden['id_usuario']=$usuario;
            $orden['Total'] = $total;
            $orden['Fecha']= $fecha;
            $orden['Tarjeta']=$tarjeta;

           

            if(estaVacio($tarjeta)||!isset($tarjeta)){
                array_push($errores,'Debes ingresar la Tarjeta de Credito.');
            }
            elseif(!esTarjeta($tarjeta)){
                array_push($errores,'La tarjeta ingresada no es valida.');
            }

            if(count($errores)==0){
               
                $this->model->insertOrdenes($orden);
                $Ordenes=$this->model->get();
                $UltimaOrden = end($Ordenes);
                //var_dump($UltimaOrden['ID_Orden']);
                $ordencupones=array();
                foreach($_SESSION["Carrito"] as $cupones => $cupon){
                    $ordencupones['ID_Cupon'] = $cupon['Codigo'];
                    $ordencupones['id_oferta'] = $cupones;
                    $ordencupones['id_orden'] = $UltimaOrden['ID_Orden'];
                    $ordencupones['Estado_Cupon'] = "Disponible";
                    $ordencupones['Cantidad'] = $cupon["Cantidad"];
                    //var_dump($ordencupones);
                    $this->model->insertCupones($ordencupones);
                }

                $Correo = $_SESSION['login_data']['Correo'];

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
                    $mail->Subject = 'Confirmacion de compra';
                    $mail->Body    = 'Ha realizado la compra con exito.';
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                
                    $mail->send();
                    
                    header('location:'.PATH.'/Cupones/index');
                    unset($_SESSION['Carrito']);
    
                    //session_destroy();
                } catch (Exception $e) {
                    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    echo "<script>alert('Hubo un problema volver a interntarlo');</script>";
                    header('location:'.PATH.'/Cupones/index');
                }

            }
            else{
                
                header('location:'.PATH.'/Cupones/VerCarrito');
            }


            
        }
    }


}