<?php
session_start();
include 'conn.php';

if (isset($_POST['idKorpa'], $_POST['nova_kolicina']) && is_numeric($_POST['nova_kolicina']) && $_POST['nova_kolicina'] > 0) {
    $idKorpa = (int)$_POST['idKorpa'];
    $nova_kolicina = (int)$_POST['nova_kolicina'];

    if ($nova_kolicina > 4) {
        exit();
    }

    $stmt = $pdo->prepare("UPDATE korpa 
                SET kolicina = :kolicina 
                WHERE korpa_id = :id AND id_korisnika = :id_korisnika");

    $stmt->execute([
        ':kolicina' => $nova_kolicina,
        ':id' => $idKorpa,
        ':id_korisnika' => $_SESSION['id_korisnika']
    ]);

    header("Location: korpa.php");
    exit();
} else {
    exit();
}
?>
