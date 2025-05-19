<?php get_header(); ?>

<div class="content-area">
    <main class="site-main">
        <?php if (have_posts()) : ?>
            <?php get_template_part('template-parts/post/content', 'excerpt'); ?>


            <!-- Paginare -->
            <div class="pagination">
                <?php
                // Navigare între pagini (fără permalinks personalizate)
                global $wp_query;
                $big = 999999999; // Un număr mare pentru înlocuire
                echo paginate_links(array(
                    'base'    => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'format'  => '?paged=%#%',
                    'current' => max(1, get_query_var('paged')),
                    'total'   => $wp_query->max_num_pages
                ));

                ?>
            </div>
        <?php else : ?>
            <p>Nu există articole disponibile.</p>
        <?php endif; ?>
    </main>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>