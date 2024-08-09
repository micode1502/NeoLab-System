<?php

class UserModel
{

    protected $db;
    protected $users;

    public function __construct()
    {
        $this->db = Connection::connect();
    }

    // Function to get all the users from the database
    public function getUsers()
    {

        $sql = "SELECT u.idUser as id, u.avatar, u.last_login, u.username, p.name, p.idPerson, p.lastName, p.dni, e.email, ph.number, r.name as role FROM user u JOIN person p ON u.idPerson = p.idPerson JOIN email e ON p.idPerson = e.idPerson JOIN phone ph ON p.idPerson = ph.idPerson JOIN role r ON u.idRole = r.idRole GROUP BY u.last_login, p.name, p.lastName, p.dni, e.email, ph.number, r.name";
        $query = $this->db->query($sql);

        while ($row = $query->fetch_assoc()) {
            $this->users[] = $row;
        }
        return $this->users;
    }

    // Function to get a user from the database
    public function getUserId($id)
    {
        $sql = "SELECT u.idUser as id, u.avatar, u.last_login, u.username, p.idPerson, p.name, p.lastName, p.dni, p.gender, p.bornDate, e.email, ph.number, r.idRole, r.name as role FROM user u JOIN person p ON u.idPerson = p.idPerson JOIN email e ON p.idPerson = e.idPerson JOIN phone ph ON p.idPerson = ph.idPerson JOIN role r ON u.idRole = r.idRole  WHERE u.idUser = $id GROUP BY u.last_login, p.name, p.lastName, p.dni, e.email, ph.number, r.name";

        $query = $this->db->query($sql);

        return $query->fetch_assoc();
    }

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

    // Function to save a new user in the database
    public function save($data)
    {
        $name = $data['name'];
        $lastName = $data['lastName'];
        $dni = $data['dni'];
        $gender = $data['gender'];
        $bornDate = $data['bornDate'];
        $email = $data['email'];
        $phone = $data['phone'];
        $roleId = $data['roleId'];
        $avatar = $data['avatar'];

        //Nomenclatura de usuario
        $username = substr($lastName, 0, 1) . $name . substr($lastName, -1);
        $pass = password_hash($username, PASSWORD_DEFAULT);

        $personQuery = "INSERT INTO person (name, lastName, dni, gender, bornDate) VALUES ('$name', '$lastName', '$dni', '$gender', '$bornDate')";

        $this->db->query($personQuery);

        $personId = $this->db->insert_id;

        $emailQuery = "INSERT INTO email (email, idPerson) VALUES ('$email', $personId)";
        $this->db->query($emailQuery);

        $phoneQuery = "INSERT INTO phone (number, idPerson) VALUES ('$phone', $personId)";
        $this->db->query($phoneQuery);


        $userQuery = "INSERT INTO user (idPerson, idRole, username, password, created_at, updated_at, last_login, avatar) VALUES ($personId, $roleId, '$username', '$pass', NOW(), NOW(), NOW(), '$avatar')";

        $this->db->query($userQuery);
    }


    // Function to update a user in the database
    public function update($data, $userId)
    {
        $name = $data['name'];
        $lastName = $data['lastName'];
        $dni = $data['dni'];
        $gender = $data['gender'];
        $bornDate = $data['bornDate'];
        $email = $data['email'];
        $phone = $data['phone'];
        $roleId = $data['roleId'];
        $avatar = $data['avatar'];

        $user = $this->getUserId($userId);
        $id = $user['idPerson'];

        $personQuery = "UPDATE person SET name = '$name', lastName = '$lastName', dni = $dni, gender = '$gender', bornDate = '$bornDate' WHERE idPerson = $id";
        $this->db->query($personQuery);

        $emailQuery = "UPDATE email SET email = '$email' WHERE idPerson = $id";

        $this->db->query($emailQuery);

        $phoneQuery = "UPDATE phone SET number = '$phone' WHERE idPerson = $id";
        $this->db->query($phoneQuery);

        $userQuery = "UPDATE user SET idRole = $roleId, updated_at = NOW(), avatar = '$avatar', 
                    modifications = CASE WHEN modifications IS NULL THEN 1 
                    ELSE modifications + 1 END WHERE idPerson = $id";
        $this->db->query($userQuery);
    }

    // Function to delete a user from the database
    public function delete($userId)
    {
        $user = $this->getUserId($userId);
        $id = $user['idPerson'];

        $userQuery = "DELETE FROM user WHERE idPerson = $id";
        $this->db->query($userQuery);

        $emailQuery = "DELETE FROM email WHERE idPerson = $id";
        $this->db->query($emailQuery);

        $phoneQuery = "DELETE FROM phone WHERE idPerson = $id";
        $this->db->query($phoneQuery);

        $personQuery = "DELETE FROM person WHERE idPerson = $id";
        $this->db->query($personQuery);
    }


    public function getModule($idRole)
    {
        $this->users = array();
        $sql = "SELECT 
                role.idRole, sub.idModule, sub.description, sub.icon
                FROM role
                INNER JOIN module on module.idModule = role.idModule
                INNER JOIN module sub on sub.idModule = module.submodule
                where role.idRole = $idRole
                GROUP BY sub.description";
        $query = $this->db->query($sql);

        while ($row = $query->fetch_assoc()) {
            $this->users[] = $row;
        }
        return $this->users;
    }
}
