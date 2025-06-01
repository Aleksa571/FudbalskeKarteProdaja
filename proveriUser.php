<?php
session_start();
include 'conn.php';

if (isset($_POST['username'], $_POST['password']) && !empty($_POST['username']) && !empty($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $upit = $pdo->prepare("SELECT * FROM korisnik WHERE username = :username");
    $upit->bindParam(':username', $username);
    $upit->execute();

    $korisnik = $upit->fetch(PDO::FETCH_ASSOC);

    if (!$korisnik) {
        header("Location: login.php?error=4"); // Korisnik ne postoji
        exit();
    }

    if ($password !== $korisnik['password']) {
        header("Location: login.php?error=3"); // Pogresna lozinka
        exit();
    }

    if ((int)$korisnik['active'] !== 1) {
        header("Location: login.php?error=2"); // Nalog nije aktiviran
        exit();
    }

    $_SESSION['id_korisnika'] = $korisnik['id_korisnika'];
    $_SESSION['username'] = $korisnik['username'];
    $_SESSION['id_uloga'] = $korisnik['id_uloga'];

    switch ((int)$korisnik['id_uloga']) {
        case 1:
            header("Location: admin.php");
            exit();
        case 2:
            header("Location: index.php");
            exit();
        default:
            header("Location: login.php?error=1"); 
            exit();
    }

} else {
    header("Location: login.php?error=1"); // Niste uneli korisničko ime i lozinku
    exit();
}