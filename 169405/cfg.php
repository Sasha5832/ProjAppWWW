<?php
$dbhost = 'localhost';
$dbuser = 'root';       // Domyślna nazwa użytkownika w XAMPP to 'root'
$dbpass = '';           // Domyślne hasło w XAMPP jest puste, chyba że zostało zmienione
$baza = 'moja_strona';  // Nazwa bazy danych, którą utworzyłeś

$link = mysqli_connect($dbhost, $dbuser, $dbpass, $baza);
if (!$link) {
    echo '<b>przerwane połączenie</b>';
    exit;
}
if (!mysqli_select_db($link, $baza)) {
    echo 'nie wybrano bazy';
}
?>
