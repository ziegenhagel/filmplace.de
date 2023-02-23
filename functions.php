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
        $page->thumbnail = get_the_post_thumbnail_url($page->ID, 'custom-thumbnail');
        return $page;
    }, $pages);

    ?>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

    <div id="app">

        <nav>
            <div id="previewImage">
                <img src="http://localhost/wp-content/uploads/2023/02/ansicht1.png"/>
                <img v-for="page in pages" :src="page.thumbnail"
                     :class="{visible:(preview && previewPage.ID == page.ID) || (!preview && pageVisible && currentPage.ID == page.ID), previewThumbnail: true}"/>
            </div>

            <aside>
                <div class="menu">
                    <img @click="hidePage()" id="logo" src="http://localhost/wp-content/uploads/2023/02/logo.png"
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
                    this.preview = true;
                },
                hidePreview() {
                    this.preview = false;
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

    <style>
        #app {
            position: absolute;

            top: 0;
            left: 0;
            right: 0;
            bottom: 0;

            overflow: hidden;
        }

        #app * {
            box-sizing: border-box;
        }

        #app nav {
            width: 100%;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: stretch;
        }

        #app nav aside {
            width: 300px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: stretch;
            position: absolute;
            right: 0;
            height: 100%;
        }

        #app nav aside ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            margin-top: 50px;
            transition: .5s;
        }

        #app nav aside ul.collapsed {
            margin-top: -30px;
            pointer-events: none;
        }

        #app nav aside ul.collapsed li:not(.active) {
            height: 0;
            padding-top: 0;
            padding-bottom: 0;
            opacity: 0;
        }

        #app nav aside ul li {
            padding: 15px;
            cursor: pointer;
            display: block;
            text-align: center;
            font-weight: 700;
            font-size: 2em;
            opacity: 1;

            /* have a little 3d deformation */
            transform: skew(-6deg, -3deg);
            transition: transform 0.5s, color 0.2s, height 0.5s, padding 0.5s;

        }

        #app nav aside ul li:hover {
            opacity: .7;
        }

        #app nav aside ul li.active {
            color: #c00;
        }

        #app nav #previewImage {
            width: calc(100% - 200px);
            height: 100vh;
        }

        #logo:hover {
            cursor: pointer;
            opacity: .7;
        }

        #app nav #previewImage img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
        }

        #hidden_preload {
            display: none;
        }

        #app .previewThumbnail {
            opacity: 0;
            transition: opacity 0.5s;
        }

        #app .visible.previewThumbnail {
            opacity: 1;
        }

        #app #previewText {
            padding: 20px;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            color: #fff;
            transform: translate(0, 100px) skew(-3deg, -1deg);
            opacity: 0;
            pointer-events: none;
            flex: 1;
            transition: 0.4s all;

        }

        #app #previewText.visible {
            transform: translate(0, 0);
            opacity: 1;
            pointer-events: auto;
        }


    </style>
    <?php
    return ob_get_clean();
}