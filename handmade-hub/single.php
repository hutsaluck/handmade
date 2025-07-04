<?php
get_header();

if (have_posts()) : while (have_posts()) : the_post();
    ?>

    <div class="container mx-auto px-4">
        <div class="my-8">
            <!-- Заголовок поста -->
            <h1 class="text-3xl font-semibold mb-4"><?php the_title(); ?></h1>

            <?php if (has_post_thumbnail()) : ?>
                <div class="mb-4">
                    <img class="w-full h-96 object-cover rounded-lg" src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
                </div>
            <?php endif; ?>

            <div class="prose lg:prose-xl mb-6">
                <?php the_content(); ?>
            </div>

            <div class="text-sm text-gray-600 mb-6">
                <p><?php printf(__('Опубліковано: %1$s автором %2$s', 'hmd'), get_the_date(), get_the_author()); ?></p>
            </div>

            <div class="mt-6">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="text-blue-500 hover:text-blue-700">
                    <?php echo __('&larr; Повернутися до всіх постів', 'hmd') ?></a>
            </div>

            <?php
            if (comments_open() || get_comments_number()) {
                comments_template();
            }
            ?>

        </div>
    </div>

<?php
endwhile;
else : ?>
    <p><?php echo __('Пост не знайдено.', 'hmd') ?></p>
<?php endif;
get_footer();
?>
