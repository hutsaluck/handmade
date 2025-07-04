<?php wp_footer(); ?>
<footer class="bg-gray-900 text-white py-8">
    <div class="container mx-auto px-4 flex flex-col md:flex-row justify-between items-center">
        <?php if(get_field( 'footer_logo', 'option' )): ?>
            <img class="w-48" src="<?php echo get_field( 'footer_logo', 'option' ) ?>" alt="logo">
        <?php endif; ?>
        <?php
        wp_nav_menu( array(
            'theme_location' => 'footer-menu',
            'container' => 'nav',
            'container_class' => 'space-x-4 mb-4 md:mb-0 list-none md:flex items-center',
            'menu_class' => '',
            'link_before' => '<span class="hover:text-gray-300">',
            'link_after' => '</span>',
            'items_wrap' => '%3$s',
        ) );
        ?>
        <div class="text-sm">
            <?php if(get_field( 'copyright', 'option' )): ?>
                <?php echo str_replace( '{year}', date( 'Y' ), get_field( 'copyright', 'option' ) ) ?>
            <?php endif; ?>
        </div>
    </div>
</footer>

</body>
</html>