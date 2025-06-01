# 🎟️ Fudbalske Karte – PHP eCommerce Sistem

Ovaj projekat je kompletan **PHP + MySQL sajt** za prodaju fudbalskih karata. Sajt podržava korisničke naloge, korpu, administraciju i osnovne eCommerce funkcionalnosti.

---

## ✨ Funkcionalnosti

- ✅ Registracija i prijava korisnika
- ✅ Login sistem sa korisničkom ulogom (admin/korisnik)
- ✅ Dodavanje, izmena i brisanje karata (admin)
- ✅ Korpa za korisnike – dodavanje, brisanje, izmena količine
- ✅ Ograničenje maksimalne količine u korpi (max 4)
- ✅ Admin panel za aktivaciju/deaktivaciju korisnika
- ✅ MySQL baza sa tabelama: korisnik, karte, korpa

---

## 📁 Struktura projekta

PhpSqlSajt/
├── index.php → Početna strana sajta
├── admin.php → Admin panel za karte i korisnike
├── login.php → Login forma za korisnike
├── registracija.php → Forma za registraciju korisnika
├── ins_registracija.php → Backend za registraciju (upis u bazu)
├── proveriUser.php → Provera login podataka korisnika
├── session_checker.php → Provera sesije (ulogovani korisnik)

├── korpa.php → Prikaz sadržaja korisničke korpe
├── ins.php → Dodavanje karata u korpu
├── izmeni.php → Izmena količine u korpi
├── obrisi.php → Brisanje pojedinačnih stavki iz korpe
├── isprazni.php → Praznjenje cele korpe

├── kupi.php → Slanje podataka iz korpe na email (Formspree)

├── conn.php → Konekcija sa MySQL bazom
├── liverpool.sql → Dump baze (za import u phpMyAdmin)

├── about.html → Informacije o sajtu (stranica "O nama")
├── contact.html → Kontakt stranica (frontend)
├── logOut.php → Odjava korisnika
├── test_sesija.php → Testiranje pristupa i sesije

├── slike/ → Folder sa slikama (logo, UI elementi)
├── vscode/ → VS Code podešavanja (automatski folder)
├── README.md → Ovaj fajl (opis projekta)

├── Stilovi (CSS):
│ ├── a.css → Stil za stranicu "O nama"
│ ├── b.css → Stil za admin sekciju
│ ├── korpa.css → Stil za prikaz korpe
│ ├── kupi.css → Stil za checkout stranicu
│ ├── index.css → Glavni stil sajta
│ ├── contact.css → Stil za kontakt stranicu
│ ├── registracija.css → Stil za registraciju korisnika

---

## 🛠️ Instalacija

1. Pokreni **XAMPP** (Apache + MySQL)
2. Kopiraj folder `PhpSqlSajt` u `htdocs`
3. U phpMyAdmin-u kreiraj bazu `liverpool` i importuj fajl `liverpool.sql`
4. Otvori `conn.php` i proveri konekciju:

```php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "liverpool";

Pokreni projekat:
👉 http://localhost/PhpSqlSajt/

👨‍💻 Admin nalozi
Korisničko ime	Lozinka	    Uloga
admin	        admin123	Admin

(Dodaj korisnike ručno kroz bazu ili registracijom)

📝 Autor
Aleksa571
📧 aleksamilosevic649@gmail.com
🔗 GitHub profil: https://github.com/Aleksa571
