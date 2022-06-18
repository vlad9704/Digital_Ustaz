$(document).ready(function () {
    //Первый шаг регистрации (первая форма на главной) 
    $(document).on('submit', '.main_form_1', function (e) {
        e.preventDefault();

        let formData = new FormData(document.forms.main_form_1);
        let request = BX.ajax.runComponentAction('ustaz:ajax', 'registerByMail', {
            mode:'class',
            data: formData
        });

        request.then(function(successResult){
        	if(successResult.data.status == 'ok'){
        		$.fancybox.open({
				src: '#modalThankYou2', 
				type: 'inline'
			});
        	} else {
        		$('.js-reg-form-errors_1').empty().html(successResult.data.message);
        	} 
		console.log(successResult);
        }, function (errorResult) {
		console.log(successResult);
        });
    })
    
   //Первый шаг регистрации (вторая форма на главной) 
   $(document).on('submit', '.main_form_2', function (e) {
        e.preventDefault();

        let formData = new FormData(document.forms.main_form_2);
        let request = BX.ajax.runComponentAction('ustaz:ajax', 'registerByMail', {
            mode:'class',
            data: formData
        });

        request.then(function(successResult){
        	if(successResult.data.status == 'ok'){
        		$.fancybox.open({
				src: '#modalThankYou2', 
				type: 'inline'
			});
        	} else {
        		$('.js-reg-form-errors_2').empty().html(successResult.data.message);
        	} 
		console.log(successResult);
        }, function (errorResult) {
		console.log(successResult);
        });
    })
   
   //Второй шаг регистрации
   $(document).on('submit', '#modalConfirmRegistration', function (e) {
        e.preventDefault();

        let formData = new FormData(document.forms.modalConfirmRegistration);
        let request = BX.ajax.runComponentAction('ustaz:ajax', 'confirmRegister', {
            mode:'class',
            data: formData
        });

        request.then(function(successResult){
        	if(successResult.data.status == 'ok'){
        		$.fancybox.close();//В идеале надо подождать пока закроется предыдущее окно
        		$.fancybox.open({
                    src: '#modalConfirmThankYou',
                    type: 'inline',
                    afterClose: function() {
                        location.href = (BX.message('SITE_ID') === 'ru' ? '/ru' : '') + '/personal/profile/';
                    }
                });
        	} else {
        		$('.js-confirm-form-errors').empty().html(successResult.data.message);
        		//alert(successResult.data.message);
        	} 
		console.log(successResult);
        }, function (errorResult) {
		console.log(successResult);
        });
        
        return false;
    })
    
    //Модалка Задать вопрос
    $(document).on('submit', '#formModalAskQuestion', function (e) {
        e.preventDefault();

        let formData = new FormData(document.forms.formModalAskQuestion);
        let request = BX.ajax.runComponentAction('ustaz:ajax', 'askQuestion', {
            mode:'class',
            data: formData
        });

        request.then(function(successResult){
        	if(successResult.data.status == 'ok'){
        		$.fancybox.close();//В идеале надо подождать пока закроется предыдущее окно
        		$.fancybox.open({
				src: '#modalThankYouAskQuestion', 
				type: 'inline'
			});
        	} else {
        		$('.js-confirm-form-errors').empty().html(successResult.data.message).show();
        		//alert(successResult.data.message);
        	} 
		console.log(successResult);
        }, function (errorResult) {
		console.log(successResult);
        });
        
        return false;
    })
    
    //Модалка Задать вопрос
});
