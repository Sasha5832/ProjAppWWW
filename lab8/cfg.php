<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = ''; // Ustaw własne hasło w razie potrzeby
$dbname = 'moja_strona';

$cfg_login = "admin"; // Login administratora
$cfg_pass = "admin123"; // Hasło administratora


$link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$link) {
    echo '<br>Przerwano połączenie z bazą';
    exit();
}

?>
