<?php

require_once 'inc/GutenbergAcfBlock.php';
require_once 'inc/HmdMenu.php';
require_once 'inc/HmdMobileMenu.php';
require_once 'inc/HandmadeTypePost.php';


define( "LINK_THEME", get_stylesheet_directory_uri() );


add_action('wp_enqueue_scripts', 'enqueue_styles');
function enqueue_styles() {
    wp_enqueue_style('hmd', LINK_THEME . '/style.css', [], '1.0');
    wp_enqueue_style('hmd-style', LINK_THEME . '/style-theme.css', [], '1.0');
    wp_enqueue_style('hmd-swiper', LINK_THEME . '/assets/css/swiper-bundle.min.css', [], '1.0');
    wp_enqueue_style('hmd-tailwind', LINK_THEME . '/assets/css/tailwind.min.css', [], '1.0');
}

add_action('wp_enqueue_scripts', 'enqueue_scripts');
function enqueue_scripts() {
    wp_enqueue_script( 'hmd-jquery', LINK_THEME . '/assets/js/jquery.min.js', array(), '1.0' );
    wp_enqueue_script('hmd-swiper', LINK_THEME . '/assets/js/swiper-bundle.min.js', ['hmd-jquery'], '1.0', true);
    wp_enqueue_script('hmd-main', LINK_THEME . '/assets/js/main.js', ['hmd-jquery', 'hmd-swiper'], '1.0', true);
    wp_localize_script('hmd-main', 'ajaxurl', admin_url('admin-ajax.php'));
}

/* Connect scripts */
add_action( 'admin_enqueue_scripts', 'hmd_admin_style' );
function hmd_admin_style() {
    if ( is_edit_page() && ! is_edit_page( 'widgets' ) ) {
        /* Styles */
        wp_enqueue_style( 'hmd-style', LINK_THEME . '/style.css', array(), '1.0' );
        wp_enqueue_style('hmd-swiper', LINK_THEME . '/assets/css/swiper-bundle.min.css', [], '1.0');
        wp_enqueue_style('hmd-tailwind', LINK_THEME . '/assets/css/tailwind.min.css', [], '1.0');
    }
}

/**
 * is_edit_page
 * function to check if the current page is a post edit page
 */
function is_edit_page( $new_edit = null ) {
    global $pagenow;

    if ( ! is_admin() ) {
        return false;
    }

    if ( $new_edit == "edit" ) {
        return $pagenow == 'post.php';
    }
    if ( $new_edit == "new" ) {
        return $pagenow == 'post-new.php';
    }
    if ( $new_edit == "widgets" ) {
        return in_array( $pagenow, array( 'widgets.php', 'admin-ajax.php' ) );
    }

    return in_array( $pagenow, array( 'post.php', 'post-new.php', 'widgets.php', 'admin-ajax.php' ) );
}


/* Initialize gutenberg categories */
add_filter( 'block_categories_all', 'hmd_theme_block_categories', 10, 1 );
function hmd_theme_block_categories( $block_categories ) {
    return array_merge(
        [
            [
                'slug'  => 'hmd_template',
                'title' => __( 'Theme templates', 'one' ),
                'icon'  => 'feedback',
            ]
        ], $block_categories
    );
}

/* Connect theme data */
add_action( 'after_setup_theme', 'theme_add_nav_menu' );
function theme_add_nav_menu() {
    /* Initialize menu */
    register_nav_menu(
        'primary-menu', __( "Primary menu at the header" )
    );
    register_nav_menu(
        'footer-menu', __( "Footer menu at the footer" )
    );

    // Add theme support for Featured Images
    add_theme_support( 'post-thumbnails' );

    /* Adds the ability to insert logo */
    add_theme_support( 'custom-logo' );

    /* Initialize title */
    add_theme_support( 'title-tag' );

    /* Initialize widgets */
    add_theme_support( 'widgets' );
}

add_action('wp_ajax_filter_lectures', 'filter_lectures_ajax');
add_action('wp_ajax_nopriv_filter_lectures', 'filter_lectures_ajax');
function filter_lectures_ajax() {
    $lecturer = isset($_GET['lecturer']) ? sanitize_text_field($_GET['lecturer']) : '';
    $price = isset($_GET['price']) ? sanitize_text_field($_GET['price']) : '';

    $args = array(
        'post_type' => 'hmd_lecture',
        'posts_per_page' => 9,
        'paged' => isset($_GET['page']) ? $_GET['page'] : 1,
    );

    $args['tax_query'] = [];

    if ($lecturer) {
        $args['tax_query'][] = array(
            'taxonomy' => 'hmd_lecturer',
            'field' => 'id',
            'terms' => $lecturer,
        );
    }

    if ( $price ) {
        $args['meta_query'][] = array(
            'key'     => 'price',
            'value'   => $price,
            'compare' => '=',
            'type'    => 'NUMERIC',
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        ob_start();
        while ($query->have_posts()) : $query->the_post();
            ?>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <a href="<?php the_permalink(); ?>">
                    <?php if (has_post_thumbnail()) : ?>
                        <img class="w-full h-48 object-cover rounded-md mb-4" src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>">
                    <?php endif; ?>
                    <h3 class="text-xl font-semibold text-blue-500 hover:text-blue-700"><?php the_title(); ?></h3>

                    <?php $lecturers = get_the_terms( get_the_ID(), 'hmd_lecturer' );
                    if ( $lecturers ) : ?>
                        <p>
                            <?php echo __( 'Марка: ', 'hmd' ) ?><span
                                    class="font-semibold"><?php echo esc_html( $lecturers[ 0 ]->name ) ?></span>
                        </p>
                    <?php endif; ?>

                    <?php $price = get_the_terms( 'price', get_the_ID() );
                    if ( $price ) : ?>
                        <p>
                            <?php echo __( 'Ціна: ', 'hmd' ) ?><span
                                    class="font-semibold"><?php echo '$' . esc_html( $price ) ?></span>
                        </p>
                    <?php endif; ?>
                </a>
            </div>
        <?php endwhile;


        $pagination = paginate_links(array(
            'total' => $query->max_num_pages,
            'current' => max(1, get_query_var('paged')),
            'type' => 'list',
        ));

        wp_send_json_success(array(
            'posts' => ob_get_clean(),
            'pagination' => $pagination,
        ));
    else :
        wp_send_json_success(array(
            'posts' => __('<p>Немає лекцій для відображення.</p>', 'hmd'),
            'pagination' => '',
        ));
    endif;

    wp_die();
}


function render_price_dropdown() {
    global $wpdb;

    $meta_key  = 'price';   // ← назва ACF-поля
    $post_type = 'hmd_lecture';    // ← типовий CPT, за потреби змініть

    // Витягуємо унікальні meta_value, сортуємо як числа
    $prices = $wpdb->get_col(
        $wpdb->prepare(
            "
            SELECT DISTINCT pm.meta_value
            FROM  {$wpdb->postmeta} pm
            INNER JOIN {$wpdb->posts} p ON p.ID = pm.post_id
            WHERE pm.meta_key   = %s
              AND p.post_status = 'publish'
              AND p.post_type   = %s
            ORDER BY CAST(pm.meta_value AS UNSIGNED) ASC
            ",
            $meta_key,
            $post_type
        )
    );

    // Якщо значення числові, можна одразу привести до int/float
    $prices = array_map( 'floatval', $prices );

    return $prices;
}


add_filter( 'register_post_type_args', 'safely_modify_post_type_args', 10, 2 );
function safely_modify_post_type_args( $args, $post_type ) {
    if ( $post_type === 'post' ) {
        $args[ 'has_archive' ] = true;
        $args[ 'rewrite' ]     = array( 'slug' => 'blog' );
    }

    return $args;
}



