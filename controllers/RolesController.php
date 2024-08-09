<?php

require_once "models/RolesModel.php";
require_once "models/PermissionModel.php";
require_once "models/ModulesModel.php";
require_once "models/LoginModel.php";
require_once "ValController.php";

class RolesController
{

    protected $db;
    protected $errors;
    protected $validation;
    protected $modules;
    protected $permissions;
    protected $panel;
    private $idModule;

    public function __construct()
    {
        session_start();
        if (empty($_SESSION["session"]["loggin_in"])) {
            $url = BASE_URL . "login";
            header("Location: $url");
            die();
        }

        $this->db = new RolesModel();
        $this->modules = new ModulesModel();
        $this->permissions = new PermissionModel();
        $this->validation = new ValController();
        $this->errors = array();
        $this->panel = new LoginModel();
        $this->idModule = $this->modules->getModuleId("roles");
    }

    public function index()
    {
        $data = array(
            "content" => "views/roles/roles.php",
            "title"    => "Administración de Roles",
            "roles"   => $this->db->getRoles(),
        );

        require_once "views/administration/administration2.php";
    }

    public function showRoles()
    {
        /* CRUD access from server */
        if (!$this->permissions->getAccessColumn($this->idModule, $_SESSION['session']['idRole'], "r")) {
            $this->errors["notAuthorized"] = "No Access";
            echo json_encode(array("statusCode" => 405, "errors" => $this->errors));
            /* return;  */
        } else {
            echo json_encode(array("roles" => $this->db->getRoles()));
        }
    }

    public function registerRole()
    {
        error_reporting(0);
        /* CRUD access from server */
        if (!$this->permissions->getAccessColumn($this->idModule, $_SESSION['session']['idRole'], "c")) {
            $this->errors["notAuthorized"] = "No Access";
            echo json_encode(array("statusCode" => 405, "errors" => $this->errors));
            return;
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $fileName = $_FILES["file"]["name"];
            $tmpName = $_FILES["file"]["tmp_name"];
            $fileSize = $_FILES["file"]["size"];
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $fileName = substr(md5(time()), 0, 10) . "." . $ext;

            $name     = $_POST["txtName"];
            $activo     = isset($_POST["chkState"]) ? 1 : 0;

            $this->validateName($name);
            $this->validateImage($ext, $fileSize);

            if ($this->errors) {
                echo json_encode(array("statusCode" => 500, "errors" => $this->errors));
            } else {
                move_uploaded_file($tmpName, "public/roles/" . $fileName);
                $dataRole = [
                    "image" => $fileName,
                    "name" => $name,
                    "state" => $activo,
                ];
                $this->db->save($dataRole);

                echo json_encode(array("statusCode" => 200));
            }
        } else {
            $url = BASE_URL .  ERROR_404;
            header("Location: $url");
        }
    }

    public function showRole($id)
    {
        $data = $this->db->getRoleId($id);
        echo json_encode(array("role" => $data));
    }

    public function updateRole($id)
    {
        error_reporting(0);
        /* CRUD access from server */
        if (!$this->permissions->getAccessColumn($this->idModule, $_SESSION['session']['idRole'], "u")) {
            $this->errors["notAuthorized"] = "No Access";
            echo json_encode(array("statusCode" => 405, "errors" => $this->errors));
            return;
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $fileName = $_FILES["file"]["name"];
            $tmpName = $_FILES["file"]["tmp_name"];
            $fileSize = $_FILES["file"]["size"];
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $fileName = substr(md5(time()), 0, 10) . "." . $ext;

            $name     = $_POST["txtName"];
            $activo     = isset($_POST["chkState"]) ? 1 : 0;

            $img = $_POST["txtImg"];

            $this->validateName($name);

            if ($tmpName != "") {
                $this->validateImage($ext, $fileSize);
                $dir = "public/roles/" . $img;
            } else {
                $fileName = $img;
                $dir = "";
            }

            if ($this->errors) {
                echo json_encode(array("statusCode" => 500, "errors" => $this->errors));
            } else {
                move_uploaded_file($tmpName, "public/roles/" . $fileName);
                if ($dir != "") {
                    unlink($dir);
                }
                unlink($dir);
                $dataRole = [
                    "image" => $fileName,
                    "name" => $name,
                    "state" => $activo,
                ];
                $this->db->update($dataRole, $id);

                echo json_encode(array("statusCode" => 200));
            }
        } else {
            $url = BASE_URL .  ERROR_404;
            header("Location: $url");
        }
    }


    public function setupPermissions($idRole)
    {
        $data = $this->modules->getAllResults();
        $tRows = "";
        $cont1 = 0;
        foreach ($data as $row) {
            if ($row["submodule"] == "") {
                $tRows .= "<tr>";
                $tRows .= "<td colspan='6' scope='row'> <strong>" . $row["description"] . "</strong></td>";
                $tRows .= "</tr>";
            } else {
                $cont1++;
                $tRows .= "<tr>";
                $tRows .= "<td scope='row'><input type='hidden' name='Module[]' value='" . $row["idModule"] . "' > " . $row["description"] . "</td>";
                $tRows .= "<td class='text-center'> 
                                <input class='form-check-input' type='checkbox' id='read" . ($cont1 - 1) . "' name = 'chkRead[" . ($cont1 - 1) . "]' " . $this->permissions->getPermissions($row["idModule"], $idRole, 'r') . ">
                            </td>";
                $tRows .= "<td class='text-center'> 
                                <input type='checkbox' class='form-check-input' id='create" . ($cont1 - 1) . "' name = 'chkCreate[" . ($cont1 - 1) . "]' " . $this->permissions->getPermissions($row["idModule"], $idRole, 'c') . ">
                            </td>";
                $tRows .= "<td class='text-center'>
                                <input type='checkbox' class='form-check-input' id='update" . ($cont1 - 1) . "' name = 'chkUpdate[" . ($cont1 - 1) . "]' " . $this->permissions->getPermissions($row["idModule"], $idRole, 'u') . ">
                            </td>";
                $tRows .= "<td class='text-center'> 
                                <input type='checkbox' class='form-check-input' id='delete" . ($cont1 - 1) . "' name = 'chkDelete[" . ($cont1 - 1) . "]' " . $this->permissions->getPermissions($row["idModule"], $idRole, 'd') . ">
                            </td>";
                $tRows .= "<td class='text-center'> 
                                <input type='checkbox' class='form-check-input' id='print" . ($cont1 - 1) . "' name = 'chkPrint[" . ($cont1 - 1) . "]' " . $this->permissions->getPermissions($row["idModule"], $idRole, 'p') . ">
                            </td>";
                $tRows .= "</tr>";
            }
        }
        $tRows .= "<tr></tr>";
        echo json_encode(array("modules" => $tRows));
    }

    public function updatePermissions($idRole)
    {
        error_reporting(0);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            try {
                $this->permissions->deletePermissions($idRole);

                $module     = $_POST["Module"];
                $create     = $_POST["chkCreate"];
                $read       = $_POST["chkRead"];
                $update     = $_POST["chkUpdate"];
                $delete     = $_POST["chkDelete"];
                $print      = $_POST["chkPrint"];

                for ($i = 0; $i < count($module); $i++) {
                    if (
                        $create[$i] == 0 &&
                        $read[$i] == 0 &&
                        $update[$i] == 0 &&
                        $delete[$i] == 0 &&
                        $print[$i] == 0
                    ) {
                        continue;
                    } else {
                        $data = [
                            "idModule" => $module[$i],
                            "idRole" => $idRole,
                            "c"         => empty($create[$i]) ? 0 : 1,
                            "r"         => empty($read[$i]) ? 0 : 1,
                            "u"         => empty($update[$i]) ? 0 : 1,
                            "d"         => empty($delete[$i]) ? 0 : 1,
                            "p"         => empty($print[$i]) ? 0 : 1,
                        ];
                        $this->permissions->savePermissions($data);
                    }
                }

                if ($_SESSION["session"]["idRole"] == $idRole) $_SESSION["session"]["user_modules"] = $this->panelList($idRole);

                echo json_encode(array("message" => "Permisos actualizados correctamente"));
            } catch (Exception $e) {
                echo json_encode(array("statusCode" => 500, "message" => $e->getMessage()));
            }
        } else {
            $url = BASE_URL .  ERROR_404;
            header("Location: $url");
        }
    }


    public function deleteRole($id)
    {
        /* CRUD access from server */
        if (!$this->permissions->getAccessColumn($this->idModule, $_SESSION['session']['idRole'], "d")) {
            $this->errors["notAuthorized"] = "No Access";
            echo json_encode(array("statusCode" => 405, "errors" => $this->errors));
            return;
        }

        $query  = $this->db->getRoleId($id);
        $dir = "public/roles/" . $query["image"];

        try {
            $this->db->delete($id);
            unlink($dir);
            echo json_encode(array("message" => "Datos eliminados correctamente"));
        } catch (Exception $e) {
            echo json_encode(array("message" => "Error al eliminar el registro"));
        }
    }


    private function validateName($value)
    {
        if (!$this->validation->validateRequired($value)) {
            $this->errors["name"] = "Debe ingresar un valor en name";
        }
        return $this->errors;
    }


    private function validateImage($ext, $img)
    {
        $extRight = array("jpg", "png", "jpeg", "gif");

        $max_file_size = "5000000"; //tamaño en bytes

        if (!in_array($ext, $extRight)) {
            $this->errors["image"] = "Extensión de archivo invalido o no se ha subido ningún valor";
        } else if ($img > $max_file_size) {
            $this->errors["image"] = "La image debe tener un tamaño inferior a 25MB";
        }
    }
    /* Client */
    function getAccessCRUD()
    {
        echo json_encode(array("access" => $this->permissions->getAccess($this->idModule, $_SESSION['session']['idRole'])));
    }

    public function panelList($idRole)
    {
        $chain = "";
        $module = $this->panel->getModule($idRole);
        foreach ($module as $mod) {
            $chain .= "<div class='item-menu'>";
            $chain .= "<a>";
            $chain .= $mod["icon"];
            $chain .= "<h3>" . $mod["description"] . "</h3></a>";

            $subModule = $this->panel->getSubModule($idRole, $mod["submodule"]);

            foreach ($subModule as $sub) {
                $chain .= "<a href='" . BASE_URL . $sub["url"] . "' class='sub sub-d'>";
                $chain .= "<h3>" . $sub["description"] . " </h3></a>";
            }
            $chain .= "</div>";
        }
        return $chain;
    }
}
