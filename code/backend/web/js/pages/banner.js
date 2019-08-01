
$(document).ready(function () {
    $("#bannermaster-tibannertype").on('change', function () {
        /* tiIsNightRateDifferent  */
        var selected = $(this).val();
        if (selected == 1 || selected == 2) {
            $(document).find('.clsEntryList').closest('.form-group').removeClass('hidden');
            $(document).find('.clsEntryList').removeAttr('disabled');
            $(document).find('.clsEntryList').closest('.form-group').removeClass('hidden');
        $("#bannermaster-ientryid").select2('val', {'id': '', 'text': ''});
        } else {
            $(document).find('.clsEntryList').closest('.form-group').addClass('hidden');
            $(document).find('.clsEntryList').val('').prop('disabled', true)
            $(document).find('.clsEntryList').val('').closest('.form-group').addClass('hidden');
            $(document).find('.clsEntryList').val('').closest('.form-group').removeClass('has-error').addClass('has-success');
            $(document).find('.clsEntryList').val('').closest('.form-group').find('.help-block').text('');
        }
        $("#bannermaster-tibannertype").val(selected);
    });
    $("#bannermaster-tibannertype").trigger('change');
});


