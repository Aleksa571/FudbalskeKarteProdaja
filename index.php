<?php include 'session_checker.php'; ?>
<?php
include 'conn.php';
$stmt = $pdo->query("SELECT * FROM karte");
$karte = $stmt->fetchAll();
?>
<?php
$idKorisnik = $_SESSION['id_korisnika'] ?? null;
$brojStavki = 0;

if ($idKorisnik) {
    $stmt = $pdo->prepare("SELECT SUM(kolicina) FROM korpa WHERE idKorisnik = :idKorisnik");
    $stmt->execute([':idKorisnik' => $idKorisnik]);
    $brojStavki = $stmt->fetchColumn();
    if (!$brojStavki) {
        $brojStavki = 0;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <title></title>
</head>
<body>
    <header>
        <nav>
            <ul class="a">
                <li><a href="index.php">Početna</a></li>
                <li><a href="about.html">O nama</a></li>
                <li><a href="contact.html">Kontakt</a></li>
            </ul>
            <ul class="b">
                <li><a href="login.php">*LOG OUT*</a></li>
                <li>
                  <a href="korpa.php" style="position: relative;">
                    🛒
                     <span style="position: absolute; top: -10px; right: -10px; background: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px;">
                        <?= $brojStavki ?>
                    </span>
                  </a>
                </li>
                <li>
                <form id="isprazniForm" method="post" action="isprazni.php" style="display:inline;">
                  <a href="#" class="isprazni" onclick="document.getElementById('isprazniForm').submit(); return false;">
                      Isprazni korpu
                  </a>
                </form>
              </li>
            </ul>
        </nav>
    </header>
    <div class="div0">
      <div class="promo-box">
        <h3>🎁 Osvoji popust</h3>
        <p>Unesi broj od 1 do 10 i osvoji popust na sledeću kartu!<br><small>Samo jedan pokušaj dozvoljen</small></p>
        <input type="number" id="unos" min="1" max="10" placeholder="Unesi broj">
        <input type="button" id="dugme" onclick="a()" value="Pokušaj">
        <p id="rezultat"></p>
        <p id="rezultat1"></p>
      </div>

      <div class="div2">
          <a href="#karte" class="buy-button">🎟️ Pogledaj karte! 🎟️</a>
      </div>

      <div class="promo-box">
        <h3>💱 Kalkulator cene</h3>
        <p>Izračunaj cenu u dinarima (EUR ➜ RSD)</p>
        <input type="number" id="price" name="price" placeholder="Cena u evrima">
        <input type="button" onclick="calculate()" value="Izračunaj">
        <p id="kalk"></p>
      </div>
    </div>
    <hr>
    
    <div class="div0">
        <div class="salah" style="max-width: 250px;">
          <div class="fudbaleri" onclick="openPopup('salah')">
            <img src="slike/salah.jpg" class="card-img-top">
            <img src="slike/kruna.png" class="plus" style="width: 60px;">
          </div>
        </div>

        <div class="steven" style="max-width: 250px;">
          <div class="fudbaleri" onclick="openPopup('steven')">
            <img src="slike/steven.jpg" class="card-img-top">
            <img src="slike/scope.png" class="plus" style="width: 60px;">
          </div>
        </div>

        <div class="virgil" style="max-width: 250px;">
            <div class="fudbaleri" onclick="openPopup('virgil')">
              <img src="slike/virgil.jpg" class="card-img-top">
              <img src="slike/wall.png" class="plus" style="width: 60px;">
            </div>
          </div>
    </div>
    <hr>
    <div id="karte"></div>
    <div class="div0">
      <div class="matches-wrapper">
      <?php
      $stmt = $pdo->query("SELECT * FROM karte ORDER BY datum ASC");
      foreach ($stmt as $karta){ ?>
        <div class="match-card">
            <div class="match-info">
                <div class="teams">Liverpool FC vs <?= htmlspecialchars($karta['protivnik']) ?></div>
                <div class="date"><?= date("d M Y", strtotime($karta['datum'])) ?></div>
                <div class="price"><?= number_format($karta['cena'], 2) ?> EUR</div>
            </div>
            <form method="post" action="ins.php">
                <input type="hidden" name="idKarte" value="<?= $karta['id'] ?>">
                <select name="kolicina">
                    <?php for ($i = 1; $i <= $karta['kolicina']; $i++){ ?>
                        <option value="<?= $i ?>"><?= $i ?></option>
                    <?php }; ?>
                </select>
                <button type="submit" name="dodaj_u_korpu">Dodaj u korpu</button>
            </form>
        </div>
      <?php }; ?>
      </select>
  </form>
</div>
    </div>
      <div id="popup_salah" class="popup" onclick="closePopup('popup_salah')">
        <div class="popup-content" onclick="event.stopPropagation()">
          <span class="close" onclick="closePopup('popup_salah')">&times;</span>
          <img src="Slike/salah.jpg" alt="Mohamed Salah" class="profile-img">
        <div class="tekst-sadrzaj">
          <h1>Salah</h1>
          <p>Mohamed Salah je egipatski fudbaler koji igra kao krilni napadač za Liverpool FC.</p>
        </div>
        <a href="https://www.instagram.com/mosalah/" target="_blank" class="instagram-desno">
          <img src="slike/instagram.png" alt="Instagram" class="instagram-icon">
        </a>
      </div>
    </div>      
    <div id="popup_steven" class="popup" onclick="closePopup('popup_steven')">
      <div class="popup-content" onclick="event.stopPropagation()">
        <span class="close" onclick="closePopup('popup_steven')">&times;</span>
        <img src="Slike/steven.jpg" alt="Steven Gerrard" class="profile-img">
      <div class="tekst-sadrzaj">
        <h1>Steven Gerrard</h1>
        <p>Legendarni vezista Liverpoola poznat po svojoj lojalnosti i liderstvu.</p>
      </div>
      <a href="https://www.instagram.com/stevengerrard/" target="_blank" class="instagram-desno">
        <img src="slike/instagram.png" alt="Instagram" class="instagram-icon">
      </a>
    </div>
</div>
    <div id="popup_virgil" class="popup" onclick="closePopup('popup_virgil')">
  <div class="popup-content" onclick="event.stopPropagation()">
    <span class="close" onclick="closePopup('popup_virgil')">&times;</span>
    <img src="slike/virgil.jpg" alt="Virgil van Dijk" class="profile-img">
    <div class="tekst-sadrzaj">
      <h1>Virgil van Dijk</h1>
      <p>Jedan od najboljih defanzivaca na svetu, ključni igrač Liverpoolove odbrane.</p>
    </div>
    <a href="https://www.instagram.com/virgilvandijk/" target="_blank" class="instagram-desno">
      <img src="slike/instagram.png" alt="Instagram" class="instagram-icon">
    </a>
  </div>
</div>
    <footer class="footer">
        <div class="footerKlasa">
        <p>© 2025 Liverpool FC. Sva prava zadržana.</p>
        </div>
    </footer>
  
    <script type="text/javascript">
        function calculate(){
        let textboxVrednost = document.getElementById('price').value;
        let parsed = parseFloat(textboxVrednost) ;
        let rezultat = parsed*117.21;
        document.getElementById('kalk').textContent = rezultat+" dinara.";}
    </script>
    <script type="text/javascript">
        let unos = document.getElementById('unos');
        let dugme = document.getElementById('dugme');
        let rezultat = document.getElementById('rezultat');
        let rezultat1 = document.getElementById('rezultat1');

        let randomBroj = Math.floor(Math.random() * 10) + 1;

        function a() {
            let pokusaj = parseInt(unos.value);

            if (pokusaj === randomBroj) {
                rezultat.textContent = "Tacno! Pogodio si broj " + randomBroj + ".";
                rezultat1.textContent="Za popust screenshotuj i posalji nam preko Kontakt stranice!";
            } else {
                rezultat.textContent = "Netacno! Random broj je bio " +randomBroj+".";
            }

            dugme.disabled = true;
            dugme.style.display='none';
        }
    </script>
    <script>
        function openPopup(ime) {
          document.getElementById('popup_' + ime).style.display = 'flex';
        }
      
        function closePopup(id) {
          document.getElementById(id).style.display = 'none';
        }
      
        window.onclick = function(event) {
          if (event.target.className === 'popup') {
            closePopup(event.target.id);
          }
        };
      </script>
      
</body>
</html>
