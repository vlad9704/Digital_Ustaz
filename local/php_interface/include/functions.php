<?php

/**
 * Получить идентификатор инфоблока по символьному коду
 * 
 * @param string $code
 * @return integer
 * @throws Exception
 */
function getIblockIdByCode(string $code) : int {
    if (CModule::IncludeModule('iblock')){ 
        $res = CIBlock::GetList(
            Array(), 
            Array(
                'ACTIVE'=>'Y', 
                'CHECK_PERMISSIONS' => 'N',
                "=CODE"=> $code
            ), false
        );
        
        $tmpData = $res->Fetch();
        
        //print_r($tmpData);
        
        if (isset($tmpData['ID'])){
            return (int) $tmpData['ID'];
        } else {
            throw new Exception("Инфоблок не найден {$code}.");
        }
        
    } else {
        throw new Exception('Модуль для работы с инфоблоками не подключен.');
    }    
}

/**
 * Склонение существительных после числительных
 * 
 * @param $value - значение
 * @param $words - Массив вариантов. Например ['комментарий', 'комментария', 'комментариев']
 */
function nounDeclension(int $value, array $words) : string{
    $num = $value % 100;
    if ($num > 19) {
        $num = $num % 10;
    }

    switch ($num) {
        case 1:
            $out .= $words[0];
            break;
        case 2:
        case 3:
        case 4:
            $out .= $words[1];
            break;
        default:
            $out .= $words[2];
            break;
    }

    return $out;
}

/**
 * Получить число дней до даты мероприятия
 * 
 * @param Datetime $date дата события
 * @param string $lang язык
 * @return string
 */
function timerCountdown(DateTime $date, string $lang) : string {
    //Шаблон выдачи
    $template = '<span>{DAYS}</span> {TEXT}';
    
    $currentTime = new DateTime("now", new \DateTimeZone('UTC'));
    $currentTime->setTimezone(new \DateTimeZone('Asia/Almaty'));
    
    $date->setTime(0, 0, 0);
    //$currentTime->setTime(0, 0, 0);
    
    $days = (int) (($date->getTimestamp() - $currentTime->getTimestamp()) / 86400);
    
    if ($days <= 0){
	    //Походу это Сегодня
	    return false;
    } else {
	    $dateText = '';
	    switch ($lang){
		case 'ru':
		    $dateText = nounDeclension((int) $days, ['день', 'дня', 'дней']);
		    break;
		case 'kz':
		    $dateText = nounDeclension((int) $days, ['күн', 'күн', 'күн']);
		    break;
		default:
		    /**
		     * Неизвестный язык
		     */
		    throw new Exception('Неизвестный язык в таймере ' . $lang);
		    break;
	    }

	return str_replace([
            '{DAYS}',
            '{TEXT}'
        ],[
            $days,
            $dateText
        ], $template);
    }
}

/**
 * Получить число секунд до определеной даты
 * 
 * @param Datetime $date дата события
 */
function timerCountdownInSeconds(DateTime $date) : int {
    $currentTime = new DateTime("now", new \DateTimeZone('UTC'));
    $currentTime->setTimezone(new \DateTimeZone('Asia/Almaty'));
    
    $date->setTime(0, 0, 0);
    //$currentTime->setTime(0, 0, 0);
    
    return (int) ($date->getTimestamp() - $currentTime->getTimestamp());
}

/**
 * Решает какие вкладки надо отобразить в профиле пользователя, а какие нет
 * 
 * @param array $user информация о пользователей
 * @return string
 */
function getUserProfileTabsStatus(array $user) : array {
	//Возвращаемые значения
	$returnData = [
		'profile' => true, // Вкладка "Анкета"
		'competition' => false,// Вкладка "Конкурс"
		'learning' => false,// Вкладка "Вебинары"
		'tabs' => 0, //Колличество активных вкладок
		'activity' => [ //Активная вкладка
			'profile' => false, // Вкладка "Анкета"
			'competition' => false,// Вкладка "Конкурс"
			'learning' => false,// Вкладка "Вебинары"
		]
	];

	//Пользовательские поля с типом Список
	$listProreptys = ['UF_PROFILE_STATUS', 'UF_COMPETITION_STAGE'];

	//Получим значения полей с типом список (не множественное поле)
	foreach ($listProreptys as $prop) {
		if (isset($user[$prop]) && strlen($user[$prop]) > 0){
			$rsRes = CUserFieldEnum::GetList(array(), array(
				    "ID" => $user[$prop],
			));
			$user['properties'][$prop] = $rsRes->Fetch();
		}
	}

	//До вкладки Конкурс допущены только пользователи с выбранным этапом конкурса
	if ($user['UF_COMPETITION_STAGE'] > 0){
		$returnData['competition'] = true;
	}

	//Вкладка вебинары доступна если статус анкеты = одобрена
	if ($user['UF_PROFILE_STATUS']['VALUE'] == 3){
		$returnData['learning'] = true;
	}
	
	//Определим активность вкладки
	//$application = Application::getInstance();
	$tmpPage = preg_replace("|\?.*$|", "", explode('/', $_SERVER['REQUEST_URI']));
	$tmpLast = array_pop($tmpPage);
	if (strlen($tmpLast) == 0 ){
		$tmpLast = array_pop($tmpPage);//Последний элемент может быть пустым, тк у урла моет быть слеш в конце
	}
	switch($tmpLast){
		case 'profile':
			$returnData['activity']['profile'] = true;
			break;
		case 'competition':
			$returnData['activity']['competition'] = true;
			break;
		case 'intensive':
			$returnData['activity']['learning'] = true;
			break;
		default:
			//throw new Exception('Неизвестный урл: ' . $tmpLast . print_r($tmpPage , 1));
			break;
	}
	
	//Посчитаем число активных вкладок
	$returnData['tabs'] = array_reduce($returnData, function($sum, $item){
		if (is_array($item) == false) {
			return $sum + (int) $item;
		} else {
			return $sum;
		}
	});


	return $returnData;
}
