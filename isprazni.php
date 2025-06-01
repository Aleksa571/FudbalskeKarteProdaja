<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['id_korisnika'])) {
    header("Location: login.php");
    exit();
}

$idKorisnik = $_SESSION['id_korisnika'];

$stmt = $pdo->prepare("DELETE FROM korpa WHERE id_korisnika = :id_korisnika");
$stmt->execute([':id_korisnika' => $idKorisnik]);

header("Location: index.php#karte");
exit();
