<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vijesti_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
        include 'connect.php';

        $picture = $_FILES['slika']['name'];
        $naslov = $_POST['naslov'];
        $kratki_sadrzaj = $_POST['kratki_sadrzaj'];
        $sadrzaj = $_POST['sadrzaj'];
        $kategorija = $_POST['kategorija']; 
        $datum = date('Y-m-d');  
        $arhiva = isset($_POST['arhiva']) ? 1 : 0;
        $target_dir = 'img/' . $picture;

        move_uploaded_file($_FILES["slika"]["tmp_name"], $target_dir);

        $query = "INSERT INTO vijesti (naslov, kratki_sadrzaj, sadrzaj, kategorija, slika, arhiva) 
                  VALUES ('$naslov', '$kratki_sadrzaj', '$sadrzaj', '$kategorija', '$picture', '$arhiva')";
        
        $result = mysqli_query($dbc, $query) or die('Error querying database.');

        mysqli_close($dbc);
        echo "Uspješno ste unijeli članak!";
    }
?>



<!DOCTYPE >
<html >
<head>
    <meta charset="UTF-8">
    <title>Unos nove vijesti</title>
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>

<header>
    <div class="container">
        <div class="header-content">
            <div class="logo">
                <img src="bbc-logo-black-and-white.png" alt="BBC Logo">
            </div>
            <nav>
                <ul>
                <li><a href="index.php">Naslovnica</a></li>
                        <li><a href="#">Unesite članak</a></li>
                        <li><a href="kategorija.php?id=kultura">Kultura</a></li>
                        <li><a href="kategorija.php?id=sport">Sport</a></li>
                        <li><a href="registracija.php">Registracija</a></li>
                        <li><a href="prijava.php">Prijava i Administracija</a></li>

                </ul>
            </nav>
        </div>
    </div>
</header>

<section role="main">
    <div class="container">
        <h2>Unos nove vijesti</h2>
        <form action="skripta.php" method="POST" enctype="multipart/form-data">
            <div class="form-item">
                <label for="naslov">Naslov vijesti</label>
                <div class="form-field">
                    <input type="text" name="naslov" class="form-field-textual" >
                </div>
            </div>
            <div class="form-item">
                <label for="kratki_sadrzaj">Kratki sadržaj vijesti (do 50 znakova)</label>
                <div class="form-field">
                    <textarea name="kratki_sadrzaj" id="kratki_sadrzaj" cols="30" rows="10" class="form-field-textual" maxlength="150" ></textarea>
                </div>
            </div>
            <div class="form-item">
                <label for="sadrzaj">Sadržaj vijesti</label>
                <div class="form-field">
                    <textarea name="sadrzaj" id="sadrzaj" cols="30" rows="10" class="form-field-textual" ></textarea>
                </div>
            </div>
            <div class="form-item">
                <label for="slika">Slika: </label>
                <div class="form-field">
                    <input type="file" accept="image/jpg,image/gif" class="input-text" name="slika" >
                </div>
            </div>
            <div class="form-item">
                <label for="kategorija">Kategorija vijesti</label>
                <div class="form-field">
                    <select name="kategorija" id="kategorija" class="form-field-textual" >
                        <option value="SPORT">Sport</option>
                        <option value="KULTURA">Kultura</option>
                    </select>
                </div>
            </div>
            <div class="form-item">
                <label>Spremiti u arhivu:</label>
                <div class="form-field">
                    <input type="checkbox" name="arhiva">
                </div>
            </div>
            <div class="form-item">
                <button type="reset" value="Poništi">Poništi</button>
                <button type="submit" value="Prihvati">Prihvati</button>
            </div>
        </form>
    </div>
</section>



</body>
</html>