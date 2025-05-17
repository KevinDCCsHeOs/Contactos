<?php
/*
Archivo:  tabcontactos.php
Objetivo: consulta general sobre contactos y acceso a operaciones detalladas
Autor:    
*/

include_once("modelo/Usuario.php");
include_once("modelo/Contacto.php");

session_start();

$sErr = "";
$sNom = "";
$arrContactos = null;
$oUsu = new Usuario();
$oContacto = new Contacto();
$esAdmin = false;

/* Verificar que exista sesión */
if (isset($_SESSION["usu"]) && !empty($_SESSION["usu"])){
    $oUsu = $_SESSION["usu"];
    $sNom = $oUsu->getNombre();
    $esAdmin = ($oUsu->getTipo() == 1); // 1=Admin
    
    try{
        $arrContactos = $oContacto->buscarTodos($esAdmin, $oUsu->getClave());
    }catch(Exception $e){
        error_log($e->getFile()." ".$e->getLine()." ".$e->getMessage(),0);
        $sErr = "Error en base de datos, comunicarse con el administrador";
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
            <h3>Contactos</h3>
            <form name="formTablaGral" method="post" action="abcContactos.php">
                <input type="hidden" name="txtClave">
                <input type="hidden" name="txtOpe">
                <table border="1">
                    <tr>
                        <td>Clave</td>
                        <td>Nombre</td>
                        <td>Teléfono</td>
                        <td>Email</td>
                        <td>Operación</td>
                    </tr>
                    <?php
                        if ($arrContactos != null){
                            foreach($arrContactos as $oContacto){
                    ?>
                    <tr>
                        <td class="llave"><?php echo $oContacto->getIdContactos(); ?></td>
                        <td><?php echo $oContacto->getNombre(); ?></td>
                        <td><?php echo $oContacto->getTelefono(); ?></td>
                        <td><?php echo $oContacto->getEmail(); ?></td>
                        <td>
                            <input type="submit" name="Submit" value="Modificar" 
                                   onClick="txtClave.value=<?php echo $oContacto->getIdContactos(); ?>; txtOpe.value='m'">
                            <input type="submit" name="Submit" value="Borrar" 
                                   onClick="txtClave.value=<?php echo $oContacto->getIdContactos(); ?>; txtOpe.value='b'">
                        </td>
                    </tr>
                    <?php
                            } 
                        } else {
                    ?>    
                    <tr>
                        <td colspan="5">No hay contactos</td>
                    </tr>
                    <?php
                        }
                    ?>
                </table>
                <input type="submit" name="Submit" value="Crear Nuevo" 
                       onClick="txtClave.value='-1'; txtOpe.value='a'">
            </form>
        </section>

<?php
include_once("pie.html");
?>