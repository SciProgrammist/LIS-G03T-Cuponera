<?php

abstract class Controller{

    public function render($view,$viewBag=array()){
     $file="View/".static::class."/$view";
       $file=str_replace("Controller","",$file);
       if(is_file($file)){
        extract($viewBag);
        ob_start();//Abriendo el buffer
        require($file);
        $content=ob_get_contents();
        ob_end_clean();//Limpiando y cerrando el buffer
        echo $content;
       }
       else{
        echo "No existe esta vista";
       }
        
       

    }
} 