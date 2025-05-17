<?php
/*
Archivo:  Contacto.php
Objetivo: clase que encapsula la información de un contacto
Autor:    
*/

class Contacto {
    private $id_contactos = 0;
    private $nombre = "";
    private $direccion = "";
    private $telefono = "";
    private $email = "";
    private $tipo_usuario = 0;
    private $id_usuario = 0;

    // Getters y Setters
    public function getIdContactos(){
        return $this->id_contactos;
    }
    
    public function setIdContactos($valor){
        $this->id_contactos = $valor;
    }
    
    public function getNombre(){
        return $this->nombre;
    }
    
    public function setNombre($valor){
        $this->nombre = $valor;
    }
    
    public function getDireccion(){
        return $this->direccion;
    }
    
    public function setDireccion($valor){
        $this->direccion = $valor;
    }
    
    public function getTelefono(){
        return $this->telefono;
    }
    
    public function setTelefono($valor){
        $this->telefono = $valor;
    }
    
    public function getEmail(){
        return $this->email;
    }
    
    public function setEmail($valor){
        $this->email = $valor;
    }
    
    public function getTipoUsuario(){
        return $this->tipo_usuario;
    }
    
    public function setTipoUsuario($valor){
        $this->tipo_usuario = $valor;
    }
    
    public function getIdUsuario(){
        return $this->id_usuario;
    }
    
    public function setIdUsuario($valor){
        $this->id_usuario = $valor;
    }

    /* Busca por clave, regresa verdadero si lo encontró */
    function buscar(){
        $oAccesoDatos = new AccesoDatos();
        $sQuery = "";
        $arrRS = null;
        $bRet = false;

        if ($this->id_contactos == 0)
            throw new Exception("Contacto->buscar(): faltan datos");
        else{
            if ($oAccesoDatos->conectar()){
                $sQuery = "SELECT nombre, direccion, telefono, email, 
                                  tipo_usuario, id_usuario
                           FROM contactos
                           WHERE id_contactos = ".$this->id_contactos;
                $arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
                $oAccesoDatos->desconectar();
                if ($arrRS){
                    $this->nombre = $arrRS[0][0];
                    $this->direccion = $arrRS[0][1];
                    $this->telefono = $arrRS[0][2];
                    $this->email = $arrRS[0][3];
                    $this->tipo_usuario = $arrRS[0][4];
                    $this->id_usuario = $arrRS[0][5];
                    $bRet = true;
                }
            }
        }
        return $bRet;
    }

    /* Insertar, regresa el número de registros agregados */
    function insertar(){
        $oAccesoDatos = new AccesoDatos();
        $sQuery = "";
        $nAfectados = -1;

        if ($this->nombre == "" || $this->id_usuario == 0)
            throw new Exception("Contacto->insertar(): faltan datos");
        else{
            if ($oAccesoDatos->conectar()){
                $sQuery = "INSERT INTO contactos (nombre, direccion, telefono, 
                                        email, tipo_usuario, id_usuario)
                           VALUES ('".$this->nombre."', 
                                   '".$this->direccion."',
                                   '".$this->telefono."',
                                   '".$this->email."',
                                   ".$this->tipo_usuario.",
                                   ".$this->id_usuario.")";
                $nAfectados = $oAccesoDatos->ejecutarComando($sQuery);
                $oAccesoDatos->desconectar();
            }
        }
        return $nAfectados;
    }

    /* Modificar, regresa el número de registros modificados */
    function modificar(){
        $oAccesoDatos = new AccesoDatos();
        $sQuery = "";
        $nAfectados = -1;
        $oUsu = isset($_SESSION["usu"]) ? $_SESSION["usu"] : null;
    
        if ($this->id_contactos == 0 || $this->nombre == "")
            throw new Exception("Contacto->modificar(): faltan datos");
    
        if ($oAccesoDatos->conectar()){
            $sQuery = "UPDATE contactos
                       SET nombre = '".$this->nombre."',
                           direccion = '".$this->direccion."',
                           telefono = '".$this->telefono."',
                           email = '".$this->email."',
                           tipo_usuario = ".$this->tipo_usuario."
                       WHERE id_contactos = ".$this->id_contactos;
            
            // Solo agregar condición de usuario si NO es admin
            if ($oUsu && $oUsu->getTipo() != 1) {
                $sQuery .= " AND id_usuario = ".$oUsu->getClave();
            }
    
            $nAfectados = $oAccesoDatos->ejecutarComando($sQuery);
            $oAccesoDatos->desconectar();
        }
        return $nAfectados;
    }

    /* Borrar, regresa el número de registros eliminados */
    function borrar(){
        $oAccesoDatos = new AccesoDatos();
        $sQuery = "";
        $nAfectados = -1;
        $oUsu = isset($_SESSION["usu"]) ? $_SESSION["usu"] : null;
    
        if ($this->id_contactos == 0)
            throw new Exception("Contacto->borrar(): faltan datos");
    
        if ($oAccesoDatos->conectar()){
            $sQuery = "DELETE FROM contactos 
                       WHERE id_contactos = ".$this->id_contactos;
            
            // Solo agregar condición de usuario si NO es admin
            if ($oUsu && $oUsu->getTipo() != 1) { 
                $sQuery .= " AND id_usuario = ".$oUsu->getClave();
            }
    
            $nAfectados = $oAccesoDatos->ejecutarComando($sQuery);
            $oAccesoDatos->desconectar();
        }
        return $nAfectados;
    }

    /* Busca todos los registros de contactos para un usuario (o todos si es admin) */
    function buscarTodos($esAdmin = false, $idUsuario = 0){
        $oAccesoDatos = new AccesoDatos();
        $sQuery = "";
        $arrRS = null;
        $aLinea = null;
        $j = 0;
        $oContacto = null;
        $arrResultado = array(); 
        
        if ($oAccesoDatos->conectar()){
            $sQuery = "SELECT id_contactos, nombre, direccion, telefono,
                              email, tipo_usuario, id_usuario
                       FROM contactos";
            
            // Si no es admin, filtrar por id_usuario
            if (!$esAdmin && $idUsuario > 0) {
                $sQuery .= " WHERE id_usuario = ".$idUsuario;
            }
            
            $sQuery .= " ORDER BY nombre";
            
            $arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
            $oAccesoDatos->desconectar();
            
            if ($arrRS){
                foreach($arrRS as $aLinea){
                    $oContacto = new Contacto();
                    $oContacto->setIdContactos($aLinea[0]);
                    $oContacto->setNombre($aLinea[1]);
                    $oContacto->setDireccion($aLinea[2]);
                    $oContacto->setTelefono($aLinea[3]);
                    $oContacto->setEmail($aLinea[4]);
                    $oContacto->setTipoUsuario($aLinea[5]);
                    $oContacto->setIdUsuario($aLinea[6]);
                    $arrResultado[$j] = $oContacto;
                    $j = $j + 1;
                }
            }
        }
        return $arrResultado;
    }
}
?>