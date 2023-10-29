// Customers Owl Carousel
$(document).ready(function () {
    // partners slider
    $('#organizations').owlCarousel({
        margin: 20,
        rtl: true,
        autoplay: true,
        loop: true,
        dots: false,
        margin: 40,
        autoHeight: true,
        autoplayTimeout: 3000,
        smartSpeed: 800,
        nav: false,
        responsive: {
            0: {
                items: 3
            },
            600: {
                items: 3
            },
            1000: {
                items: 6
            }
        }
    });
});