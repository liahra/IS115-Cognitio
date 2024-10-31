<?php 

class Account {
    protected $fname;
    protected $lname;
    protected $username;
    protected $email;
    protected $role;
    protected $regDate;
    protected $password;

    // Henter databaseforbindelsen fra Database-klassen
    protected function getDbConnection() {
        $db = new Database();
        $pdo = $db->getConnection();
        
        // Debug
        if ($pdo instanceof PDO) {
            echo "PDO-tilkoblingen er opprettet korrekt.<br>";
        } else {
            echo "Feil: PDO-tilkoblingen ble ikke opprettet.<br>";
        }

        return $pdo;
    }

     // Setter-metode for hver egenskap
     public function setFirstName($fname) {
        $this->fname = $fname;
    }

    public function setLastName($lname) {
        $this->lname = $lname;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function setRegDate($regDate) {
        $this->regDate = $regDate;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function usernameExists($username) {
        $pdo = $this->getDbConnection();
        $stmt = $pdo->prepare("SELECT id FROM accounts WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function createAccount() {
        $pdo = $this->getDbConnection(); // Henter PDO-forbindfelsen
        $sql = "INSERT INTO accounts (fname, lname, username, email, password, role, regDate) 
            VALUES (:fname, :lname, :username, :email, :password, :role, :regDate)";

        $stmt = $pdo->prepare($sql);

        // Binder verdier til navngitte parametere.
        $stmt->bindParam(':fname', $this->fname);
        $stmt->bindParam(':lname', $this->lname);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':regDate', $this->regDate);

        // Utfører spørringen
        $stmt->execute();

        echo "Konto opprettet!";
    }

}
?>