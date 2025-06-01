<?php
session_start();

if (!isset($_SESSION['id_korisnika'])) {
    header("Location: login.php?error=1");
    exit();
}

include 'conn.php';
$stmt = $pdo->prepare("SELECT active FROM korisnik WHERE id_korisnika = ?");
$stmt->execute([$_SESSION['id_korisnika']]);
$user = $stmt->fetch();

if (!$user || $user['active'] != 1) {
    session_destroy(); // Uklanjanje sesije ako nije aktivan
    header("Location: login.php?error=2"); // Niste aktivirani
    exit();
}
?>
