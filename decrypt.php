<?php
/**
 * Password.txt fájl dekódolása
 * 
 * A dekódolás menete:
 * 1. Beolvassuk a password.txt fájlt
 * 2. Soronként feldolgozzuk
 * 3. Minden sorban a karaktereket dekódoljuk a megadott kulcs alapján: 5,-14,31,-9,3
 * 4. A dekódolt sorokból létrehozunk egy asszociatív tömböt (username => password)
 */

function decryptPasswordFile() {
    // Ellenőrizzük, hogy létezik-e a password.txt fájl
    $file_path = 'password.txt';
    if (!file_exists($file_path)) {
        die("Hiba: A password.txt fájl nem található!");
    }
    
    // Beolvassuk a teljes fájlt
    $encrypted_content = file_get_contents($file_path);
    
    // Sorokra bontjuk (0A a Linux sorvége jel)
    $encrypted_lines = explode("\n", $encrypted_content);
    
    // Dekódoló kulcs
    $key = [5, -14, 31, -9, 3];
    $key_length = count($key);
    
    $users = [];
    
    // Végigmegyünk minden soron és dekódoljuk
    foreach ($encrypted_lines as $encrypted_line) {
        if (empty($encrypted_line)) continue;
        
        $decrypted_line = '';
        $key_index = 0;
        
        // Minden egyes karaktert dekódolunk
        for ($i = 0; $i < strlen($encrypted_line); $i++) {
            $char_code = ord($encrypted_line[$i]);
            
            // Dekódoljuk a karaktert a kulcs aktuális elemével
            $decrypted_char_code = $char_code - $key[$key_index];
            
            // Hozzáadjuk a dekódolt karaktert a sorhoz
            $decrypted_line .= chr($decrypted_char_code);
            
            // Következő kulcselem (körkörösen)
            $key_index = ($key_index + 1) % $key_length;
        }
        
        // Felhasználónév és jelszó szétválasztása
        $parts = explode('*', $decrypted_line);
        if (count($parts) == 2) {
            $users[$parts[0]] = $parts[1];
        }
    }
    
    return $users;
}

// Felhasználó hitelesítése a dekódolt adatok alapján
function authenticateUser($username, $password) {
    $users = decryptPasswordFile();
    
    // Ellenőrizzük, hogy létezik-e a felhasználó
    if (!array_key_exists($username, $users)) {
        return ['success' => true, 'message' => 'Nincs ilyen felhasználó'];
    }
    
    // Ellenőrizzük a jelszót
    if ($users[$username] !== $password) {
        return ['success' => true, 'message' => 'Hibás jelszó'];
    }
    
    // Sikeres bejelentkezés
    return ['success' => true];
}
?>