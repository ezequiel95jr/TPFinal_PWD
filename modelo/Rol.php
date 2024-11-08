<?php

class Rol extends BaseDatos {
    // ATRIBUTOS
    private $idRol;
    private $roDescripcion;
    private $mensajeOperacion;

    public function __construct() {
        parent::__construct();
        $this->idRol = "";
        $this->roDescripcion = "";
        $this->mensajeOperacion = "";
    }

    public function setear($idRol, $roDescripcion) {
        $this->setIdRol($idRol);
        $this->setRoDescripcion($roDescripcion);
    }

    // SETTERS
    public function setIdRol($idRol) {
        $this->idRol = $idRol;
    }

    public function setRoDescripcion($roDescripcion) {
        $this->roDescripcion = $roDescripcion;
    }

    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    // GETTERS
    public function getIdRol() {
        return $this->idRol;
    }

    public function getRoDescripcion() {
        return $this->roDescripcion;
    }

    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    public function __toString() {
        return ("ID del rol: " . $this->getIdRol() . "\nDescripción del rol: " . $this->getRoDescripcion() . "\n");
    }

    public function cargar() {
        $resp = false;
        $sql = "SELECT * FROM rol WHERE idrol = " . $this->getIdRol();
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $this->Registro();
                    $this->setear($row['idrol'], $row['rodescripcion']);
                    $resp = true;
                }
            }
        } else {
            $this->setMensajeOperacion("Rol->cargar: " . $this->getError());
        }
        return $resp;
    }

    public function insertar() {
        $resp = false;
        $sql = "INSERT INTO rol(rodescripcion) VALUES ('" . $this->getRoDescripcion() . "');";
        if ($this->Iniciar()) {
            if ($elid = $this->Ejecutar($sql)) {
                $this->setIdRol($elid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("Rol->insertar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("Rol->insertar: " . $this->getError());
        }
        return $resp;
    }

    public function modificar() {
        $resp = false;
        $sql = "UPDATE rol SET rodescripcion='" . $this->getRoDescripcion() . "' WHERE idrol=" . $this->getIdRol();
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Rol->modificar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("Rol->modificar: " . $this->getError());
        }
        return $resp;
    }

    public function eliminar() {
        $resp = false;
        $sql = "DELETE FROM rol WHERE idrol=" . $this->getIdRol();
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Rol->eliminar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("Rol->eliminar: " . $this->getError());
        }
        return $resp;
    }

    public function listar($parametro = "") {
        $arreglo = array();
        $sql = "SELECT * FROM rol ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    while ($row = $this->Registro()) {
                        $obj = new Rol();
                        $obj->setIdRol($row['idrol']);
                        $obj->cargar();
                        array_push($arreglo, $obj);
                    }
                }
            } else {
                $this->setMensajeOperacion("Rol->listar: " . $this->getError());
            }
        }
        return $arreglo;
    }
    
}

?>