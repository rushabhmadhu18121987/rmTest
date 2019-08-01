
$(document).ready(function () {
    $("#adminannouncements-tinotificationreceiver").on('change', function () {
        /* tiIsNightRateDifferent  */
        var selected = $(this).val();
        if (selected == 1 || selected == 2) {
            $(document).find('.clsUserList').closest('.form-group').removeClass('hidden');
            $(document).find('.clsUserList').removeAttr('disabled');
            $(document).find('.clsUserList').closest('.form-group').removeClass('hidden');
        $("#adminannouncements-iusers").select2('val', {'id': '', 'text': ''});
        } else {
            $(document).find('.clsUserList').closest('.form-group').addClass('hidden');
            $(document).find('.clsUserList').val('').prop('disabled', true)
            $(document).find('.clsUserList').val('').closest('.form-group').addClass('hidden');
            $(document).find('.clsUserList').val('').closest('.form-group').removeClass('has-error').addClass('has-success');
            $(document).find('.clsUserList').val('').closest('.form-group').find('.help-block').text('');
        }
        $("#adminannouncements-tinotificationreceiver").val(selected);
    });
    $("#adminannouncements-tinotificationreceiver").trigger('change');
});


