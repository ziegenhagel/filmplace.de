<?php
get_header();
the_post();
echo "<div class='container-fluid'>";
if (is_front_page()) {

    the_content();

} else {
    ?>
    <main id="nojs">
        <nav id="top">
            <div class="container">
                <a class="big"
                   href="<?php echo get_permalink(get_post_ancestors(get_the_ID())[0] ?? get_option('page_on_front')); ?>">«
                    Zurück</a>
                <img src="<?php echo get_template_directory_uri(); ?>/logo.svg"/>
                <span></span>
            </div>
        </nav>
        <section id="first">
            <div class="container mt">
                <h1><?php the_title(); ?></h1>
                <div><?php the_content(); ?></div>
            </div>
        </section>
        <?php
        // if the current page has children and is the direct child of the front page
        if (count(get_pages(['child_of' => get_the_ID()])) > 0 && get_post_ancestors(get_the_ID())[0] == get_option('page_on_front')) {
            foreach (get_pages(['child_of' => get_the_ID()]) as $page) {
                echo "<section>";
                echo "<div class='container'>";
                echo "<img src='" . get_the_post_thumbnail_url($page->ID) . "' class='thumbnail'/>";
                echo "<h2>" . $page->post_title . "</h2>";
                echo "<div>" . $page->post_content . "</div>";
                echo "</div>";
                echo "</section>";
            }
        }
        ?>
    </main>
    <?php
}
echo "</div>";
get_footer();
