<?php
session_start();
include 'conn.php';

$username = $_SESSION['username'];
$id_korisnika = $_SESSION['id_korisnika'];

$stmt = $pdo->prepare("SELECT a.protivnik, a.datum, a.tip, a.cena, k.kolicina
                       FROM korpa k
                       JOIN karte a ON k.id_karte = a.id_karte
                       WHERE k.id_korisnika = ?");
$stmt->execute([$id_korisnika]);
$stavke = $stmt->fetchAll();

$porudzbinaTekst = "";
$ukupno = 0;

foreach ($stavke as $stavka) { 
    $protivnik = $stavka['protivnik'];
    $datum = $stavka['datum'];
    $tip = $stavka['tip'];
    $cena = $stavka['cena'];
    $kolicina = $stavka['kolicina'];

    $linija = $protivnik . " | " . $datum . " | " . $tip . " | " . $cena . "€ x " . $kolicina . "\n";
    
    $porudzbinaTekst .= $linija;

    $ukupno = $ukupno + ($cena * $kolicina);
}

$porudzbinaTekst .= "\nUkupno: " . number_format($ukupno, 2) . " EUR";
?>

<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Potvrdi kupovinu</title>
    <link rel="stylesheet" href="kupi.css">  
</head>
<body>

    <div class="form-container">
    <h2>Potvrda kupovine</h2>

    <form action="https://formspree.io/f/xdkgqybj" method="POST">
        <label for="email">Vaš email:</label>
        <input type="email" id="email" name="email" required>

        <label for="adresa">Adresa za isporuku:</label>
        <textarea id="adresa" name="adresa" rows="4" required></textarea>

        <textarea name="narudzbina" style="display:none;"><?php echo htmlspecialchars($porudzbinaTekst); ?></textarea>

        <input type="hidden" name="_subject" value="Nova porudžbina preko sajta">

        <button type="submit">Pošalji potvrdu</button>
        <a href="korpa.php">Vrni se</a>
    </form>

    </div>

</body>
</html>
