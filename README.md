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

## 📂 Struktura projekta

/PhpSqlSajt/
├── index.php ← Početna strana
├── register.php ← Registracija korisnika
├── login.php ← Login forma
├── admin.php ← Admin panel
├── korpa.php ← Korpa korisnika
├── conn.php ← Konekcija sa bazom
├── baza.sql ← MySQL dump baze (liverpool.sql)
├── /css/ ← Stilovi
├── /images/ ← Slike (ako postoje)

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