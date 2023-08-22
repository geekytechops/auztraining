$(document).on('input','.number-field',function(e){
    $(this).val($(this).val().replace(/[^0-9]/gi, ''));
})
$(document).on('focus','input,select',function(e){
    $(this).removeClass('invalid-div');
    $(this).closest('div').find('.error-feedback').hide();
})