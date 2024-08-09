<?php

class AdministrationModel
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

        $sql = "SELECT u.idUser as id, u.avatar, u.last_login, u.username, p.name, p.idPerson, p.lastName, p.dni, e.email, ph.number, r.name as role FROM user u JOIN person p ON u.idPerson = p.idPerson JOIN email e ON p.idPerson = e.idPerson JOIN phone ph ON p.idPerson = ph.idPerson JOIN role r ON u.idRole = r.idRole  WHERE u.created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH) GROUP BY u.last_login, p.name, p.lastName, p.dni, e.email, ph.number, r.name ORDER BY u.created_at DESC";
        $query = $this->db->query($sql);

        while ($row = $query->fetch_assoc()) {
            $this->users[] = $row;
        }
        return $this->users;
    }

    public function lastLogins()
    {
        $sql = "SELECT u.avatar, u.last_login, u.created_at, p.name, p.lastName, r.name as role FROM user u JOIN person p ON u.idPerson = p.idPerson JOIN role r ON u.idRole = r.idRole GROUP BY u.last_login ORDER BY u.last_login DESC LIMIT 5";
        $query = $this->db->query($sql);

        $data = array();

        while ($row = $query->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    #Consulta de datos de registros por dia
    public function userCountRegisterDay()
    {
        #Columnas de la tabla User
        $sql = "SELECT DATE(created_at) AS register_date, COUNT(*) AS user_count
                FROM user WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)
                GROUP BY DATE(created_at)
                ORDER BY register_date";
        $query = $this->db->query($sql);

        $data = array();
        while ($row = $query->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    
    public function usersTotal()
    {
        $sql = "SELECT COUNT(*) as users_total FROM user";
        $query = $this->db->query($sql);
        $row = $query->fetch_assoc();
        return $row['users_total'];
    }

    public function averageUserModifications()
    {
        #calculo del promedio de modificaciones
        $sql = "SELECT SUM(modifications) / COUNT(*) as averageModifications FROM user";
        $query = $this->db->query($sql);
        
        $row = $query->fetch_assoc();
        return $row['averageModifications'];
    }
    public function userVisitDay()
    {
        #calculo del promedio de modificaciones
        $sql = "SELECT SUM(login_visit_day) AS visitDay FROM user";
        $query = $this->db->query($sql);
        
        $row = $query->fetch_assoc();
        return $row['visitDay'];
    }
    public function userVisit()
    {
        #calculo del promedio de modificaciones
        $sql = "SELECT SUM(login_visit) AS visit FROM user";
        $query = $this->db->query($sql);
        
        $row = $query->fetch_assoc();
        return $row['visit'];
    }
}
