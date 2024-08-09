<?php

class RolesModel
{

    protected $db;
    protected $roles;

    public function __construct()
    {
        $this->db = Connection::connect();
    }
    /* Function to get idProfile from idPerson (usually used in permissions)*/
    /* function getIdProfile($idPerson) {
        $sql = "SELECT p.id_Profile FROM person p WHERE p.idPerson = $idPerson;";
        $consult = $this->db->query($sql);
        $row =  $consult->fetch_assoc();
        return $row["id_Profile"];
    } */

    // Function to get all the roles from the database
    public function getRoles()
    {
        $roles = array();
        $sql = "SELECT * FROM role";
        $query = $this->db->query($sql);

        while ($row = $query->fetch_assoc()) {
            $roles[] = $row;
        }
        return $roles;
    }

    // Function to get a role from the database
    public function getRoleId($id)
    {
        $sql = "SELECT * FROM role WHERE idRole = $id";

        $query = $this->db->query($sql);

        return $query->fetch_assoc();
    }

    // Function to save a new role in the database
    public function save($data)
    {
        $name = $data['name'];
        $image = $data['image'];
        $state = $data['state'];

        $query = "INSERT INTO role (name, image, state) VALUES ('$name', '$image', '$state')";

        $this->db->query($query);
    }


    // Function to update a role in the database
    public function update($data, $roleId)
    {
        $name = $data['name'];
        $image = $data['image'];
        $state = $data['state'];

        $query = "UPDATE role SET name = '$name', image = '$image', state = '$state' WHERE idRole = $roleId";

        $this->db->query($query);
    }

    // Function to delete a role from the database
    public function delete($roleId)
    {
        $query = "DELETE FROM role WHERE idRole = $roleId";

        $this->db->query($query);
    }
}
