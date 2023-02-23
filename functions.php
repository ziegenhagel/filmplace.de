<?php


if (!function_exists('ziegenhagel_register_navigations')) {
    /**
     * Registers theme's navigation menus.
     *
     * @return void
     * @todo Update prefix in the hook function and if statement.
     *
     * @todo Change function prefix to your textdomain.
     */
    function ziegenhagel_register_navigations()
    {
        register_nav_menus(
            array(
                'top' => __('Top Navigation', 'ziegenhagel'),
                'bottom' => __('Bottom Navigation', 'ziegenhagel'),
            )
        );
    }
}
add_action('after_setup_theme', 'ziegenhagel_register_navigations');

if (is_user_logged_in() && !current_user_can("edit_posts")) {
    add_filter('show_admin_bar', '__return_false');
}

if (!function_exists('ziegenhagel_register_thumbnails')) {
    /**
     * Registers theme's additional thumbnail sizes.
     *
     * @return void
     * @todo Update prefix in the hook function and if statement.
     *
     * @todo Change function prefix to your textdomain.
     */
    function ziegenhagel_register_thumbnails()
    {
        add_image_size('custom-thumbnail', 800, 600, true);
    }
}
add_action('after_setup_theme', 'ziegenhagel_register_thumbnails');

add_theme_support('post-thumbnails');

// zghl_filmplace_startseite
add_shortcode('zghl_filmplace_startseite', 'zghl_filmplace_startseite');
function zghl_filmplace_startseite()
{
    ob_start();

    // go through all direct children of the front page
    $args = array(
        'post_type' => 'page',
        'post_parent' => get_option('page_on_front'),
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC'
    );
    $pages = get_posts($args);

    ?>
    <div class="page">

    </div>
    <?php
    return ob_get_clean();
}