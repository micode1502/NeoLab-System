<?php

#function to validate if the controller is valid

function validateController($controller)
{
    $ctr = $controller . "Controller";
    $file = "controllers/" . $ctr . ".php";

    if (is_file($file)) {
        require_once $file;
        $control = new $ctr();
        return $control;
    }

    showError();
}

# Function to validate if the action is valid
function validateAction($controller, $action, $id = null)
{
    if (isset($action) && method_exists($controller, $action)) {
        if ($id == null) {
            $controller->$action();
        } else {
            $controller->$action($id);
        }
    } else {

        showError();
    }
}

function showError()
{
    require_once ERROR_404;
}
