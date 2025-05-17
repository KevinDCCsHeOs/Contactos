<?php
/*
Archivo:  resABCContactos.php
Objetivo: ejecuta la afectación a contactos y retorna a la pantalla de consulta general
Autor:    
*/

include_once("modelo/Usuario.php");

session_start();

$sErr = ""; 
$sOpe = ""; 
$sCve = "";
$oUsu = new Usuario();

/* Verificar que exista la sesión */
if (isset($_SESSION["usu"]) && !empty($_SESSION["usu"])){
    $oUsu = $_SESSION["usu"];
    
    /* Verifica datos de captura mínimos */
    if (isset($_POST["txtClave"]) && !empty($_POST["txtClave"]) &&
        isset($_POST["txtOpe"]) && !empty($_POST["txtOpe"])){
        
        $sOpe = $_POST["txtOpe"];
        $sCve = $_POST["txtClave"];
        $oUsu->setClave($sCve);
        
        if ($sOpe != "b"){
            $oUsu->setNombre($_POST["txtNombre"]);
            $oUsu->setTelefono($_POST["txtTelefono"]);
            $oUsu->setPwd($_POST["txtPassword"]);
            $oUsu->setTipo($_POST["cmbTipo"]);
        }

        try{
            if ($sOpe == 'a'){
                $nResultado = $oUsu->insertar();
            }
            else if ($sOpe == 'b'){
                $nResultado = $oUsu->borrar();
            }
            else {
                $nResultado = $oUsu->modificar();
            }
            
            if ($nResultado != 1){
                $sError = "Error en bd";
            }
        }catch(Exception $e){
            error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
            $sErr = "Error en base de datos, comunicarse con el administrador";
        }
    }
    else{
        $sErr = "Faltan datos";
    }
}
else
    $sErr = "Falta establecer el login";

if ($sErr == "")
    header("Location: tabusuarios.php");
else
    header("Location: error.php?sError=".$sErr);
exit();
?>