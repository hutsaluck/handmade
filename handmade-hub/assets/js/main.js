jQuery(function ($) {
    // Toggle mobile menu
    $('#mobile-menu-toggle').on('click', function() {
        $('#mobile-menu').toggle();
    });

    // Toggle submenu on desktop
    $('.menu-item:has(a.parent)').hover(function(e) {
        $(this).children('.submenu').toggle();
    });

    // Toggle submenu on mobile
    $('.menu-item button:not(.active)').on('click', function(e) {
        $(this).addClass('.active')
        $(this).siblings('.submenu').show();
    });

    // Hide submenu when clicking outside
    $('.menu-item button.active').on('click', function(e) {
        $(this).removeClass('.active')
        $(this).siblings('.submenu').hide();
    });

    //Include Swiper initialization script
    const swiper = new Swiper('.swiper-container', {
        loop: true,
        slidesPerView: 1,
        autoplay: {
            delay: 10000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });


    // Archive cars
    function applyFilters() {
        const lecturer = $('#lecturer-filter').val();
        const price = $('#price-filter').val();

        $.ajax({
            url: ajaxurl,
            method: 'GET',
            data: {
                action: 'filter_lectures',
                lecturer: lecturer,
                price: price,
                page: 1
            },
            success: function(response) {
                $('#lecture-posts').html(response.data.posts);
                $('.pagination').html(response.data.pagination);
            }
        });
    }

    $('#apply-filters').on('click', function() {
        applyFilters();
    });

    $('#brand-filter, #year-filter').on('change', function() {
        applyFilters();
    });




    const lazyLoad = () => {
        $('.lazyload').each((int, el) => {
            const img = $(el);
            const windowTop = $(window).scrollTop();
            const windowBottom = windowTop + $(window).height();
            const imgTop = img.offset().top;
            const imgBottom = imgTop + img.height();


            if (imgBottom >= windowTop && imgTop <= windowBottom) {
                const src = img.attr('data-src');
                img.attr('src', src);
                img.removeClass('lazyload');
            }
        });
    }


    $(window).on('scroll', lazyLoad);
    lazyLoad();

})
