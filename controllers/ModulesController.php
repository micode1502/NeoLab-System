<?php

require_once "ValController.php";
require_once "models/ModulesModel.php";
require_once "models/PermissionModel.php";

class ModulesController
{

    protected $db;
    protected $errors;
    protected $validation;

    private $permissions;
    private $idModule;

    public function __construct()
    {
        session_start();
        if (empty($_SESSION["session"]["loggin_in"])) {
            $url = BASE_URL . "login";
            header("Location: $url");
            die();
        }
        $this->db = new ModulesModel();
        $this->validation = new ValController();
        $this->errors = array();

        $this->permissions = new PermissionModel();
        $this->idModule = $this->db->getModuleId("modules");
    }

    public function index()
    {
        $data = array(
            "content" => "views/modules/modules.php",
            "title"    => "Administración de Módulos",
            "modules"   => $this->db->getSubModules(),
            "records" => $this->db->getAllResults(),
        );
        require_once "views/administration/administration2.php";
    }

    public function viewModules()
    {
        error_reporting(0);
        /* CRUD access from server */
        if (!$this->permissions->getAccessColumn($this->idModule,$_SESSION['session']['idRole'],"r")){
            $this->errors["notAuthorized"] = "No Access";
            echo json_encode(array("statusCode" => 405, "errors" => $this->errors));
            /* return;  */
        } else{
            echo json_encode(array("modules" => $this->db->getAllResults()));
        }
    }

    public function registerModules()
    {
        error_reporting(0);

        /* CRUD access from server */
        if (!$this->permissions->getAccessColumn($this->idModule, $_SESSION['session']['idRole'], "c")) {
            $this->errors["notAuthorized"] = "No Access";
            echo json_encode(array("statusCode" => 405, "errors" => $this->errors));
            return;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $tipeOption = $_POST["cboOption"];
            $icon       = $_POST["txtIcon"];
            $cboModule  = $_POST["cboModule"];
            $url        = $_POST["txtUrl"];
            $description = $_POST["txtDescription"];

            if ($tipeOption == 1) {
                $this->validateIcon($icon);
                $this->validateDescription($description);
            } else {
                $this->validateDescription($description);
                $this->validateURL($url);
            }

            if ($this->errors) {
                echo json_encode(array("statusCode" => 500, "errors" => $this->errors));
            } else {

                if ($tipeOption == 1) {
                    $dataModule = [
                        "description" => $description,
                        "icon"        => $icon,
                    ];
                    $this->db->saveModule($dataModule);
                } else {
                    $dataSubModule = [
                        "description" => $description,
                        "url"         => $url,
                        "submodule"   => $cboModule
                    ];
                    $this->db->saveSubModule($dataSubModule);
                }
                echo json_encode(array("statusCode" => 200));
            }
        } else {
            $data["contenido"] = ERROR_404;
            require_once "views/modules/modules.php";
        }
    }

    public function viewModuleID($id)
    {

        echo json_encode(array("data" => $this->db->getResultID($id)));
    }

    public function updateModules($id)
    {
        error_reporting(0);
        /* CRUD access from server */
        if (!$this->permissions->getAccessColumn($this->idModule, $_SESSION['session']['idRole'], "u")) {
            $this->errors["notAuthorized"] = "No Access";
            echo json_encode(array("statusCode" => 405, "errors" => $this->errors));
            return;
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $tipeOption = $_POST["cboOption"];
            $icon       = $_POST["txtIcon"];
            $cboModule  = $_POST["cboModule"];
            $url        = $_POST["txtUrl"];
            $description = $_POST["txtDescription"];

            if ($tipeOption == 1) {
                $this->validateIcon($icon);
                $this->validateDescription($description);
            } else {
                $this->validateDescription($description);
                $this->validateURL($url);
            }

            if ($this->errors) {
                echo json_encode(array("statusCode" => 500, "errors" => $this->errors));
            } else {

                if ($tipeOption == 1) {
                    $dataModule = [
                        "description" => $description,
                        "icon"        => $icon,
                    ];
                    $this->db->updateModule($id, $dataModule);
                } else {
                    $dataSubModule = [
                        "description" => $description,
                        "url"         => $url,
                        "submodule"   => $cboModule
                    ];
                    $this->db->updateSubModule($id, $dataSubModule);
                }

                echo json_encode(array("statusCode" => 200));
            }
        } else {
            $data["content"] = ERROR_404;
            require_once "views/users/modules.php";
        }
    }

    public function delete($id)
    {
        error_reporting(0);
        /* CRUD access from server */
        if (!$this->permissions->getAccessColumn($this->idModule, $_SESSION['session']['idRole'], "d")) {
            $this->errors["notAuthorized"] = "No Access";
            echo json_encode(array("statusCode" => 405, "errors" => $this->errors));
            return;
        }
        try {
            if ($this->db->deleteModule($id)) {
                echo json_encode(array("mensaje" => "Datos eliminados correctamente"));
            }
        } catch (Exception $e) {
            echo json_encode(array("mensaje" => "Error al eliminar los datos"));
        }
    }

    private function validateIcon($valor)
    {
        if (!$this->validation->validateRequired($valor)) {
            $this->errors["icon"] = "Debe ingresar un valor en ICON";
        }
        return $this->errors;
    }

    private function validateDescription($valor)
    {
        if (!$this->validation->validateRequired($valor)) {
            $this->errors["description"] = "Debe ingresar un valor en DESCRIPCION";
        }
    }

    private function validateURL($valor)
    {
        if (!$this->validation->validateRequired($valor)) {
            $this->errors["url"] = "Debe ingresar un valor en URL";
        }
    }

    /* Client */
    function getAccessCRUD()
    {
        echo json_encode(array("access" => $this->permissions->getAccess($this->idModule, $_SESSION['session']['idRole'])));
    }
}
