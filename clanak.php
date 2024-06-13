<!DOCTYPE >
<html>
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<style>
      nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 1.3em;
            transition: color 0.3s;
        }
        nav ul li a:hover {
            color: #FFD700;
        }
     .headery {
            background-color: #FFD700;
            padding: 2px 0;
        }
        .footer {
    background-color: #f8f9fa;
    padding: 20px 0;
    text-align: center;
}
</style>
    <title>Članak</title>
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

<?php
include 'connect.php';
define('UPLPATH', 'img/');

$id = $_GET['id'];
$query = "SELECT * FROM vijesti WHERE id=$id";
$result = mysqli_query($dbc, $query);
$row = mysqli_fetch_array($result);


echo '<div class="headery"><div class="container"><h2>' . $row['kategorija'] . '</h2></div></div>';
echo '<div class="container">';
echo '<h1>' . $row['naslov'] . '</h1>';
echo '<p>' . $row['datum'] . '</p>';
echo '<img src="' . UPLPATH . $row['slika'] . '" alt="' . $row['naslov'] .'" class="card-img-top">';
echo '<h4><div class="container">' . $row['kratki_sadrzaj'] . '</h4></div>';
echo '<p><div class="container">' . $row['sadrzaj'] . '</p></div>';
echo '</div>';

mysqli_close($dbc);
?>

<footer class="footer text-center">
        <p>&copy; Copyright 2024 BBC.</p>
    </footer>
</body>
</html>

