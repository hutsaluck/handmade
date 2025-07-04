<?php
get_header();

if (have_posts()) : ?>

    <div class="container mx-auto px-4">
        <div class="my-8">
            <h1 class="text-3xl font-semibold mb-4"><?php echo __('Архів постів', 'hmd') ?></h1>

            <div class="space-y-6">
                <?php
                while (have_posts()) : the_post();
                    ?>
                    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                        <h2 class="text-2xl font-semibold mb-4">
                            <a href="<?php the_permalink(); ?>" class="text-blue-500 hover:text-blue-700"><?php the_title(); ?></a>
                        </h2>

                        <?php if (has_post_thumbnail()) : ?>
                            <div class="mb-4">
                                <a href="<?php the_permalink(); ?>">
                                    <img class="w-full h-64 object-cover rounded-lg" src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="text-gray-700 mb-4">
                            <?php the_excerpt(); ?>
                        </div>

                        <div class="text-sm text-gray-600">
                            <p>
                                <?php printf(__('Опубліковано: %1$s автором %2$s', 'hmd'), get_the_date(), get_the_author()); ?>
                            </p>
                        </div>

                        <a href="<?php the_permalink(); ?>" class="text-blue-500 hover:text-blue-700"><?php echo __('Читати далі &rarr;', 'hmd') ?></a>
                    </div>
                <?php endwhile; ?>
            </div>

            <div class="mt-6">
                <?php
                the_posts_pagination( array(
                    'mid_size' => 2,
                    'prev_text' => __('&laquo; Попередня', 'hmd'),
                    'next_text' => __('Наступна &raquo;', 'hmd'),
                    'screen_reader_text' => __('Переглянути сторінки', 'hmd'),
                ) );
                ?>
            </div>

        </div>
    </div>

<?php else : ?>

    <p><?php echo __('Пости не знайдено.', 'hmd') ?></p>

<?php endif;

get_footer();
?>
