<?php

require_once __DIR__ . '/inc/db.inc.php';

class Account
{
    protected $id;
    protected $fname;
    protected $lname;
    protected $username;
    protected $email;
    protected $role;
    protected $regDate;
    protected $password;

    // Henter databaseforbindelsen fra Database-klassen
    protected function getDbConnection()
    {
        $db = new Database();

        $pdo = $db->getConnection();

        return $pdo;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setFirstName($fname)
    {
        $this->fname = $fname;
    }

    public function setLastName($lname)
    {
        $this->lname = $lname;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function setRegDate($regDate)
    {
        $this->regDate = $regDate;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    // Sjekker om brukernavn allerede eksisterer
    public function usernameExists($username)
    {
        $pdo = $this->getDbConnection();
        $stmt = $pdo->prepare("SELECT id FROM accounts WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function addTask($userId, $title, $description, $due_date)
    {
        try {
            $pdo = $this->getDbConnection();
            $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title, description, due_date) VALUES (:user_id, :title, :description, :due_date)");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':due_date', $due_date, PDO::PARAM_STR);
            $stmt->execute();

            return true; // Success
        } catch (PDOException $e) {
            error_log("Error adding task: " . $e->getMessage());
            return false; // Failure
        }
    }

    public function getUpcomingTasks()
    {
        $pdo = $this->getDbConnection();
        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = :user_id 
        AND status = 'pending' AND due_date >= CURDATE() 
        ORDER BY due_date ASC");

        $stmt->bindParam(':user_id', $this->id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Todos
    public function addTodo($userId, $value)
    {
        try {
            $pdo = $this->getDbConnection();
            $stmt = $pdo->prepare("INSERT INTO todo (user_id, value) VALUES (:user_id, :value)");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':value', $value, PDO::PARAM_STR);
            $stmt->execute();

            return true; // Success
        } catch (PDOException $e) {
            error_log("Error adding task: " . $e->getMessage());
            return false; // Failure
        }
    }

    public function getUnfinishedTodos()
    {
        $pdo = $this->getDbConnection();
        $stmt = $pdo->prepare("SELECT * FROM todo WHERE user_id = :user_id 
        AND status = 'pending'");

        $stmt->bindParam(':user_id', $this->id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createAccount()
    {
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
