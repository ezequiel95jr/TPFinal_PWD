<?php

class MenuRol extends BaseDatos {
    // ATRIBUTOS
    private $objMenu; // Objeto de la clase Menu
    private $objRol;  // Objeto de la clase Rol
    private $mensajeOperacion;

    public function __construct()
    {
        $this->objMenu = null;
        $this->objRol = null;
        $this->mensajeOperacion = "";
    }

    public function setear($menu, $rol)
    {
        $this->setObjMenu($menu);
        $this->setObjRol($rol);
    }

    // SETTERS
    public function setObjMenu($menu)
    {
        $this->objMenu = $menu;
    }

    public function setObjRol($rol)
    {
        $this->objRol = $rol;
    }

    public function setMensajeOperacion($mensajeOperacion)
    {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    // GETTERS
    public function getObjMenu()
    {
        return $this->objMenu;
    }

    public function getObjRol()
    {
        return $this->objRol;
    }

    public function getMensajeOperacion()
    {
        return $this->mensajeOperacion;
    }

    public function cargar() {
        $resp = false;
        $sql = "SELECT * FROM menurol WHERE idmenu = " . $this->getObjMenu()->getIdMenu() . " AND idrol = " . $this->getObjRol()->getIdRol();

        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $this->Registro();
                    // Cargar el objeto Menu
                    $menu = null;
                    if ($row['idmenu'] != null) {
                        $menu = new Menu();
                        $menu->setIdMenu($row['idmenu']);
                        $menu->cargar();
                    }
                    // Cargar el objeto Rol
                    $rol = null;
                    if ($row['idrol'] != null) {
                        $rol = new Rol();
                        $rol->setIdRol($row['idrol']);
                        $rol->cargar();
                    }
                    $this->setear($menu, $rol);
                    $resp = true;
                }
            } else {
                $this->setMensajeOperacion("menurol->cargar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("menurol->cargar: " . $this->getError());
        }
        return $resp;
    }

    public function insertar() {
        $resp = false;
        $sql = "INSERT INTO menurol (idmenu, idrol) VALUES (" . $this->getObjMenu()->getIdMenu() . ", " . $this->getObjRol()->getIdRol() . ")";
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("menurol->insertar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("menurol->insertar: " . $this->getError());
        }
        return $resp;
    }

    public function modificar() {
        $resp = false;
        $sql = "UPDATE menurol SET idrol = " . $this->getObjRol()->getIdRol() . " WHERE idmenu = " . $this->getObjMenu()->getIdMenu();
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("menurol->modificar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("menurol->modificar: " . $this->getError());
        }
        return $resp;
    }

    public function eliminar() {
        $resp = false;
        $sql = "DELETE FROM menurol WHERE idmenu = " . $this->getObjMenu()->getIdMenu() . " AND idrol = " . $this->getObjRol()->getIdRol();
        if ($this->Iniciar()) {
            if ($this->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion("menurol->eliminar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("menurol->eliminar: " . $this->getError());
        }
        return $resp;
    }

    public function listar($parametro = "") {
        $arreglo = [];
        $sql = "SELECT * FROM menurol";
        if ($parametro != "") {
            $sql .= " WHERE " . $parametro;
        }
        if ($this->Iniciar()) {
            $res = $this->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    while ($row = $this->Registro()) {
                        $menu = null;
                        if ($row['idmenu'] != null) {
                            $menu = new Menu();
                            $menu->setIdMenu($row['idmenu']);
                            $menu->cargar();
                        }
                        $rol = null;
                        if ($row['idrol'] != null) {
                            $rol = new Rol();
                            $rol->setIdRol($row['idrol']);
                            $rol->cargar();
                        }
                        $obj = new MenuRol();
                        $obj->setear($menu, $rol);
                        array_push($arreglo, $obj);
                    }
                }
            } else {
                $this->setMensajeOperacion("menurol->listar: " . $this->getError());
            }
        } else {
            $this->setMensajeOperacion("menurol->listar: " . $this->getError());
        }
        return $arreglo;
    }

}


?>