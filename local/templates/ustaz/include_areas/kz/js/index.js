$(document).ready(function(){

	$(".labelSlider").slick({
		infinite: true,
		dots: false,
		slidesToShow: 1,
		slidesToScroll: 1,
		variableWidth: true,
		arrows: false,
		touchThreshold: 50,
		autoplay: true,
		autoplaySpeed: 3000,	
	});

	$(".adviceSlider").slick({
		infinite: true,
		dots: false,
		slidesToShow: 4,
		slidesToScroll: 1,
		arrows: true,
		touchThreshold: 50,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					variableWidth: true,
					centerMode: true,
				},
			},			
		]
	});

	// переключение слайдов по стрелкам Наблюдательный совет 
	$(".advicePrevJs").on("click", function (e) {
		e.preventDefault();
		sliderChangeSlide('adviceSlider', 'slick-prev')
	});			
	$(".adviceNextJs").on("click", function (e) {
		e.preventDefault();
		sliderChangeSlide('adviceSlider', 'slick-next ')
	});		

	// переключение спикеров
	$(".speakers-js").on("click", function (e) {
		e.preventDefault();
		if(!$(this).hasClass('disabled')) {
			let windowWidth = $(window).outerWidth(); 

			let cardPrev, imgPrev, titlePrev, positionPrev, cityPrev, themePrev,
							cardNext, imgNext, titleNext, positionNext, cityNext, themeNext;
			$('.speakers-link').addClass('disabled');
			cardPrev = $('.speakers-card');
			cardNext = $(this);
			$(cardPrev).addClass('is-loading');

			imgPrev = $(cardPrev).attr('data-img');
			titlePrev = $(cardPrev).attr('data-title');
			positionPrev = $(cardPrev).attr('data-position');
			cityPrev = $(cardPrev).attr('data-city');
			themePrev = $(cardPrev).attr('data-theme');

			imgNext = $(cardNext).attr('data-img');
			titleNext = $(cardNext).attr('data-title');
			positionNext = $(cardNext).attr('data-position');
			cityNext = $(cardNext).attr('data-city');
			themeNext = $(cardNext).attr('data-theme');

			$(cardPrev)
				.attr('data-img', imgNext)
				.attr('data-title', titleNext)
				.attr('data-position', positionNext)
				.attr('data-city', cityNext)
				.attr('data-theme', themeNext);

			$(cardNext)
				.attr('data-img', imgPrev)
				.attr('data-title', titlePrev)
				.attr('data-position', positionPrev)
				.attr('data-city', cityPrev)
				.attr('data-theme', themePrev);
				
			setTimeout(function() {
				$('.speakers-card__img--block').css({'backgroundImage':'url('+imgNext+')'});
				$('.speakers-card__info--title').text(titleNext);
				$('.speakers-card__info--position').text(positionNext);
				$('.speakers-card__info--city').text(cityNext);
				$('.speakers-card__info--theme').text(themeNext);				
				$(cardNext).css({'backgroundImage':'url('+imgPrev+')'});				
				$('.speakers-link').removeClass('disabled');
				$('.speakers-card').removeClass('is-loading');		
				
				if(windowWidth <= 1023) {
					$('html, body').animate({
						scrollTop: $('#speakers').offset().top - 80
					}, 800);					
				}
				
			}, 500);



		}
	});	
	

// var selector = '.slick-slide:not(.slick-cloned) a';

// $().fancybox({
//   selector : '.sliderSkolkovo .slick-slide:not(.slick-cloned) a',
//   backFocus : false
// });
// $().fancybox({
//   selector : '.sliderAlmaty .slick-slide:not(.slick-cloned) a',
//   backFocus : false
// });

$(document).on('click', '.slick-cloned a', function(e) {
	e.preventDefault();
  $(selector)
    .eq( ( $(e.currentTarget).attr("data-slick-index") || 0) % $(selector).length )
    .trigger("click.fb-start", {
      $trigger: $(this)
    });

  return false;
});	

}); //- end ready 22222222222

function sliderChangeSlide(slider, btn) {
	$('.' + slider).find('.'+btn).trigger('click');
}

function sliderInit(slider, params) {
 $('.' + slider).slick(params);  
}
function sliderDestroy(slider) {
 $('.' + slider).slick('unslick');
}




function loadPageIndex() {
	var windowWidth = $(window).outerWidth(); 




}//end loadPageIndex
window.addEventListener("load", loadPageIndex);


function resizePageIndex() {
	var windowWidth = $(window).outerWidth(); 


}//end resizePageIndex
window.addEventListener("resize", resizePageIndex);

// } catch (e) {}



