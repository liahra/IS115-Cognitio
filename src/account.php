<?php

/* require_once __DIR__ . '/inc/db.inc.php';
 */
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

    public function setRole($role) {
        $this->role = $role;
    }

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

    public function getRole() {
        return $this->role;
    }

    public function getRegDate() {
        return $this->regDate;
    }

}
