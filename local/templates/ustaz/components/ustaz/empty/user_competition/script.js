
function timer(number, elPlace) {
  var days        = Math.floor(seconds[number]/24/60/60);
  var hoursLeft   = Math.floor((seconds[number]) - (days*86400));
  var hours       = Math.floor(hoursLeft/3600);
  var minutesLeft = Math.floor((hoursLeft) - (hours*3600));
  var minutes     = Math.floor(minutesLeft/60);
  
  function pad(n) {
    return (n < 10 ? "0" + n : n);
  }
  
  function nounDeclension(number, one, two, five) {
    number = Math.abs(number);
    number %= 100;
    if (number >= 5 && number <= 20) {
        return five;
    }
    number %= 10;
    if (number == 1) {
        return one;
    }
    if (number >= 2 && number <= 4) {
        return two;
    }
    return five;
  } 

  $('#' + elPlace).html('<span class="days">' + pad(days) + '</span> ' + nounDeclension(days, 'день', 'дня', 'дней') + ': <span class="hours"> ' + pad(hours) + '</span> ' + nounDeclension(hours, 'час', 'часа', 'часов') + ': <span class="minutes">' + pad(minutes) + '</span> ' + nounDeclension(minutes, 'минута', 'минуты', 'минут'));
  if (seconds[number] == 0) {
    clearInterval(countdownTimer[number]);
    $('#' + elPlace).parent().remove();
  } else {
    seconds[number]--;
  }
}
var countdownTimer = [];
countdownTimer[0] = setInterval('timer(0, "countdown_1")', 1000);
countdownTimer[1] = setInterval('timer(1, "countdown_2")', 1000);
countdownTimer[1] = setInterval('timer(2, "countdown_3")', 1000);

    $(document).on('submit', '.formCompetition', function (e) {
        e.preventDefault();

        let formData = new FormData($(this)[0]);
        let request = BX.ajax.runComponentAction('ustaz:ajax', 'sendCompetition', {
            mode:'class',
            data: formData
        });
        
        var formEl = $(this);

        request.then(function(successResult){
        	if(successResult.data.status == 'ok'){
        		window.location.reload();
        	} else {
        		//$('.form-group__error-block').html(successResult.data.message).show();
        		//alert(successResult.data.message);
        		//подсветим поля с ошибками
        		if (successResult.data.fields.length > 0){
        			formEl.find('input').parent().removeClass('is-error');
        			formEl.find('textarea').parent().removeClass('is-error');
				successResult.data.fields.forEach(function(element){
					formEl.find('[name^="data\['+ element + '\]"]').parent().addClass('is-error');
					//console.log(element);
				});
				formEl.find('[name^="data\[' + successResult.data.fields[0] + '\]"]').get(0).scrollIntoView({block: "center", behavior: "smooth"});
        		}
        		
        	} 
		console.log(successResult);
        }, function (errorResult) {
		console.log(successResult);
        });
        
        //$('input[name="data\[name\]"').get(0).scrollIntoView({block: "center", behavior: "smooth"});
        
        return false;
    })
