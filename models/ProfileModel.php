<?php

class ProfileModel
{

    protected $db;

    public function __construct()
    {
        $this->db = Connection::connect();
    }

    public function getUser($username)
    {
        $sql = "SELECT u.idUser as id, u.avatar, u.username, p.name, p.lastName, p.dni, p.bornDate, e.email, ph.number, r.name as role FROM user u JOIN person p ON u.idPerson = p.idPerson JOIN email e ON p.idPerson = e.idPerson JOIN phone ph ON p.idPerson = ph.idPerson JOIN role r ON u.idRole = r.idRole  WHERE u.username = '$username' GROUP BY p.name, p.lastName, p.dni, e.email, ph.number, r.name";
        $query = $this->db->query($sql);
        $row = $query->fetch_assoc();
        return $row;
    }

    public function updateUser($data, $id)
    {
        $pass = password_hash($data['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE user SET username = '{$data['username']}', 
                                password = '$pass', 
                                avatar = '{$data['avatar']}',
                                updated_at = NOW()
                                WHERE idUser = $id";


        $query = $this->db->query($sql);
        return $query;
    }
}
