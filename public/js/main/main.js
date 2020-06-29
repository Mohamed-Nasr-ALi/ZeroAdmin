$(document).ready(function () {
    window.setTimeout(function () {
        $(".alert").remove();
    }, 6000);

    $(window).keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });
    $("#myToast").toast('show');
    $('.modal').insertAfter($('body'));
});

