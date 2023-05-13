<?php
require_once 'Controller.php';
require_once './Core/validaciones.php';
require_once './Model/CuponesModel.php';
require_once './Model/EmpresaModel.php';

class CuponesController extends Controller{

    private $model;

    function __construct(){
        $this->model=new CuponesModel();  
    }


    public function index(){ //Funciona
        $empresa = new EmpresaModel();
        $viewBag=array();
        $cupones=$this->model->get();
        $viewBag['cupones']=$cupones;
        $viewBag['empresas']=$empresa->get();
        //var_dump($viewBag);
        $this->render("index.php",$viewBag);
    }

    public function detalles(){
        $viewBag=array();
        $ofertas=$this->model->DatosOferta();
        $viewBag['ofertas']=$ofertas;
        $this->render("detalles.php",$viewBag);
    }

    public function detallesEmpresa($id){
        $viewBag=array();
        $ofertas=$this->model->DatosOferta($id);
        $viewBag['ofertas']=$ofertas;
        $this->render("detallesCuponesEmpresa.php",$viewBag);
    }



    public function details($id){ //Funciona
         echo json_encode($this->model->get($id)[0]); //crea un json por medio de un arreglo
    }

    public function Admin(){
    
        /*$categoriaModel = new CategoriasModel();
        $viewBag=array();
        $productos=$this->model->get();
        $viewBag['productos']=$productos;
        $viewBag['categorias']=$categoriaModel->get();
        //var_dump($viewBag);
        if($_SESSION['login_data']['id_tipo_usuario'] == 1){*/
        $empresa = new EmpresaModel();
        $viewBag = array();
        $ofertas = $this->model->get();
        $viewBag['empresas']=$empresa->get();
        $viewBag['ofertas']=$ofertas;
        $this->render("VistaAdmin.php",$viewBag);
        /*}elseif($_SESSION['login_data']['id_tipo_usuario'] == 2){
            $this->render("VistaEmpleado.php",$viewBag);
        }*/
        
    }

    /*public function Empleado(){
        $categoriaModel = new CategoriasModel();
        $viewBag=array();
        $productos=$this->model->get();
        $viewBag['productos']=$productos;
        $viewBag['categorias']=$categoriaModel->get();
        //var_dump($viewBag);
        $this->render("VistaEmpleado.php",$viewBag);
    }*/

    /*public function create(){
        $viewBag=array();
        $categoriaModel = new CategoriasModel();
        $viewBag['categorias']=$categoriaModel->get();
        //var_dump($viewBag);
        $this->render("new.php",$viewBag);
    }*/

    public function VerCarrito(){
        if(is_null($_SESSION['Carrito'])){
            header('location:'.PATH.'/Cupones/index');
        }else{
            $this->render("carrito.php");
        } 
    }

    public function VaciarCarrito(){
        unset($_SESSION['Carrito']);
        header('location:'.PATH.'/Cupones/index');
    }

    public function Eliminar($id){
        unset($_SESSION['Carrito'][$id]);
        header('location:'.PATH.'/Cupones/VerCarrito');
    }

    public function Carrito(){
        if(isset($_POST['Guardar'])){
            extract($_POST);

            //$id_empresa .= rand(1000000,9999999);


            $i = "";

           //var_dump($id_empresa);
           //unset($_SESSION['Carrito']);
           var_dump ($_SESSION['Carrito']);
          
            if(isset($_SESSION["Carrito"])){
                foreach($_SESSION["Carrito"] as $cupones => $cupon) {
                    if($cupones == $ID_Oferta){
                        $i = $ID_Oferta;
                        break;
                    }
                }
            }

            if($i == $ID_Oferta){
                $_SESSION["Carrito"][$ID_Oferta]["Cantidad"] += $Cantidad;
                //array_push($advertencias,'Producto Actualizado.');
                //$productos=$this->model->get();
                //$viewBag['productos']=$productos;
                //$viewBag['errores']=$advertencias;
                //$this->render("index.php",$viewBag);
                header('location:'.PATH.'/Cupones/index');
            }else {
                $id_empresa .= rand(1000000,9999999);
                $_SESSION["Carrito"][$ID_Oferta]["Codigo"] = $id_empresa;
                $_SESSION["Carrito"][$ID_Oferta]["Titulo"] = $Titulo_Oferta;
                $_SESSION["Carrito"][$ID_Oferta]["Precio_Regular"] = $Precio_Regular;
                $_SESSION["Carrito"][$ID_Oferta]["Precio_Oferta"] = $Precio_Oferta;
                $_SESSION["Carrito"][$ID_Oferta]["Cantidad"] = $Cantidad;
                /*array_push($advertencias,'Producto Ingresado.');
                $productos=$this->model->get();
                $viewBag['productos']=$productos;
                $viewBag['errores']=$advertencias;
                $this->render("index.php",$viewBag);*/
                header('location:'.PATH.'/Cupones/index');
               
            }
            
        }   
    }

    public function VerCupones(){
        if(!empty($_SESSION['login_data'])){
            $viewBag=array();
            $id = $_SESSION['login_data']['ID_Usuario'];
            $CuponesUser=$this->model->CuponesUsuario($id);
            $viewBag['cupones'] = $CuponesUser;
            $this->render("MisCupones.php",$viewBag);
        }else{
            header('location:'.PATH.'/Cupones/index');
        }
    }

     public function Create($id_empresa){
        $Empresa = new EmpresaModel();
        $viewBag=array();
        $viewBag['empresa']=$Empresa->get($id_empresa)[0];
        //var_dump($viewBag);
        $this->render("new.php",$viewBag);
    }
    public function add(){
        if(isset($_POST['Guardar'])){

            $archivo = $_FILES['Img']['name'];
            
            extract($_POST);
            $errores=array();
            $oferta=array();
            $viewBag=array();

            $oferta['ID_Oferta']="";
            $oferta['Titulo_Oferta']=$Titulo_Oferta;
            $oferta['Precio_Regular']=$Precio_Regular;
            $oferta['Precio_Oferta']=$Precio_Oferta;
            $oferta['Fecha_Inicio_Oferta']=$Fecha_Inicio_Oferta;
            $oferta['Fecha_Fin_Oferta']=$Fecha_Fin_Oferta;
            $oferta['Cantidad_Cupones']=$Cantidad_Cupones;
            $oferta['Descripcion']=$Descripcion;
            $oferta['Estado_Oferta']="En Espera";
            $oferta['Justificacion']="";
            //$oferta['Imagen']=$Imagen;
            $oferta['id_empresa']=$id_empresa;

            //var_dump($id_empresa);


            if(estaVacio($Titulo_Oferta)||!isset($Titulo_Oferta)){
                array_push($errores,'Debes ingresar un Titulo a la Oferta');
            }
            
            if(estaVacio($Precio_Regular)||!isset($Precio_Regular)){
                array_push($errores,'Debes ingresar el Precio Regular'); 
            }

            if(estaVacio($Precio_Oferta)||!isset($Precio_Oferta)){
                array_push($errores,'Debes ingresar el Precio de Oferta'); 
            }
            
            if(estaVacio($Fecha_Inicio_Oferta)||!isset($Fecha_Inicio_Oferta)){
                array_push($errores,'Debes ingresar Una Fecha de Inicio');
            }

            if(estaVacio($Fecha_Fin_Oferta)||!isset($Fecha_Fin_Oferta)){
                array_push($errores,'Debes ingresar Una Fecha Final');
            }

            if(estaVacio($Descripcion)||!isset($Descripcion)){
                array_push($errores,'Debes ingresar una Descripcion');
            }


            if(estaVacio($archivo)||!isset($archivo)){
                array_push($errores,'Debes ingresar una imagen');
            }

            if(isset($archivo) && $archivo != ""){

                $tipo = $_FILES['Img']['type'];
                $tamano = $_FILES['Img']['size'];
                $temp = $_FILES['Img']['tmp_name'];
                //var_dump($tipo);

                if (!((strpos($tipo, "jpg") || strpos($tipo, "png") || strpos($tipo, "jpeg")))) {
                    array_push($errores,'Error. La extensión o el tamaño de los archivos no es correcta.');
                }else{
                    if (move_uploaded_file($temp, './View/img/'.$archivo)) {
                        chmod('./View/img/'.$archivo.'', 0777);
                        $oferta['Imagen']=$archivo;
    
                    }else{
                        array_push($errores,'Ocurrió algún error al subir el fichero. No pudo guardarse.');
                    }
                }
            }
            
            if(count($errores)==0){
               
                $this->model->insertOferta($oferta);
                header('location:'.PATH.'/Empresas/Admin');

            }
            else{
                $Empresa = new EmpresaModel();
                $viewBag['errores']=$errores;
                $viewBag['oferta']=$oferta;
                $viewBag['empresa']=$Empresa->get($id_empresa)[0];
                $this->render("new.php",$viewBag);
            }


            
        }
    }

    public function edit($id){
        $viewBag=array();
        $oferta=$this->model->get($id);
        $empresa = new EmpresaModel();
        $viewBag['empresas']=$empresa->get();
        $viewBag['oferta']=$oferta[0];
        $this->render("edit.php",$viewBag);
    }

    public function EditCuponEmpresa($id){
        $viewBag=array();
        $oferta=$this->model->get($id);
        $empresa = new EmpresaModel();
        $viewBag['empresas']=$empresa->get();
        $viewBag['oferta']=$oferta[0];
        $this->render("EditCuponEmpresa.php",$viewBag);
    }

    public function update($id){
        if(isset($_POST['Guardar'])){

            $archivo = $_FILES['Img']['name'];
            
            extract($_POST);
            $errores=array();
            $oferta=array();
            $viewBag=array();

            $oferta['ID_Oferta']=$ID_Oferta;
            $oferta['Titulo_Oferta']=$Titulo_Oferta;
            $oferta['Precio_Regular']=$Precio_Regular;
            $oferta['Precio_Oferta']=$Precio_Oferta;
            $oferta['Fecha_Inicio_Oferta']=$Fecha_Inicio_Oferta;
            $oferta['Fecha_Fin_Oferta']=$Fecha_Fin_Oferta;
            $oferta['Cantidad_Cupones']=$Cantidad_Cupones;
            $oferta['Descripcion']=$Descripcion;
            $oferta['Estado_Oferta']=$Estado_Oferta;
            $oferta['Justificacion']=$Justificacion;
            //$oferta['Imagen']=$Imagen;
            $oferta['id_empresa']=$id_empresa;

            //var_dump($id_empresa);


            if(estaVacio($ID_Oferta)||!isset($ID_Oferta)){
                array_push($errores,'Debes ingresar el codigo de la Oferta');
            }

            if(estaVacio($Titulo_Oferta)||!isset($Titulo_Oferta)){
                array_push($errores,'Debes ingresar un Titulo a la Oferta');
            }
            
            if(estaVacio($Precio_Regular)||!isset($Precio_Regular)){
                array_push($errores,'Debes ingresar el Precio Regular'); 
            }

            if(estaVacio($Precio_Oferta)||!isset($Precio_Oferta)){
                array_push($errores,'Debes ingresar el Precio de Oferta'); 
            }
            
            if(estaVacio($Fecha_Inicio_Oferta)||!isset($Fecha_Inicio_Oferta)){
                array_push($errores,'Debes ingresar Una Fecha de Inicio');
            }

            if(estaVacio($Fecha_Fin_Oferta)||!isset($Fecha_Fin_Oferta)){
                array_push($errores,'Debes ingresar Una Fecha Final');
            }

            if(estaVacio($Descripcion)||!isset($Descripcion)){
                array_push($errores,'Debes ingresar una Descripcion');
            }

            if(isset($archivo) && $archivo != ""){

                $tipo = $_FILES['Img']['type'];
                var_dump($tipo);
                $tamano = $_FILES['Img']['size'];
                $temp = $_FILES['Img']['tmp_name'];

                if (!((strpos($tipo, "jpg") || strpos($tipo, "png") || strpos($tipo, "jpeg")))) {
                    array_push($errores,'Error. La extensión o el tamaño de los archivos no es correcta.');
                }else{
                    if (move_uploaded_file($temp, './View/img/'.$archivo)) {
                        chmod('./View/img/'.$archivo.'', 0777);
                        $oferta['Imagen']=$archivo;
    
                    }else{
                        array_push($errores,'Ocurrió algún error al subir el fichero. No pudo guardarse.');
                    }
                }
            }
            

            if(count($errores)==0){
                if($_SESSION['login_data']['id_tipo_usuario'] == 1){
                    if(!isset($oferta['Imagen']) || $oferta['Imagen'] ==""){
                        $this->model->updateOferta($oferta);
                        header('location:'.PATH.'/Cupones/Admin');
                    }else{
                        $this->model->updateOferta_2($oferta);
                        header('location:'.PATH.'/Cupones/Admin');
                    }
                }else{
                    if(!isset($oferta['Imagen']) || $oferta['Imagen'] ==""){
                        $this->model->updateOferta($oferta);
                        header('location:'.PATH.'/Empresas/Admin');
                    }else{
                        $this->model->updateOferta_2($oferta);
                        header('location:'.PATH.'/Empresas/Admin');
                    }
                }          
            }
            else{
                if($_SESSION['login_data']['id_tipo_usuario'] == 1){
                    $empresa = new EmpresaModel();
                    $viewBag['errores']=$errores;
                    $viewBag['oferta']=$oferta;
                    $viewBag['empresas']=$empresa->get();
                    $this->render("edit.php",$viewBag);
                }else{
                    $empresa = new EmpresaModel();
                    $viewBag['errores']=$errores;
                    $viewBag['oferta']=$oferta;
                    $viewBag['empresas']=$empresa->get();
                    $this->render("EditCuponEmpresa.php",$viewBag);
                }
            }


            
        }
    }

   /* public function remove($id){
        $this->model->removeProductos($id);
        //var_dump($id);
        header('location:'.PATH.'/Productos/Admin');
    }*/

}