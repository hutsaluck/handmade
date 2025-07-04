<?php get_header(); ?>

<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="text-center">
        <h1 class="text-4xl font-bold text-red-600"><?php echo __('404', 'hmd') ?></h1>
        <p class="text-lg text-gray-700 mb-4"><?php echo __('Ой! Сторінку не знайдено.', 'hmd') ?></p>
        <p class="text-sm text-gray-500 mb-6">
            <?php echo __('Вибачте, але сторінка, яку ви шукаєте, не існує або була переміщена.', 'hmd') ?>
        </p>
        <a href="<?php echo home_url(); ?>" class="px-6 py-2 text-white bg-blue-600 rounded hover:bg-blue-700 transition duration-200">
            <?php echo __('Повернутися на головну', 'hmd') ?>
        </a>
    </div>
</div>

<?php get_footer(); ?>
