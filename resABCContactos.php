<?php
/*
Archivo:  resABCContactos.php
Objetivo: ejecuta la afectación a contactos y retorna a la pantalla de consulta general
Autor:    
*/

include_once("modelo/Contacto.php");
include_once("modelo/Usuario.php");

session_start();

$sErr = ""; $sOpe = ""; $sCve = "";
$oContacto = new Contacto();
$oUsu = new Usuario();

/* Verificar que exista la sesión */
if (isset($_SESSION["usu"]) && !empty($_SESSION["usu"])){
    $oUsu = $_SESSION["usu"];
    
    /* Verifica datos de captura mínimos */
    if (isset($_POST["txtClave"]) && !empty($_POST["txtClave"]) &&
        isset($_POST["txtOpe"]) && !empty($_POST["txtOpe"])){
        
        $sOpe = $_POST["txtOpe"];
        $sCve = $_POST["txtClave"];
        $oContacto->setIdContactos($sCve);
        $oContacto->setIdUsuario($oUsu->getClave());
        
        if ($sOpe != "b"){
            $oContacto->setNombre($_POST["txtNombre"]);
            $oContacto->setDireccion($_POST["txtDireccion"]);
            $oContacto->setTelefono($_POST["txtTelefono"]);
            $oContacto->setEmail($_POST["txtEmail"]);
            $oContacto->setTipoUsuario($_POST["cmbTipo"]);
        }

        try{
            if ($sOpe == 'a'){
                $nResultado = $oContacto->insertar();
            }
            else if ($sOpe == 'b'){
                $nResultado = $oContacto->borrar();
            }
            else {
                $nResultado = $oContacto->modificar();
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
    header("Location: tabcontactos.php");
else
    header("Location: error.php?sError=".$sErr);
exit();
?>