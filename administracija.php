<?php
include 'connect.php';
session_start();

$registriranKorisnik = false;
$msg = '';

if (isset($_POST['add_user'])) {
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
                $msg = 'Korisnik je uspješno dodan.';
            } else {
                $msg = 'Dodavanje korisnika nije uspjelo. Molimo pokušajte ponovno.';
            }
        }
    }
    mysqli_close($dbc);
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $stmt = mysqli_prepare($dbc, "DELETE FROM vijesti WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
}

define('UPLPATH', 'img/');
if (isset($_POST['update'])) {
    $picture = $_FILES['pphoto']['name'];
    $title = $_POST['title'];
    $about = $_POST['about'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $archive = isset($_POST['archive']) ? 1 : 0;

    $target_dir = 'img/' . $picture;
    move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_dir);
    $id = $_POST['id'];
    $stmt = mysqli_prepare($dbc, "UPDATE vijesti SET naslov=?, kratki_sadrzaj=?, sadrzaj=?, slika=?, kategorija=?, arhiva=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'ssssssi', $title, $about, $content, $picture, $category, $archive, $id);
    mysqli_stmt_execute($stmt);
}
?>

<!DOCTYPE >
<html>
<head>
    <meta charset="UTF-8">
    <title>Administracija</title>
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
        form textarea:focus,
        form select:focus,
        form input[type="file"]:focus {
            border-color: orange;
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
            background-color: darkorange;
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
                    <li><a href="registracija.php">Registracija</a></li>
                    <li><a href="prijava.php">Prijava i Administracija</a></li>

                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <h1 style="padding: 2%;">Dodavanje korisnika</h1>
        <?php 
        if ($registriranKorisnik) {
            echo '<p>' . $msg . '</p>';
        } elseif (isset($_SESSION['razina']) && $_SESSION['razina'] == 1) { ?>
            <form method="post" action="administracija.php">
                <label for="ime">Ime:</label>
                <input type="text" name="ime" id="ime" required>
                
                <label for="prezime">Prezime:</label>
                <input type="text" name="prezime" id="prezime" required>
                
                <label for="username">Korisničko ime:</label>
                <input type="text" name="username" id="username" required>
                
                <label for="password">Lozinka:</label>
                <input type="password" name="password" id="password" required>
                
                <button type="submit" name="add_user">Dodaj korisnika</button>
            </form>
            
            <h2>Upravljanje vijestima</h2>
            <?php
            $query = "SELECT * FROM vijesti";
            $result = mysqli_query($dbc, $query);
            while ($row = mysqli_fetch_array($result)) {
                echo '<form enctype="multipart/form-data" action="administracija.php" method="POST">
                    <div class="form-item">
                        <label for="title">Naslov vijesti:</label>
                        <div class="form-field">
                            <input type="text" name="title" class="form-field-textual" value="' . $row['naslov'] . '">
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="about">Kratki sadržaj vijesti (do 50 znakova):</label>
                        <div class="form-field">
                            <textarea name="about" cols="30" rows="10" class="form-field-textual">' . $row['kratki_sadrzaj'] . '</textarea>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="content">Sadržaj vijesti:</label>
                        <div class="form-field">
                            <textarea name="content" cols="30" rows="10" class="form-field-textual">' . $row['sadrzaj'] . '</textarea>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="pphoto">Slika:</label>
                        <div class="form-field">
                            <input type="file" class="input-text" id="pphoto" value="' . $row['slika'] . '" name="pphoto"/> <br>
                            <img src="' . UPLPATH . $row['slika'] . '" width=100px>
                        </div>
                    </div>
                    <div class="form-item">
                        <label for="category">Kategorija vijesti:</label>
                        <div class="form-field">
                            <select name="category" class="form-field-textual">
                                <option value="sport"' . ($row['kategorija'] == 'sport' ? ' selected' : '') . '>Sport</option>
                                <option value="kultura"' . ($row['kategorija'] == 'kultura' ? ' selected' : '') . '>Kultura</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-item">
                        <label>Spremiti u arhivu:</label>
                        <div class="form-field">';
                if ($row['arhiva'] == 0) {
                    echo '<input type="checkbox" name="archive" id="archive"/> Arhiviraj?';
                } else {
                    echo '<input type="checkbox" name="archive" id="archive" checked/> Arhiviraj?';
                }
                echo '</div>
                        </label>
                    </div>
                    <div class="form-item">
                        <input type="hidden" name="id" class="form-field-textual" value="' . $row['id'] . '">
                        <button type="reset" value="Poništi">Poništi</button>
                        <button type="submit" name="update" value="Prihvati">Izmjeni</button>
                        <button type="submit" name="delete" value="Izbriši">Izbriši</button>
                    </div>
                </form>';
            }
            ?>
        <?php } else {
            echo '<p>Prijavljeni, ali niste administrator.</p>';
        }?>
    </div>

    <script type="text/javascript">
        document.getElementById("dodajKorisnika").onclick = function(event) {
            var slanjeForme = true;

            var poljeIme = document.getElementById("ime");
            var ime = document.getElementById("ime").value;
            if (ime.length == 0) {
                slanjeForme = false;
                poljeIme.style.border = "1px dashed red";
                document.getElementById("porukaIme").innerHTML = "<br>Unesite ime!<br>";
            } else {
                poljeIme.style.border = "1px solid green";
                document.getElementById("porukaIme").innerHTML = "";
            }

            var poljePrezime = document.getElementById("prezime");
            var prezime = document.getElementById("prezime").value;
            if (prezime.length == 0) {
                slanjeForme = false;
                poljePrezime.style.border = "1px dashed red";
                document.getElementById("porukaPrezime").innerHTML = "<br>Unesite prezime!<br>";
            } else {
                poljePrezime.style.border = "1px solid green";
                document.getElementById("porukaPrezime").innerHTML = "";
            }

            var poljeUsername = document.getElementById("username");
            var username = document.getElementById("username").value;
            if (username.length == 0) {
                slanjeForme = false;
                poljeUsername.style.border = "1px dashed red";
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
                poljePass.style.border = "1px dashed red";
                poljePassRep.style.border = "1px dashed red";
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
