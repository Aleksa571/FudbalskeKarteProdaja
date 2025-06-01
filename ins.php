<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['id_korisnika'])) {
    header("Location: login.php?error=1");
    exit();
}

$idKorisnik = $_SESSION['id_korisnika'];
$idKarte = $_POST['idKarte'];
$kolicina = (int)$_POST['kolicina'];

// Provera da li ta karta vec postoji u korpi
$stmt = $pdo->prepare("SELECT * FROM korpa WHERE id_korisnika = :idKorisnik AND id_karte = :idKarte");
$stmt->execute([
    ':idKorisnik' => $idKorisnik,
    ':idKarte' => $idKarte
]);

if ($stmt->rowCount() > 0) {
    $postojeca = $stmt->fetch(PDO::FETCH_ASSOC);
    $novaKolicina = $postojeca['kolicina'] + $kolicina;

    if ($novaKolicina > 4) {
        $novaKolicina = 4;
    }

    $stmtUpdate = $pdo->prepare("UPDATE korpa 
                                 SET kolicina = :kolicina, updated_at = NOW() 
                                 WHERE korpa_id = :id");
    $stmtUpdate->execute([
        ':kolicina' => $novaKolicina,
        ':id' => $postojeca['korpa_id']
    ]);
} else {
    // Ubacivanje nove stavke
    if ($kolicina > 4) {
        $kolicina = 4;
    }

    $stmtInsert = $pdo->prepare("INSERT INTO korpa (id_korisnika, id_karte, kolicina, created_at, updated_at) 
                                 VALUES (:idKorisnik, :idKarte, :kolicina, NOW(), NOW())");
    $stmtInsert->execute([
        ':idKorisnik' => $idKorisnik,
        ':idKarte' => $idKarte,
        ':kolicina' => $kolicina
    ]);
}

header("Location: index.php#karte");
exit();
