import $ from "jquery";

$(document).ready(function () {
       $(".slider").slick({
        slidesToShow: 3,     
        slidesToScroll: 1,
        // dots: true,
        // arrows: true,
        autoplay: true,
        autoplaySpeed: 3000,
        infinite: true,
        //  prevArrow: `
        //     <button class="absolute left-2 top-1/2 -translate-y-1/2 z-10 bg-black text-white px-3 py-2 rounded">
        //         ←
        //     </button>`,

        // nextArrow: `
        //     <button class="absolute right-2 top-1/2 -translate-y-1/2 z-10 bg-black text-white px-3 py-2 rounded">
        //         →
        //     </button>`
    });
});