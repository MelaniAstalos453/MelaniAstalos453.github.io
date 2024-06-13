<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vijesti_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $naslov = $_POST['naslov'];
    $kratki_sadrzaj = $_POST['kratki_sadrzaj'];
    $sadrzaj = $_POST['sadrzaj'];
    $kategorija = $_POST['kategorija'];
    $slika = $_FILES['slika']['name'];
    $arhiva = isset($_POST['arhiva']) ? 1 : 0;

    $target_dir = "img/";
    $target_file = $target_dir . basename($slika);

    if (move_uploaded_file($_FILES["slika"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO vijesti (naslov, kratki_sadrzaj, sadrzaj, kategorija, slika, arhiva, datum) 
                VALUES ('$naslov', '$kratki_sadrzaj', '$sadrzaj', '$kategorija', '$slika', '$arhiva', NOW())";

        if ($conn->query($sql) === TRUE) {
            echo "Vijest uspješno unesena!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Došlo je do greške pri uploadu slike.";
    }
}

$conn->close();
?>

<!DOCTYPE >
<html>
<head>
    <meta charset="UTF-8">
    <title>Uneseni članak</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        header {
            background-color: #000;
            color: white;
            display: flex;
            justify-content: flex-start;
        }
        .headery {
            background-color: #FFD700;
            padding: 0.5px 0;
            font-weight: 1000;
        }
        .header-content {
            display: flex;
            align-items: center;
        }
        .logo img {
            height: 40px;
            margin-right: 20px;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
        }
        nav ul li {
            margin-left: 10px;
            border-left: 1px solid #555;
            padding-left: 10px;
        }
        nav ul li:first-child {
            border-left: none;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 0.9em;
        }
        nav ul li a:hover {
            color: #FFD700;
        }
        .news-section {
            margin-top: 20px;
        }
        .news-section h2 {
            color: orange;
        }
        .news-item img, .sport-item img {
            width: 100%;
            height: auto;
        }
        .footer {
    background-color: #f8f9fa;
    padding: 20px 0;
    text-align: center;
}
        .header h1 {
            margin: 0;
            padding: 0 15px;
        }
        .article-title {
            margin-top: 20px;
        }
        .article-content img {
            width: 100%;
            height: auto;
        }
        .title {
            padding: 5px;
            font-weight: 700;
        }
        .category {
            font-weight: bold;
        }
        .sumary1 {
            width: 100%;
            word-wrap: break-word;
        }
        .summary {
            padding: 5%;
        }
        h5 {
            padding-top: 10px;
            font-weight: bold;
            word-wrap: break-word;
        }
        .date {
            margin-top: 10px;
            color: #888;
            font-size: 0.9em;
        }
    </style>

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
                    <li><a href="unos.html">Unesite članak</a></li>
                    <li><a href="kategorija.php?id=kultura">Kultura</a></li>
                    <li><a href="kategorija.php?id=sport">Sport</a></li>
                    <li><a href="registracija.php">Registracija</a></li>
                    <li><a href="prijava.php">Prijava i Administracija</a></li>

                </ul>
            </nav>
        </div>
    </div>
</header>

<div class="header">
    <div class="headery">
        <div class="container">
            <h1 class="category"><?php echo $_POST['kategorija']; ?></h1>
        </div>
    </div>
</div>

<div class="container">
    <div class="article-title">
        <h2 class="title"><?php echo $_POST['naslov']; ?></h2>
    </div>
    <div class="article-content">
        <img src="<?php echo 'img/' . $_FILES['slika']['name']; ?>" alt="Naslovna slika">
        <div class="date"><?php echo date("d.m.Y H:i:s"); ?></div>
    </div>
    <div class="summary1">
        <h5 style="font-weight: 1200;"><?php echo $_POST['kratki_sadrzaj']; ?></h5>
    </div>
    <p class="sumary1"><?php echo $_POST['sadrzaj']; ?></p>
</div>

<footer class="footer text-center">
    <p>&copy; Copyright 2024 BBC.</p>
</footer>

</body>
</html>
