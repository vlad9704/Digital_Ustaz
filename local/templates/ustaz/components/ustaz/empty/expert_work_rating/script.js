$('body').on('submit', '#work-rating-form', function (e) {
    e.preventDefault();
    $(this).submitRating('workRate');
}).on('click', '.btn-reset-rating', function (){
    $("#work-rating-form").find('input.rang-slider').each(function (){
        $(this).data("ionRangeSlider").update({
            from: 0,
        });
    }).closest('form').submitRating('clearWorkRate');
});


$.fn.submitRating = function (action){
    var $this = $(this);

    var query = {
        c: 'ustaz:ajax',
        action: action,
        mode: 'class',
    };

    $.ajax({
        url: '/bitrix/services/main/ajax.php?' + $.param(query, true),
        data: $this.serialize(),
        type: 'post',
        beforeSend: function () {
            $('.response-message').empty();
            $this.find('input, select, textarea, button').prop('disabled', true);
        },
        complete: function () {
            $this.find('textarea, input, button, select').prop('disabled', false);
        },
        success: function (response) {
            if(response.data && response.data.redirect){
                location.href = 'index.php'
            } else if (response.data && response.data.message) {
                $('.response-message').html(response.data.message);
            }
        }
    });
}