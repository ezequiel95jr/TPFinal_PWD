<?php

class Menu extends BaseDatos {
    // ATRIBUTOS
    private $idMenu;
    private $meNombre;
    private $meDescripcion;
    private $idPadre; // Será un objeto Menu
    private $meDeshabilitado;
    private $mensajeOperacion;

    public function __construct() {
        parent::__construct();
        $this->idMenu = "";
        $this->meNombre = "";
        $this->meDescripcion = "";
        $this->idPadre = null;
        $this->meDeshabilitado = null;
        $this->mensajeOperacion = "";
    }

    public function setear($idMenu, $meNombre, $meDescripcion, $idPadre, $meDeshabilitado) {
        $this->setIdMenu($idMenu);
        $this->setMeNombre($meNombre);
        $this->setMeDescripcion($meDescripcion);
        $this->setIdPadre($idPadre);
        $this->setMeDeshabilitado($meDeshabilitado);
    }

    // SETTERS
    public function setIdMenu($idMenu) {
        $this->idMenu = $idMenu;
    }

    public function setMeNombre($meNombre) {
        $this->meNombre = $meNombre;
    }

    public function setMeDescripcion($meDescripcion) {
        $this->meDescripcion = $meDescripcion;
    }

    public function setIdPadre($idPadre) {
        // Asumimos que $idPadre es un objeto Menu
        $this->idPadre = $idPadre;
    }

    public function setMeDeshabilitado($meDeshabilitado) {
        $this->meDeshabilitado = $meDeshabilitado;
    }

    public function setMensajeOperacion($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    // GETTERS
    public function getIdMenu() {
        return $this->idMenu;
    }

    public function getMeNombre() {
        return $this->meNombre;
    }

    public function getMeDescripcion() {
        return $this->meDescripcion;
    }

    public function getIdPadre() {
        // Retornamos el objeto Menu
        return $this->idPadre;
    }

    public function getMeDeshabilitado() {
        return $this->meDeshabilitado;
    }

    public function getMensajeOperacion() {
        return $this->mensajeOperacion;
    }

    public function __toString() {
        return ("ID del menú: " . $this->getIdMenu() . "\nNombre: " . $this->getMeNombre() . "\nDescripción: " . $this->getMeDescripcion() . "\n");
    }

    public function cargar() {
        $resp = false;
        $sql = "SELECT * FROM menu WHERE idmenu = " . $this->getIdMenu();
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $this->Registro();
                    $objPadre = null;
                    if ($row['idpadre'] != null) {
                        $objPadre = new Menu();
                        $objPadre->setIdMenu($row['idpadre']);
                        $objPadre->cargar();
                    }
                    $resp = true;
                    $this->setear($row['idmenu'], $row['menombre'], $row['medescripcion'], $objPadre, $row['medeshabilitado']);
                }
            }
        } else {
            $this->setMensajeOperacion("Menu->cargar: " . $this->getError());
        }
        return $resp;
    }

    public function insertar() {
        $resp = false;
        $sql = "INSERT INTO menu(menombre, medescripcion, idpadre, medeshabilitado) VALUES (
            '" . $this->getMeNombre() . "', 
            '" . $this->getMeDescripcion() . "', 
            " . ($this->getIdPadre() !== null ? $this->getIdPadre()->getIdMenu() : 'NULL') . ", 
            " . ($this->getMeDeshabilitado() !== null ? "'" . $this->getMeDeshabilitado() . "'" : 'NULL') . "
        );";
        if ($this->Iniciar()) {
            if ($elid = $this->Ejecutar($sql)) {
                $this->setIdMenu($elid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("Menu->insertar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("Menu->insertar: " . $this->getError());
        }
        return $resp;
    }

    public function modificar() {
        $resp = false;
        $sql = "UPDATE menu SET 
            menombre='" . $this->getMeNombre() . "', 
            medescripcion='" . $this->getMeDescripcion() . "', 
            idpadre=" . ($this->getIdPadre() != null ? $this->getIdPadre()->getIdMenu() : 'NULL') . ", 
            medeshabilitado=" . ($this->getMeDeshabilitado() != null ? "'" . $this->getMeDeshabilitado() . "'" : 'NULL') . " 
            WHERE idmenu=" . $this->getIdMenu();
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Menu->modificar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("Menu->modificar: " . $this->getError());
        }
        return $resp;
    }

    public function eliminar() {
        $resp = false;
        $sql = "DELETE FROM menu WHERE idmenu=" . $this->getIdMenu();
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("Menu->eliminar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("Menu->eliminar: " . $this->getError());
        }
        return $resp;
    }

    public function listar($parametro = "") {
        $arreglo = array();
        $sql = "SELECT * FROM menu";
        if ($parametro != "") {
            $sql .= ' WHERE ' . $parametro;
        }

        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    while ($row = $this->Registro()) {
                        $objMenu = new Menu();
                        $objPadre = null;
                        if ($row['idpadre'] != null) {
                            $objPadre = new Menu();
                            $objPadre->setIdMenu($row['idpadre']);
                            $objPadre->cargar();
                        }
                        $objMenu->setear($row['idmenu'], $row['menombre'], $row['medescripcion'], $objPadre, $row['medeshabilitado']);
                        $arreglo[] = $objMenu;
                    }
                }
            } else {
                $this->setMensajeOperacion("Menu->listar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("Menu->listar: " . $this->getError());
        }

        return $arreglo;
    }

}

?>