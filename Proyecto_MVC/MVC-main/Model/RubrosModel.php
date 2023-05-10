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

  
}