<div class="col-md-4" id="movie-<?php $movie['id'] ?>">
    <div class="card h-100">
        <img src="<?php echo $movie['image']; ?>" class="card-img-top" alt="Posterul filmului <?php echo $movie['title']; ?>">
        <div class="card-body">
            <h5 class="card-title">
                <?php echo $movie['title']; ?>
            </h5>
            <p class="card-text">
                <?php echo $movie['description'], '...'; ?>
            </p>
            <a href="<?php echo $movie['link']; ?>" class="btn btn-primary">Read more...</a>
        </div>
    </div>
</div>