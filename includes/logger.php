<?php
// Definizioni delle funzioni di logging
function writeDebugLog($message) {
    // Puoi aggiungere un'origine come "[MAIN]" o "[UC]" se vuoi distinguere
    file_put_contents('scarico/debug_log.txt', date('Y-m-d H:i:s') . " - " . $message . "\n");
}

function writeErrorLog($message) {
    // Puoi aggiungere un'origine come "[MAIN]" o "[UC]" se vuoi distinguere
    file_put_contents('scarico/error_log.txt', date('Y-m-d H:i:s') . " - ERRORE: " . $message . "\n");
}
?>