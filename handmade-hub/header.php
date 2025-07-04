<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="font-sans bg-gray-100 text-gray-900">
<?php wp_head(); ?>

<!-- Header -->
<header class="bg-white shadow">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <div class="text-lg font-bold">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <?php
                $custom_logo_id = get_theme_mod( 'custom_logo' );
                $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );

                if ( has_custom_logo() ) : ?>
                    <img src="<?php echo esc_url($logo[0]) ?>" alt="<?php echo get_bloginfo( 'name' ) ?>"
                         class="w-36">
                <?php else: ?>
                   <h1><?php echo get_bloginfo( 'name' ) ?></h1>
                <?php endif; ?>
            </a>
        </div>
        <?php
        wp_nav_menu(array(
            'theme_location' => 'primary-menu',
            'items_wrap'     => '<nav class="space-x-4 hidden md:flex items-center">%3$s</nav>',
            'walker' => new HmdMenu(),
        ));
        ?>

        <!-- Search Form -->
        <div class="flex items-center space-x-4">
            <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center">
                <input type="search" name="s" class="p-2 border border-gray-300 rounded-l-lg focus:outline-none"
                       placeholder="<?php echo __('Шукати...', 'hmd'); ?>" value="<?php echo get_search_query(); ?>" />
                <button type="submit" class="p-2 bg-blue-600 text-white rounded-r-lg hover:bg-blue-700 focus:outline-none">
                    <?php echo __('Пошук', 'hmd'); ?>
                </button>
            </form>
        </div>

        <!-- Mobile Menu Button -->
        <div class="md:hidden">
            <button id="mobile-menu-toggle" class="text-gray-700 focus:outline-none">
                ☰
            </button>
        </div>
    </div>

    <?php
    wp_nav_menu(array(
        'theme_location' => 'primary-menu',
        'items_wrap'     => '<nav id="mobile-menu" class="hidden bg-white shadow-lg md:hidden">%3$s</nav>',
        'walker' => new HmdMobileMenu(),
    ));
    ?>
</header>


