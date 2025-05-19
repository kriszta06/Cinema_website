<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Soos_Kriszta</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>

<?php
// Activare raportare erori
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$navbar = [
  [
    'name' => "HOME",
    'link' => 'index.php'
  ],
  [
    'name' => "MOVIES",
    'link' => 'movies.php'
  ],
  [
    'name' => "CONTACT",
    'link' => 'contact.php'
  ]
];
?>

<body>

  <?php $logo = "SK"; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <nav class="navbar navbar-expand-lg bg-light"> 
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><?php echo $logo; ?></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <?php
          $current_file = basename($_SERVER['PHP_SELF']);
          foreach ($navbar as $navel) {
            $active_class = ($current_file == $navel['link']) ? 'active' : '';
          ?>
            <li class="nav-item">
              <a class="nav-link <?php echo $active_class; ?>" aria-current="page" href="<?php echo $navel['link']; ?>"><?php echo $navel['name']; ?></a>
            </li>
          <?php } ?>
        </ul>
        <?php require(__DIR__ . '/search-form.php'); ?>
      </div>
    </div>
  </nav>

  <?php
  $current_page = basename($_SERVER['PHP_SELF']);
  if ($current_page == 'movies.php') {
    $movies = json_decode(file_get_contents(__DIR__ . '/../assets/movies-list-db.json'), true)['movies'];
  }
  ?>

  <?php require(__DIR__ . '/functions.php'); ?> 

</body>

</html>