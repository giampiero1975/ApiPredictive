<?php
namespace ApiPredictive\Synthesys;
use PDO;

/**
 *
 * @author giamp
 *        
 */
class Services
{

    /**
     */
    private $dbMSSQL;

    public function __construct()
    {
        try {
            $options = array(
                #PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => true                
            );

            // Connessione a MSSQL - Synthesys
            $this->dbMSSQL = new PDO("sqlsrv:Server=192.168.10.43;Database=Synthesys_General", "sa", "c4p1t4n.bl4tt4",$options);
            // $this->dbMSSQL = new PDO("dblib:host=192.168.10.43;dbname=Synthesys_General", "sa", "c4p1t4n.bl4tt4");
        } catch (Exception $e) {
            // Ottieni il backtrace delle chiamate
            $backtrace = debug_backtrace();
            
            // Estrai il nome della classe e del metodo chiamante
            $callerClass = $backtrace['class'];
            $callerMethod = $backtrace['function'];
            
            // Stampa il messaggio di errore con informazioni sul chiamante
            echo "Connessione non riuscita: ". $e->getMessage(). " (chiamato da $callerClass::$callerMethod)";
            
            // Lancia l'eccezione
            throw new Exception("Connessione non riuscita: ". $e->getMessage());
        }
    }

    public function getProgetti()
    {
        try {
            echo "<br>> 1 - " . __METHOD__;
            $sql = "SELECT * from v_progetti";
            $stmt = $this->dbMSSQL->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die("Errore getProgetti: " . $e->getMessage());
        }
    }

    /**
     * Metodo per filtrare il risultato di getProgetti, verifico che le tabelle delle main siano presenti.
     * E' una verifica per scartare i progetti Syntheys in costruzione
     *
     * @param array $mains
     * @return array $accountsFiltrati
     */
    public function getMains($accounts)
    {
        try {
            echo "<br>> 2 - " . __METHOD__;
            $tableNames = [];
            foreach ($accounts as $account) {
                $tableNames[] = $account['tab_main']; // Aggiungi l'elemento all'array
            }

            $sql = "SELECT TABLE_NAME
            FROM INFORMATION_SCHEMA.TABLES
            WHERE table_name IN ('" . implode("','", $tableNames) . "')";

            $stmt = $this->dbMSSQL->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Estraggo i nomi delle tabelle dal risultato della query
            $tabellePresenti = array_column($result, 'TABLE_NAME');

            // Filtro l'array $accounts per mantenere solo gli elementi
            // con 'tab_main' presente in $tabellePresenti
            $accountsFiltrati = array_filter($accounts, function ($account) use ($tabellePresenti) {
                return in_array($account['tab_main'], $tabellePresenti);
            });
            return $accountsFiltrati;
        } catch (Exception $e) {
            die("Errore getMains: ".$e->getMessage());
        }
    }

    function __destruct()
    {
        $this->dbMSSQL = null; // Chiusura della connessione
    }
}

