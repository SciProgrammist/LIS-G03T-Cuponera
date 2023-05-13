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

    public function OfertasEmpresa($id=''){
        if($id==''){
            $query="SELECT * FROM ofertas";
            return $this->getQuery($query);
        }else{
            $query="SELECT * FROM ofertas WHERE id_empresa=:id_empresa";
            return $this->getQuery($query,['id_empresa'=>$id]);
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

    public function CanjeCupon($id=''){
        if($id != ''){
            $query="SELECT C.ID_Cupon, O.Titulo_Oferta, O.Descripcion, E.Nombre_Empresa, E.ID_Empresa, U.Nombres, U.DUI, C.Estado_Cupon, C.Cantidad, SUM(O.Precio_Oferta*C.Cantidad) AS Total FROM cupones C 
			INNER JOIN ofertas O ON C.id_oferta = O.ID_Oferta
            INNER JOIN empresa E ON O.id_empresa = E.ID_Empresa
            INNER JOIN ordenes ORD ON C.id_orden = ORD.ID_Orden 
            INNER JOIN usuarios U  ON U.ID_Usuario = ORD.id_usuario 
            WHERE C.ID_Cupon = :ID_Cupon 
            GROUP BY C.ID_Cupon, O.Titulo_Oferta, O.Descripcion, C.Estado_Cupon";
            return $this->getQuery($query,['ID_Cupon'=>$id]);
        }
    }

    public function updateCupon($cupon=array()){
        $query="UPDATE cupones SET Estado_Cupon=:Estado_Cupon WHERE ID_Cupon=:ID_Cupon";
        return $this->setQuery($query,$cupon);
    }

    public function DatosOferta($id=''){
        if($id==''){
            $query = "SELECT O.Titulo_Oferta, E.Nombre_Empresa, SUM(C.Cantidad) AS Cantidad, O.Cantidad_Cupones, SUM(C.Cantidad*O.Precio_Oferta) AS Ingresos,  ROUND(SUM((C.Cantidad*O.Precio_Oferta)*(E.Porcentaje_Comision/100)),2) AS Cargo  FROM cupones C 
            INNER JOIN ofertas O ON C.id_oferta = O.ID_Oferta
            INNER JOIN empresa E ON O.id_empresa = E.ID_Empresa
            INNER JOIN ordenes ORD ON C.id_orden = ORD.ID_Orden  
            GROUP BY  O.Titulo_Oferta";
            return $this->getQuery($query);
        }else{
            $query= "SELECT O.Titulo_Oferta, E.Nombre_Empresa, SUM(C.Cantidad) AS Cantidad, O.Cantidad_Cupones, SUM(C.Cantidad*O.Precio_Oferta) AS Ingresos,  ROUND(SUM((C.Cantidad*O.Precio_Oferta)*(E.Porcentaje_Comision/100)),2) AS Cargo  FROM cupones C 
            INNER JOIN ofertas O ON C.id_oferta = O.ID_Oferta
            INNER JOIN empresa E ON O.id_empresa = E.ID_Empresa
            INNER JOIN ordenes ORD ON C.id_orden = ORD.ID_Orden 
            WHERE E.ID_Empresa =:ID_Empresa
            GROUP BY  O.Titulo_Oferta";
            return $this->getQuery($query,['ID_Empresa'=>$id]);
        }
    }

    public function updateOferta($oferta=array()){
        $query="UPDATE ofertas SET Titulo_Oferta=:Titulo_Oferta, Precio_Regular=:Precio_Regular, Precio_Oferta=:Precio_Oferta , Fecha_Inicio_Oferta=:Fecha_Inicio_Oferta, Fecha_Fin_Oferta=:Fecha_Fin_Oferta, Cantidad_Cupones=:Cantidad_Cupones, Descripcion=:Descripcion, Estado_Oferta=:Estado_Oferta, Justificacion=:Justificacion, id_empresa=:id_empresa WHERE ID_Oferta=:ID_Oferta";
        return $this->setQuery($query,$oferta);

    }

    public function updateOferta_2($oferta=array()){
        $query="UPDATE ofertas SET Titulo_Oferta=:Titulo_Oferta, Precio_Regular=:Precio_Regular, Precio_Oferta=:Precio_Oferta , Fecha_Inicio_Oferta=:Fecha_Inicio_Oferta, Fecha_Fin_Oferta=:Fecha_Fin_Oferta, Cantidad_Cupones=:Cantidad_Cupones, Descripcion=:Descripcion, Estado_Oferta=:Estado_Oferta, Justificacion=:Justificacion, Imagen=:Imagen, id_empresa=:id_empresa WHERE ID_Oferta=:ID_Oferta";
        return $this->setQuery($query,$oferta);

    }

    public function insertOferta($oferta=array()){
        $query="INSERT INTO ofertas VALUES (:ID_Oferta,:Titulo_Oferta,:Precio_Regular,:Precio_Oferta,:Fecha_Inicio_Oferta,:Fecha_Fin_Oferta,:Cantidad_Cupones,:Descripcion,:Estado_Oferta, :Justificacion, :Imagen, :id_empresa)";
        return $this->setQuery($query,$oferta);
    }


}