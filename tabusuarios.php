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
$arrUsuarios = null;
$oUsusuario = new Usuario();
$esAdmin = false;

/* Verificar que exista sesión */
if (isset($_SESSION["usu"]) && !empty($_SESSION["usu"])){
    $oUsuario = $_SESSION["usu"];
    $sNom = $oUsuario->getNombre();
    $esAdmin = ($oUsuario->getTipo() == 1); // 1=Admin
    
    try{
        $arrUsuarios = $oUsuario->buscarTodosLosUsuarios();
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
            <h3>Usuarios</h3>
            <form name="formTablaGral" method="post" action="abcUsuarios.php">
                <input type="hidden" name="txtClave">
                <input type="hidden" name="txtOpe">
                <table border="1">
                    <tr>
                        <td>Clave</td>
                        <td>Nombre</td>
                        <td>Teléfono</td>
                        <td>tipo</td>
                        <td>Operación</td>
                    </tr>
                    <?php
                        if ($arrUsuarios != null){
                            foreach($arrUsuarios as $oUsuario){
                    ?>
                    <tr>
                        <td class="llave"><?php echo $oUsuario->getClave(); ?></td>
                        <td><?php echo $oUsuario->getNombre(); ?></td>
                        <td><?php echo $oUsuario->getTelefono(); ?></td>
                        <td><?php echo ($oUsuario->getTipo()==1)?'Administrador':'Visualizador'; ?></td>
                        <td>
                            <input type="submit" name="Submit" value="Modificar" 
                                   onClick="txtClave.value=<?php echo $oUsuario->getClave(); ?>; txtOpe.value='m'">
                            <input type="submit" name="Submit" value="Borrar" 
                                   onClick="txtClave.value=<?php echo $oUsuario->getClave(); ?>; txtOpe.value='b'">
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