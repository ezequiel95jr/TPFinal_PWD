<?php

class UsuarioRol extends BaseDatos {
    // ATRIBUTOS
    private $objUsuario; // Objeto de la clase Usuario
    private $objRol; // Objeto de la clase Rol
    private $mensajeOperacion;

    public function __construct() {
        parent::__construct();
        $this->objUsuario = new Usuario();
        $this->objRol = new Rol();
        $this->mensajeOperacion = "";
    }

    public function setear($objUsuario, $objRol) {
        $this->setObjUsuario($objUsuario);
        $this->setObjRol($objRol);
    }

    // SETTERS
    public function setObjUsuario($objUsuario) {
        $this->objUsuario = $objUsuario;
    }

    public function setObjRol($objRol) {
        $this->objRol = $objRol;
    }

    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    // GETTERS
    public function getObjUsuario() {
        return $this->objUsuario;
    }

    public function getObjRol() {
        return $this->objRol;
    }

    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    public function __toString() {
        return "Usuario ID: " . $this->getObjUsuario()->getIdUsuario() . "\nRol ID: " . $this->getObjRol()->getIdRol() . "\n";
    }

    public function cargar() {
        $resp = false;
        $sql = "SELECT * FROM usuariorol WHERE idusuario = " . $this->getObjUsuario()->getIdUsuario() . " AND idrol = " . $this->getObjRol()->getIdRol();
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $this->Registro();
                    $usuario = new Usuario();
                    $usuario->setIdUsuario($row['idusuario']);
                    $usuario->cargar();

                    $rol = new Rol();
                    $rol->setIdRol($row['idrol']);
                    $rol->cargar();

                    $this->setear($usuario, $rol);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("UsuarioRol->cargar: " . $this->getError());
        }
        return $resp;
    }

    public function insertar() {
        $resp = false;
        $sql = "INSERT INTO usuariorol(idusuario, idrol) VALUES (" . $this->getObjUsuario()->getIdUsuario() . "," . $this->getObjRol()->getIdRol() . ");";
        try {
            if ($this->Iniciar()) {
                if ($this->Ejecutar($sql)) {
                    $resp = true;
                } else {
                    $this->setMensajeOperacion("UsuarioRol->insertar: " . $this->getError());
                }
            } else {
                $this->setMensajeOperacion("UsuarioRol->insertar: " . $this->getError());
            }
        }
        catch (PDOException $e) {
            $this->setMensajeOperacion("Error al insertar: " . $e->getMessage());
        }
        return $resp;
    }

    public function modificar() {
        $resp = false;
        $sql = "UPDATE usuariorol SET idrol=" . $this->getObjRol()->getIdRol() . " WHERE idusuario=" . $this->getObjUsuario()->getIdUsuario();
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("UsuarioRol->modificar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("UsuarioRol->modificar: " . $this->getError());
        }
        return $resp;
    }

    public function eliminar() {
        $resp = false;
        $sql = "DELETE FROM usuariorol WHERE idusuario=" . $this->getObjUsuario()->getIdUsuario() . " AND idrol=" . $this->getObjRol()->getIdRol();
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("UsuarioRol->eliminar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("UsuarioRol->eliminar: " . $this->getError());
        }
        return $resp;
    }

    public function listar($parametro = "") {
        $arreglo = array();
        $sql = "SELECT * FROM usuariorol ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    while ($row = $this->Registro()) {
                        $obj = new UsuarioRol();
                        $obj->getObjUsuario()->setIdUsuario($row['idusuario']);
                        $obj->getObjRol()->setIdRol($row['idrol']);
                        $obj->cargar();
                        array_push($arreglo, $obj);
                    }
                }
            } else {
                $this->setMensajeOperacion("UsuarioRol->listar: " . $this->getError());
            }
        }
        return $arreglo;
    }
    
}

?>