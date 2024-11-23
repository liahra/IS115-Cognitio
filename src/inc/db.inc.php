<?php

class Database {
    // Konfig-detaljer for db
    private $host = '127.0.0.1';
    private $port;
    private $user = 'root';
    private $pass = 'root';
    private $dbname = 'phplogin';
    private $dsn; // Tilkoblingsstrengen
    private $pdo; // Variabel for PDO-tilkoblingen

    // Konstruktør
    public function __construct() {
        // Siden ulike system kan ha ulike porter, så kan vi ha andre portnummer i en egen fil
        // Hvis denne filen eksisterer, så henter vi portnummeret fra der
        if (file_exists(__DIR__ . '/portfile.php')) {
            $portfile = require 'portfile.php';
        } else {
            // Hvis portfilen ikke eksisterer så bruker vi 8889 som default
            $portfile = array(
                'port' => '8889'
            );
        }
        $this->port = $portfile['port'];
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
            echo 'Feil ved tilkobling til databasen: ' . $e->getMessage();
            exit;
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

    // Opprett konto
    public function createAccount($account) {
        //$pdo = $this->getDbConnection(); // Henter PDO-forbindfelsen

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
}
