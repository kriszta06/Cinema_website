<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<header>
    <div class="container">

        <head>
            <meta charset="<?php bloginfo('charset'); ?>" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
            <title><?php wp_title(); ?></title>
            <link rel="profile" href="http://gmpg.org/xfn/11" />
            <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
            <?php if (is_singular() && get_option('thread_comments')) wp_enqueue_script('comment-reply'); ?>
            <?php wp_head(); ?>
        </head>
        <h2>PARTEA DE SUS</h2>

        <body <?php body_class(); ?>>
            <!-- Codul programatorului vine aici -->
</header>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">