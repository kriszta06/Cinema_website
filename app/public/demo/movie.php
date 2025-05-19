<?php require_once('includes/header.php'); ?>

<?php
// Deschidem fișierul JSON cu filmele
$file_path = __DIR__ . '/assets/movies-list-db.json';
$favorites_count_file = __DIR__ . '/assets/movie-favorites.json';

// Verificăm dacă fișierul există
if (!file_exists($file_path)) {
    die('Error: Movies data could not be loaded.');
}

// Citim conținutul fișierului JSON
$json_content = file_get_contents($file_path);
$movies = json_decode($json_content, true)['movies'] ?? null;

// Verificăm dacă datele despre filme sunt valide
if (!$movies) {
    die('Error: Movies data could not be loaded.');
}

// Gestionăm adăugarea/ștergerea de filme în lista de favorite
session_start();
if (!isset($_SESSION['favorites'])) {
    $_SESSION['favorites'] = [];
}

if (!file_exists($favorites_count_file)) {
    file_put_contents($favorites_count_file, json_encode([]));
}
$favorites_count = json_decode(file_get_contents($favorites_count_file), true);

// 🟡 ADĂUGĂ ACEST COD:
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['favorite_movie_id'])) {
    $movie_id = $_POST['favorite_movie_id'];
    $is_fav = $_POST['is_favorite'] === '1';

    if ($is_fav && !in_array($movie_id, $_SESSION['favorites'])) {
        $_SESSION['favorites'][] = $movie_id;
        $favorites_count[$movie_id] = ($favorites_count[$movie_id] ?? 0) + 1;
    } elseif (!$is_fav && in_array($movie_id, $_SESSION['favorites'])) {
        $_SESSION['favorites'] = array_diff($_SESSION['favorites'], [$movie_id]);
        $favorites_count[$movie_id] = max(0, ($favorites_count[$movie_id] ?? 1) - 1);
    }

    // Salvăm în fișier
    file_put_contents($favorites_count_file, json_encode($favorites_count));

    // Redirect pentru a evita re-submisia formularului la refresh
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}

// Verificăm dacă utilizatorul a adăugat un film la favorite
function is_favorite($movie_id)
{
    return in_array($movie_id, $_SESSION['favorites']);
}

// Filtrăm filmele după ID
function find_movie_by_id($movie)
{
    if (isset($_GET['movie_id'])) {
        return $movie['id'] == $_GET['movie_id'];
    }
    return false;
}

$movies_filtered = array_filter($movies, 'find_movie_by_id');
if (isset($movies_filtered) && count($movies_filtered) > 0) {
    $movie = array_values($movies_filtered)[0];
    $movie_id = $movie['id'];
    $favorite_count = $favorites_count[$movie_id] ?? 0;

    // Conectarea la baza de date
    $host = 'localhost';
    $dbname = 'local'; // Asigură-te că baza de date este corectă
    $username = 'root';
    $password = 'root'; // Adaugă parola corectă
    $port = 10005;

    // Inițializăm mesajul de succes și review-urile
    $success_message = '';
    $reviews = []; // Inițializăm variabila $reviews

    try {
        $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Creăm tabela dacă nu există
        $sql = "CREATE TABLE IF NOT EXISTS reviews (
                    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    movie_id INT(6) NOT NULL,
                    name VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL,
                    message TEXT NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";
        $conn->exec($sql);

        // Gestionăm trimiterea formularului de review
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review_submit'])) {
            if (isset($_POST['agree'])) {
                $names = htmlspecialchars($_POST['name']);
                $emails = htmlspecialchars($_POST['email']);
                $messages = htmlspecialchars($_POST['message']);

                if (!empty($names) && filter_var($emails, FILTER_VALIDATE_EMAIL) && !empty($messages)) {
                    $stmt = $conn->prepare("INSERT INTO reviews (movie_id, name, email, message) VALUES (:movie_id, :name, :email, :message)");
                    $stmt->bindParam(':movie_id', $movie_id);
                    $stmt->bindParam(':name', $names);
                    $stmt->bindParam(':email', $emails);
                    $stmt->bindParam(':message', $messages);
                    $stmt->execute();
                    $success_message = 'Review-ul tău a fost trimis cu succes!';
                } else {
                    $success_message = 'Toate câmpurile sunt obligatorii și emailul trebuie să fie valid.';
                }
            }
        }

        // Afișăm review-urile pentru acest film
        $stmt = $conn->prepare("SELECT name, message FROM reviews WHERE movie_id = :movie_id ORDER BY created_at DESC");
        $stmt->bindParam(':movie_id', $movie_id);
        $stmt->execute();
        $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">Eroare de conexiune la baza de date: ' . $e->getMessage() . '</div>';
    }
?>
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex align-items-center justify-content-between">
                <h1><?php echo htmlspecialchars($movie['title']); ?></h1>
                <!-- Formular pentru favorite -->
                <form method="POST" class="d-inline-block">
                    <input type="hidden" name="favorite_movie_id" value="<?php echo $movie['id']; ?>">
                    <input type="hidden" name="is_favorite" value="<?php echo is_favorite($movie['id']) ? '0' : '1'; ?>">
                    <button type="submit" class="btn btn-<?php echo is_favorite($movie['id']) ? 'danger' : 'success'; ?>">
                        <?php echo is_favorite($movie['id']) ? 'Șterge din Favorite' : 'Adaugă la Favorite'; ?>
                    </button>
                </form>
                <span class="badge bg-info"><?php echo $favorite_count; ?> adăugări la favorite</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-lg-3">
                <img src="<?php echo htmlspecialchars($movie['posterUrl']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>" class="img-fluid">
            </div>
            <div class="col-md-8 col-lg-9">
                <h3><?php echo htmlspecialchars($movie['year']); ?></h3>
                <p><strong>Scenariu:</strong> <?php echo htmlspecialchars($movie['plot']); ?></p>
                <p><strong>Gen:</strong> <?php echo implode(', ', $movie['genres']); ?></p>
                <p><strong>Director:</strong> <?php echo htmlspecialchars($movie['director']); ?></p>
                <p><strong>Durată:</strong> <?php echo runtime_prettier($movie['runtime']); ?></p>
                <h5>Actori:</h5>
                <ul>
                    <?php
                    $actors = explode(', ', $movie['actors']);
                    foreach ($actors as $actor) {
                        echo '<li>' . htmlspecialchars($actor) . '</li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
        <hr>
        <h3>Lasă un review</h3>
        <?php if ($success_message): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php else: ?>
            <form method="POST">
                <div class="form-group">
                    <label for="name">Nume:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="message">Mesaj:</label>
                    <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="agree" name="agree" required>
                    <label class="form-check-label" for="agree">Sunt de acord cu procesarea datelor cu caracter personal</label>
                </div>
                <button type="submit" name="review_submit" class="btn btn-primary">Trimite review</button>
            </form>
        <?php endif; ?>
        <hr>
        <h3>Review-uri</h3>
        <?php if ($reviews): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="card my-3">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($review['name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($review['message']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nu există review-uri pentru acest film încă.</p>
        <?php endif; ?>
    </div>
<?php } else {
    echo 'Filmul nu a fost găsit.';
} ?>
<?php require_once('includes/footer.php'); ?>