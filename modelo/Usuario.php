<?php
/*
Archivo:  Usuario.php
Objetivo: clase que encapsula la información de un usuario
Autor:
*/

include_once("AccesoDatos.php");
//include_once("PersonalHospitalario.php");

class Usuario {
    private $nClave = 0;
    private $sPwd = "";
    private $sNombre = "";
    private $sTelefono = "";
    private $nTipo = 0; // 1=Admin, 2=Visualizador

    public function getNombre(){
        return $this->sNombre;
    }
    
    public function setNombre($valor){
        $this->sNombre = $valor;
    }
    
    public function getTelefono(){
        return $this->sTelefono;
    }
    
    public function setTelefono($valor){
        $this->sTelefono = $valor;
    }
    
    public function getClave(){
        return $this->nClave;
    }
    
    public function setClave($valor){
        $this->nClave = $valor;
    }
    
    public function getPwd(){
        return $this->sPwd;
    }
    
    public function setPwd($valor){
        $this->sPwd = $valor;
    }
    
    public function getTipo(){
        return $this->nTipo;
    }
    
    public function setTipo($valor){
        $this->nTipo = $valor;
    }

    /* Insertar, regresa el número de registros agregados */
    function insertar(){
        $oAccesoDatos = new AccesoDatos();
        $sQuery = "";
        $nAfectados = -1;

        if ($this->sNombre == "" || $this->nClave == 0)
            throw new Exception("Usuario->insertar(): faltan datos");
        else{
            if ($oAccesoDatos->conectar()){
                $sQuery = "INSERT INTO usuario (nombre, telefono, 
                                        contraseña, tipo)
                           VALUES ('".$this->sNombre."', 
                                   '".$this->sTelefono."',
                                   '".$this->sPwd."',
                                   ".$this->nTipo.")";
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
    
        if ($this->nClave == 0 || $this->sNombre == "")
            throw new Exception("Usuario->modificar(): faltan datos");
    
        if ($oAccesoDatos->conectar()){
            $sQuery = "UPDATE usuario
                       SET nombre = '".$this->sNombre."',
                           telefono = '".$this->sTelefono."',
                           contraseña = '".$this->sPwd."',
                           tipo = ".$this->nTipo."
                       WHERE id_usuario = ".$this->nClave;
    
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
    
        if ($this->nClave == 0)
            throw new Exception("Usuario->borrar(): faltan datos");
    
        if ($oAccesoDatos->conectar()){
            $sQuery = "DELETE FROM usuario 
                       WHERE id_usuario = ".$this->nClave;
    
            $nAfectados = $oAccesoDatos->ejecutarComando($sQuery);
            $oAccesoDatos->desconectar();
        }
        return $nAfectados;
    }

    public function buscarCvePwd(){
        $bRet = false;
        $sQuery = "";
        $arrRS = null;

        if (($this->nClave == 0 || $this->sPwd == ""))
            throw new Exception("Usuario->buscarCvePwd: faltan datos");
        else{
            $sQuery = "SELECT nombre, telefono, tipo
                       FROM usuario
                       WHERE id_usuario = ".$this->nClave."
                       AND contraseña = '".$this->sPwd."'";
            
            $oAD = new AccesoDatos();
            if ($oAD->conectar()){
                $arrRS = $oAD->ejecutarConsulta($sQuery);
                $oAD->desconectar();
                if ($arrRS != null){
                    $this->sNombre = $arrRS[0][0];
                    $this->sTelefono = $arrRS[0][1];
                    $this->nTipo = $arrRS[0][2];
                    $bRet = true;
                }
            }
        }
        return $bRet;
    }

    public function buscar(){
        $bRet = false;
        $sQuery = "";
        $arrRS = null;

        if (($this->nClave == 0 || $this->sPwd == ""))
            throw new Exception("Usuario->buscar: faltan datos");
        else{
            $sQuery = "SELECT nombre, telefono, tipo
                       FROM usuario
                       WHERE id_usuario = '".$this->nClave."'";
            
            $oAD = new AccesoDatos();
            if ($oAD->conectar()){
                $arrRS = $oAD->ejecutarConsulta($sQuery);
                $oAD->desconectar();
                if ($arrRS != null){
                    $this->sNombre = $arrRS[0][0];
                    $this->sTelefono = $arrRS[0][1];
                    $this->nTipo = $arrRS[0][2];
                    $bRet = true;
                }
            }
        }
        return $bRet;
    }

    function buscarTodosLosUsuarios(){
        $oAccesoDatos = new AccesoDatos();
        $sQuery = "";
        $arrRS = null;
        $aLinea = null;
        $j = 0;
        $oUsuario = null;
        $arrResultado = array(); 
        
        if ($oAccesoDatos->conectar()){
            $sQuery = "SELECT id_usuario,nombre,telefono,tipo
                       FROM usuario";
            
            // Si no es admin no mostrara nada
            if ($this->nTipo != 1) {return;}
            
            $sQuery .= " ORDER BY id_usuario ASC";
            
            $arrRS = $oAccesoDatos->ejecutarConsulta($sQuery);
            $oAccesoDatos->desconectar();
            
            if ($arrRS){
                foreach($arrRS as $aLinea){
                    $oUsuario = new Usuario();
                    $oUsuario->setClave($aLinea[0]);
                    $oUsuario->setNombre($aLinea[1]);
                    $oUsuario->setTelefono($aLinea[2]);
                    $oUsuario->setTipo($aLinea[3]);
                    $arrResultado[$j] = $oUsuario;
                    $j = $j + 1;
                }
            }
        }
        return $arrResultado;
    }
}
?>