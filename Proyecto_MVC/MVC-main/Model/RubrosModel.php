<?php
require_once 'Model.php';
class RubrosModel extends Model{

    public function get($id=''){
        if($id==''){
            $query="SELECT * FROM rubros";
            return $this->getQuery($query);
        }
        else{
            $query="SELECT * FROM rubros WHERE ID_Rubro=:ID_Rubro";
            return $this->getQuery($query,['ID_Rubro'=>$id]);
        }
       
        
    }

    public function insertRubros($rubro=array()){
        $query="INSERT INTO rubros VALUES (:ID_Rubro,:Nombre_Rubro)";
        return $this->setQuery($query,$rubro);

    }

    public function updateRubros($rubro=array()){
        $query="UPDATE rubros SET Nombre_Rubro=:Nombre_Rubro  WHERE ID_Rubro=:ID_Rubro";
        return $this->setQuery($query,$rubro);

    }

    public function removeRubros($id){
        $query="DELETE FROM rubros WHERE ID_Rubro=:ID_Rubro";
        return $this->setQuery($query,['ID_Rubro'=>$id]);
    }
  
}