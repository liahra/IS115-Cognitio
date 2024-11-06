<?php
class Database
{
    // Konfig-detaljer for db
    private $host = '127.0.0.1';
    private $port = array('8889', '3306'); // Liste over porter vi kan forsøke å koble til
    private $portIndex = 0;
    private $user = 'root';
    private $pass = 'root';
    private $dbname = 'phplogin';
    private $dsn; // Tilkoblingsstrengen
    private $pdo; // Variabel for PDO-tilkoblingen

    // Konstruktør
    public function __construct() {
        $this->connectToDatabase();
    }

    // Metode for å prøve å koble seg til databasen
    public function connectToDatabase()
    {
        try {
            // Bygger DSN-strengen (Data Source Name) for tilkoblingen
            $dsn = 'mysql:host=' . $this->host . ';port=' . $this->port[$this->portIndex] . ';dbname=' . $this->dbname;

            // Oppretter en ny PDO-tilkobling
            $this->pdo = new PDO($dsn, $this->user, $this->pass);

            // Setter PDO til å kaste unntak hvis en feil oppstår
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // En mulig feil kan være porten. MAMP bruker 8889, mens XAMPP bruker 3306.
            // Vi prøver derfor å koble til med neste port i listen over porter hvis det er mulig
            if ($this->portIndex < sizeof($this->port)) {
                $this->portIndex++; // Går videre til neste port
                $this->connectToDatabase();
            } else {
                // Håndterer feil ved tilkobling og viser en melding
                echo 'Feil ved tilkobling til databasen: ' . $e->getMessage();
                exit;
            }
        }
    }

    // Getter-metode for å hente PDO-tilkoblingen
    public function getConnection()
    {
        return $this->pdo; // Returnerer PDO-objektet for å kunne bruke det i andre klasser
    }
}
