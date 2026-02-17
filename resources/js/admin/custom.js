import $ from "jquery";
window.autoHideMessage = function (selector = ".message", delay = 4000) {
    const $msg = $(selector);

    if (!$msg.length) return;

    setTimeout(function () {
        $msg.fadeOut(500, function () {
            $(this).remove();
        });
    }, delay);
};

$(document).ready(function () {
    autoHideMessage();
});