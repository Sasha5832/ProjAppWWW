<?php

// --------------------------------------
// Ustawienia początkowe i konfiguracja
// --------------------------------------
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

// Ładowanie wymaganych plików konfiguracyjnych
include('showpage.php');

// --------------------------------------
// Dynamiczne wczytywanie treści podstrony
// --------------------------------------
$strona = '<p>Brak zawartości</p>'; // Domyślna zawartość

// Weryfikacja parametru GET 'id' i zabezpieczenie przed atakiem typu CODE INJECTION
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Konwersja na liczbę calkowitą w celu ochrony przed code injection
    $strona = PokazPodstrone($id);
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="Content-Language" content="pl" />
    <meta name="Author" content="Hrypas Oleksandr" />
    <link rel="stylesheet" href="css/style.css">
    <title>Komputer moją pasją</title>
    <script src="js/kolorujtlo.js" type="text/javascript"></script>
    <script src="js/timedate.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body onload="uruchomZegar()">

    

    <!-- Główna struktura strony -->
    <div class="container">
        <table class="layout">
            <tr>
                <td colspan="2" class="header">
                    <h1>Komputer moją pasją</h1>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="menu">
                    <!-- Nawigacja strony -->
                    <div class="menu">
                        <a href="index.php?id=1">Strona Główna</a>
                        <a href="index.php?id=2">Historia komputerów</a>
                        <a href="index.php?id=3">Podzespoły</a>
                        <a href="index.php?id=4">Oprogramowanie</a>
                        <a href="index.php?id=5">Kontakt</a>
                        <a href="koszyk.php">Sklep Internetowy</a>
                        <a href="admin/admin.php">Panel Administratora</a>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="content">
                    <?php
                        // Wyświetlanie treści podstrony
                        echo $strona;
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="footer">
                    <!-- Stopka strony -->
                    <p>&copy; 2024 Oleksandr Hrypas. Wszelkie prawa zastrzeżone.</p>
                    <?php
                        $nr_indeksu = '169405';
                        $nrGrupy = '2';
                        echo 'Autor: Oleksandr Hrypas. ' . $nr_indeksu . ', grupa: ' . $nrGrupy;
                    ?>
                </td>
            </tr>
        </table>
    </div>

    <!-- Sekcja zegarka i daty -->
    <div id="zegarek"></div>
    <div id="data"></div>

    <!-- Formularz zmiany tła strony -->
    <form method="POST" name="background">
        <input type="button" value="żółty" onclick="changeBackground('#FFF000')">
        <input type="button" value="czarny" onclick="changeBackground('#000000')">
        <input type="button" value="biały" onclick="changeBackground('#FFFFFF')">
        <input type="button" value="zielony" onclick="changeBackground('#00FF00')">
        <input type="button" value="niebieski" onclick="changeBackground('#0000FF')">
        <input type="button" value="pomarańczowy" onclick="changeBackground('#FF8000')">
        <input type="button" value="szary" onclick="changeBackground('#c0c0c0')">
        <input type="button" value="czerwony" onclick="changeBackground('#FF0000')">
    </form>
    
    <!-- Sekcja animacji
    <div id="animacjaTestowa3" class="test-block">Klikaj, abym urósł</div>
    <script>
        $("#animacjaTestowa3").on("click", function() {
            if (!$(this).is(":animated")) {
                $(this).animate({
                    width: "+=50",
                    height: "+=10",
                    opacity: "+=0.1"
                }, {
                    duration: 3000
                });
            }
        });
    </script>

    <div id="animacjaTestowa2" class="test-block">Najedź kursorem, a się powiększę</div>
    <script>
        $("#animacjaTestowa2").on({
            "mouseover": function() {
                $(this).animate({
                    width: 300
                }, 800);
            },
            "mouseout": function() {
                $(this).animate({
                    width: 200
                }, 800);
            }
        });
    </script>

    <div id="animacjaTestowa1" class="test-block">Kliknij, a się powiększę</div>
    <script>
        $("#animacjaTestowa1").on("click", function() {
            $(this).animate({
                width: "500px",
                opacity: 0.4,
                fontSize: "3em",
                borderWidth: "10px"
            }, 1500);
        });
    </script>
     -->
</body>
</html>