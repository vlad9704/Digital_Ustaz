$(document).ready(function () {
    $(document).on('submit', '.js-auth-form', function (e) {
        e.preventDefault();
        $('#modalLogin .js-btn-submit').attr('disabled', 'disabled');
        $.post(
            '/auth/',
            $(this).serialize(),
            function (res) {
                /*grecaptcha.execute('6Lc-1M4ZAAAAANX_l3qkr19UZgB6y6IsXd5lYn79', {action: 'form'})
                    .then(function(token) {
                        if (token && document.getElementById('auth_token')) {
                            document.getElementById('auth_token').value = token;
                            document.getElementById('auth_action').value = 'form';
                        }
                    });*/
                if ($(res).find('#modalLogin').length) {
                    $('#modalLogin .js-btn-submit').removeAttr('disabled');
                    $('#modalLogin .js-auth-form-errors').replaceWith($(res).find('#modalLogin .js-auth-form-errors'));
                } else {
                    setTimeout(function () {
                        if (BX.message('SITE_ID') == 'ru') {
                            location.href = '/ru/';
                        } else {
			     location.href = '/';
                        }
                    }, 1000);
                }
            }
        )
    })
});
