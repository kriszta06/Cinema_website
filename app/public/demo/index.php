<?php require('includes/header.php') ?>
<div class="container">
  <h4><em>Bine ai venit pe pagina noastră! Îți urăm o vizionare plăcută!</em></h4>
  <div class="container">
    <?php
    date_default_timezone_set('Europe/Bucharest');
    $ora_curenta = date("H");
    if ($ora_curenta >= 5 && $ora_curenta < 12)
      $mesaj = 'Bună dimineața!';
    else if ($ora_curenta >= 12 && $ora_curenta < 18)
      $mesaj = 'Bună ziua!';
    else if ($ora_curenta >= 18 && $ora_curenta < 22)
      $mesaj = 'Bună seara!';
    else
      $mesaj = 'Noapte bună!';
    echo "<h1 class='mt-4'>$mesaj!</h1>";
    ?>
  </div>
  <a href="movies.php" type="button" class="btn btn-outline-warning">Vezi filmele..</a>
</div>
<?php require('includes/footer.php') ?>
</body>

</html>