<?php
get_header();


if ( have_posts() ) : while ( have_posts() ) : the_post();
    ?>

    <div class="container mx-auto px-4">
        <div class="my-8">
            <h1 class="text-3xl font-semibold mb-4"><?php the_title(); ?></h1>

            <?php if ( has_post_thumbnail() ) : ?>
                <div class="mb-4">
                    <img class="w-full h-96 object-cover rounded-lg" src="<?php the_post_thumbnail_url( 'large' ); ?>"
                         alt="<?php the_title(); ?>">
                </div>
            <?php endif; ?>

            <div class="mb-4 text-sm text-gray-600">

                <?php $lecturers = get_the_terms( get_the_ID(), 'hmd_lecturer' );
                if ( $lecturers ) : ?>
                    <p>
                        <?php echo __('Вчитель: ', 'hmd') ?><span class="font-semibold"><?php echo esc_html( $lecturers[ 0 ]->name ) ?></span>
                    </p>
                <?php endif; ?>

                <?php $price = get_field( 'price', get_the_ID() );
                if ( $price ) : ?>
                    <p>
                        <?php echo __('Ціна: ', 'hmd') ?><span class="font-semibold"><?php echo '$' . esc_html( $price ) ?></span>
                    </p>
                <?php endif; ?>
            </div>

            <div class="prose lg:prose-xl">
                <?php the_content(); ?>
            </div>


            <?php
            $current_post_id = get_the_ID();

            $categories = get_the_category( $current_post_id );
            if ( $categories ) {
                $category_ids = array();
                foreach ( $categories as $category ) {
                    $category_ids[] = $category->term_id;
                }

                $related_posts_query = new WP_Query( array(
                    'post_type'      => 'hmd_lecture',
                    'category__in'   => $category_ids,
                    'post__not_in'   => array( $current_post_id ),
                    'posts_per_page' => 3,
                    'orderby'        => 'rand',
                ) );

                if ( $related_posts_query->have_posts() ) : ?>
                    <div class="related-posts my-8">
                        <h2 class="text-2xl font-semibold mb-4"><?php echo __("Пов'язані пости", 'hmd') ?></h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            <?php while ( $related_posts_query->have_posts() ) : $related_posts_query->the_post(); ?>
                                <div class="bg-white p-4 rounded-lg shadow-md">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php if ( has_post_thumbnail() ) : ?>
                                            <img class="w-full h-48 object-cover rounded-md mb-4"
                                                 src="<?php the_post_thumbnail_url( 'medium' ); ?>"
                                                 alt="<?php the_title(); ?>">
                                        <?php endif; ?>
                                        <h3 class="text-xl font-semibold text-blue-500 hover:text-blue-700"><?php the_title(); ?></h3>
                                    </a>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                <?php endif;

                wp_reset_postdata();
            }

            $related_posts_manual = get_field( 'related_posts' );
            if ( $related_posts_manual ) : ?>
                <div class="related-posts my-8">
                    <h2 class="text-2xl font-semibold mb-4"><?php echo __("Ручні пов'язані пости", 'hmd') ?></h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <?php foreach ( $related_posts_manual as $post ) : ?>
                            <div class="bg-white p-4 rounded-lg shadow-md">
                                <a href="<?php echo get_permalink( $post->ID ); ?>">
                                    <?php if ( has_post_thumbnail( $post->ID ) ) : ?>
                                        <img class="w-full h-48 object-cover rounded-md mb-4"
                                             src="<?php echo get_the_post_thumbnail_url( $post->ID, 'medium' ); ?>"
                                             alt="<?php echo get_the_title( $post->ID ); ?>">
                                    <?php endif; ?>
                                    <h3 class="text-xl font-semibold text-blue-500 hover:text-blue-700"><?php echo get_the_title( $post->ID ); ?></h3>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>


            <div class="mt-6">
                <a href="<?php echo get_post_type_archive_link( 'hmd_lecture' ); ?>"
                   class="text-blue-500 hover:text-blue-700">
                    &larr; <?php echo __('Повернутися до архіву лекцій', 'hmd') ?>
                </a>
            </div>
        </div>
    </div>

<?php
endwhile;
else : ?>
    <p><?php echo __('Пост не знайдено.', 'hmd') ?></p>
<?php endif;

get_footer();
?>
