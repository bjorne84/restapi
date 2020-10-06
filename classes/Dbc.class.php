<?php
//Klass för databaskoppling, klassnamn skall starta med stor bokstav
class Dbc
{
    /* root är i localhost automatiskt tillgång om man inte ställt in annorlunda, 
    och det behövs inget lösenord till det.
    */
    private $host = DBHOST;
    private $user = DBUSER;
    private $password = DBPASS;
    private $dbName = DBDATABASE;
    private $charset = 'utf8mb4';

    protected function connect()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbName . ';charset=' . $this->charset;
        /* Options som en array, ställer in assosiativ array som standard för fetchmode, fel i from exeptions, och stänger av emulate mode*/
        $options = [
            PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
        ];

        try {
            /* provar databasanslutningen som returneras, vid fel skickas felmeddelande*/
            $pdo = new PDO($dsn, $this->user, $this->password, $options);
            //$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch (Exception $e) {
            error_log($e->getMessage());
            exit('Fel vid databasanslutning');
        }
    }
}