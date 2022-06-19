$('body').on('click', '.btn-laod-more', function (e){
    e.preventDefault();
    var $this = $(this);
    $.ajax({
        url: $this.data('url'),
        beforeSend: function (){
            $this.attr('disabled', true);
        },
        complete: function (){
            $this.attr('disabled', false);
        },
        success: function (response){
            var news = 'ul.main-news__list';
            $('ul.main-news__list').append($(response).find('.main-news__item'));

            var $btn = $(response).find('.btn-laod-more');
            if ($btn.length > 0){
                $this.data('url', $btn.data('url'));
            } else {
                $this.hide();
            }
        }
    });
    return false;
});