<?php

require_once "ValController.php";
require_once "models/UserModel.php";
require_once "models/ModulesModel.php";
require_once "models/PermissionModel.php";

class UserController
{

    protected $db;
    protected $errors;
    protected $validation;

    protected $module;
    private $idModule;
    private $permissions;

    public function __construct()
    {
        session_start();
        if (empty($_SESSION["session"]["loggin_in"])) {
            $url = BASE_URL . "login";
            header("Location: $url");
            die();
        }

        $this->db = new UserModel();
        $this->validation = new ValController();
        $this->errors = array();

        $this->permissions = new PermissionModel();
        $this->module = new ModulesModel();
        $this->idModule = $this->module->getModuleId("user");
    }

    public function index()
    {
        $data = array(
            "content" => "views/users/user.php",
            "title" => "Administración de usuarios",
            "roles" => $this->db->getRoles(),
        );
        require_once "views/administration/administration2.php";
    }

    public function register()
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

            $name = $_POST['txtName'];
            $lastName = $_POST['txtLastName'];
            $dni = $_POST['txtDni'];
            $gender = $_POST['gender'];
            $bornDate = $_POST['dateBorn'];
            $email = $_POST['txtMail'];
            $phone = $_POST['txtPhone'];
            $roleId = $_POST['cboRole'];

            $this->validateName($name);
            $this->validateLastName($lastName);
            $this->validateDni($dni);
            $this->validateGender($gender);
            $this->validateEmail($email);
            $this->validatePhone($phone);
            $this->validateRole($roleId);
            $this->validateImage($ext, $fileSize);

            if ($this->errors) {
                echo json_encode(array("statusCode" => 500, "errors" => $this->errors));
                return;
            }

            move_uploaded_file($tmpName, "public/users/" . $fileName);

            $dataPersona = array(
                'name' => $name,
                'avatar' => $fileName,
                'lastName' => $lastName,
                'dni' => $dni,
                'gender' => $gender,
                'bornDate' => $bornDate,
                'email' => $email,
                'phone' => $phone,
                'roleId' => $roleId

            );

            try {
                $this->db->save($dataPersona);
                $_SESSION["message"] = "Usuario registrado correctamente";
                echo json_encode(array("statusCode" => 200));
            } catch (Exception $e) {
                $this->errors["exception"] = $e->getMessage();
                echo json_encode(array("statusCode" => 500, "errors" => $this->errors));
            }
        } else {

            $url = BASE_URL .  ERROR_404;
            header("Location: $url");
        }
    }

    public function update($id)
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

            $name = $_POST['txtName'];
            $lastName = $_POST['txtLastName'];
            $dni = $_POST['txtDni'];
            $gender = $_POST['gender'];
            $bornDate = $_POST['dateBorn'];
            $email = $_POST['txtMail'];
            $phone = $_POST['txtPhone'];
            $roleId = $_POST['cboRole'];

            $img = $_POST["txtImg"];

            $this->validateName($name);
            $this->validateLastName($lastName);
            $this->validateDni($dni);
            $this->validateGender($gender);
            $this->validateEmail($email);
            $this->validatePhone($phone);
            $this->validateRole($roleId);

            if ($tmpName != "") {
                $this->validateImage($ext, $fileSize);
                $dir = "public/users/" . $img;
            } else {
                $fileName = $img;
                $dir = "";
            }

            if ($this->errors) {
                echo json_encode(array("statusCode" => 500, "errors" => $this->errors));
                return;
            }

            move_uploaded_file($tmpName, "public/users/" . $fileName);
            if ($dir != "") {
                unlink($dir);
            }
            unlink($dir);
            $dataPersona = array(
                'name' => $name,
                'lastName' => $lastName,
                'dni' => $dni,
                'gender' => $gender,
                'bornDate' => $bornDate,
                'email' => $email,
                'phone' => $phone,
                'roleId' => $roleId,
                'avatar' => $fileName
            );

            try {
                $this->db->update($dataPersona, $id);
                $_SESSION["message"] = "Usuario actualizado correctamente";
                echo json_encode(array("statusCode" => 200));
            } catch (Exception $e) {
                $this->errors["exception"] = $e->getMessage();
                echo json_encode(array("statusCode" => 500, "errors" => $this->errors));
            }
        } else {

            $url = BASE_URL .  ERROR_404;
            header("Location: $url");
        }
    }

    public function showUsers()
    {
        /* CRUD access from server */
        if (!$this->permissions->getAccessColumn($this->idModule,$_SESSION['session']['idRole'],"r")){
            $this->errors["notAuthorized"] = "No Access";
            echo json_encode(array("statusCode" => 405, "errors" => $this->errors));
            /* return;  */
        }else{
            echo json_encode(array("users" => $this->db->getUsers()));
        }
    }

    public function showUser($id)
    {
        echo json_encode(array("user" => $this->db->getUserId($id)));
    }

    public function delete($id)
    {
        /* CRUD access from server */
        if (!$this->permissions->getAccessColumn($this->idModule, $_SESSION['session']['idRole'], "d")) {
            $this->errors["notAuthorized"] = "No Access";
            echo json_encode(array("statusCode" => 405, "errors" => $this->errors));
            return;
        }
        try {
            $this->db->delete($id);
            echo json_encode(array("message" => "Usuario eliminado correctamente"));
        } catch (Exception $e) {
            echo json_encode(array("message" => "Error al eliminar el usuario"));
        }
    }

    public function menu($idRole)
    {
        $cadena = "";
        $module = $this->db->getModule($idRole);
        foreach ($module as $mod) {

            $cadena .= "<a href='" . BASE_URL . $mod["url"] . "'>" . $mod["description"] . "";
            $cadena .= "<i class='menu-item has-child'>";
            $cadena .= $mod["icon"];
            $cadena .= "<h3'>" . $mod["description"] . "</h3></a>";
            $cadena .= "</i>";
        }
        return $cadena;
    }

    public function validateName($name)
    {
        if (!$this->validation->validateRequired($name)) {
            $this->errors["name"] = "El nombre es requerido";
        }
    }

    public function validateLastName($lastName)
    {
        if (!$this->validation->validateRequired($lastName)) {
            $this->errors["lastName"] = "El apellido es requerido";
        }
    }

    public function validateDni($dni)
    {
        $options = array(
            "options" => array(
                "min_range" => 8,
                "max_range" => 8
            )
        );
        if (!$this->validation->validateRequired($dni)) {
            $this->errors["dni"] = "El DNI es requerido";
        } else if (!$this->validation->validateLength($dni, $options)) {
            $this->errors["dni"] = "El DNI debe tener 8 dígitos";
        }
    }

    public function validateGender($gender)
    {
        if (!$this->validation->validateRequired($gender)) {
            $this->errors["gender"] = "El género es requerido";
        }
    }

    public function validateBornDate($bornDate)
    {
        if (new DateTime($bornDate) > new DateTime()) {
            $this->errors["bornDate"] = "La fecha de nacimiento no puede ser mayor a la fecha actual";
        }
    }

    public function validateEmail($email)
    {
        if (!$this->validation->validateRequired($email)) {
            $this->errors["mail"] = "El correo electrónico es requerido";
        } else if (!$this->validation->validateEmail($email)) {
            $this->errors["mail"] = "El correo electrónico no es válido";
        }
    }

    public function validatePhone($phone)
    {
        $options = array(
            "options" => array(
                "min_range" => 9,
                "max_range" => 9
            )
        );
        if (!$this->validation->validateRequired($phone)) {
            $this->errors["phone"] = "El teléfono es requerido";
        } else if (!$this->validation->validateLength($phone, $options)) {
            $this->errors["phone"] = "El teléfono debe tener 9 dígitos";
        }
    }

    public function validateRole($roleId)
    {
        if (!$this->validation->validateRequired($roleId)) {
            $this->errors["role"] = "El rol es requerido";
        }
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
}
