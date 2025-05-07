<?php
// Adatbázis kapcsolat és dekódoló függvények betöltése
require_once 'config.php';
require_once 'decrypt.php';

// Ellenőrizzük, hogy POST kérés érkezett-e
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Felhasználói adatok beolvasása a POST tömbből
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    // Felhasználó hitelesítése
    $auth_result = authenticateUser($username, $password);
    
    if ($auth_result['success']) {
        // Sikeres bejelentkezés - kedvenc szín lekérdezése az adatbázisból
        $sql = "SELECT Titkos FROM tabla WHERE Username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $color = $row['Titkos'];
            
            // Megjelenítjük a felhasználó kedvenc színét
            showColorPage($username, $color);
        } else {
            echo "A felhasználónév nem található az adatbázisban.";
        }
        
        $stmt->close();
    } else {
        // Sikertelen bejelentkezés
        if ($auth_result['message'] == 'Hibás jelszó') {
            // Hibás jelszó esetén átirányítás a police.hu-ra 3 másodperc múlva
            echo '<!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Hibás bejelentkezés</title>
                <meta http-equiv="refresh" content="3;url=https://www.police.hu">
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        text-align: center;
                        padding: 50px;
                        background-color: #ffdddd;
                    }
                    .error-box {
                        background-color: white;
                        padding: 20px;
                        border-radius: 8px;
                        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                        max-width: 500px;
                        margin: 0 auto;
                    }
                    h1 {
                        color: #cc0000;
                    }
                </style>
            </head>
            <body>
                <div class="error-box">
                    <h1>Hibás jelszó!</h1>
                    <p>Átirányítás a police.hu oldalra 3 másodperc múlva...</p>
                </div>
            </body>
            </html>';
        } else {
            // Nincs ilyen felhasználó
            echo '<!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Hibás bejelentkezés</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        text-align: center;
                        padding: 50px;
                        background-color: #f4f4f4;
                    }
                    .error-box {
                        background-color: white;
                        padding: 20px;
                        border-radius: 8px;
                        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                        max-width: 500px;
                        margin: 0 auto;
                    }
                    h1 {
                        color: #cc0000;
                    }
                    .back-button {
                        display: inline-block;
                        margin-top: 20px;
                        padding: 10px 15px;
                        background-color: #4CAF50;
                        color: white;
                        text-decoration: none;
                        border-radius: 4px;
                    }
                </style>
            </head>
            <body>
                <div class="error-box">
                    <h1>Nincs ilyen felhasználó!</h1>
                    <p>A megadott felhasználónév nem létezik a rendszerben.</p>
                    <a href="index.php" class="back-button">Vissza a bejelentkezéshez</a>
                </div>
            </body>
            </html>';
        }
    }
} else {
    // Ha nem POST kérés, átirányítás a kezdőlapra
    header("Location: index.php");
    exit();
}

// Sikeres bejelentkezés esetén megjelenítjük a kedvenc színt
function showColorPage($username, $color) {
    // A szín magyar neve alapján meghatározzuk az angol megfelelőjét
    $color_map = [
        'piros' => 'red',
        'zold' => 'green',
        'sarga' => 'yellow',
        'kek' => 'blue',
        'fekete' => 'black',
        'feher' => 'white'
    ];
    
    $bg_color = isset($color_map[$color]) ? $color_map[$color] : 'gray';
    
    // Szín megjelenítése
    echo '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Sikeres bejelentkezés</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                text-align: center;
                padding: 50px;
                background-color: #f4f4f4;
            }
            .welcome-box {
                background-color: white;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                max-width: 500px;
                margin: 0 auto;
                margin-bottom: 20px;
            }
            .color-circle {
                width: 200px;
                height: 200px;
                border-radius: 50%;
                background-color: ' . $bg_color . ';
                margin: 20px auto;
                border: 3px solid #333;
            }
            h1 {
                color: #4CAF50;
            }
            .logout-button {
                display: inline-block;
                margin-top: 20px;
                padding: 10px 15px;
                background-color: #4CAF50;
                color: white;
                text-decoration: none;
                border-radius: 4px;
            }
        </style>
    </head>
    <body>
        <div class="welcome-box">
            <h1>Sikeres bejelentkezés!</h1>
            <p>Üdvözöljük, <strong>' . htmlspecialchars($username) . '</strong>!</p>
            <p>Az Ön kedvenc színe: <strong>' . htmlspecialchars($color) . '</strong></p>
        </div>
        
        <div class="color-circle"></div>
        
        <a href="index.php" class="logout-button">Kijelentkezés</a>
    </body>
    </html>';
}

// Kapcsolat lezárása
$conn->close();
?>