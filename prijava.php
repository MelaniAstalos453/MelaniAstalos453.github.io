<?php
include 'connect.php';
session_start();

$msg = '';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, korisnicko_ime, lozinka, razina FROM korisnik WHERE korisnicko_ime = ?";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $id, $korisnicko_ime, $hashed_password, $razina);
            mysqli_stmt_fetch($stmt);
            if (password_verify($password, $hashed_password)) {
                $_SESSION['id'] = $id;
                $_SESSION['korisnicko_ime'] = $korisnicko_ime;
                $_SESSION['razina'] = $razina;
                
                $_SESSION['success_msg'] = 'Uspješno ste se prijavili. Dobrodošli!';

                header("Location: administracija.php");
                exit();
            } else {
                $msg = 'Pogrešno korisničko ime ili lozinka!';
            }
        } else {
            $msg = 'Pogrešno korisničko ime ili lozinka!';
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($dbc);
}
?>

<!DOCTYPE >
<html>
<head>
    <meta charset="UTF-8">
    <title>Prijava i Administracija</title>
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
        <h1 style="padding: 2%;">Prijava</h1>
        <?php if (isset($msg)) echo '<p>' . $msg . '</p>'; ?>
        <form method="post" action="prijava.php">
            <label for="username">Korisničko ime:</label>
            <input type="text" name="username" id="username" required>
            
            <label for="password">Lozinka:</label>
            <input type="password" name="password" id="password" required>
            
            <button type="submit" name="login">Prijavi se</button>
        </form>
    </div>
</body>
</html>
