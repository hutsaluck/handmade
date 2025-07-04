<?php get_header(); ?>

<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold text-center mb-8">
        <?php single_term_title(); ?> <!-- Назва поточної таксономії -->
    </h1>

    <div class="categories-buttons text-center mb-6 flex flex-wrap justify-center gap-4">
        <a href="<?php echo esc_url(get_post_type_archive_link( 'hmd_lecture' )); ?>" class="px-4 py-2 rounded-md transition duration-200 text-white bg-blue-500 hover:bg-blue-600">
            <?php echo __('Всі', 'hmd'); ?>
        </a>
        <?php
        $categories = get_categories(array(
            'taxonomy' => 'hmd_lecturer',
            'post_type'      => 'hmd_lecture',
            'hide_empty' => true,
            'orderby' => 'date',
            'order'   => 'DESC'
        ));

        foreach ($categories as $category) :
            $category_link = get_category_link($category->term_id);
            if($category->term_id === get_queried_object()->term_id): ?>
                <p class="px-4 py-2 rounded-md transition duration-200 text-blue-500 bg-white">
                    <?php echo esc_html($category->name); ?>
                </p>
            <?php else: ?>
                <a href="<?php echo esc_url($category_link); ?>" class="px-4 py-2 rounded-md transition duration-200 text-white bg-blue-500 hover:bg-blue-600">
                    <?php echo esc_html($category->name); ?>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <?php
    $args = array(
        'post_type' => 'hmd_lecture',
        'tax_query' => array(
            array(
                'taxonomy' => 'hmd_lecturer',
                'field' => 'id',
                'terms' => get_queried_object()->term_id,
                'operator' => 'IN',
            ),
        ),
    );
    $query = new WP_Query($args);
    ?>

    <?php if ($query->have_posts()) : ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <div class="car-item bg-white rounded-lg shadow p-4">
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>">
                            <img class="w-full h-48 object-cover rounded-t-md" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                        </a>
                    <?php endif; ?>
                    <div class="p-4">
                        <h2 class="text-xl font-semibold mb-2">
                            <a href="<?php the_permalink(); ?>" class="text-blue-500 hover:underline"><?php the_title(); ?></a>
                        </h2>
                        <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Пагінація -->
        <div class="pagination mt-8">
            <?php
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => __('« Попередня', 'hmd'),
                'next_text' => __('Наступна »', 'hmd'),
            ));
            ?>
        </div>
    <?php else : ?>
        <p><?php echo __('Немає постів у цій категорії.', 'hmd') ?></p>
    <?php endif; ?>

    <?php wp_reset_postdata(); ?>
</div>

<?php get_footer(); ?>
