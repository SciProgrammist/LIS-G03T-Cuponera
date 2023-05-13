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

    public function insertEmpresa($empresa=array()){
        $query="INSERT INTO empresa VALUES (:ID_Empresa,:Nombre_Empresa,:Direccion,:Nombre_Contacto,:Telefono,:Correo,:Pass,:Rubro,:Porcentaje_Comision,:id_tipo_usuario)";
        return $this->setQuery($query,$empresa);
    }

    public function getEmpleado($id){
        $query="SELECT * FROM `empleados` WHERE id_empresa =:id_empresa";
        return $this->getQuery($query,['id_empresa'=>$id]);
    }

    public function insertEmpleado($empleado=array()){
        $query="INSERT INTO empleados VALUES (:ID_Empleado,:Nombres,:Apellidos,:Correo,:Pass,:id_empresa,:id_tipo_usuario)";
        return $this->setQuery($query,$empleado);
    }

    public function updateEmpleado($empleado=array()){
        $query="UPDATE empleados SET Nombres=:Nombres, Apellidos=:Apellidos, Correo=:Correo WHERE ID_Empleado=:ID_Empleado";
        return $this->setQuery($query,$empleado);
    }

    public function removeEmpleado($id){
        $query="DELETE FROM empleados WHERE ID_Empleado=:ID_Empleado";
        return $this->setQuery($query,['ID_Empleado'=>$id]);
    }

}