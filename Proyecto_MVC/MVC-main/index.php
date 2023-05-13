<?php
include_once 'Core/config.php';
include_once 'Controller/UsuariosController.php';
include_once 'Controller/CuponesController.php';
include_once 'Controller/OrdenesController.php';
include_once 'Controller/EmpresasController.php';
include_once 'Controller/RubrosController.php';
$url=$_SERVER['REQUEST_URI'];
session_start();//Iniciando sesion
$url=explode("/",$url);
$controller=empty($url[3])?"Index":$url[3];
$controller.="Controller";
$method=empty($url[4])?"index":$url[4];
$param=empty($url[5])?"":$url[5];
$controlador=new $controller();
$controlador->$method($param);
