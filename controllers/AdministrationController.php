<?php

require_once "models/AdministrationModel.php";

class AdministrationController
{
    protected $db;
    public function __construct()
    {

        session_start();
        if (empty($_SESSION["session"]["loggin_in"])) {
            $url = BASE_URL . "login";
            header("Location: $url");
            die();
        }
        $this->db = new AdministrationModel();
    }
    public function percentUser(){
        $userCounts = $this->db->userCountRegisterDay(); 
        $totalUsers = array_sum(array_column($userCounts, 'user_count'));

        $totalPercentageUsers = $this->db->usersTotal();
        $percentageUser = ($totalUsers / $totalPercentageUsers) * 100;
        return number_format($percentageUser, 2);
    }
    public function averMod(){
        return number_format($averageModifications = $this->db->averageUserModifications(),2);
    }
    public function promVis(){
        $visitDay = $this->db->userVisitDay();
        $visitTotal = $this->db->userVisit();
        $promVisit = ($visitDay*100)/$visitTotal;
        return number_format($promVisit, 2);
    }
    public function index()
    {
        $averageModifications = number_format($averageModifications = $this->db->averageUserModifications(),2);
        /* inicio cod Dara ya en una funcion */
        $userCounts = $this->db->userCountRegisterDay(); 
        $totalUsers = array_sum(array_column($userCounts, 'user_count'));

        $totalPercentageUsers = $this->db->usersTotal();
        $percentageUser = ($totalUsers / $totalPercentageUsers) * 100;
        /* fin cod Dara ya en funcion */
        $visitDay = $this->db->userVisitDay();
        $visitTotal = $this->db->userVisit();
        $promVisit = ($visitDay*100)/$visitTotal;

        $data = array(
            "content" => "views/dashboard/content.php",
            "title" => "DASHBOARD",
            "percentageUser" => $this->percentUser(),
            "userCounts" => $userCounts,
            "totalUsers" => $totalUsers,
            "averageModifications" => $this->averMod(),
        );

        require_once "views/administration/administration.php";
    }
    public function data(){
        echo json_encode(array("percentageUser" => $this->percentUser(), "promVis" => $this->promVis()));
    }

    public function showUsers()
    {
        echo json_encode(array("users" => $this->db->getUsers()));
    }

    public function showLastLogins()
    {
        echo json_encode(array("lastLogins" => $this->db->lastLogins()));
    }
}
