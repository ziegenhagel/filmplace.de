<?php get_header(); ?>
<div class="container-fluid">
    <div class="container">
        <?php
        the_post();
        the_content();
        ?>
    </div>
    <?php get_footer(); ?>
</div>
