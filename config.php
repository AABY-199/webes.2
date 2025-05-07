<?php
// Adatbázis kapcsolat beállításai
$servername = "localhost";
$username = "root";  // Ide írd a MySQL felhasználóneved
$password = "";       // Ide írd a MySQL jelszavad
$dbname = "adatok";

// Kapcsolat létrehozása
$conn = new mysqli($servername, $username, $password, $dbname);

// Kapcsolat ellenőrzése
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// UTF-8 karakterkészlet beállítása
$conn->set_charset("utf8");
?>