// *** Funkcja do pobrania daty i jej wyświetlenia ***
function pobierzDate() { 
    // Pobranie aktualnej daty
    let dzisiaj = new Date();

    // Sformatowanie daty jako MM/DD/YY
    let data = "" + (dzisiaj.getMonth() + 1) + "/" + dzisiaj.getDate() + "/" + (dzisiaj.getFullYear() % 100);

    // Wyświetlenie daty w elemencie HTML o id 'data'
    document.getElementById("data").innerHTML = data;
}

// *** Globalne zmienne dla zegara ***
var idTimera = null; // ID timera, potrzebne do zatrzymywania i resetowania
var timerDziala = false; // Flaga wskazująca, czy timer jest aktywny

// *** Funkcja do zatrzymania zegara ***
function zatrzymajZegar() {
    if (timerDziala) {
        // Zatrzymanie bieżącego timera
        clearTimeout(idTimera);
        timerDziala = false;
    }
}

// *** Funkcja do uruchamiania zegara ***
function uruchomZegar() {
    // Zatrzymanie istniejeącego zegara (jeśli działa)
    zatrzymajZegar();

    // Pobranie i wyświetlenie daty
    pobierzDate();

    // Rozpoczęcie wyświetlania czasu
    pokazCzas();
}

// *** Funkcja do wyświetlania aktualnego czasu ***
function pokazCzas() {
    let teraz = new Date(); // Pobranie aktualnego czasu

    // Pobranie godzin, minut i sekund
    let godziny = teraz.getHours();
    let minuty = teraz.getMinutes();
    let sekundy = teraz.getSeconds();

    // Sformatowanie czasu w formacie 12-godzinnym
    let czasWartosc = "" + ((godziny > 12) ? godziny - 12 : godziny);
    czasWartosc += ((minuty < 10) ? ":0" : ":") + minuty;
    czasWartosc += ((sekundy < 10) ? ":0" : ":") + sekundy;
    czasWartosc += (godziny >= 12) ? " P.M." : " A.M.";

    // Wyświetlenie czasu w elemencie HTML o id 'zegarek'
    document.getElementById("zegarek").innerHTML = czasWartosc;

    // Ustawienie timera, aby funkcja pokazywała czas co sekundę
    idTimera = setTimeout(pokazCzas, 1000);
    timerDziala = true; // Aktualizacja flagi stanu timera
}

