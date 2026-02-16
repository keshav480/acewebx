import $ from "jquery";

$(document).ready(function() {
    console.log("Custom JS loaded. Checking for Slick...");

    // Safety check to ensure Slick is ready
    if ($.fn.slick) {
        $('.slider').slick({
            autoplay: true,
            dots: true,
            infinite: true,
            arrows: true
        });
        console.log("Slick initialized!");
    } else {
        console.error("Slick is not a function. Check app.js import order.");
    }
});
