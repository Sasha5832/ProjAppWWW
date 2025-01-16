<?php

// --------------------------------------
// Konfiguracja połączenia z bazą danych
// --------------------------------------
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = ''; // Ustaw własne hasło w razie potrzeby
$dbname = 'moja_strona';

// Dane logowania administratora
$cfg_login = "admin"; // Login administratora
$cfg_pass = "admin123"; // Hasło administratora

// --------------------------------------
// Nawiązanie połączenia z bazą danych
// --------------------------------------
$link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Sprawdzenie, czy połączenie się powiodło
if (!$link) {
    echo '<br>Przerwano połączenie z bazą';
    exit();
}

?>