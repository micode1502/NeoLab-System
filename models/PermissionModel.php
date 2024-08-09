<?php

class PermissionModel
{

    protected $db, $permissions;

    public function __construct()
    {
        $this->db = Connection::connect();
        $this->permissions = array();
    }

    public function getPermissions($module, $role, $column)
    {

        $state = "";

        $sql = "SELECT $column FROM permission where idModule = $module and idRole=$role";
        $query = $this->db->query($sql);
        $row =  $query->fetch_assoc();
        if (isset($row)) {
            if ($row["$column"] == 1) {
                return $state = "checked";
            }
        }
        return $state;
    }

    public function savePermissions($data)
    {

        $sql = "INSERT INTO permission (idModule, idRole, c, r, u, d, p) 
                        VALUES ('" . $data["idModule"] . "', 
                                '" . $data["idRole"] . "', 
                                '" . $data["c"] . "', 
                                '" . $data["r"] . "', 
                                '" . $data["u"] . "', 
                                '" . $data["d"] . "', 
                                '" . $data["p"] . "')";
        $this->db->query($sql);
    }

    public function deletePermissions($idRole)
    {
        $sql = "DELETE FROM permission WHERE idRole = $idRole";
        $this->db->query($sql);
    }

    /* 1 Get a specific permission from profile, module and column */
    public function getAccessColumn($module, $role, $column)
    {
        $state = false;

        if ($module == NULL) {
            return $state;
        }

        $sql = "SELECT $column FROM permission WHERE idModule = $module and idRole=$role";
        $consult = $this->db->query($sql);
        $row =  $consult->fetch_assoc();
        if (isset($row)) {
            if ($row["$column"] == 1) {
                $state = true;
            } else {
                $state = false;
            }
        }
        return $state;
    }
    /* 2 Get a CRUD permissions of a module with the module and role */
    function getAccess($idModule, $idRole)
    {
        $sql = "SELECT p.r, p.c, p.u, p.d, p.p FROM permission p WHERE p.idModule = $idModule AND p.idRole = $idRole";
        $consult = $this->db->query($sql);
        $row =  $consult->fetch_assoc();
        return $row;
    }
}
