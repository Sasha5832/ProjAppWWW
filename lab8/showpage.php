<?php
include('cfg.php');
function PokazPodstrone($id) {
    global $link; // Dostęp do połączenia z bazy danych

    // Przygotowanie zapytania SQL
    $stmt = $link->prepare("SELECT * FROM page_list WHERE id = ? LIMIT 1");
    $stmt->bind_param("s", $id); // Zabezpieczenie parametru jako string
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        return "[Błąd zapytania do bazy: " . $link->error . "]";
    }

    $row = $result->fetch_assoc();

    // Wyświetlenie zawartości strony
    if (empty($row['id'])) {
        return '[Nie znaleziono strony]';
    } else {
        return $row['page_content'];
    }
}


?>
