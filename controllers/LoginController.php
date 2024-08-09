<?php
require_once "models/LoginModel.php";
require_once "ValController.php";

class LoginController
{
    protected $db;
    protected $validation;
    protected $errors;

    public function __construct()
    {
        session_start();
        $this->db = new LoginModel();
        $this->validation = new ValController();
        $this->errors = array();
    }

    public function index()
    {
        if (isset($_COOKIE["tokenLogin"])){
            //no eliminar, es un codigo en caso de emergencias
            /* if( strlen($_COOKIE["tokenLogin"]) == 0 ){
                $this->loginUToken();
                return;
            } */
            $username = $this->getSavedLogin($_COOKIE["tokenLogin"]);
            $consult = $this->db->getList($username);
            if ($consult["state"] == 1 && $consult["user_state"] == 1) {
                $data_session = [
                    "username"  => $username,
                    "loggin_in" => 1,
                    "avatar"    => $consult["avatar"],
                    "role"      => $consult["roleN"],
                    "idRole"    => $consult["idRole"],
                    "user_modules"  => $this->panelList($consult["idRole"])
                ];
                $_SESSION["session"] = $data_session;
                $url = BASE_URL . "";
                header("Location: $url");
                return;
            }else if (isset($consult) && $consult["state"] == 1) {
                $data["msj_login"] = "Usuario deshabilitado. Contactarse con el administrador";
            } else if (isset($consult)) {
                $data["msj_login"] = "Rol deshabilitado. Contactarse con el administrador";
            }
            $data["csrf_token"] = $_SESSION['csrf_token'];
            require_once "views/login/login.php";
            return;
        }
        //Permite que al actualizar la pagina el token se actualice y genere de manera aleatoria
        $this->loginUToken();
    }

    public function loginUToken()
    {
        // bin2hex genera un cadena binaria de 32 bytes aleatoriamente
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        $data = array("csrf_token" => $_SESSION['csrf_token']);
        require_once "views/login/login.php";
    }

    public function validate()
    {   
        //Token CSRF:en un sistema de inicio de sesión ayuda a prevenir que un atacante utilice 
        //un formulario externo o una solicitud maliciosa para realizar acciones no deseadas en 
        //nombre de un usuario autenticado.
        $data = array();
        // Si el metodo de solicitud es diferente de POST, entonces retorna
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            // Recuperar el token CSRF de la sesión y asignarlo a los datos para usarlo en la vista
            $data["msj_login"] = "Solicitud no válida. Por favor, inténtalo nuevamente.";
            // Envio el token para poder enviarlo de vuelta al loginU.php
            if (isset($_SESSION['csrf_token'])) {
                $data["csrf_token"] = $_SESSION['csrf_token'];
            }
            require_once "views/login/login.php";
            return;
        }
        // Verifica si el token mostrado en el formulario es igual al que esta almacenado en session,
        // si gustan manipulen el token que aparece en el inspeccionar, este saldra como solicitud no valida
        if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $data["msj_login"] = "Solicitud no válida. Por favor, inténtalo nuevamente.";
            if (isset($_SESSION['csrf_token'])) {
                $data["csrf_token"] = $_SESSION['csrf_token'];
            }
            require_once "views/login/login.php";
            return;
        }

        $username = $this->validation->sanitization($_POST["txtUsername"]);
        $password = $this->validation->sanitization($_POST["txtPassword"]);
        $this->validateUsername($username);

        if ($this->errors) {
            $data["csrf_token"] = $_SESSION['csrf_token'];
            $data["errors"] = $this->errors;
        } else {
            
            $consult = $this->db->getList($username);
            if(!isset($consult)){
                $data["csrf_token"] = $_SESSION['csrf_token'];
                $data["msj_login"] = "Usuario incorrecto y/o no existente";
                require_once "views/login/login.php";
                return;
            }
            $loginAttempts = $this->db->getLoginAttempts($username);
            if ($loginAttempts >= 3) {
                $this->enableUserAndReset($username);
            }
            
            $this->validatePassword($username, $password);
            
            //Comprobamos si hay errores de password
            if(isset($this->errors["password"])){
                $data["csrf_token"] = $_SESSION['csrf_token'];
                $data["errors"] = $this->errors;
                require_once "views/login/login.php";
                return;
            }
            if(isset($_POST["cboxRememberMe"])){
                $this->saveLogin($username);
            }
            $this->db->incrementVisitDay($username);
            $this->db->updateLastLogin($username);

            //Verificacion de roles.state y user.state si esta en 1
            if ($consult["state"] == 1 && $consult["user_state"] == 1) {
                $data_session = [
                    "username"  => $username,
                    "loggin_in" => 1,
                    "avatar"    => $consult["avatar"],
                    "role"      => $consult["roleN"],
                    "idRole"    => $consult["idRole"],
                    "user_modules"  => $this->panelList($consult["idRole"])/* ,
                    "temp" => $_POST["cboxRememberMe"] */
                ];
                $_SESSION["session"] = $data_session;
                $url = BASE_URL . "";//redireciona a la pagina de administracion por defecto
                header("Location: $url");
                return;
            } else if (isset($consult) && $consult["state"] == 1) {
                $data["msj_login"] = "Usuario deshabilitado. Contactarse con el administrador";
            } else if (isset($consult)) {
                $data["msj_login"] = "Rol deshabilitado. Contactarse con el administrador";
            }
        }
        // El token CSRF actual es enviado de vuelta al formulario loginU.php
        $data["csrf_token"] = $_SESSION['csrf_token'];
        require_once "views/login/login.php";
    }
    public function panelList($idRole)
    {
        $chain = "";
        $module = $this->db->getModule($idRole);
        foreach ($module as $mod) {
            $chain .= "<div class='item-menu'>";
            $chain .= "<a>";
            $chain .= $mod["icon"];
            $chain .= "<h3>" . $mod["description"] . "</h3></a>";

            $subModule = $this->db->getSubModule($idRole, $mod["submodule"]);

            foreach ($subModule as $sub) {
                $chain .= "<a href='" . BASE_URL . $sub["url"] . "' class='sub sub-d'>";
                $chain .= "<h3>" . $sub["description"] . " </h3></a>";
            }
            $chain .= "</div>";
        }
        return $chain;
    }
    private function validateUsername($value)
    {
        if (!$this->validation->validateRequired($value)) {
            $this->errors["username"] = "Debes Ingresar un Usuario";
        }
    }
    private function validatePassword($username,$value)
    {
        $user = $this->db->getList($username);
        $maxAttempts = 3; // Numero de intentos fallidos
        $loginAttempts = $this->db->getLoginAttempts($username);

        if ($loginAttempts >= $maxAttempts) {
            $this->errors["password"] = "Perfil deshabilitado. Contactarse con el administrador.";
            return;
        }
        // Verificacion de la contraseña ingresada con que esta en la BD
        if ($user && password_verify($value, $user["password"])) {
            $this->db->incrementVisit($username);
            $this->db->ultimateVisit($username);
        } else {
            //Mas de 3 intentos, inhabilita el usuario (user.state)
            $this->incrementLoginAttempts($username);
            $this->checkLoginAttempts($username);

            $this->errors["password"] = ($user) ? "Contraseña incorrecta, vuelva a intentarlo." : "Usuario incorrecto y/o no existente";
        }
        
    }

    private function incrementLoginAttempts($username)
    {
        $this->db->incrementLoginAttempts($username);
    }

    public function enableUserAndReset($username)
    {
        $this->db->reset($username);
        $this->db->enableUser($username);
    }

    private function checkLoginAttempts($username)
    {
        $maxAttempts = 3;
        $loginAttempts = $this->db->getLoginAttempts($username);

        if ($loginAttempts >= $maxAttempts) {
            $this->db->disableUser($username);
        }
    }

    private function saveLogin($username){
        $token = bin2hex(random_bytes(127));
        // 3600 es 1h , 86400 es un día, 604800 es una semana
        // el valor sumado es la duración de la cookie
        setcookie("tokenLogin", $token,time()+604800);
        $this->db->setLoginToken($username, $token);
    }
    private function getSavedLogin($token){
        // se envia el token y se obtiene el username como respuesta
        return $this->db->getLoginUsername($token);
    }
    public function logout()
    {
        if (isset($_COOKIE["tokenLogin"])){
            setcookie("tokenLogin", "", time() - 3600);
        }
        session_unset();
        session_destroy();
        $url = BASE_URL . "login";
        header("Location: $url");
    }
}
