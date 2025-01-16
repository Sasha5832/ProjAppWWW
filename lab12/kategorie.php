<?php
require_once 'cfg.php';
require_once 'showpage.php';
require_once 'showcategory.php';

// Funkcja wyświetlająca kategorie z linkami do powiązanych podstron
function PokazKategorieZPodstronami($matka = NULL, $poziom = 0) {
    $linkToCategory = "showcategory.php?id=$id"; // Link do kategorii
    echo str_repeat('&nbsp;', $poziom * 4) . "- <a href=\"$linkToCategory\">$nazwa</a><br>";

    global $link;

    $matkaCondition = $matka === NULL ? 'IS NULL' : "= $matka";
    $query = "SELECT * FROM kategorie WHERE matka $matkaCondition";
    $result = mysqli_query($link, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $id = (int)$row['id'];
        $nazwa = htmlspecialchars($row['nazwa']);
        $linkToPage = "showpage.php?id=$id"; // Link do podstrony powiązanej z kategorią

        echo str_repeat('&nbsp;', $poziom * 4) . "- <a href=\"$linkToPage\">$nazwa</a><br>";
        PokazKategorieZPodstronami($id, $poziom + 1); // Rekurencja dla podkategorii
    }
}

// Wyświetlanie kategorii wraz z podstronami
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Kategorie i podstrony</title>
</head>
<body>
    <h1>Kategorie i powiązane podstrony</h1>
    <?php PokazKategorieZPodstronami(); ?>
</body>
</html>
