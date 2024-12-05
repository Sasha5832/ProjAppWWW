function pobierzDate() { 
    dzisiaj = new Date();
    data = "" + (dzisiaj.getMonth() + 1) + "/" + dzisiaj.getDate() + "/" + (dzisiaj.getYear() - 100);
    document.getElementById("data").innerHTML = data;
}

var idTimera = null;
var timerDziala = false;

function zatrzymajZegar() {
    if (timerDziala) {
        clearTimeout(idTimera);
        timerDziala = false;
    }
}

function uruchomZegar() {
    zatrzymajZegar();
    pobierzDate();
    pokazCzas();
}

function pokazCzas() {
    var teraz = new Date();
    var godziny = teraz.getHours();
    var minuty = teraz.getMinutes();
    var sekundy = teraz.getSeconds();
    var czasWartosc = "" + ((godziny > 12) ? godziny - 12 : godziny);
    czasWartosc += ((minuty < 10) ? ":0" : ":") + minuty;
    czasWartosc += ((sekundy < 10) ? ":0" : ":") + sekundy;
    czasWartosc += (godziny >= 12) ? " P.M." : " A.M.";
    document.getElementById("zegarek").innerHTML = czasWartosc;
    idTimera = setTimeout("pokazCzas()", 1000);
    timerDziala = true;
}
