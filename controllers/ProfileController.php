<?php

require_once "models/ProfileModel.php";
require_once "ValController.php";

class ProfileController
{
    protected $db;
    protected $errors;
    protected $validation;
    public function __construct()
    {

        session_start();
        if (empty($_SESSION["session"]["loggin_in"])) {
            $url = BASE_URL . "login";
            header("Location: $url");
            die();
        }
        $this->db = new ProfileModel();
        $this->errors = array();
        $this->validation = new ValController();
    }

    public function index()
    {
        $data = array(
            "content" => "views/users/profile.php",
            "title" => "Usuario",
            "user" => $this->db->getUser($_SESSION["session"]["username"]),
        );
        require_once "views/administration/administration2.php";
    }

    public function updateUser($id)
    {
        error_reporting(0);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $fileName = $_FILES["file"]["name"];
            $tmpName = $_FILES["file"]["tmp_name"];
            $fileSize = $_FILES["file"]["size"];
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $fileName = substr(md5(time()), 0, 10) . "." . $ext;

            $username = $_POST['txtUsername'];
            $password = $_POST['txtPassword'];

            $img = $_POST["txtImg"];


            if ($tmpName != "") {
                $this->validateImage($ext, $fileSize);
                $dir = "public/users/" . $img;
            } else {
                $fileName = $img;
                $dir = "";
            }

            $this->validateUsername($username);
            $this->validatePassword($password);


            if ($this->errors) {
                echo json_encode(array("statusCode" => 500, "errors" => $this->errors));
                return;
            }

            move_uploaded_file($tmpName, "public/users/" . $fileName);
            if ($dir != "") {
                unlink($dir);
            }
            unlink($dir);
            $data = array(
                "username" => $username,
                "password" => $password,
                'avatar' => $fileName
            );

            try {
                $this->db->updateUser($data, $id);
                $_SESSION["message"] = "Usuario actualizado correctamente";
                echo json_encode(array("statusCode" => 200));
                $_SESSION["session"]["username"] = $username;
                $_SESSION["session"]["avatar"] = $fileName;
            } catch (Exception $e) {
                $this->errors["exception"] = $e->getMessage();
                echo json_encode(array("statusCode" => 500, "errors" => $this->errors));
            }
        } else {

            $url = BASE_URL .  ERROR_404;
            header("Location: $url");
        }
    }

    public function validateUsername($phone)
    {
        $options = array(
            "options" => array(
                "min_range" => 5,
                "max_range" => 30
            )
        );
        if (!$this->validation->validateRequired($phone)) {
            $this->errors["username"] = "El usuario es requerido";
        } else if (!$this->validation->validateLength($phone, $options)) {
            $this->errors["username"] = "El usuario debe tener entre 5 y 30 caracteres";
        }
    }

    public function validatePassword($pwd)
    {
        if (!$this->validation->validateRequired($pwd)) {
            $this->errors["password"] = "El rol es requerido";
        } else if (!$this->validation->validatePasswordStrength($pwd)) {
            $this->errors["password"] = "La contraseña debe tener al menos 8 caracteres, una letra mayúscula, una minúscula, un número y un carácter especial";
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
}
