<?php

require_once __DIR__ . '/inc/db.inc.php';

class Account {
    protected $id;
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
        return $pdo;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

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

    // Sjekker om brukernavn allerede eksisterer
    public function usernameExists($username) {
        $pdo = $this->getDbConnection();
        $stmt = $pdo->prepare("SELECT id FROM accounts WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getTaskById($taskId) {
        $pdo = $this->getDbConnection();
        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = :task_id AND user_id = :user_id");
        $stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $this->id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addTask($userId, $title, $course_code, $description, $due_date, $status, $materialUrl) {
    try {
        $pdo = $this->getDbConnection();
        
        // Oppdater SQL-spørringen til å inkludere de nye feltene
        $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title, course_code, description, due_date, status, material_url) 
                               VALUES (:user_id, :title, :course_code, :description, :due_date, :status, :material_url)");

        // Bind parametere
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':course_code', $course_code, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':due_date', $due_date, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);

        // Håndter tilfelle hvor $materialUrl kan være null
        if ($materialUrl === null) {
            $stmt->bindValue(':material_url', null, PDO::PARAM_NULL);
        } else {
            $stmt->bindParam(':material_url', $materialUrl, PDO::PARAM_STR);
        }

        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        echo "Feil ved lagring av oppgave: " . $e->getMessage(); // Detaljert feilmelding for feilsøking
        return false;
    }
}

    public function getUpcomingTasks() {
        $pdo = $this->getDbConnection();
        $stmt = $pdo->prepare("SELECT * FROM tasks 
                            WHERE user_id = :user_id 
                            AND status IN ('pending', 'not-started') 
                            AND due_date >= CURDATE() 
                            ORDER BY due_date ASC");

        $stmt->bindParam(':user_id', $this->id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateTask($taskId, $title, $description, $due_date, $status) {
        try {
            $pdo = $this->getDbConnection();
            $stmt = $pdo->prepare("UPDATE tasks SET title = :title, description = :description, due_date = :due_date, status = :status WHERE id = :task_id AND user_id = :user_id");
            
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':due_date', $due_date, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $this->id, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error updating task: " . $e->getMessage());
            return false;
        }
    }

    // Todos
    public function addTodo($userId, $value) {
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

    public function getUnfinishedTodos() {
        $pdo = $this->getDbConnection();
        $stmt = $pdo->prepare("SELECT * FROM todo WHERE user_id = :user_id 
        AND status = 'pending'");

        $stmt->bindParam(':user_id', $this->id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Slett gjøremål (altså sett dem til finished i databasen)
    public function deactivateTodo($id){
        echo "Ey";
        try{
            $pdo = $this->getDbConnection();
            $stmt = $pdo->prepare("UPDATE todo SET status = 'completed' WHERE id = :id");

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return true; 
        } catch (PDOException $e){
            error_log("Error deactivating todo: " . $e->getMessage());
            return false;
        }
        

    }

    // Opprett konto
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
