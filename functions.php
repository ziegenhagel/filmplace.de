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
        add_image_size('custom-thumbnail', 1750, 900, true);
    }
}
add_action('after_setup_theme', 'ziegenhagel_register_thumbnails');

add_theme_support('post-thumbnails');

// zghl_filmplace_startseite
add_shortcode('zghl_filmplace_startseite', 'zghl_filmplace_startseite');
function zghl_filmplace_startseite()
{
    ob_start();

    // go through all direct children of the front page,  also get the featured image
    $pages = get_pages(array(
        'child_of' => get_option('page_on_front'),
        'parent' => get_option('page_on_front'),
        'sort_column' => 'menu_order',
        'sort_order' => 'ASC',
        'hierarchical' => 0,
        'meta_key' => '_thumbnail_id',
        'meta_value' => '',
        'meta_compare' => '!=',
    ));
    $pages = array_map(function ($page) {
        $page->thumbnail = get_the_post_thumbnail_url($page->ID, 'original');
        return $page;
    }, $pages);

    ?>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

    <div id="app">

        <nav>
            <div id="previewImage"
                 :class="{hoverable:pageVisible,previewVisible:previewVisible, pageVisible:pageVisible}"
                 @click="hidePreview();hidePage()">
                <img src="/wp-content/uploads/2023/02/map.jpg" id="frontImage" alt="Ansicht">
                <img v-for="page in pages" :src="page.thumbnail"
                     :class="{visible:(previewPage.ID == page.ID && previewVisible) || (!previewVisible && pageVisible && currentPage.ID == page.ID), previewThumbnail: true}"/>
            </div>

            <aside>
                <div class="menu">
                    <img @click="hidePage()" id="logo" src="/wp-content/uploads/2023/02/Logo-1.png"
                         class="hoverable"
                         alt="Logo">
                    <ul :class="{collapsed:pageVisible}">
                        <li v-for="(page,index) in pages" @click="setPage(index)" @mouseenter="previewThePage(index)"
                            @mouseleave="hidePreview()" :class="{active:currentPageIndex == index && pageVisible}">
                            {{page.post_title}}
                        </li>
                    </ul>
                </div>
                <div id="previewText" :class="{visible:pageVisible}">
                    <div v-html="currentPage.post_content"></div>
                    <a @click="viewMore()" class="viewMore">Mehr erfahren</a>
                    <?php
                    if (current_user_can("edit_posts")) {
                        echo "<a :href=\"'/wp-admin/post.php?post='+currentPage.ID+'&action=edit'\" target='_blank'>Seite Bearbeiten</a>";
                    }
                    ?>
                </div>
            </aside>
        </nav>

        <pre>{{currentPageIndex}}</pre>
        <pre>previ {{previewPageIndex}}</pre>

        <div id="hidden_preload">
            <img v-for="page in pages" :src="page.thumbnail"/>
        </div>
    </div>

    <script>
        const {createApp} = Vue

        createApp({
            data() {
                return {
                    pages: <?php echo json_encode($pages); ?>,
                    currentPageIndex: 0,
                    previewPageIndex: 0,
                    previewVisible: false,
                    pageVisible: false
                }
            },
            methods: {
                setPage(index) {
                    this.currentPageIndex = index;
                    this.pageVisible = true;
                },
                previewThePage(index) {
                    this.previewPageIndex = index;
                    this.previewVisible = true;
                },
                hidePreview() {
                    this.previewVisible = false;
                },
                hidePage() {
                    this.pageVisible = false;
                }
            },
            computed: {
                currentPage() {
                    return this.pages[this.currentPageIndex];
                },
                previewPage() {
                    return this.pages[this.previewPageIndex];
                }
            }
        }).mount('#app')
    </script>

    <?php

    // no app loading delay for admins
    if (current_user_can("edit_posts")) {
        ?>
        <style>
            #app, #custom-cursor {
                opacity: 1 !important;
                animation: none !important;
            }
        </style>
        <?php
    }

    return ob_get_clean();
}