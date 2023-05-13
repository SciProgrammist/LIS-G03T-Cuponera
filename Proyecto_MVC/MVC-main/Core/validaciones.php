<?php
function estaVacio($var){
 return empty(trim($var));
}

function esTexto($var){
    return preg_match('/^[a-zA-Z ]+$/',$var);
}

function esMail($var){
    return filter_var($var,FILTER_VALIDATE_EMAIL);
}

function esTelefono($var){
    return preg_match('/^[267][0-9]{3}-?[0-9]{4}$/',$var);
}

function esTarjeta($var){
    return preg_match('/^5[1-5][0-9]{2}( ?[0-9]{4}){3}$/',$var);
}

function esDui($var){
    return preg_match('/^\d{8}-\d$/',$var);
}

function esCodigoEmpresa($var){
    return preg_match('/^EMP[0-9]{3}$/',$var);
}

?>