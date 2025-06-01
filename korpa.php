<?php
session_start();
include 'conn.php';

// Provera da li je korisnik ulogovan
if (!isset($_SESSION['id_korisnika'])) {
    header("Location: login.php?error=1");
    exit();
}

// Prikaz svih stavki iz tabele 'korpa' za korisnika
$id_korisnika = $_SESSION['id_korisnika'];
$stmt = $pdo->prepare("SELECT k.korpa_id AS korpa_id, k.kolicina, k.created_at, k.updated_at,
                              a.protivnik, a.datum, a.tip, a.cena
                              FROM korpa k
                              JOIN karte a ON k.id_karte = a.id_karte
                              WHERE k.id_korisnika = ?");
$stmt->execute([$id_korisnika]);
$stavke = $stmt->fetchAll();
$ukupno = 0;
foreach ($stavke as $stavka) {
    $ukupno += $stavka['cena'] * $stavka['kolicina'];
}
?>

<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Moja korpa</title>
    <link rel="stylesheet" href="korpa.css">
</head>
<body>

<h2>Moja korpa
    <a href="index.php#karte" class="btn-kupovina">Nastavi sa kupovinom</a>
</h2>

<table>
    <tr>
        <th>Protivnik</th>
        <th>Datum</th>
        <th>Tip</th>
        <th>Cena</th>
        <th>Količina</th>
        <th>Ukupno</th>
        <th>Datum unosa</th>
        <th>Poslednja izmena</th>
    </tr>

    <?php foreach ($stavke as $stavka){ ?>
    <tr>
        <td><?php echo $stavka['protivnik']; ?></td>
        <td><?php echo $stavka['datum']; ?></td>
        <td><?php echo $stavka['tip']; ?></td>
        <td><?php echo $stavka['cena']; ?> EUR</td>
        <td>
            <form action="izmeni.php" method="post" class="form-izmena">
                <input type="hidden" name="idKorpa" value="<?php echo $stavka['korpa_id']; ?>">
                <input type="number" name="nova_kolicina" value="<?php echo $stavka['kolicina']; ?>" min="1" max="4">
                <input type="submit" value="Izmeni">
            </form>
        </td>
        <td><?php echo number_format($stavka['cena'] * $stavka['kolicina'], 2); ?> EUR</td>
        <td><?php echo $stavka['created_at']; ?></td>
        <td><?php echo $stavka['updated_at']; ?></td>
        <td>
            <a class="obrisi-btn" href="obrisi.php?id=<?php echo $stavka['korpa_id']; ?>" onclick="return confirm('Da li ste sigurni da želite da obrišete ovu kartu?');">Obriši</a>
        </td>
    </tr>
    <?php }; ?>
</table>
<?php if (count($stavke) > 0) {?>
    <div class="ukupno-box">
        Ukupna cena:<?php echo number_format($ukupno, 2); ?> EUR;
        <a href="kupi.php">Kupi</a>
    </div>
<?php };?>
</body>
</html>
