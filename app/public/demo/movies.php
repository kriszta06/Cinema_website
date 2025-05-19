<?php
require('includes/header.php');

// Citim fișierul JSON și îl decodăm într-un array asociativ
$movies_data = json_decode(file_get_contents('./assets/movies-list-db.json'), true);


// Verificăm dacă fișierul a fost încărcat corect și are date
if (isset($movies_data['movies']) && !empty($movies_data['movies'])) {
    $movies = $movies_data['movies'];
} else {
    die('Error: Movies data could not be loaded.');
}
?>

<div class="container py-4"></div>
<div class="container">
    <h1>FILME</h1>
    <div class="row">
        <?php
        // Iterăm prin fiecare film dacă există
        foreach ($movies as $movie) {
            require('includes/archive-movies.php');
        }
        ?>
    </div>
</div>

<?php require('includes/footer.php'); ?>
</body>

</html>