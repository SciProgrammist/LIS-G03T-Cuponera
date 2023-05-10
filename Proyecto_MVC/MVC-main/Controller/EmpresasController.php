<?php
require_once 'Controller.php';
require_once './Core/validaciones.php';
require_once './Model/CuponesModel.php';
require_once './Model/EmpresaModel.php';
require_once './Model/RubrosModel.php';

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

    
    public function details($id){
        echo json_encode($this->model->get($id)[0]); //crea un json por medio de un arreglo
    }

    public function create(){
        $this->render("new.php");
    }

    public function add(){
        if(isset($_POST['Guardar'])){
            extract($_POST);
            $errores=array();
            $categoria=array();
            $viewBag=array();
            $categoria['ID_Categoria'] = "";
            $categoria['Categoria']=$Categoria;
                   

            if(estaVacio($Categoria)||!isset($Categoria)){
                array_push($errores,'Debes ingresar la categoria');
            }
            

            if(count($errores)==0){
               
                $this->model->insertCategorias($categoria);
                header('location:'.PATH.'/Categorias/Index');

            }
            else{
                $viewBag['errores']=$errores;
                $viewBag['categorias']=$Categoria;
                $this->render("new.php",$viewBag);
            }


            
        }
    }

    public function edit($id){
        $rubros = new RubrosModel();
        $viewBag=array();
        $Empresa=$this->model->get($id);
        $viewBag['empresa']=$Empresa[0];
        $viewBag['rubros']=$rubros->get();
        $this->render("edit.php",$viewBag);
    }

    public function update($id){
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




            if(count($errores)==0){
                $this->model->updateCategorias($categoria);
                header('location:'.PATH.'/Categorias/Index');

            }
            else{
                $categoria=$this->model->get($id);
                $viewBag['categoria']=$categoria[0];
                $viewBag['errores']=$errores;
                $this->render("edit.php",$viewBag);
            }


            
        }
    }
    
    public function remove($id){
        $this->model->removeCategorias($id);
        //var_dump($id);
        header('location:'.PATH.'/Categorias/Index');
    }

}