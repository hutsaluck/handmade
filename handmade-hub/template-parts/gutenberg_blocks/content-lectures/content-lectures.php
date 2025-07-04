<?php
/**
 * Content Lectures Template.
 */

if ( isset( $block[ 'data' ][ 'preview_image_help' ] ) ) :    /* rendering in inserter preview  */

    echo '<h2>' . $block[ 'data' ][ 'description' ] . '</h2>
    <figure><img src="' . $block[ 'data' ][ 'preview_image_help' ] . '"/></figure>';

else :
    $number = get_field( 'number' );
    $args = array(
        'post_type'      => 'hmd_lecture',
        'posts_per_page' => $number,
    );
    $query = new WP_Query( $args );

    ?>
    <section class="container mx-auto px-4 py-16 grid grid-cols-1 md:grid-cols-<?php echo $number ?> gap-8">
        <?php if ( $query->have_posts() ) : ?>
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                <div class="text-center">
                    <div class="bg-gray-300 h-48 w-full mb-4">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <img class="h-48 w-full" src="<?php the_post_thumbnail_url( 'medium' ); ?>"
                                 alt="<?php the_title(); ?>">
                        <?php endif; ?>
                    </div>
                    <h3 class="text-2xl font-bold"><?php the_title(); ?></h3>
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
                    <a href="<?php echo esc_url( get_the_permalink() ); ?>"
                       class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold my-2 py-2 px-4 rounded">
                        <?php echo __( 'Перейти', 'hmd' ) ?>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </section>
<?php
endif;