$(document).ready(function () {
    $(document).on('submit', '#modalPasswordChange', function (e) {
        e.preventDefault();
        $('#modalConfirmPasswordChange .js-btn-submit').attr('disabled', 'disabled');
        $.post(
            $(this).attr('action'),
            $(this).serialize(),
            function (res) {
                res = res.replace("0<div>", "<div>");

                $('#modalConfirmPasswordChange .js-btn-submit').removeAttr('disabled');

                let errors = $(res).find('#modalConfirmPasswordChange .js-confirm-form-errors');
                if (errors.length) {
                    $('#modalPasswordChange .js-confirm-form-errors').replaceWith(errors);
                    /*
                    grecaptcha.execute('6Lc-1M4ZAAAAANX_l3qkr19UZgB6y6IsXd5lYn79', {action: 'form'})
                        .then(function(token) {
                            if (token && document.getElementById('cp_token')) {
                                document.getElementById('cp_token').value = token;
                                document.getElementById('cp_action').value = 'form';
                            }
                        });
                        */
                } else {
                    $('#modalConfirmPasswordChange .modal__content').replaceWith($(res).find('#modalConfirmPasswordChange .modal__content'));
                }
            }
        );
    })
});
