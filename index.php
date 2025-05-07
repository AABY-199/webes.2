<?php
// Név és Neptun kód megadása
$nev = "Simorka János";
$neptun = "L5ENTS";
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezési Rendszer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
        }
        .login-form {
            margin: 20px 0;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Webes megoldások 2.beadandó</h1>
            <p>Készítette: <?php echo $nev; ?> (<?php echo $neptun; ?>)</p>
        </div>
        
        <div class="login-form">
            <h2>Kérem jelentkezzen be</h2>
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="username">Felhasználónév:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Jelszó:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Belépés</button>
            </form>
        </div>
    </div>
</body>
</html>
