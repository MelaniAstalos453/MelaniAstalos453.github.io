<?php
include 'connect.php';
$registriranKorisnik = false;
$msg = '';

if (isset($_POST['register'])) {
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime = ?";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $msg = 'Korisničko ime već postoji!';
        } else {
            $query = "INSERT INTO korisnik (ime, prezime, korisnicko_ime, lozinka, razina) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($dbc);
            if (mysqli_stmt_prepare($stmt, $query)) {
                $razina = 1; 
                mysqli_stmt_bind_param($stmt, 'ssssi', $ime, $prezime, $username, $hashed_password, $razina);
                mysqli_stmt_execute($stmt);
                $registriranKorisnik = true;
                $msg = 'Uspješno ste se registrirali.';
            } else {
                $msg = 'Dogodila se greška.Probajte ponovno.';
            }
        }
    }
    mysqli_close($dbc);
}
?>




<!DOCTYPE >
<html>
<head>
    <meta charset="UTF-8">
    <title>Registracija</title>
    <link href="style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
  body {
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #000;
            padding: 15px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo img {
            height: 40px;
        }

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

        .container {
            background-color: white;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 20px;
        }

        form label {
            font-weight: bold;
        }

        form input[type="text"],
        form input[type="password"],
        form textarea,
        form select,
        form input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: border-color 0.3s;
        }

        form input[type="text"]:focus,
        form input[type="password"]:focus,
        form textarea:focus,
        form select:focus,
        form input[type="file"]:focus {
            border-color: orange;
        }

        form .form-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        form input[type="checkbox"] {
            transform: scale(1.5);
            margin-left: 10px;
        }

        form button[type="submit"] {
            padding: 10px 20px;
            background-color: orange;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
            border-radius: 4px;
        }

        form button[type="submit"]:hover {
            background-color: darkgoldenrod;
        }

        hr {
            border: 0;
            border-top: 2px solid orange;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        footer {
            text-align: center;
            background-color: #f8f9fa;
            padding: 10px 0;
            margin-top: 20px;
            border-top: 1px solid #ddd;
        }
   </style>   
</head>
<body>
    <header>
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
                    <li><a href="administracija.php">Registracija</a></li>
                    <li><a href="prijava.php">Prijava i Administracija</a></li>

                </ul>
            </nav>
        </div>    </header>
    <div class="container">
        <h1 style="padding: 2%;">Registracija</h1>
        <?php if ($registriranKorisnik) {
            echo '<p>' . $msg . '</p>';
        } else { ?>
        <form method="post" action="registracija.php">
        <label for="ime">Ime:</label>
            <input type="text" name="ime" id="ime" required>
            <span id="porukaIme" class="bojaPoruke"></span>

            <label for="prezime">Prezime:</label>
            <input type="text" name="prezime" id="prezime" required>
            <span id="porukaPrezime" class="bojaPoruke"></span>

            <label for="username">Korisničko ime:</label>
            <input type="text" name="username" id="username" required>
            <span id="porukaUsername" class="bojaPoruke"></span>

            <label for="password">Lozinka:</label>
            <input type="password" name="password" id="password" required>
            <span id="porukaPass" class="bojaPoruke"></span>

            <label for="passRep">Ponovite lozinku:</label>
            <input type="password" name="passRep" id="passRep" required>
            <span id="porukaPassRep" class="bojaPoruke"></span>

            <button type="submit" name="register" id="slanje">Registriraj se</button>        </form>
        <?php echo '<p>' . $msg . '</p>'; } ?>
    </div>


    <script type="text/javascript">
        document.getElementById("slanje").onclick = function(event) {
            var slanjeForme = true;

            var poljeIme = document.getElementById("ime");
            var ime = document.getElementById("ime").value;
            if (ime.length == 0) {
                slanjeForme = false;
                poljeIme.style.border = "1px solid red";
                document.getElementById("porukaIme").innerHTML = "<br>Unesite ime!<br>";
            } else {
                poljeIme.style.border = "1px solid green";
                document.getElementById("porukaIme").innerHTML = "";
            }

            var poljePrezime = document.getElementById("prezime");
            var prezime = document.getElementById("prezime").value;
            if (prezime.length == 0) {
                slanjeForme = false;
                poljePrezime.style.border = "1px solid red";
                document.getElementById("porukaPrezime").innerHTML = "<br>Unesite prezime!<br>";
            } else {
                poljePrezime.style.border = "1px solid green";
                document.getElementById("porukaPrezime").innerHTML = "";
            }

            var poljeUsername = document.getElementById("username");
            var username = document.getElementById("username").value;
            if (username.length == 0) {
                slanjeForme = false;
                poljeUsername.style.border = "1px solid red";
                document.getElementById("porukaUsername").innerHTML = "<br>Unesite korisničko ime!<br>";
            } else {
                poljeUsername.style.border = "1px solid green";
                document.getElementById("porukaUsername").innerHTML = "";
            }

            var poljePass = document.getElementById("password");
            var pass = document.getElementById("password").value;
            var poljePassRep = document.getElementById("passRep");
            var passRep = document.getElementById("passRep").value;
            if (pass.length == 0 || passRep.length == 0 || pass != passRep) {
                slanjeForme = false;
                poljePass.style.border = "1px solid red";
                poljePassRep.style.border = "1px solid red";
                document.getElementById("porukaPass").innerHTML = "<br>Lozinke nisu iste!<br>";
                document.getElementById("porukaPassRep").innerHTML = "<br>Lozinke nisu iste!<br>";
            } else {
                poljePass.style.border = "1px solid green";
                poljePassRep.style.border = "1px solid green";
                document.getElementById("porukaPass").innerHTML = "";
                document.getElementById("porukaPassRep").innerHTML = "";
            }

            if (slanjeForme != true) {
                event.preventDefault();
            }
        };
    </script>
</body>
</html>




















