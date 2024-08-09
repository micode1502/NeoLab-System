<?php

class CpanelController
{

    public function __construct()
    {
        session_start();
        //Si el usuario ya inicio sesion, pues simplemente en la barra 
        //no regrese a cpanel = Inicio o pagina principal
        if (isset($_SESSION["session"]["username"])) {
            $url = BASE_URL . "administration";
            header("Location: $url");
            die();
        }
    }

    public function index()
    {
        require_once TEMPLATE;
    }
}
