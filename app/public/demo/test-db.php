<?php
require_once 'includes/functions.php';  // Include fișierul cu funcția de conectare

// Încearcă să te conectezi la baza de date
$pdo = db_connect();

if ($pdo) {
    echo "Conexiunea la baza de date a fost realizată cu succes!";
} else {
    echo "Eroare la conectarea la baza de date!";
}
