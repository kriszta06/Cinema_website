<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
$movies = json_decode(file_get_contents('assets/movies-list-db.json'), true)['movies'];
if (json_last_error() !== JSON_ERROR_NONE) {
    die("Eroare la decodarea JSON: " . json_last_error_msg());
}

print_r($movies); 
if (isset($_GET['s']) && strlen($_GET['s']) > 0) {
    $search_query = strtolower($_GET['s']);

    if (strlen($search_query) < 3) {
        echo "<p>Termenul de căutare trebuie să aibă cel puțin 3 caractere.</p>";
        exit();
    }
    echo "<p>Termen de căutare: " . htmlspecialchars($search_query) . "</p>";

    $filtered_movies = array_filter($movies, function($movie) use ($search_query) {
        return strpos(strtolower($movie['title']), $search_query) !== false;
    });

    echo "<h1>Rezultate pentru: " . htmlspecialchars($search_query) . "</h1>";
    
    echo '<form class="d-flex" role="search" method="GET" action="search-results.php">
            <input class="form-control me-2" type="search" name="s" value="' . htmlspecialchars($search_query) . '" placeholder="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
          </form>';

    if (count($filtered_movies) > 0) {
        if (count($filtered_movies) == 1) {
            $movie = reset($filtered_movies);
            header("Location: movie.php?movie_id=" . $movie['id']);
            exit();
        }
        
        foreach ($filtered_movies as $movie) {
            echo "<div>";
            echo "<h2>" . htmlspecialchars($movie['title']) . "</h2>";
            echo "<p>" . htmlspecialchars(substr($movie['plot'], 0, 100)) . "...</p>";
            echo "<a href='movie.php?movie_id=" . $movie['id'] . "'>Detalii</a>";
            echo "</div>";
        }
    } else {
        echo "<p>Nu au fost găsite rezultate pentru termenul de căutare: " . htmlspecialchars($search_query) . "</p>";
    }
} else {
    echo "<p>Introduceți un termen de căutare.</p>";
}
?>
    
    </body>
</html>