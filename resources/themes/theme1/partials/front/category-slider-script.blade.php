<script>
var swiper = new Swiper('.swiper-3', {
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
       // when window width is <= 1280px
        1280: {
            slidesPerView: 4,
            spaceBetween: 40
        },
       // when window width is <= 1360px
        1360: {
            slidesPerView: 5,
            spaceBetween: 40
        }
    }
});
</script>