<!DOCTYPE >
<html>
<head>
    <meta charset="UTF-8">
    <title>BBC-Kategorije</title>
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
        .category-title {
            font-size: 2em;
            font-weight: bold;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ddd;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #333;
        }
        .headery {
            background-color: #FFD700;
            padding: 2px 0;
        }
        .btn-primary {
    background-color: #FFD700;
    border-color: #FFD700;
    color: black;
}

.btn-primary:hover {
    background-color: #FFD700;
    border-color: #FFD700;
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

    <?php
    include 'connect.php';
    define('UPLPATH', 'img/');

    if (isset($_GET['id'])) {
        $kategorija = $_GET['id'];
    ?>
        <div class="headery">
            <div class="container">
                <h2><?php echo ucfirst($kategorija); ?></h2>
            </div>
        </div>
    <?php
    } else {
        echo '<div class="headery"><div class="container"><h1>Greška u prikazu</h1></div></div>';
    }
    ?>

    <div class="container">
        <div class="text-right mt-3">
            <p><?php echo date('l, d. F'); ?></p>
        </div>

        <section class="news-section">
            <div class="row justify-content-center">
                <?php
                if (isset($kategorija)) {
                    $query = "SELECT * FROM vijesti WHERE kategorija = '$kategorija'";
                    $result = mysqli_query($dbc, $query);

                    while ($row = mysqli_fetch_array($result)) {
                        echo '<div class="col-md-4 d-flex align-items-stretch">';
                        echo '<div class="news-item card">';
                        echo '<img src="' . UPLPATH . $row['slika'] . '" alt="' . $row['naslov'] . '" class="card-img-top">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . $row['naslov'] . '</h5>';
                        echo '<p class="card-text">' . $row['kratki_sadrzaj'] . '</p>';
                        echo '<a href="clanak.php?id=' . $row['id'] . '" class="btn btn-primary">Pročitaj više</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>Nije odabrana kategorija.</p>';
                }

                mysqli_close($dbc);
                ?>
            </div>
        </section>
    </div>

</body>
</html>
