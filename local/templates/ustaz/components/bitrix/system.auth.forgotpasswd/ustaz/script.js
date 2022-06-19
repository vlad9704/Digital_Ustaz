$(document).ready(function () {
    $(document).on('submit', '.js-forgotpasswd-form', function (e) {
        e.preventDefault();
        $('#modalRestorePassword .js-btn-submit').attr('disabled', 'disabled');
        $.post(
            $(this).attr('action'),
            $(this).serialize(),
            function (res) {
                $('#modalRestorePassword .js-btn-submit').removeAttr('disabled');
		/*
                grecaptcha.execute('6Lc-1M4ZAAAAANX_l3qkr19UZgB6y6IsXd5lYn79', {action: 'form'})
                    .then(function(token) {
                        if (token && document.getElementById('fp_token')) {
                            document.getElementById('fp_token').value = token;
                            document.getElementById('fp_action').value = 'form';
                        }
                    });
		*/
                let errors = $(res).find('#modalRestorePassword .js-forgotpasswd-form-errors');
                if (errors.length) {
                    $('#modalRestorePassword .js-forgotpasswd-form-errors').replaceWith(errors);
                } else {
                    $('#modalRestorePassword .modal-content__block').replaceWith($(res).find('.modal-content__block'));
                }
            }
        );
    });
    $(document).on('submit', '.js-register-form', function (e) {
        e.preventDefault();

        let formData = new FormData(document.forms.b_register_form);
        let request = BX.ajax.runComponentAction('ustaz:ajax', 'registerByMail', {
            mode:'class',
            data: formData
        });

        var $form = $(this);

        $form.find('input,button,select,textarea').prop('disabled', true);

        request.then(function(successResult){
            $form.find('input,button,select,textarea').prop('disabled', false);
            if(successResult.data.status == 'ok'){
                $.fancybox.close();
                $.fancybox.open({
                    src: '#modalThankYou2',
                    type: 'inline'
                });
            } else {
                $('.js-register-form-errors').empty().html(successResult.data.message);
            }
        }, function (errorResult) {
            $form.find('input,button,select,textarea').prop('disabled', false);
        });
    })
});
