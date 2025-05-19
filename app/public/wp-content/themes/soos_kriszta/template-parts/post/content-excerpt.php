<article id="post-<?php the_ID(); ?>" <?php post_class('col-md-4 mb-4'); ?>>
    <div class="card">
        <div class="card-body">
            <h2 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <p class="card-text"><?php the_excerpt(); ?></p>
            <a href="<?php the_permalink(); ?>" class="btn btn-primary">Citește mai mult</a>
        </div>
    </div>
</article>