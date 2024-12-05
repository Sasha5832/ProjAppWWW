var obliczone = false;
var dziesietny = 0;

function konwertuj(entryform, from, to) {
    convertfrom = from.selectedIndex;
    convertto = to.selectedIndex;
    entryform.display.value = (entryform.wejscie.value * from[convertfrom].value / to[convertto].value);
}

function dodajZnak(wejscie, znak) {
    if ((znak == '.' && dziesietny == "0") || znak != '.') {
        wejscie.value == "" || wejscie.value == "0" ? wejscie.value = znak : wejscie.value += znak;
        konwertuj(wejscie.form, wejscie.form.measure1, wejscie.form.measure2);
        obliczone = true;
        if (znak == '.') {
            dziesietny = 1;
        }
    }
}

function openVothcom() {
    window.open("", "Display window", "toolbar=no,directories=no,menubar=no");
}

function clear(form) {
    form.wejscie.value = 0;
    form.display.value = 0;
    dziesietny = 0;
}

function changeBackground(hexNumber) {
    document.bgColor = hexNumber;
}

