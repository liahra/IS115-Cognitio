<?php

require_once __DIR__ . '/inc/db.inc.php';

class User {
    protected $id;
    protected $fname;
    protected $lname;
    protected $username;
    protected $email;
    /* protected $role; */
    protected $regDate;
    protected $password;

    // Henter databaseforbindelsen fra Database-klassen
    /* protected function getDbConnection() {
        $db = new Database();
        $pdo = $db->getConnection();
        return $pdo;
    } */

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

    /* public function setRole($role) {
        $this->role = $role;
    } */

    public function setRegDate($regDate) {
        $this->regDate = $regDate;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getFirstName() {
        return $this->fname;
    }

    public function getLastName() {
        return $this->lname;
    }


    public function getUserName() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getRegDate() {
        return $this->regDate;
    }

    // Tasks
    public function addNewTask($title, $course_code, $description, $due_date, $status, $materialUrl) {
        $db = new Database();
        return $db->addNewTask($this->id, $title, $course_code, $description, $due_date, $status, $materialUrl);
    }

    public function updateTask($taskId, $title, $description, $due_date, $status){
        $db = new Database();
        return $db->updateTask($this->id, $taskId, $title, $description, $due_date, $status);
    }

    public function getUpcomingTasks(){
        $db = new Database();
        return $db->getUpcomingTasks($this->id);
    }

    // TODO
    public function addTodo($value){
        $db = new Database();
        return $db->addTodo($this->id, $value);
    }

    public function deactivateTodo($todoId){
        $db = new Database();
        return $db->deactivateTodo($todoId);
    }

    public function updateTodo($todoId, $updated_description){
        $db = new Database();
        return $db->updateTodo($todoId, $updated_description);
    }

    public function getUnfinishedTodos(){
        $db = new Database();
        return $db->getUnfinishedTodos($this->id);
    }
}

class Admin extends User{
    protected $role = 'admin';

    public function getRole() {
        return $this->role;
    }

    public function getStudents(){
        $db = new Database();
        return $db->getStudents();
    }
}

class Student extends User{
    protected $role = 'student';

    public function getRole() {
        return $this->role;
    }
}