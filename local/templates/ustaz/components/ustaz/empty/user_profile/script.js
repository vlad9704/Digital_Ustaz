//Анкета в профиле пользователя
$(document).on('submit', '#formUserProfile', function (e) {
    e.preventDefault();

    $(this).find('.is-error').removeClass('is-error');

    var error = false;

    var fileExperienceValid = $("#file_experience").checkFile();
    if (!fileExperienceValid) {
        error = true;
    }

    var fileProfDocValid = $("#file_profdoc").checkFile();

    if (!fileProfDocValid) {
        error = true;
    }

    if (error) {
        return false;
    }

    let formData = new FormData(document.forms.formUserProfile);
    let request = BX.ajax.runComponentAction('ustaz:ajax', 'updateProfile', {
        mode: 'class',
        data: formData
    });

	$('.wrapper').addClass('custom_loader')
	
    request.then(function (successResult) {
		if (successResult.data.status === 'ok') {
            window.location.reload();
        } else {
            //$('.form-group__error-block').html(successResult.data.message).show();
            //alert(successResult.data.message);
            //подсветим поля с ошибками
            addFieldsError(successResult.data.fields);

        }
		$('.wrapper').removeClass('custom_loader')
		//console.log(successResult);
    }, function (errorResult) {
		$('.wrapper').removeClass('custom_loader')
		//console.log(successResult);
    });

    //$('input[name="data\[name\]"').get(0).scrollIntoView({block: "center", behavior: "smooth"});

    return false;
})

$('#formUserProfile input').on('input', function () {
    $(this).parent().removeClass('is-error');
})

$('#formUserProfile textarea').on('input', function () {
    $(this).parent().removeClass('is-error');
})

//Отобразить имя загруженного файла
$('input#file_experience, input#file_profdoc').on('change', function () {
    if ($(this).checkFile()) {
        let fileName = this.value.replace(/.*[\/\\]/, '');
        if (fileName.length > 0) {
            $(this).parent().find('.file-load__content').html(fileName).show();
        }
    }
});

//avatar upload
var input = document.getElementById('file_avatar');
$('input#file_avatar').on('change', function () {
    var curFiles = input.files;
    if (curFiles.length > 0) {
        if ($(this).validFileType()) {
            var image = document.createElement('img');
            image.src = window.URL.createObjectURL(curFiles[0]);
            image.classList.add("img-responsive");
            $(".profile-photo__block--img").empty().append(image);
            $("input#delete_avatar_input").attr('value', '0');
        } else {
            $('a#delete_avatar').click();
            $("input#delete_avatar_input").attr('value', '0');
            addFieldsError([$(this).attr('id')]);
        }
    }
});

$('a#delete_avatar').on('click', function () {
    var image = document.createElement('img');
    image.src = 'https://static.digitalustazalmaty.kz/images/sprites/svg/icon-user-default2.svg';
    image.classList.add("img-responsive");
    $(".profile-photo__block--img").empty().append(image);
    $("#file_avatar").val("");
    $("input#delete_avatar_input").attr('value', '1');
    return false;
});

$.fn.validFileType = function (extensions) {
    return true;
    if ($(this).attr('type') === 'file' && $(this).get(0).files.length > 0) {
        var file = $(this).get(0).files[0];
        extensions = extensions || [
            'jpg',
            'jpeg',
            'png',
        ];

        var fileExt = file.name.toLowerCase().split('.').pop();
        return extensions.indexOf(fileExt) > -1;
    }

    return false;
}

$.fn.validFileSize = function (maxFileSize) {
    if ($(this).attr('type') === 'file' && $(this).get(0).files.length > 0) {
        var file = $(this).get(0).files[0];
        maxFileSize = maxFileSize || 10;
        maxFileSize *= 1024 * 1024;

        return file.size <= maxFileSize;
    }

    return false;
}

//подсветим поля с ошибками
function addFieldsError(fields, dontScroll) {
    if (fields.length > 0) {
        $('#formUserProfile input').parent().removeClass('is-error');
        $('#formUserProfile textarea').parent().removeClass('is-error');
        $('#formUserProfile select').parent().removeClass('is-error');
        fields.forEach(function (element) {
            $('[name^="data\[' + element + '\]"],#' + element + '[type="file"]').parent().addClass('is-error');
            $('#' + element + '[type="file"]').parent().addClass('is-error');
            //console.log(element);
        });

        if (!dontScroll) {
            $('[name^="data\[' + fields[0] + '\]"],#' + fields[0] + '[type="file"]').get(0).scrollIntoView({
                block: "center",
                behavior: "smooth"
            });
        }
    }
}

//Вывод ошибок для файла
$.fn.addFileErrorMessage = function (message) {
    if ($(this).attr('type') === 'file' && $(this).get(0).files.length > 0) {
        var fileName = $(this).get(0).files[0].name;
        $(this).parent().find('.file-load__content').html('[' + fileName + '] ' + message).show();
    }
}

$.fn.checkFile = function (params, dontScroll) {
    params = params || {};

    if ($.isEmptyObject(params)) {
        var fileParams = {
            'file_profdoc': {
                'maxFileSize': 10,
                'fileTypes': ['doc', 'docx', 'txt'],
            },
            'file_experience': {
                'maxFileSize': 50,
                'fileTypes': ['pdf', 'jpeg', 'jpg', 'png'],
            }
        }

        var id = $(this).attr('id');
        if (fileParams[id]) {
            params = fileParams[id];
        }
    }

    params = Object.assign({
        'maxFileSize': 10,
        'fileTypes': [
            'jpg',
            'jpeg',
            'png',
        ]
    }, params);

    //Проверка типа файлв
    if (!$(this).validFileType(params.fileTypes)) {
        addFieldsError([$(this).attr('id')], dontScroll);
        messId = "ERROR_FILE_TYPE";
        $(this).addFileErrorMessage(BX.message(messId).replace('#TYPES#', params.fileTypes.join(', ')))
        return false;
    }
    //Проверка размера
    else if (!$(this).validFileSize(params.maxFileSize)) {
        addFieldsError([$(this).attr('id')], dontScroll);
        messId = "ERROR_FILE_SIZE";
        $(this).addFileErrorMessage(BX.message(messId).replace('#SIZE#', params.maxFileSize))
        return false;
    }

    return true;
}

$(document).ready(function ()
{
	if( $('.j_profile-tab__item_precent').length && $('#memberType2').is(':checked') )
		$('.j_profile-tab__item_precent').addClass('no_active')

	$('body').on('change', '.j_change_member_type', function ()
	{
		// меняем тип участника (слушатель / участник)
		BX.ajax.runComponentAction('ustaz:ajax', 'updateMembertype', {
			mode: 'class',
			data: {
				uf_member_type: $(this).val()
			}
		})

		// Активируем / деактивируем вкладку "Конкурс" в зависимости от типа участника
		if( $(this).val() == 'USER_PROFILE_OPTION_PERSON_TYPE_LISTENER' && $(this).prop('checked') )
			$('.j_profile-tab__item_precent').addClass('no_active')
		else
			$('.j_profile-tab__item_precent').removeClass('no_active')
	})
})











