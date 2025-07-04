<?php get_header(); ?>

<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-4xl px-4 py-8 bg-white rounded-lg shadow-lg">
        <!-- Форма пошуку -->
        <form role="search" method="get" class="mb-8" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <div class="flex items-center border border-gray-300 rounded-lg p-2">
                <input type="search" class="w-full p-2 text-gray-700 border-0 rounded-l-lg focus:outline-none"
                       placeholder="<?php echo __( 'Шукати...', 'hmd' ) ?>" value="<?php echo get_search_query(); ?>"
                       name="s"/>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-r-lg hover:bg-blue-700 focus:outline-none">
                    <?php echo __( 'Пошук: ', 'hmd' ) ?>
                </button>
            </div>
        </form>

        <h1 class="text-3xl font-semibold text-gray-800 mb-6"><?php echo __('Результати пошуку', 'hmd') ?></h1>

        <?php if ( have_posts() ) : ?>
            <div class="space-y-4">
                <?php while ( have_posts() ) : the_post(); ?>
                    <div class="p-4 border-b border-gray-200 rounded-lg">
                        <h2 class="text-xl font-semibold text-blue-600 hover:text-blue-800">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>
                        <p class="text-gray-600 mt-2"><?php the_excerpt(); ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="mt-6">
                <?php the_posts_pagination( array(
                    'prev_text'          => __('&laquo; Попередні', 'hmd'),
                    'next_text'          => __('Наступні &raquo;', 'hmd'),
                    'screen_reader_text' => __('Навігація по сторінках', 'hmd')
                ) ); ?>
            </div>
        <?php else : ?>
            <p class="text-lg text-gray-700"><?php echo __('Нічого не знайдено за вашим запитом.', 'hmd') ?></p>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
