<?php
session_start();
include('../cfg.php');

// Funkcja do wyświetlenia formularza logowania
function FormularzLogowania() {
    $wynik = '
    <div class="logowanie" style="max-width: 400px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background-color: #f9f9f9; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">
        <h1 class="heading" style="text-align: center; font-family: Arial, sans-serif;">Panel CMS</h1>
        <form method="post" name="loginForm" enctype="multipart/form-data" action="'.$_SERVER['REQUEST_URI'].'">
            <table class="logowanie" style="width: 100%; margin-top: 10px;">
                <tr><td class="log4_t" style="padding-bottom: 10px; font-family: Arial, sans-serif;">Email:</td><td><input type="text" name="login_email" class="logowanie" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;" /></td></tr>
                <tr><td class="log4_t" style="padding-bottom: 10px; font-family: Arial, sans-serif;">Hasło:</td><td><input type="password" name="login_pass" class="logowanie" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px;" /></td></tr>
                <tr><td>&nbsp;</td><td style="text-align: right;"><input type="submit" name="x1_submit" class="logowanie" value="Zaloguj" style="padding: 10px 20px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer;" /></td></tr>
            </table>
        </form>
    </div>
    ';
    return $wynik;
}

// Sprawdzenie, czy formularz logowania został wysłany
if (isset($_POST['x1_submit'])) {
    $login = $_POST['login_email'];
    $password = $_POST['login_pass'];

    // Pobierz dane z cfg.php
    if ($login == $cfg_login && $password == $cfg_pass) {
        // Zalogowanie użytkownika
        $_SESSION['zalogowany'] = true;
    } else {
        echo '<p style="color: red; text-align: center;">Nieprawidłowy login lub hasło.</p>';
        echo FormularzLogowania();
        exit();
    }
}

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['zalogowany']) || $_SESSION['zalogowany'] !== true) {
    echo FormularzLogowania();
    exit();
}

// Kod administracyjny - dostępny tylko dla zalogowanych użytkowników
echo '<div style="max-width: 800px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background-color: #f9f9f9; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">';
echo '<h2 style="text-align: center; font-family: Arial, sans-serif;">Witaj w panelu administratora!</h2>';
echo '<div style="text-align: center; margin-bottom: 20px;"><a href="admin.php?akcja=dodaj" style="padding: 10px 20px; background-color: #28a745; color: #fff; border: none; border-radius: 5px; text-decoration: none; cursor: pointer;">Dodaj nową podstronę</a></div>';
echo '<div style="text-align: center; margin-bottom: 20px;"><a href="admin.php?akcja=podstrony" style="padding: 10px 20px; background-color: #28a745; color: #fff; border: none; border-radius: 5px; text-decoration: none; cursor: pointer;">Zarządzaj podstronami</a></div>';
echo '<div style="text-align: center; margin-bottom: 20px;"><a href="admin.php?akcja=kategorie" style="padding: 10px 20px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; text-decoration: none; cursor: pointer;">Zarządzaj kategoriami</a></div>';
echo '<div style="text-align: center; margin-top: 20px;"><a href="admin.php?akcja=wyloguj" style="padding: 10px 20px; background-color: #dc3545; color: #fff; border: none; border-radius: 5px; text-decoration: none; cursor: pointer;">Wyloguj</a></div>';

// Funkcja do wyświetlenia listy podstron
function ListaPodstron() {
    include('../cfg.php');
    $query = "SELECT id, page_title FROM page_list";
    $result = $link->query($query);

    if ($result) {
        echo '<div style="max-width: 800px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background-color: #f9f9f9; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">';
        echo '<table border="1" style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;">';
        echo '<tr style="background-color: #007bff; color: #fff;"><th style="padding: 10px;">ID</th><th style="padding: 10px;">Tytuł</th><th style="padding: 10px;">Akcje</th></tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr style="border-bottom: 1px solid #ccc;">';
            echo '<td style="padding: 10px; text-align: center;">' . $row['id'] . '</td>';
            echo '<td style="padding: 10px;">' . htmlspecialchars($row['page_title']) . '</td>';
            echo '<td style="padding: 10px; text-align: center;">
                    <a href="admin.php?akcja=edytuj&id=' . $row['id'] . '" style="color: #007bff; text-decoration: none;">Edytuj</a> |
                    <a href="admin.php?akcja=usun&id=' . $row['id'] . '" style="color: #dc3545; text-decoration: none;" onclick="return confirm(\'Czy na pewno chcesz usunąć tę podstronę?\');">Usuń</a>
                  </td>';
            echo '</tr>';
        }
        echo '</table>';
        echo '</div>';
    } else {
        echo '<p style="color: red;">Błąd podczas wyświetlania listy podstron: ' . $link->error . '</p>';
    }
}

// Funkcja do wyświetlenia listy kategorii
function ListaKategorii() {
    include('../cfg.php');

    echo '<div style="max-width: 800px; margin: 20px auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background-color: #f9f9f9; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);">';
    echo '<h2 style="text-align: center; font-family: Arial, sans-serif;">Zarządzanie Kategoriami</h2>';
    echo '<div style="text-align: center; margin-bottom: 20px;"><a href="admin.php?akcja=dodaj_kat" style="padding: 10px 20px; background-color: #28a745; color: #fff; border: none; border-radius: 5px; text-decoration: none; cursor: pointer;">Dodaj kategorię</a></div>';

    function displayCategoryTree($parent_id = 0, $level = 0) {
        global $link;
        $query = "SELECT id, name FROM categories WHERE parent_id = ?";
        $stmt = $link->prepare($query);
        if ($stmt) {
            $stmt->bind_param("i", $parent_id);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                echo str_repeat("&nbsp;&nbsp;", $level) . htmlspecialchars($row['name']) . ' 
                      <a href="admin.php?akcja=edytuj_kat&id=' . $row['id'] . '">Edytuj</a> | 
                      <a href="admin.php?akcja=usun_kat&id=' . $row['id'] . '" onclick="return confirm(\'Usunąć tę kategorię?\');">Usuń</a><br>';
                displayCategoryTree($row['id'], $level + 1);
            }
        }
    }

    displayCategoryTree();
    echo '</div>';
}


// Funkcja do usuwania podstrony
function UsunPodstrone($id) {
    include('../cfg.php');
    $query = "DELETE FROM page_list WHERE id = ? LIMIT 1";
    $stmt = $link->prepare($query);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        echo '<p style="color: green;">Podstrona została usunięta.</p>';
    } else {
        echo '<p style="color: red;">Błąd podczas usuwania podstrony: ' . $link->error . '</p>';
    }
}

// Funkcja do edytowania podstrony
function EdytujPodstrone($id) {
    include('../cfg.php');

    if (isset($_POST['update'])) {
        $new_title = $_POST['page_title'];
        $new_content = $_POST['page_content'];
        $new_status = isset($_POST['status']) ? 1 : 0;

        $query = "UPDATE page_list SET page_title = ?, page_content = ?, status = ? WHERE id = ? LIMIT 1";
        $stmt = $link->prepare($query);
        if ($stmt) {
            $stmt->bind_param("ssii", $new_title, $new_content, $new_status, $id);
            $stmt->execute();
            echo '<p style="color: green;">Podstrona została zaktualizowana.</p>';
        } else {
            echo '<p style="color: red;">Błąd podczas edytowania podstrony: ' . $link->error . '</p>';
        }
    }

    $query = "SELECT * FROM page_list WHERE id = ? LIMIT 1";
    $stmt = $link->prepare($query);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo '<div style="max-width: 600px; margin: 20px auto;">';
        echo '<form method="POST" action="">
                <label>Tytuł: <input type="text" name="page_title" value="' . htmlspecialchars($row['page_title']) . '" required></label><br>
                <label>Treść: <textarea name="page_content" required>' . htmlspecialchars($row['page_content']) . '</textarea></label><br>
                <label>Status: <input type="checkbox" name="status"' . ($row['status'] ? ' checked' : '') . '></label><br>
                <input type="submit" name="update" value="Zaktualizuj">
              </form>';
        echo '</div>';
    } else {
        echo '<p style="color: red;">Błąd podczas pobierania danych podstrony: ' . $link->error . '</p>';
    }
}

// Funkcja do dodawania nowej podstrony
function DodajNowaPodstrone() {
    include('../cfg.php');

    if (isset($_POST['add'])) {
        $title = $_POST['page_title'];
        $content = $_POST['page_content'];
        $status = isset($_POST['status']) ? 1 : 0;

        $query = "INSERT INTO page_list (page_title, page_content, status) VALUES (?, ?, ?)";
        $stmt = $link->prepare($query);
        if ($stmt) {
            $stmt->bind_param("ssi", $title, $content, $status);
            $stmt->execute();
            echo '<p style="color: green;">Nowa podstrona została dodana.</p>';
        } else {
            echo '<p style="color: red;">Błąd podczas dodawania podstrony: ' . $link->error . '</p>';
        }
    }

    echo '<div style="max-width: 600px; margin: 20px auto;">';
    echo '<form method="POST" action="">
            <label>Tytuł: <input type="text" name="page_title" required></label><br>
            <label>Treść: <textarea name="page_content" required></textarea></label><br>
            <label>Status: <input type="checkbox" name="status"></label><br>
            <input type="submit" name="add" value="Dodaj">
          </form>';
    echo '</div>';
}

// Funkcja do dodawania kategorii
function DodajKategorie() {
    include('../cfg.php');

    if (isset($_POST['add'])) {
        $name = $_POST['category_name'];
        $parent_id = $_POST['parent_id'];

        $query = "INSERT INTO categories (name, parent_id) VALUES (?, ?)";
        $stmt = $link->prepare($query);
        if ($stmt) {
            $stmt->bind_param("si", $name, $parent_id);
            $stmt->execute();
            echo '<p style="color: green;">Nowa kategoria została dodana.</p>';
        } else {
            echo '<p style="color: red;">Błąd podczas dodawania kategorii: ' . $link->error . '</p>';
        }
    }

    echo '<div style="max-width: 600px; margin: 20px auto;">';
    echo '<form method="POST" action="">
            <label>Nazwa kategorii: <input type="text" name="category_name" required></label><br>
            <label>Rodzic kategoria: 
                <select name="parent_id">
                    <option value="0">Brak</option>';
    global $link;
    $result = $link->query("SELECT id, name FROM categories WHERE parent_id = 0");
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['name']) . '</option>';
    }
    echo '    </select>
            </label><br>
            <input type="submit" name="add" value="Dodaj Kategorię">
          </form>';
    echo '</div>';
}

// Funkcja do edytowania kategorii
function EdytujKategorie($id) {
    include('../cfg.php');

    if (isset($_POST['update'])) {
        $name = $_POST['category_name'];
        $parent_id = $_POST['parent_id'];

        $query = "UPDATE categories SET name = ?, parent_id = ? WHERE id = ?";
        $stmt = $link->prepare($query);
        if ($stmt) {
            $stmt->bind_param("sii", $name, $parent_id, $id);
            $stmt->execute();
            echo '<p style="color: green;">Kategoria została zaktualizowana.</p>';
        } else {
            echo '<p style="color: red;">Błąd podczas edytowania kategorii: ' . $link->error . '</p>';
        }
    }

    $query = "SELECT * FROM categories WHERE id = ?";
    $stmt = $link->prepare($query);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo '<div style="max-width: 600px; margin: 20px auto;">';
        echo '<form method="POST" action="">
                <label>Nazwa kategorii: <input type="text" name="category_name" value="' . htmlspecialchars($row['name']) . '" required></label><br>
                <label>Rodzic kategoria: 
                    <select name="parent_id">
                        <option value="0">Brak</option>';
        global $link;
        $result = $link->query("SELECT id, name FROM categories WHERE parent_id = 0 AND id != $id");
        while ($parent = $result->fetch_assoc()) {
            $selected = $parent['id'] == $row['parent_id'] ? 'selected' : '';
            echo '<option value="' . $parent['id'] . '" ' . $selected . '>' . htmlspecialchars($parent['name']) . '</option>';
        }
        echo '    </select>
                </label><br>
                <input type="submit" name="update" value="Zaktualizuj Kategorię">
              </form>';
        echo '</div>';
    } else {
        echo '<p style="color: red;">Błąd podczas pobierania danych kategorii: ' . $link->error . '</p>';
    }
}

// Funkcja do usuwania kategorii
function UsunKategorie($id) {
    include('../cfg.php');
    $query = "DELETE FROM categories WHERE id = ? OR parent_id = ?";
    $stmt = $link->prepare($query);
    if ($stmt) {
        $stmt->bind_param("ii", $id, $id);
        $stmt->execute();
        echo '<p style="color: green;">Kategoria została usunięta.</p>';
    } else {
        echo '<p style="color: red;">Błąd podczas usuwania kategorii: ' . $link->error . '</p>';
    }
}


// Logika obsługi akcji
if (isset($_GET['akcja'])) {
    $akcja = $_GET['akcja'];
    if ($akcja == 'usun' && isset($_GET['id'])) {
        UsunPodstrone((int)$_GET['id']);
    } elseif ($akcja == 'podstrony') {
        ListaPodstron();
    } elseif ($akcja == 'edytuj' && isset($_GET['id'])) {
        EdytujPodstrone((int)$_GET['id']);
    } elseif ($akcja == 'dodaj') {
        DodajNowaPodstrone();
    } elseif ($akcja == 'kategorie') {
        ListaKategorii();
    } elseif ($akcja == 'dodaj_kat') {
        DodajKategorie();
    } elseif ($akcja == 'usun_kat' && isset($_GET['id'])) {
        UsunKategorie((int)$_GET['id']);
    } elseif ($akcja == 'edytuj_kat' && isset($_GET['id'])) {
        EdytujKategorie((int)$_GET['id']);
    } elseif ($akcja == 'wyloguj') {
        session_unset();
        session_destroy();
        header("Location: admin.php");
        exit();
    } else {
        ListaPodstron();
    }
} else {
    ListaPodstron();
}

echo '</div>';
?>
