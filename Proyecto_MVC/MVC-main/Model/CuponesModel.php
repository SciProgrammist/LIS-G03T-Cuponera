<?php
require_once 'Model.php';
class CuponesModel extends Model{

   
    public function get($id=''){ //Funcional
        if($id==''){
            $query="SELECT * FROM ofertas";
            return $this->getQuery($query);
        }
        else{
            $query="SELECT * FROM ofertas WHERE ID_Oferta=:ID_Oferta";
            return $this->getQuery($query,['ID_Oferta'=>$id]);
        }      
    }

    public function CuponesUsuario($id=''){
        if($id !=''){
            $query="SELECT C.ID_Cupon, O.Titulo_Oferta, O.Descripcion, C.Estado_Cupon, C.Cantidad, SUM(O.Precio_Oferta*C.Cantidad) AS Total FROM cupones C INNER JOIN ofertas O ON C.id_oferta = O.ID_Oferta 
            INNER JOIN ordenes ORD ON C.id_orden = ORD.ID_Orden 
            INNER JOIN usuarios U  ON U.ID_Usuario = ORD.id_usuario WHERE U.ID_Usuario = :ID_Usuario 
            GROUP BY C.ID_Cupon, O.Titulo_Oferta, O.Descripcion, C.Estado_Cupon";
            return $this->getQuery($query,['ID_Usuario'=>$id]);
        }

    }

}