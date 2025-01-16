<?php
include('cfg.php');

/**
 * PokazKategorieLubPodstrone - Funkcja pobiera podkategorie lub treść kategorii z bazy danych na podstawie ID kategorii.
 *
 * @param int $id ID kategorii do wyświetlenia
 * @return string HTML z listą podkategorii lub treścią kategorii
 */
function PokazKategorieLubPodstrone($id = NULL) {
    global $link;

    // Jeśli ID kategorii nie zostało przekazane, wyświetlamy główne kategorie (matka = NULL)
    if ($id === NULL) {
        $query = "SELECT * FROM kategorie WHERE matka IS NULL";
    } else {
        // Sprawdź, czy są podkategorie dla wybranej kategorii
        $query = "SELECT * FROM kategorie WHERE matka = ?";
    }

    $stmt = $link->prepare($query);

    if ($id !== NULL) {
        $stmt->bind_param("i", $id);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    // Sprawdzenie, czy są podkategorie
    if ($result->num_rows > 0) {
        $output = "<h2>Podkategorie:</h2><ul>";
        while ($row = $result->fetch_assoc()) {
            $nazwa = htmlspecialchars($row['nazwa']);
            $categoryLink = "showcategory.php?id=" . $row['id'];
            $output .= "<li><a href=\"$categoryLink\">$nazwa</a></li>";
        }
        $output .= "</ul>";
        return $output;
    } else {
        // Jeśli brak podkategorii, spróbujmy wyświetlić treść kategorii
        $stmt = $link->prepare("SELECT page_content FROM page_list WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return "<h2>Treść kategorii:</h2>" . htmlspecialchars($row['page_content']);
        } else {
            return "<p>Nie znaleziono treści dla tej kategorii.</p>";
        }
    }
}

// Obsługa ID kategorii przekazywanego w URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : NULL;
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategorie</title>
</head>
<body>
    <h1>Kategorie</h1>
    <?php
    echo PokazKategorieLubPodstrone($id);
    ?>
</body>
</html>
