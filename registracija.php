<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registracija</title>
    <link rel="stylesheet" href="registracija.css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    
</head>
<body>
<?php
$error = "";
if (isset($_GET['error'])) {
    if ($_GET['error'] == 1) {
        $error = "Morate popuniti sva polja.";
    } elseif ($_GET['error'] == 4) {
        $error = "Korisničko ime već postoji. Pokušajte ponovo.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'conn.php';

    if (isset($_POST['username'])) {
        $username = $_POST['username'];
    } else {
        $username = '';
    }

    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    } else {
        $password = '';
    }

    if (isset($_POST['uloga'])) {
        $uloga = $_POST['uloga'];
    } else {
        $uloga = '';
    }

    if (empty($username) || empty($password) || empty($uloga)) {
        header("Location: registracija.php?error=1");
        exit();
    }

    $stmt = $pdo->prepare("SELECT * FROM korisnik WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        header("Location: registracija.php?error=2");
        exit();
    }

    $stmt = $pdo->prepare("INSERT INTO korisnik (username, password, id_uloga, active) VALUES (:username, :password, :uloga, 1)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);  
    $stmt->bindParam(':uloga', $uloga);
    $stmt->execute();

    header("Location: login.php?success=1");
    exit();
}
?>
<div class="reg">
    <h1>Forma za registraciju</h1>
    <form action="ins_registracija.php" method="POST">
        <div>
            <label for="username">Korisničko ime:</label>
            <input type="text" name="username" id="username" placeholder="Unesite korisničko ime" required />
        </div>
        <div>
            <label for="password">Lozinka:</label>
            <input type="password" name="password" id="password" placeholder="Unesite lozinku" required />
        </div>
        <div class="button">
            <input type="submit" value="Registruj se" />
        </div>
    </form>
</div>
<?php if ($error){ ?>
    <div class="error"><?php echo htmlspecialchars($error); ?></div>
<?php }; ?>
</body>
</html>
