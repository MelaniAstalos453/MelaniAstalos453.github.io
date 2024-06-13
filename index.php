<!DOCTYPE >
<html>
<head>
    <meta charset="UTF-8">
    <title>BBC Vijesti</title>
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
        .btn-custom {
            background-color: #FFD700;
            color: black;
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            font-weight: 640;
            padding: 5px 10px; 
            font-size: 0.9em;  
            transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s; 
        }
        .btn-custom:hover {
            background-color: #FFC300; 
            transform: scale(1.05); 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
        }
        .category-section {
            margin-bottom: 50px;
        }
        .category-section h2 {
            margin-top: 30px;
        }
        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .card-img-top {
            height: 400px;
            width: 475px;
            object-fit: cover;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        .card-title {
            margin-bottom: 10px;
            font-size: 1.5em;
        }
        .card-text {
            flex-grow: 1;
        }
        .news-item, .sport-item {
            margin-bottom: 30px;
        }
        .custom-container {
            max-width: 1500px;
        }
        a.goto {
            position: relative;
            text-decoration: none;
            color: inherit;
        }
        a.goto:hover .card {
            transform: scale(1.02);
            transition: transform 0.2s ease-in-out;
        }
        a.goto .card {
            border: none;
        }
        a.goto .card-body {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .footer {
    background-color: #f8f9fa;
    padding: 20px 0;
    text-align: center;
}
    </style>
</head>
<body>
    <header>
        <div class="container custom-container">
            <div class="header-content">
                <div class="logo">
                    <img src="bbc-logo-black-and-white.png" alt="BBC Logo">
                </div>
                <nav>
                    <ul>
                        <li><a href="#">Naslovnica</a></li>
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
    <div class="container custom-container">
        <?php if (isset($_SESSION['success_msg'])): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['success_msg']; ?>
            </div>
            <?php unset($_SESSION['success_msg']);  ?>
        <?php endif; ?>

    <div class="container custom-container">
        <div class="text-right mt-3">
            <p><?php echo date('l, d. F'); ?></p>
        </div>

        <h4 class="tekstw">Dobrodošli na BBC.com</h4>

        <section class="news-section category-section">
            <h2 class="category-title"><a href="kategorija.php?id=KULTURA" style="color: #BA0000;">Kultura</a></h2>
            <div class="row">
                <?php
                include 'connect.php';
                define('UPLPATH', 'img/');

                $query = "SELECT * FROM vijesti WHERE kategorija='KULTURA' LIMIT 3";
                $result = mysqli_query($dbc, $query);

                while ($row = mysqli_fetch_array($result)) {
                    echo '<div class="col-lg-4 col-md-6 mb-4">';
                    echo '<a href="clanak.php?id=' . $row['id'] . '" class="goto">';
                    echo '<div class="news-item card">';
                    echo '<img src="' . UPLPATH . $row['slika'] . '" alt="' . $row['naslov'] . '" class="card-img-top">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row['naslov'] . '</h5>';
                    echo '<p class="card-text">' . $row['kratki_sadrzaj'] . '</p>';
                    echo '<button class="btn btn-custom">Pročitaj više</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</a>';
                    echo '</div>';
                }
                ?>
            </div>
        </section>

        <section class="sport-section category-section">
            <h2 class="category-title"><a href="kategorija.php?id=SPORT" style="color: #BA0000;">Sport</a></h2>
            <div class="row">
                <?php
                $query = "SELECT * FROM vijesti WHERE kategorija='SPORT' LIMIT 3";
                $result = mysqli_query($dbc, $query);

                while ($row = mysqli_fetch_array($result)) {
                    echo '<div class="col-lg-4 col-md-6 mb-4">';
                    echo '<a href="clanak.php?id=' . $row['id'] . '" class="goto">';
                    echo '<div class="sport-item card">';
                    echo '<img src="' . UPLPATH . $row['slika'] . '" alt="' . $row['naslov'] . '" class="card-img-top">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row['naslov'] . '</h5>';
                    echo '<p class="card-text">' . $row['kratki_sadrzaj'] . '</p>';
                    echo '<button class="btn btn-custom">Pročitaj više</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</a>';
                    echo '</div>';
                }

                mysqli_close($dbc);
                ?>
            </div>
        </section>
    </div>
    </div>
    <footer class="footer text-center">
        <p>&copy; Copyright 2024 BBC.</p>
    </footer>
</body>
</html>
