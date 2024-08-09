<?php

class ModulesModel
{

    protected $db;
    protected $records;

    public function __construct()
    {
        $this->db = Connection::connect();
        $this->records = array();
    }

    /* For permissions */
    /* Get Module ID from module name */
    function getModuleId($module)
    {
        $sql = "SELECT m.idModule FROM module m WHERE m.url = '$module'";
        $consult = $this->db->query($sql);
        $row =  $consult->fetch_assoc();
        return $row["idModule"];
    }

    public function getAllResults()
    {
        $this->records = array();
        $sql = "SELECT *FROM module WHERE submodule is null";
        $consult = $this->db->query($sql);

        while ($row = $consult->fetch_assoc()) {
            $this->records[] = $row;

            $idModule = $row["idModule"];
            $sql1 = "SELECT*FROM module WHERE submodule = $idModule";
            $consulta1 = $this->db->query($sql1);
            while ($row = $consulta1->fetch_assoc()) {
                $this->records[] = $row;
            }
        }
        return $this->records;
    }

    public function getSubModules()
    {
        $this->records = array();
        $sql = "SELECT *FROM module WHERE submodule is null";
        $consult = $this->db->query($sql);

        while ($row = $consult->fetch_assoc()) {
            $this->records[] = $row;
        }

        return $this->records;
    }

    public function saveModule($data)
    {
        $sql = "INSERT INTO module (description, 
                                      icon) 
                VALUES ('" . $data["description"] . "', 
                        '" . $data["icon"] . "')";
        $this->db->query($sql);
    }

    public function saveSubModule($data)
    {
        $sql = "INSERT INTO module (description,
                                    url, 
                                      submodule) 
                VALUES ('" . $data["description"] . "',
                        '" . $data["url"] . "', 
                        '" . $data["submodule"] . "')";

        $this->db->query($sql);
    }

    public function getResultID($id)
    {
        $sql = "SELECT * FROM module WHERE idModule = $id";
        $consult = $this->db->query($sql);
        $row =  $consult->fetch_assoc();
        return $row;
    }

    public function updateModule($id, $data)
    {

        $sql = "UPDATE module SET  description = '" . $data["description"] . "', 
                                    icon = '" . $data["icon"] . "' 
                                WHERE module.idModule = $id";
        $this->db->query($sql);
    }

    public function updateSubModule($id, $data)
    {
        $sql = "UPDATE module SET  description = '" . $data["description"] . "',
                                    url = '" . $data["url"] . "', 
                                    submodule= '" . $data["submodule"] . "'
                               WHERE idModule = $id";
        $this->db->query($sql);
    }

    public function deleteModule($id)
    {
        $sql = "DELETE FROM module WHERE idModule = '$id'";
        if ($this->db->query($sql) == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
