$(document).ready(function() {
    $('#newPassword, #confirmNewPassword').on('keyup', function () {
        if ($('#newPassword').val() == $('#confirmNewPassword').val()) {
            $('#confirmNewPassword').removeClass('is-invalid');
        } else {
            $('#confirmNewPassword').addClass('is-invalid');
        }
    });
});
