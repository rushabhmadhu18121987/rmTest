$(document).ready(function () {
    if ($("#categorymaster-ticategorytype").length) {
        $("#categorymaster-ticategorytype").on('change', function () {
            var selected = $(this).val();
            if (selected != 1) {
                $(document).find('.clsCategory').val('').prop('disabled', true)
                $(document).find('.clsCategory').val('').closest('.form-group').addClass('hidden');
                $(document).find('.clsCategory').val('').closest('.form-group').removeClass('has-error').addClass('has-success');
                $(document).find('.clsCategory').val('').closest('.form-group').find('.help-block').text('');
            } else {
                $(document).find('.clsCategory').removeAttr('disabled');
                $(document).find('.clsCategory').closest('.form-group').removeClass('hidden');
            }
        });
        $("#categorymaster-ticategorytype").trigger('change');
    }
});