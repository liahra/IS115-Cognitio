<?php 
    class Database {
        // Konfig-detaljer for db
        private $host = '127.0.0.1';
        private $port = '8889';
        private $user = 'root';
        private $pass = 'root';
        private $dbname = 'phplogin';
        private $pdo; // Variabel for PDO-tilkoblingen

        // Konstruktør
        public function __construct() {
            // Bygger DSN-strengen (Data Source Name) for tilkoblingen
            $dsn = 'mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->dbname;

            try {
                // Oppretter en ny PDO-tilkobling
                $this->pdo = new PDO($dsn, $this->user, $this->pass);

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
    }

?>