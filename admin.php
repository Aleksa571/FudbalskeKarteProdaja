<?php
session_start();
if (!isset($_SESSION['id_korisnika']) || $_SESSION['id_uloga'] != 1) {
    header("Location: index.php?error=4");
    exit();
}

include 'conn.php';

// Aktivacija/deaktivacija korisnika
if (isset($_GET['aktiviraj_korisnika'])) {
    $id = intval($_GET['aktiviraj_korisnika']);
    
    $stmt = $pdo->prepare("SELECT active FROM korisnik WHERE id_korisnika = ?");
    $stmt->execute([$id]);
    $korisnik = $stmt->fetch();

    if ($korisnik) {
        $novi_status = $korisnik['active'] ? 0 : 1;
        $stmt = $pdo->prepare("UPDATE korisnik SET active = ? WHERE id_korisnika = ?");
        $stmt->execute([$novi_status, $id]);
    }

    header("Location: admin.php");
    exit();
}

$greska = "";
$uspeh = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_ticket'])) {
    $datum = $_POST['datum'];
    $kolicina = intval($_POST['kolicina']);
    $tip = $_POST['tip'];
    $cena = floatval($_POST['cena']);
    $protivnik = $_POST['protivnik'];

    $stmt = $pdo->prepare("INSERT INTO karte (datum, kolicina, tip, cena, protivnik)
                            VALUES (:datum, :kolicina, :tip, :cena, :protivnik)");
    $stmt->execute([
        ':datum' => $datum,
        ':kolicina' => $kolicina,
        ':tip' => $tip,
        ':cena' => $cena,
        ':protivnik' => $protivnik
    ]);
    $uspeh = "Karta uspešno dodata.";
    }


// Brisanje karte
if (isset($_GET['delete_ticket'])) {
    $id = intval($_GET['delete_ticket']);
    $stmt = $pdo->prepare("DELETE FROM karte WHERE id_karte = ?");
    $stmt->execute([$id]);
    header("Location: admin.php");
    exit();
}

// Ucitavanje svih karata i korisnika
$karte = $pdo->query("SELECT * FROM karte ORDER BY datum DESC")->fetchAll(PDO::FETCH_ASSOC);
$korisnici = $pdo->query("SELECT * FROM korisnik ORDER BY id_korisnika ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Admin kontrolna tabla</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <h1>You'll never walk alone: <?php echo $_SESSION['username']; ?></h1>
    <div class="logout-link">
        <a href="logOut.php">Odjavi se</a>
    </div>

    <h2>Objavi novu kartu</h2>
    <form method="POST">
        Datum: <input type="date" name="datum" required>
        <label for="kolicina">Količina:</label>
        <input type="number" name="kolicina" id="kolicina" min="1" max="4">
        Tip karte: 
        <select name="tip" required>
            <option value="pojedinacna">Pojedinačna</option>
            <option value="sezonska">Sezonska</option>
        </select>
        Cena (EUR): <input type="number" name="cena" min="0" required>
        Protivnik: <input type="text" name="protivnik" required>
        <button type="submit" name="add_ticket">Dodaj kartu</button>
    </form>

    <h2>Lista objavljenih karata</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Datum</th>
            <th>Količina</th>
            <th>Tip</th>
            <th>Cena (EUR)</th>
            <th>Protivnik</th>
            <th></th>
        </tr>
        <?php foreach ($karte as $karta){ ?>
        <tr>
            <td><?php echo $karta['id_karte']; ?></td>
            <td><?php echo $karta['datum']; ?></td>
            <td><?php echo $karta['kolicina']; ?></td>
            <td><?php echo ucfirst($karta['tip']); ?></td> 
            <td><?php echo number_format($karta['cena'], 2); ?></td>
            <td><?php echo $karta['protivnik']; ?></td>
            <td>
                <a href="admin.php?delete_ticket=<?php echo $karta['id_karte']; ?>" onclick="return confirm('Obrisati kartu?')">Obriši</a>
            </td>
        </tr>
        <?php }; ?>
   </table>

    <h2>Korisnici</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Korisničko ime</th>
            <th>Uloga</th>
            <th>Aktivan</th>
            <th>Akcija</th>
        </tr>
        <?php foreach ($korisnici as $korisnik){ ?>
        <tr>
            <td><?php echo $korisnik['id_korisnika']; ?></td>
            <td><?php echo $korisnik['username']; ?></td>
            <td>
                <?php echo ($korisnik['id_uloga'] == 1) ? 'Admin' : 'Korisnik'; ?>
            </td>
            <td>
                <?php echo $korisnik['active'] ? 'Da' : 'Ne'; ?>
            </td>
            <td>
                <a href="admin.php?aktiviraj_korisnika=<?php echo $korisnik['id_korisnika']; ?>">
                    <?php echo $korisnik['active'] ? 'Deaktiviraj' : 'Aktiviraj'; ?>
                </a>
            </td>
        </tr>
        <?php }; ?>
    </table>
</body>
</html>
