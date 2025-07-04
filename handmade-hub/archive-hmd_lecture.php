<?php get_header(); ?>

<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold text-center mb-8"><?php echo __('Лекції', 'hmd') ?></h1>

    <div class="categories-buttons text-center mb-6 flex flex-wrap justify-center gap-4">
        <p class="px-4 py-2 rounded-md transition duration-200 text-blue-500 bg-white">
            <?php echo __( 'Всі', 'hmd' ); ?>
        </p>
        <?php

        $categories = get_categories( array(
            'taxonomy'   => 'hmd_lecturer',
            'post_type'  => 'hmd_lecture',
            'hide_empty' => true,
            'orderby'    => 'date',
            'order'      => 'DESC'
        ) );

        // Виводимо кожну категорію як кнопку
        foreach ( $categories as $category ) :
            $category_link = get_category_link( $category->term_id );
            ?>
            <a href="<?php echo esc_url( $category_link ); ?>"
               class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-200">
                <?php echo esc_html( $category->name ); ?>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="mb-6 flex justify-center gap-4">
        <?php $lecturers = get_terms( array(
                'taxonomy'   => 'hmd_lecturer',
                'orderby'    => 'name',
                'hide_empty' => true,
            ) );
        if(!empty($lecturers)): ?>
        <select id="lecturer-filter" class="border p-2 rounded">
            <option value=""><?php echo __( 'Виберіть вчителя', 'hmd' ) ?></option>
            <?php
            foreach ( $lecturers as $lecturer ) {
                echo '<option value="' . $lecturer->term_id . '">' . $lecturer->name . '</option>';
            }
            ?>
        </select>
        <?php endif; ?>
        <?php $prices = render_price_dropdown();
        if ( !empty( $prices ) ): ?>
            <select id="price-filter" class="border p-2 rounded">
                <option value=""><?php echo __( 'Виберіть ціну', 'hmd' ) ?></option>
                <?php
                foreach ( $prices as $price ) {
                    echo '<option value="' . $price . '">' . $price . '</option>';
                }
                ?>
            </select>
        <?php endif; ?>

        <button id="apply-filters" class="bg-blue-500 text-white p-2 rounded">
            <?php echo __( 'Застосувати фільтри', 'hmd' ) ?>
        </button>
    </div>

    <div id="lecture-posts" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post();
                ?>
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <a href="<?php the_permalink(); ?>">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <img class="w-full h-48 object-cover rounded-md mb-4"
                                 src="<?php the_post_thumbnail_url( 'medium' ); ?>" alt="<?php the_title(); ?>">
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
        else : ?>
            <p><?php echo __( 'Немає лекцій для відображення.', 'hmd' ) ?></p>
        <?php endif; ?>
    </div>

    <div class="pagination mt-8">
        <?php
        the_posts_pagination( array(
            'prev_text'          => __( '&laquo; Попередня', 'hmd' ),
            'next_text'          => __( 'Наступна &raquo;', 'hmd' ),
            'before_page_number' => __( '<span class="sr-only">Сторінка </span>', 'hmd' ),
        ) );
        ?>
    </div>
</div>

<?php get_footer(); ?>
