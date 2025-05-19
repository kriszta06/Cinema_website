<?php
function runtime_prettier($lungime_minute)
{
    $ora = 0;

    while ($lungime_minute >= 60) {
        $ora++;
        $lungime_minute -= 60;
    }

    return $ora . " hours " . $lungime_minute . " minutes";
}

function check_old_movie($an)
{
    $an_actual = date("Y");
    if ($an_actual - $an >= 40)
        return "Old movie: " . ($an_actual - $an) . " years";
    else
        return false;
} ?>

<?php
// Funcția de conectare la baza de date pentru site-ul tău existent
function db_connect()
{
    // Parametrii de conectare la baza de date pentru site-ul existent
    $host = 'localhost';
    $db = 'local';  // Numele bazei de date, de ex: 'wordpress', 'local', etc.
    $user = 'root';  // Username-ul implicit în Local by Flywheel este 'root'
    $pass = 'root';  // Parola implicită în Local by Flywheel este 'root'
    $charset = 'utf8mb4';  // Set de caractere pentru compatibilitate maximă
    $port = 10005;  // Portul MySQL, verifică dacă este același în Local

    // Data Source Name (DSN)
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  // Activează erorile PDO
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  // Returnează array-uri asociative
        PDO::ATTR_EMULATE_PREPARES => false,  // Siguranță suplimentară pentru query-uri pregătite
    ];

    try {
        // Creează o conexiune PDO cu baza de date
        $pdo = new PDO($dsn, $user, $pass, $options);
        return $pdo;
    } catch (PDOException $e) {
        // Dacă apare o eroare, afișează un mesaj și oprește execuția
        die("Connection failed: " . $e->getMessage());
    }
}
?>

