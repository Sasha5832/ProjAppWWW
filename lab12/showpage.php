<?php

// --------------------------------------
// Funkcja do wyświetlania podstrony na podstawie ID
// --------------------------------------
include('cfg.php');

/**
 * PokazPodstrone - Funkcja pobiera treść podstrony z bazy danych na podstawie podanego ID.
 *
 * @param int $id ID podstrony do wyświetlenia
 * @return string Treść podstrony lub komunikat o błędzie
 */
function PokazPodstrone($id) {
    global $link; // Dostęp do połączenia z bazą danych

    // --------------------------------------
    // Przygotowanie zapytania SQL
    // --------------------------------------
    $stmt = $link->prepare("SELECT * FROM page_list WHERE id = ? LIMIT 1");

    if (!$stmt) {
        return "[Błąd przygotowania zapytania: " . $link->error . "]";
    }

    // Zabezpieczenie parametru ID i jego przypisanie
    $stmt->bind_param("i", $id); // Oczekujemy liczby całkowitej

    // Wykonanie zapytania
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        return "[Błąd zapytania do bazy: " . $link->error . "]";
    }

    // Pobranie wyniku zapytania
    $row = $result->fetch_assoc();

    // --------------------------------------
    // Zwrot treści podstrony lub komunikat o jej braku
    // --------------------------------------
    if (empty($row['id'])) {
        return '[Nie znaleziono strony]';
    } else {
        return $row['page_content'];
    }
}

?>