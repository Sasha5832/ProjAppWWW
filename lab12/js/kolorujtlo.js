// --------------------------------------
// Globalne zmienne
// --------------------------------------
var obliczone = false; // Flaga, czy wartość została obliczona
var dziesietny = 0;    // Flaga dziesiętna (czy liczba zawiera ".")

// --------------------------------------
// Funkcja konwersji jednostek
// --------------------------------------
function konwertuj(entryform, from, to) {
    let convertfrom = from.selectedIndex; // Pobranie indeksu wybranej jednostki wejściowej
    let convertto = to.selectedIndex;     // Pobranie indeksu wybranej jednostki wyjściowej
    
    // Obliczenie wartości wyjściowej na podstawie współczynników konwersji
    entryform.display.value = (entryform.wejscie.value * from[convertfrom].value / to[convertto].value);
}

// --------------------------------------
// Funkcja dodawania znaku do wejścia
// --------------------------------------
function dodajZnak(wejscie, znak) {
    // Dodanie znaku tylko, jeśli nie jest to kropka po kropce
    if ((znak == '.' && dziesietny == "0") || znak != '.') {
        wejscie.value == "" || wejscie.value == "0" ? wejscie.value = znak : wejscie.value += znak;
        
        // Przeliczenie po dodaniu znaku
        konwertuj(wejscie.form, wejscie.form.measure1, wejscie.form.measure2);
        obliczone = true;
        
        // Ustawienie flagi dla liczby dziesiętnej
        if (znak == '.') {
            dziesietny = 1;
        }
    }
}

// --------------------------------------
// Funkcja otwierania nowego okna (nieużywana)
// --------------------------------------
function openVothcom() {
    window.open("", "Display window", "toolbar=no,directories=no,menubar=no");
}

// --------------------------------------
// Funkcja czyszczenia formularza
// --------------------------------------
function clear(form) {
    form.wejscie.value = 0;   // Reset wejścia
    form.display.value = 0;   // Reset wyjścia
    dziesietny = 0;           // Reset flagi dziesiętnej
}

// --------------------------------------
// Funkcja zmiany koloru tła strony
// --------------------------------------
function changeBackground(hexNumber) {
    document.bgColor = hexNumber; // Ustawienie koloru tła na podstawie podanego kodu HEX
}