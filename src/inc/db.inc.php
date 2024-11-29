<?php
include dirname(__FILE__) . "/logger.inc.php";

class Database {

    // Konfig-detaljer for db
    private $host = '127.0.0.1';
    private $port;
    private $user = 'root';
    private $pass = 'root';
    private $dbname = 'phplogin';
    private $dsn; // Tilkoblingsstrengen
    private $pdo; // Variabel for PDO-tilkoblingen
    private $logger;

    // Konstruktør
    public function __construct() {
        $this->logger = new Logger();

        if (file_exists(dirname(__FILE__) . '/portfile.php')) {
            $this->port =  require dirname(__FILE__) . '/portfile.php';
        } else {
            $this->port = '8889';
        }
        $this->connectToDatabase();
        
    }

    // Metode for å prøve å koble seg til databasen
    public function connectToDatabase() {
        try {

            // Bygger DSN-strengen (Data Source Name) for tilkoblingen
            $this->dsn = 'mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->dbname;

            // Oppretter en ny PDO-tilkobling
            $this->pdo = new PDO($this->dsn, $this->user, $this->pass);

            // Setter PDO til å kaste unntak hvis en feil oppstår
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {

            // Håndterer feil ved tilkobling og viser en melding
            //echo 'Feil ved tilkobling til databasen: ' . $e->getMessage();
            $this->logger->logError($e->getMessage() . '\n' . $this->port);
            header("Location: ../public/login.php?status=500");
            exit();
        }
    }

    // Getter-metode for å hente PDO-tilkoblingen
    public function getConnection() {
        return $this->pdo; // Returnerer PDO-objektet for å kunne bruke det i andre klasser
    }

    // Sjekker om brukernavn allerede eksisterer
    public function usernameExists($username) {
        //$pdo = $this->getDbConnection();
        $stmt = $this->pdo->prepare("SELECT id FROM accounts WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;

    }

    // Hent bruker hvis den eksisterer
    public function getUser($username){
        $stmt = $this->pdo->prepare("SELECT * FROM accounts WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }

    // Opprett konto
    public function createAccount($account) {
        $sql = "INSERT INTO accounts (fname, lname, username, email, password, role, regDate) 
            VALUES (:fname, :lname, :username, :email, :password, :role, :regDate)";

        $stmt = $this->pdo->prepare($sql);

        // Binder verdier til navngitte parametere.
        $stmt->bindParam(':fname', $account->getFirstName());
        $stmt->bindParam(':lname', $account->getLastName());
        $stmt->bindParam(':username', $account->getUserName());
        $stmt->bindParam(':email', $account->getEmail());
        $stmt->bindParam(':password', $account->getPassword());
        $stmt->bindParam(':role', $account->getRole());
        $stmt->bindParam(':regDate', $account->getRegDate());

        // Utfører spørringen
        $stmt->execute();

        echo "Konto opprettet!";
    }

    // TASKS
    public function addNewTask($userId, $title, $course_code, $description, $due_date, $status, $materialUrl) {
        try {
            
            // Oppdater SQL-spørringen til å inkludere de nye feltene
            $stmt = $this->pdo->prepare("INSERT INTO tasks (user_id, title, course_code, description, due_date, status, material_url) 
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

            return $stmt->rowCount() > 0;

        } catch (PDOException $e) {
            $this->logger->logError("Feil ved lagring av oppgave: " . $e->getMessage()); 
            return false;
        }
    }

    public function getUpcomingTasks($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM tasks 
                                        WHERE user_id = :user_id 
                                        AND status IN ('pending', 'not-started') 
                                        AND due_date >= CURDATE() 
                                        ORDER BY due_date ASC");
    
            $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $this->logger->logError("Database error in getUpcomingTasks: " . $e->getMessage());
    
            // Returner en tom array for å unngå at koden som kaller dette feiler
            return [];
        }
    }

    public function getTaskById($taskId, $userId) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM tasks WHERE id = :task_id AND user_id = :user_id");
            $stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();
    
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $this->logger->logError("Database error in getTaskById: " . $e->getMessage());
    
            // Returner null for å indikere at noe gikk galt
            return null;
        }
    }

    public function updateTask($userId, $taskId, $title, $description, $due_date, $status) {
        try {
            $stmt = $this->pdo->prepare("UPDATE tasks SET title = :title, description = :description, due_date = :due_date, status = :status WHERE id = :task_id AND user_id = :user_id");

            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':due_date', $due_date, PDO::PARAM_STR);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0;

        } catch (PDOException $e) {
            $this->logger->logError("Error updating task: " . $e->getMessage());
            return false;
        }
    }

    public function getAllTasksByUserId($userId)
    {
        $query = "SELECT id, title, course_code, description, due_date, status, material_url 
                  FROM tasks 
                  WHERE user_id = :userId 
                  ORDER BY due_date ASC";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActiveTasksByUserIdSorted($userId, $sortField, $sortOrder)
    {
        $query = "SELECT id, title, description, course_code, due_date, status, material_url 
                  FROM tasks 
                  WHERE user_id = :userId 
                  AND status != 'inactive' -- Ekskluder inaktive oppgaver
                  ORDER BY $sortField $sortOrder";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deactivateTask($userId, $taskId) {
        try {
            
            $query = "UPDATE tasks SET status = 'inactive' WHERE id = :task_id AND user_id = :user_id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $result = $stmt->execute();
            return $result;
        } catch (PDOException $e) {
            $this->logger->logError("Database error in deactivateTask: " . $e->getMessage());
            return false;
        }
    }

    // TODOS
    public function addTodo($userId, $value) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO todo (user_id, value) VALUES (:user_id, :value)");
            $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':value', $value, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            $this->logger->logError("Error adding task: " . $e->getMessage());
            return false; // Failure
        }
    }

    public function getUnfinishedTodos($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM todo WHERE user_id = :user_id 
        AND status = 'pending'");

        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateTodo($id, $updated_description) {
        try {
            $stmt = $this->pdo->prepare("UPDATE todo SET value = :updated_description WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':updated_description', $updated_description, PDO::PARAM_STR);
            $stmt->execute();

            return true;

        } catch (PDOException $e) {
            $this->logger->logError("Error deactivating todo: " . $e->getMessage());
            return false;
        }
    }

    public function deactivateTodo($id) {
        try {
            $stmt = $this->pdo->prepare("UPDATE todo SET status = 'completed' WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return true;

        } catch (PDOException $e) {
            $this->logger->logError("Error deactivating todo: " . $e->getMessage());
            return false;
        }
    }

    // ADMIN
    public function getStudents(){
        try{
             $stmt = $this->pdo->prepare("SELECT id, fname, lname, username, email, regDate  FROM accounts WHERE role='student'");
             $stmt->execute();
             if($stmt->rowCount() > 0){

                return $stmt->fetchAll(PDO::FETCH_ASSOC);

             } else {
                echo "No students found";
                exit();
             }
        } catch(PDOException $e){
            $this->logger->logError("Error getting students: " . $e->getMessage());
        }
    }
}
