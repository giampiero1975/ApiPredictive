<?php
namespace ApiPredictive\Synthesys;

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
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => true
            );

            // Connessione a MSSQL - Synthesys
            # $this->dbMSSQL = new PDO("sqlsrv:Server=192.168.10.43;Database=Synthesys_General", "sa", "c4p1t4n.bl4tt4");
            $this->dbMSSQL = new PDO("dblib:host=192.168.10.43;dbname=Synthesys_General", "sa", "c4p1t4n.bl4tt4");
        } catch (Exception $e) {
            echo "Connessione non riuscita: " . $e->getMessage();
        }
    }

    /**
     */
    function __destruct()
    {}
}

