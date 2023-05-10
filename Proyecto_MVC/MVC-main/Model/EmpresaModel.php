<?php
require_once 'Model.php';
class EmpresaModel extends Model{

   
    public function get($id=''){ //Funcional
        if($id==''){
            $query="SELECT * FROM empresa";
            return $this->getQuery($query);
        }
        else{
            $query="SELECT * FROM empresa WHERE ID_Empresa=:ID_Empresa";
            return $this->getQuery($query,['ID_Empresa'=>$id]);
        }      
    }

    public function updateEmpresa($empresa=array()){
        $query="UPDATE empresa SET Nombre_Empresa=:Nombre_Empresa, Direccion=:Direccion, Nombre_Contacto=:Nombre_Contacto, Telefono=:Telefono, Correo=:Correo, Rubro=:Rubro, Porcentaje_Comision=:Porcentaje_Comision  WHERE ID_Empresa=:ID_Empresa";
        return $this->setQuery($query,$empresa);

    }

}