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

    /*public function updateUsuario($usuario=array()){
        $query="UPDATE usuarios SET Nombres=:Nombres, Apellidos=:Apellidos, Telefono=:Telefono, Correo=:Correo, Pass=:Pass, Estado=:Estado, id_tipo_usuario=:id_tipo_usuario  WHERE ID_Usuario=:ID_Usuario";
        return $this->setQuery($query,$usuario);

    }*/

}