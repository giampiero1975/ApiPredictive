<?php
# http://apipredictive.test/index.php/scarico
# http://svc.metmi.it/ApiPredictive/index.php/scarico
# http://svc.metmi.it/ApiPredictive/scarico/scarico_annuale_CC.csv
# http://svc.metmi.it/ApiPredictive/scarico/scarico_annuale_SA.csv

ini_set('memory_limit', '256M');
ini_set('max_execution_time', 300);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'controllers/UserController.php';

// Instanzia il controller
$userController = new UserController();
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
# print_r($uri);
# die();
try {
    // Gestisce la richiesta GET all'endpoint /users
    # $uri['2'] in locale/ 3 in esercizio
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && $uri['3'] === 'scarico') {
        // echo "<br>step 1.";
        // Ottieni il centralino e servizio accessori giornalieri dal controller
        
        # cancello vecchio file
        
        if (file_exists('scarico/scarico_annuale_CC.csv'))
            unlink('scarico/scarico_annuale_CC.csv');
        
        $switchboard = $userController->getSwitchboard();
        $userController->exportToCsv("scarico_annuale_CC.csv", $switchboard, true);
        
        $switchboardAT = $userController->getSwitchboardAT();
        $userController->exportToCsv("scarico_annuale_CC.csv", $switchboardAT, false);
        
        $switchboardES = $userController->getSwitchboardES();
        $userController->exportToCsv("scarico_annuale_CC.csv", $switchboardES, false);
        
        $switchboardFR = $userController->getSwitchboardFR();
        $userController->exportToCsv("scarico_annuale_CC.csv", $switchboardFR, false);
        
        if (file_exists('scarico/scarico_annuale_SA.csv'))
            unlink('scarico/scarico_annuale_SA.csv');
        
        $services = $userController->getServices();
        #$userController->exportToCsv("scarico_annuale_SA.csv", $services, true);
       
        # spostamento file csv da server a document server
        # $userController->exportCsv("scarico_annuale_CC.csv");
        # $userController->exportCsv("scarico_annuale_SA.csv");
        /*
         // Invia la risposta in formato JSON
         header('Content-Type: application/json');
         echo json_encode($switchboard);
         */
    } else {
        // Gestisci altre richieste o errori
        http_response_code(404);
        echo 'Not Found';
    }
} catch (Exception $e) {
    echo "Errore: " . $e->getMessage();
}