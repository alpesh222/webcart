<script>
    var swiper = new Swiper('.deal-swiper-{{$index}}', {
        pagination: '.swiper-pagination',
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        paginationClickable: true,
        slidesPerView: {{$slides_preview}},
        spaceBetween: 30,
        loop: false,
        autoplay: false,
        autoplayDisableOnInteraction: false,
        breakpoints: {
            // when window width is <= 320px
            320: {
                slidesPerView: 1,
                spaceBetween: 10
            },
            // when window width is <= 480px
            480: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            // when window width is <= 640px
            640: {
                slidesPerView: 1,
                spaceBetween: 30
            },
           // when window width is <= 1024px
            1024: {
                slidesPerView: 2,
                spaceBetween: 40
            },
           // when window width is <= 1048px
            1048: {
                slidesPerView: 3,
                spaceBetween: 40
            },
           // when window width is <= 1296px
            1296: {
                slidesPerView: 4,
                spaceBetween: 40
            },
           // when window width is <= 1495px
            1495: {
                slidesPerView: 5,
                spaceBetween: 40
            },
            2000: {
                slidesPerView: 5,
                spaceBetween: 40
            }
        }
    });
</script>