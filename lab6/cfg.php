<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = ''; // Ustaw własne hasło w razie potrzeby
$dbname = 'moja_strona';

$link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$link) {
    echo '<br>Przerwano połączenie z bazą';
    exit();
}
?>
