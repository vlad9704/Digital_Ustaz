<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;

Loader::includeModule('iblock');

Loc::loadMessages(str_replace('result_modifier.php', 'template.php', __FILE__));
$messages = Loc::loadLanguageFile(str_replace('result_modifier.php', 'template.php', __FILE__));

//Если админ, то он может просматривать анкеты других пользователей, но кнопка с отправкой данных будет скрыта
global $USER;
$arResult['show_confirm_button'] = true;
$request = \Bitrix\Main\Context::getCurrent()->getRequest();
if ($USER->IsAdmin() && (int) $request->get("uid") > 0) {
	$userId = (int) $request->get("uid");
	$arResult['show_confirm_button'] = false;
} else {
	$userId = $GLOBALS["USER"]->GetId();
}

$arUser = CUser::GetByID($userId)->Fetch();

//Если статус На модерации или Принята, то скрываем кнопку отправки
if (in_array($arUser['UF_PROFILE_STATUS'], [2, 3])){
	$arResult['show_confirm_button'] = false;
}

//Пользовательские поля с типом Список
$listProreptys = ['UF_PROFILE_STATUS'];

//Получим значения полей с типом список (не множественное поле)
foreach ($listProreptys as $prop) {
	if (isset($arUser[$prop]) && strlen($arUser[$prop]) > 0){
		$rsRes = CUserFieldEnum::GetList(array(), array(
		            "ID" => $arUser[$prop],
		));
		$arUser['properties'][$prop] = $rsRes->Fetch();
	}
}

//Дата рождения хранится через опу, надо конвертнуть
if (isset($arUser['PERSONAL_BIRTHDAY']) && strlen($arUser['PERSONAL_BIRTHDAY']) > 8){
        //Дата рождения 2010-12-30 10.08.2021
        $tmpDate = new DateTime($arUser['PERSONAL_BIRTHDAY']);
        $arUser['PERSONAL_BIRTHDAY_TRUE_WAY'] = $tmpDate;
}

$arResult['user'] = $arUser;

//Соответствие статуса анкеты - стилю
$arResult['status_css'] = [
	'new' => 'edit',
	'moderation' => 'moderation',
	'approved' => 'success',
	'reject' => 'error',
];

//Содержимое селектов
$selectContent = [];
//print_r($messages);
$selectList = ['USER_PROFILE_SELECT_IM_TYPE', 'USER_PROFILE_SELECT_LANG'];
foreach ($selectList as $selectItem) {
	//Заголовок
	echo $selectItem . '_TITLE';
	if(isset($messages[$selectItem . '_TITLE'])){
		$selectContent[$selectItem][$selectItem . '_TITLE'] = $messages[$selectItem . '_TITLE'];
	}
	
	//Элементы
	foreach ($messages as $msgName => $msgValue) {
		if (strstr($msgName, $selectItem . '_OPT_') !== false){
			$selectContent[$selectItem][$msgName] = $msgValue;
		}
	}
}

$arResult['selects'] = $selectContent;

//Аватарка пользователя
if (isset($arResult['user']['PERSONAL_PHOTO']) && $arResult['user']['PERSONAL_PHOTO'] > 0){
	$file = CFile::ResizeImageGet($arResult['user']['PERSONAL_PHOTO'], ['width' =>148, 'height'=>148], BX_RESIZE_IMAGE_PROPORTIONAL, true); 
	$arResult['user']['avatar'] = $file['src'];
} else {
	$arResult['user']['avatar'] = '/img_almaty_ustaz/profile_img.svg';
}

$arResult['user']['UF_FILE_PROFDOC_ARRAY'] = CFile::GetFileArray($arResult['user']['UF_FILE_PROFDOC']);
$arResult['user']['UF_EXPERIENCE_ARRAY'] = CFile::GetFileArray($arResult['user']['UF_EXPERIENCE']);

// Достанем список школ
$res = CIBlockElement::GetList(['SORT' => 'ASC'], ['IBLOCK_ID' => 28, 'ACTIVE' => 'Y'], false, false, ['ID', 'NAME']);
while ($ob = $res->fetch())
	$arResult['SCHOOL'][] = $ob;
unset($res, $ob);

// Достанем предметы по ГОСО
$res = CIBlockElement::GetList(['SORT' => 'ASC'], ['IBLOCK_ID' => 29, 'ACTIVE' => 'Y'], false, false, ['ID', 'NAME']);
while ($ob = $res->fetch())
	$arResult['SUBJECTS'][] = $ob;
unset($res, $ob);