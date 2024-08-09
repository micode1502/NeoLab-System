<?php
require_once "core/routes.php";
require_once "config/config.php";
require_once "config/Connection.php";
require_once "controllers/UserController.php";


if (!empty($_GET["controller"])) {
    $controller = validateController($_GET["controller"]);
    if (!empty($_GET["action"])) {
        if (!empty($_GET["id"])) {
            validateAction($controller, $_GET["action"], $_GET["id"]);
        } else {
            validateAction($controller, $_GET["action"]);
        }

        return;
    }
    if ($controller !== NULL) {
        validateAction($controller, DEFAULT_ACTION);
    }
    return;
}
$controller = validateController(DEFAULT_CONTROLLER);
$action = DEFAULT_ACTION;
$controller->$action();
