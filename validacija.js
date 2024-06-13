document.getElementById("forma").onsubmit = function(event) {
    var slanjeForme = true;

    var poljeTitle = document.getElementById("naslov");
    var title = document.getElementById("naslov").value;
    if (title.length < 5 || title.length > 30) {
        slanjeForme = false;
        poljeTitle.style.border="1px dashed red";
        document.getElementById("porukaTitle").innerHTML="Naslov vijesti mora imati između 5 i 30 znakova!<br>";
    } else {
        poljeTitle.style.border="1px solid green";
        document.getElementById("porukaTitle").innerHTML="";
    }

    var poljeAbout = document.getElementById("kratki_sadrzaj");
    var about = document.getElementById("kratki_sadrzaj").value;
    if (about.length < 10 || about.length > 100) {
        slanjeForme = false;
        poljeAbout.style.border="1px dashed red";
        document.getElementById("porukaAbout").innerHTML="Kratki sadržaj mora imati između 10 i 100 znakova!<br>";
    } else {
        poljeAbout.style.border="1px solid green";
        document.getElementById("porukaAbout").innerHTML="";
    }

    var poljeContent = document.getElementById("sadrzaj");
    var content = document.getElementById("sadrzaj").value;
    if (content.length == 0) {
        slanjeForme = false;
        poljeContent.style.border="1px dashed red";
        document.getElementById("porukaContent").innerHTML="Sadržaj mora biti unesen!<br>";
    } else {
        poljeContent.style.border="1px solid green";
        document.getElementById("porukaContent").innerHTML="";
    }

    var poljeSlika = document.getElementById("slika");
    var pphoto = document.getElementById("slika").value;
    if (pphoto.length == 0) {
        slanjeForme = false;
        poljeSlika.style.border="1px dashed red";
        document.getElementById("porukaSlika").innerHTML="Slika mora biti unesena!<br>";
    } else {
        poljeSlika.style.border="1px solid green";
        document.getElementById("porukaSlika").innerHTML="";
    }

    var poljeCategory = document.getElementById("kategorija");
    if (document.getElementById("kategorija").selectedIndex == 0) {
        slanjeForme = false;
        poljeCategory.style.border="1px dashed red";
        document.getElementById("porukaKategorija").innerHTML="Kategorija mora biti odabrana!<br>";
    } else {
        poljeCategory.style.border="1px solid green";
        document.getElementById("porukaKategorija").innerHTML="";
    }

    if (!slanjeForme) {
        event.preventDefault();
    }
};
