<?php
function PokazPodstrone($id) {
    // Oczyszczamy $id, aby zapobiec atakom SQL Injection
    $id_Clear = htmlspecialchars($id);

    // Tworzymy zapytanie SQL z LIMIT 1, aby pobrać jedną stronę o danym id
    $query = "SELECT * FROM page_list WHERE id='$id_Clear' LIMIT 1";
    $result = mysqli_query($GLOBALS['link'], $query);  // Zakładam, że $link jest globalnie ustawione w cfg.php
    $row = mysqli_fetch_array($result);

    // Sprawdzamy, czy wynik jest pusty, jeśli tak, zwracamy komunikat o braku strony
    if (empty($row['id'])) {
        $web = '[nie_znaleziono_strony]';
    } else {
        $web = $row['page_content'];
    }

    return $web;
}
?>
