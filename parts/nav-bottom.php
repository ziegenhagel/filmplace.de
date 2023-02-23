<footer <?php if (is_front_page()) echo "class='front-page'"; ?>>
    <?php
    /* simple footer navigation */
    wp_nav_menu(array(
        'theme_location' => 'bottom',
        'container' => null,
        'fallback_cb' => false,
    ));
    ?>
</footer>