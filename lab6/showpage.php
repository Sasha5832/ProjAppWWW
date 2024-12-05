<?php
include('cfg.php');
function PokazPodstrone($id) {
    global $link; // Dostęp do połączenia z bazy danych

    // Oczyszczenie zmiennej, aby zapobiec SQL Injection
    $id_clean = htmlspecialchars($id);

    // Zapytanie do bazy danych z limitem
    $query = "SELECT * FROM page_list WHERE id='$id_clean' LIMIT 1";
    $result = mysqli_query($link, $query);

    if (!$result) {
        return "[Błąd zapytania do bazy: " . mysqli_error($link) . "]";
    }

    $row = mysqli_fetch_array($result);

    // Wyświetlenie zawartości strony
    if (empty($row['id'])) {
        return '[Nie znaleziono strony]';
    } else {
        return $row['page_content'];
    }
}

?>
