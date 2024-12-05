<?php
$nr_indeksu = '169405'; // 
$nrGrupy = '2'; // 
echo 'Twoje Imię i Nazwisko: '.$nr_indeksu.' grupa '.$nrGrupy.'<br/><br/>';
echo 'Zastosowanie metody include()<br/>';
?>
<?php
echo 'Przykład użycia metody include():<br>';
include 'included_file.php'; 
echo '<br>';

echo 'Przykład użycia metody require_once():<br>';
require_once 'included_file.php'; 
echo '<br>';
?>
<?php
$exampleValue = 5;

echo 'Przykład użycia instrukcji if, else, elseif:<br>';
if ($exampleValue < 3) {
    echo 'Wartość jest mniejsza niż 3<br>';
} elseif ($exampleValue == 5) {
    echo 'Wartość wynosi dokładnie 5<br>';
} else {
    echo 'Wartość jest większa niż 5<br>';
}

echo 'Przykład użycia instrukcji switch:<br>';
switch ($exampleValue) {
    case 1:
        echo 'Wartość to 1<br>';
        break;
    case 5:
        echo 'Wartość to 5<br>';
        break;
    default:
        echo 'Wartość jest inna niż 1 lub 5<br>';
        break;
}
?>
<?php
echo 'Przykład użycia pętli while:<br>';
$i = 0;
while ($i < 3) {
    echo 'Licznik while: '.$i.'<br>';
    $i++;
}

echo 'Przykład użycia pętli for:<br>';
for ($j = 0; $j < 3; $j++) {
    echo 'Licznik for: '.$j.'<br>';
}
?>
<?php
echo 'Przykład użycia $_GET:<br>';
if (isset($_GET['name'])) {
    echo 'Witaj, '.$_GET['name'].'!<br>';
} else {
    echo 'Brak podanej wartości w $_GET.<br>';
}
?>
