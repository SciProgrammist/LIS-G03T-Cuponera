<?php
require_once 'Controller.php';
require_once './Core/validaciones.php';
require_once './Model/CuponesModel.php';
require_once './Model/EmpresaModel.php';
require_once './Model/RubrosModel.php';

class RubrosController extends Controller{

    private $model;

    function __construct(){
        
        $this->model=new RubrosModel();
       
    }

    public function index(){
        $viewBag=array();
        $rubros=$this->model->get();
        $viewBag['rubros']=$rubros;
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
            $Rubro=array();
            $viewBag=array();

            $Rubro['ID_Rubro']='';
            $Rubro['Nombre_Rubro']=$Nombre_Rubro;
            

            if(estaVacio($Nombre_Rubro)||!isset($Nombre_Rubro)){
                array_push($errores,'Debes ingresar el nombre del Rubro');
            }elseif(!esTexto($Nombre_Rubro)){
                array_push($errores,'Solo Texto');
            }

            
            if(count($errores)==0){
               
                $this->model->insertRubros($Rubro);
                header('location:'.PATH.'/Rubros/Index');

            }
            else{
                $viewBag['errores']=$errores;
                $viewBag['rubro']=$Rubro;
                $this->render("new.php",$viewBag);
            }


            
        }
    }

    public function edit($id){ //Funciona
        
        $viewBag=array();
        $Rubros=$this->model->get($id);
        $viewBag['rubro']=$Rubros[0];
        $this->render("edit.php",$viewBag);
    }

    public function update($id){ //Funciona
        if(isset($_POST['Guardar'])){
            extract($_POST);
            $errores=array();
            $rubro=array();
            $viewBag=array();

            $rubro['ID_Rubro']=$ID_Rubro;
            $rubro['Nombre_Rubro']=$Nombre_Rubro;
            

            if(estaVacio($Nombre_Rubro)||!isset($Nombre_Rubro)){
                array_push($errores,'Debes ingresar el Rubro');
            }
            elseif(!esTexto($Nombre_Rubro)){
                array_push($errores,'Solo letras');
            }

            if(count($errores)==0){
                $this->model->updateRubros($rubro);
                header('location:'.PATH.'/Rubros/Index');

            }
            else{
                $viewBag['errores']=$errores;
                $viewBag['rubro']=$rubro;
                $this->render("edit.php",$viewBag);
            }


            
        }
    }
    
    public function remove($id){
        $this->model->removeRubros($id);
        //var_dump($id);
        header('location:'.PATH.'/Rubros/Index');
    }

}