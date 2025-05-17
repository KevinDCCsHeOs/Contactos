<?php
/*
Archivo:  abcContactos.php
Objetivo: edición sobre Contactos
Autor:    
*/

include_once("modelo/Contacto.php");
include_once("modelo/Usuario.php");

session_start();

$sErr = ""; $sOpe = ""; $sCve = ""; $sNomBoton = "Borrar";
$oContacto = new Contacto();
$oUsu = new Usuario();
$bCampoEditable = false; $bLlaveEditable = false;

/* Verificar que haya sesión */
if (isset($_SESSION["usu"]) && !empty($_SESSION["usu"])){
    $oUsu = $_SESSION["usu"];
    
    /* Verificar datos de captura */
    if (isset($_POST["txtClave"]) && !empty($_POST["txtClave"]) &&
        isset($_POST["txtOpe"]) && !empty($_POST["txtOpe"])){
        
        $sOpe = $_POST["txtOpe"];
        $sCve = $_POST["txtClave"];
        
        if ($sOpe != 'a'){
            $oContacto->setIdContactos($sCve);
            $oContacto->setIdUsuario($oUsu->getClave());
            try{
                if (!$oContacto->buscar()){
                    $sError = "Contacto no existe";
                }
            }catch(Exception $e){
                error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
                $sErr = "Error en base de datos, comunicarse con el administrador";
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
            <form name="abcContactos" action="resABCContactos.php" method="post">
                <input type="hidden" name="txtOpe" value="<?php echo $sOpe;?>">
                <input type="hidden" name="txtClave" value="<?php echo $sCve;?>"/>
                Nombre
                <input type="text" name="txtNombre"
                    <?php echo ($bCampoEditable==true?'':' disabled ');?>
                    value="<?php echo $oContacto->getNombre();?>"/>
                <br/>
                Dirección
                <input type="text" name="txtDireccion"
                    <?php echo ($bCampoEditable==true?'':' disabled ');?>
                    value="<?php echo $oContacto->getDireccion();?>"/>
                <br/>
                Teléfono
                <input type="text" name="txtTelefono"
                    <?php echo ($bCampoEditable==true?'':' disabled ');?>
                    value="<?php echo $oContacto->getTelefono();?>"/>
                <br/>
                Email
                <input type="email" name="txtEmail"
                    <?php echo ($bCampoEditable==true?'':' disabled ');?>
                    value="<?php echo $oContacto->getEmail();?>"/>
                <br/>
                Tipo de Usuario
                <select name="cmbTipo" <?php echo ($bCampoEditable==true?'':' disabled ');?>>
                    <option value="1" <?php echo ($oContacto->getTipoUsuario()==1?'selected="true"':'');?>>Personal</option>
                    <option value="2" <?php echo ($oContacto->getTipoUsuario()==2?'selected="true"':'');?>>Familiar</option>
                    <option value="3" <?php echo ($oContacto->getTipoUsuario()==3?'selected="true"':'');?>>Trabajo</option>
                </select>
                <br/>
                <input type="submit" value="<?php echo $sNomBoton;?>"/>
                <input type="submit" name="Submit" value="Cancelar"
                     onClick="abcContactos.action='tabcontactos.php';">
            </form>
        </section>

<?php
include_once("pie.html");
?>