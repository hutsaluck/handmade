<?php
/**
 * Register acf blocks
 *
 */
add_action( 'acf/init', 'hmd__acf_blocks' );
function hmd__acf_blocks() {
    define( 'LINK_TEMPLATE', get_template_directory() . '/template-parts/gutenberg_blocks/' );
    define( 'LINK_STYLESHEET', LINK_THEME . '/template-parts/gutenberg_blocks/' );

    if ( ! function_exists( 'acf_register_block' ) ) {
        return;
    }

    /* Content Lectures */
    acf_register_block_type( array(
        'name'            => 'content-lectures',
        'title'           => __( 'Content Lectures', 'hmd' ),
        'description'     => __( 'Content Lectures', 'hmd'  ),
        'icon'            => 'welcome-learn-more',
        'keywords'        => array( 'Content Lectures', 'Контент з лекціями' ),
        'render_template' => LINK_TEMPLATE . 'content-lectures/content-lectures.php',
        'category'        => 'hmd_template',
        'mode'            => 'auto',
        'align'           => 'full',
        'example'         => array(
            'attributes' => array(
                'mode' => 'preview',
                'data' => array(
                    'description'        => __( 'Content Lectures', 'hmd'  ),
                    'preview_image_help' => LINK_STYLESHEET . 'content-lectures/content-lectures.png'
                )
            )
        )
    ) );


}

