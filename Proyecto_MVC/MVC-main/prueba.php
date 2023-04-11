<?php
include_once 'Model/UsuariosModel.php';

$model = new UsuariosModel();
$datos = ['ID_Usuario'=>'','Nombres'=>'Marco','Apellidos'=>'Lopez','Telefono'=>'62096080','Correo'=>'marcolopez@outlook.com', 'Direccion'=>'Por la casa', 'DUI'=>'0602021-4','Pass'=>'123456','id_tipo_usuario'=>4];
$model->insertUsuario($datos);
var_dump($datos);
var_dump($model->get());
?>