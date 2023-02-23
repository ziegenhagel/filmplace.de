<footer>
    <nav class="navbar">
        <div class="container">
            <ul class="menu">
                <?php

                // get all links from with position "Bottom"
                $menu_items = wp_get_nav_menu_items('Bottom');

                // print each link with dropdowns for submenus
                foreach ($menu_items as $menu_item) {
                    if ($menu_item->menu_item_parent == 0) {

                        // filter out menu items that are not top level
                        $children = array();
                        foreach ($menu_items as $submenu) {
                            if ($submenu->menu_item_parent == $menu_item->ID) {
                                $children[] = $submenu;
                            }
                        }

                        // if there are children, print the dropdown
                        if (count($children) > 0) {

                            // print the dropdown, add a active class if the current page is a child of this menu item or the menu item itself
                            echo '<li class="dropdown">';
                            echo '<a href="' . $menu_item->url . '">' . $menu_item->title . '</a>';
                            echo '<ul class="dropdown-content">';
                            foreach ($children as $submenu) {
                                echo '<li><a href="' . $submenu->url . '">' . $submenu->title . '</a></li>';
                            }
                            echo '</ul>';
                            echo '</li>';
                        } else {
                            echo '<li><a href="' . $menu_item->url . '">' . $menu_item->title . '</a></li>';
                        }
                    }
                }

                ?>
            </ul>
    </nav>

    <!-- copyrigth -->
    <div class="copyright">
        &copy; <?php echo date('Y'); ?> <?php echo get_bloginfo('name'); ?>
    </div>

    </div>
</footer>