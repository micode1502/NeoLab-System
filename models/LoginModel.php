<?php
    class LoginModel{
        protected $db;
        protected $registers;
    
        public function __construct()
        {
            $this->db = connection::connect();
            $this->registers = array();
        }

        public function getList($username){
            $sql = "SELECT *, user.state AS user_state, role.name as roleN
            FROM user INNER JOIN role ON role.idRole = user.idRole 
            INNER JOIN person ON person.idPerson = user.idPerson 
            WHERE username='" . $username . "'";
            $consult = $this->db->query($sql);
            $row = $consult->fetch_assoc();
            return $row;
        }
        public function incrementLoginAttempts($username)
        {
            $stmt = $this->db->prepare("UPDATE user SET login_attempts = login_attempts + 1 WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->close();
        }
        public function incrementVisitDay($username)
        {
            $stmt = $this->db->prepare("UPDATE user SET login_visit_day = login_visit_day + 1 WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->close();
        }
        public function incrementVisit($username)
        {
            $stmt = $this->db->prepare("UPDATE user SET login_visit = login_visit + 1 WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->close();
        }
        public function ultimateVisit($username)
        {
            $stmt = $this->db->prepare("UPDATE user SET login_visit_day = 0 WHERE login_attempts >=DATE_SUB(NOW(), INTERVAL 1 DAY) AND username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->close();
        }


        public function getLoginAttempts($username)
        {
            $sql = "SELECT login_attempts FROM user WHERE username = '" . $username . "'";
            $result = $this->db->query($sql);

            if ($result) {
                $row = $result->fetch_assoc();
                return $row['login_attempts'];
            }

            return 0;
        }

        public function disableUser($username)
        {
            $sql = "UPDATE user SET state = 0, disableDate = NOW() + INTERVAL 1 SECOND WHERE username = '" . $username . "'";
            $this->db->query($sql);
        }

        public function enableUser($username)
        {
            $sql = "UPDATE user SET state = 1 WHERE username = '" . $username . "' AND state = 0 AND disableDate <= NOW() - INTERVAL 15 SECOND";
            $this->db->query($sql);
        }

        public function reset($username)
        {
            $resetLoginAttemptsSQL = "UPDATE user SET login_Attempts = 0 WHERE username = '" . $username . "' AND state = 1 AND disableDate <= NOW() - INTERVAL 15 SECOND";
            $this->db->query($resetLoginAttemptsSQL);
        }

        public function updateLastLogin($username)
        {
            $sql = "UPDATE user SET last_login = NOW() WHERE username = '" . $username . "'";
            $this->db->query($sql);
        }

        public function getModule($idRole)
        {
            $this->registers = array();
            $sql = "SELECT p.idRole, m.submodule,sub.description,sub.icon
                        FROM permission p
                        INNER JOIN module m ON m.idModule = p.idModule
                        INNER JOIN module sub ON sub.idModule = m.submodule
                        WHERE p.idRole = $idRole
                        GROUP BY p.idRole,m.submodule, sub.description, sub.icon";
            $consult = $this->db->query($sql);

            while ($row = $consult->fetch_assoc()) {
                $this->registers[] = $row;
            }
            return $this->registers;
        }

        public function getSubModule($idRole, $idModule)
        {
            $this->registers = array();
            $sql = "SELECT 
                        module.description, module.url
                        FROM permission
                        INNER JOIN module on module.idModule = permission.idModule
                        WHERE module.submodule=$idModule AND permission.idRole=$idRole";
            $consult = $this->db->query($sql);

            while ($row = $consult->fetch_assoc()) {
                $this->registers[] = $row;
            }
            return $this->registers;
        }
        // Read and Save login token
        public function getLoginUsername($token){
            $sql = "SELECT u.username FROM user u WHERE u.savedLoginToken = '".$token."'";
            $consult = $this->db->query($sql);
            $row = $consult->fetch_assoc();
            $token = $row['username']; 
            return $token;
        }
        public function setLoginToken($username, $token){
            $sql = "UPDATE user u SET savedLoginToken = '".$token."' WHERE u.username = '".$username."'";
            $consult = $this->db->query($sql);
        }
    }