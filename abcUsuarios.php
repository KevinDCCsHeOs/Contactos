<?php
/*
Archivo:  abcContactos.php
Objetivo: edición sobre Contactos
Autor:    
*/

include_once("modelo/Usuario.php");

session_start();

$sErr = ""; 
$sOpe = ""; //Operacion a realizar
$sCve = ""; //Clave del usuario
$sNomBoton = "Borrar"; //titulo del boton de la operacion
$oUsu = new Usuario();
$bCampoEditable = false; 
$bLlaveEditable = false;

/* Verificar que haya sesión */
if (isset($_SESSION["usu"]) && !empty($_SESSION["usu"])){
    $oUsu = $_SESSION["usu"];
    
    /* Verificar datos de captura */
    if (isset($_POST["txtClave"]) && !empty($_POST["txtClave"]) &&
        isset($_POST["txtOpe"]) && !empty($_POST["txtOpe"])){
        
        $sOpe = $_POST["txtOpe"];
        $sCve = $_POST["txtClave"];
        
        if ($sOpe != 'a'){
            try{
                if (!$oUsu->buscar()){
                    $sError = "Contacto no existe";
                }
            }catch(Exception $e){
                error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
                $sErr = "Error en base de datos, comunicarse con el administrador :(";
            }
        }

        if ($sOpe == 'a'){
            $bCampoEditable = true;
            $bLlaveEditable = true;
            $sNomBoton = "Agregar";
        }
        else if ($sOpe == 'm'){
            $bCampoEditable = true;
            $sNomBoton = "Modificar";
        }
    }
    else{
        $sErr = "Faltan datos";
    }
}
else
    $sErr = "Falta establecer el login";

if ($sErr == ""){
    include_once("cabecera.html");
    include_once("menu.php");
    include_once("aside.html");
}
else{
    header("Location: error.php?sError=".$sErr);
    exit();
}
?>

        <section>
            <form name="abcUsuarios" action="resABCUsuarios.php" method="post">
                <input type="hidden" name="txtOpe" value="<?php echo $sOpe;?>">
                <input type="hidden" name="txtClave" value="<?php echo $sCve;?>"/>
                Nombre
                <input type="text" name="txtNombre"
                    <?php echo ($bCampoEditable==true?'':' disabled ');?>
                    value="<?php echo $oUsu->getNombre();?>"/>
                <br/>
                Teléfono
                <input type="text" name="txtTelefono"
                    <?php echo ($bCampoEditable==true?'':' disabled ');?>
                    value="<?php echo $oUsu->getTelefono();?>"/>
                <br/>
                Contraseña
                <input type="password" name="txtPassword"
                    <?php echo ($bCampoEditable==true?'':' disabled ');?>
                    value="<?php echo $oUsu->getPwd();?>"/>
                <br/>
                Tipo de Usuario
                <select name="cmbTipo" <?php echo ($bCampoEditable==true?'':' disabled ');?>>
                    <option value="1" <?php echo ($oUsu->getTipo()==1?'selected="true"':'');?>>Administrador</option>
                    <option value="2" <?php echo ($oUsu->getTipo()==2?'selected="true"':'');?>>Visualizador</option>
                </select>
                <br/>
                <input type="submit" value="<?php echo $sNomBoton;?>"/>
                <input type="submit" name="Submit" value="Cancelar"
                     onClick="abcUsuarios.action='tabusuarios.php';">
            </form>
        </section>

<?php
include_once("pie.html");
?>