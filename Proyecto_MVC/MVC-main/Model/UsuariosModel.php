<?php
require_once 'Model.php';
class UsuariosModel extends Model{

    public function validateUser($correo,$pass){ 
        $query="SELECT ID_Usuario, Nombres, Correo, Estado, id_tipo_usuario FROM usuarios
        WHERE Correo=:Correo AND Pass=:Pass";
        return $this->getQuery($query,['Correo'=>$correo, 'Pass'=>$pass]);
    }

    public function CodigoUser($codigo){ 
        $query="SELECT ID_Usuario, Estado, Codigo FROM usuarios
        WHERE Codigo=:Codigo";
        return $this->getQuery($query,['Codigo'=>$codigo]);
    }

    public function ActivarUsuario($usuario=array()){ 
        $query="UPDATE usuarios SET  Estado=:Estado 
        WHERE ID_Usuario=:ID_Usuario AND Codigo=:Codigo";
        return $this->getQuery($query,$usuario);
    }


    public function get($id=''){ //Funcional
        if($id==''){
            $query="SELECT * FROM Usuarios";
            return $this->getQuery($query);
        }
        else{
            $query="SELECT * FROM Usuarios WHERE ID_Usuario=:ID_Usuario";
            return $this->getQuery($query,['ID_Usuario'=>$id]);
        }      
    }

    public function insertUsuario($usuario=array()){
        $query="INSERT INTO Usuarios VALUES (:ID_Usuario,:Nombres,:Apellidos,:Telefono,:Correo,:Direccion,:DUI,:Pass,:Estado,:Codigo,:id_tipo_usuario)";
        return $this->setQuery($query,$usuario);
    }

    /*public function updateUsuario($usuario=array()){
        $query="UPDATE usuarios SET Nombres=:Nombres, Apellidos=:Apellidos, Telefono=:Telefono, Correo=:Correo, Pass=:Pass, Estado=:Estado, id_tipo_usuario=:id_tipo_usuario  WHERE ID_Usuario=:ID_Usuario";
        return $this->setQuery($query,$usuario);

    }*/

}