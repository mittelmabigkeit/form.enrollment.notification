function initNotificationJs() {

    $('.legal').on('change', function () {
        if ($(this).is(':checked')) {
            $(this).closest('form').find('.btn-enrollment-notification').attr('disabled', false);
        } else {
            $(this).closest('form').find('.btn-enrollment-notification').attr('disabled', true);
        }
    });

    window.popups();

}

$(document).ready(function () {
    initNotificationJs();
});

BX.addCustomEvent('onAjaxSuccess', function(){
    initNotificationJs();
});
