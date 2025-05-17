<?php
/*
Archivo:  login.php
Objetivo: verifica clave y contraseña contra repositorio a través de clases
Autor:  
*/

include_once("modelo/Usuario.php");

session_start();

$sErr = "";
$sCve = "";
$sNom = "";
$sPwd = "";
$oUsu = new Usuario();

/* Verificar que hayan llegado los datos */
if (isset($_POST["txtCve"]) && !empty($_POST["txtCve"]) &&
    isset($_POST["txtPwd"]) && !empty($_POST["txtPwd"])){
    
    $sCve = $_POST["txtCve"];
    $sPwd = $_POST["txtPwd"];
    $oUsu->setClave($sCve);
    $oUsu->setPwd($sPwd);
    
    try{
        if ($oUsu->buscarCvePwd()){
            $sNom = $oUsu->getNombre();
            $_SESSION["usu"] = $oUsu;
            
            if ($oUsu->getTipo() == 1)
                $_SESSION["tipo"] = "Administrador";
            else
                $_SESSION["tipo"] = "Visualizador";
        }
        else{
            $sErr = "Usuario desconocido";
        }
    }catch(Exception $e){
        error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
        $sErr = "Error al acceder a la base de datos";
    }
}
else
    $sErr = "Faltan datos";

if ($sErr == "")
    header("Location: inicio.php");
else
    header("Location: error.php?sError=".$sErr);
?>