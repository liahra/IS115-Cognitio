<?php

class Database
{
    // Konfig-detaljer for db
    private $host = '127.0.0.1';
    private $port;
    private $user = 'root';
    private $pass = 'root';
    private $dbname = 'phplogin';
    private $dsn; // Tilkoblingsstrengen
    private $pdo; // Variabel for PDO-tilkoblingen

    // Konstruktør
    public function __construct()
    {
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
    public function connectToDatabase()
    {
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
    public function getConnection()
    {
        return $this->pdo; // Returnerer PDO-objektet for å kunne bruke det i andre klasser
    }
}
