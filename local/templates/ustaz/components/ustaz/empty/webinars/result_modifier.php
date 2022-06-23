<?php
/**
 * @var CMain $APPLICATION
 * @var array $arResult
 * @var array $arParams
 */
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(str_replace('result_modifier.php', 'template.php', __FILE__));
global $USER;

if (!$USER->IsAuthorized()){
    LocalRedirect('/#modalLogin');
}

$arFilter = [
    'IBLOCK_ID' => IBLOCK_ID_WEBINARS,
    'ACTIVE' => 'Y',
];
$arSelect = [
    '*',
    'PROPERTY_type',
    'PROPERTY_name_kz',
    'PROPERTY_name_ru',
    'speaker_name_',
    'speaker_title_',
    'speaker_town_',
];

$user = CUser::GetByID($USER->GetID())->Fetch();
if ($user['UF_SHOW_WEBINARS']){
    $arFilter['ID'] = $user['UF_SHOW_WEBINARS'];
}

$arResult['ITEMS'] = [];
$elementRes = CIBlockElement::GetList(["SORT"=>"ASC"], $arFilter);
while ($element = $elementRes->GetNext()){
    $resProp =  CIBlockElement::GetProperty(IBLOCK_ID_WEBINARS, $element['ID']);
    $element['PROPERTIES'] = [];
    while ($prop = $resProp->GetNext()) {
        $element['PROPERTIES'][$prop['CODE']] = $prop;
    }

    //Получаем информацию о спикере
    $res = CIBlockElement::GetProperty(IBLOCK_ID_MAIN_SPEAKERS, $element['PROPERTIES']['speaker']['VALUE']);

    $element['SPEAKER'] = [];
    while ($prop = $res->GetNext()) {

        if ($prop['PROPERTY_TYPE'] == 'F') {
            $element['SPEAKER'][$prop['CODE']] = CFile::ResizeImageGet($prop['VALUE'], ['width' => 275, 'height' => 275]);
        } else {
            $element['SPEAKER'][$prop['CODE']] = $prop['VALUE'];
        }
    }

    //Если вебинар еще не прошел, то выводим ссылку zoom, иначе ссылка на на видео
    if (MakeTimeStamp($element['PROPERTIES']['date']['VALUE']) >= MakeTimeStamp(date('d.m.Y 00:00:00'))) {
        $element['LINK'] = $element['PROPERTIES']['zoom']['VALUE'];;
        $element['BUTTON_TEXT'] = Loc::getMessage('BUTTON_CONNECT');
    } else {
        $element['VIDEO'] = $element['PROPERTIES'][strtolower('youtube_'.SITE_ID)]['~VALUE']['TEXT'];
        $element['BUTTON_TEXT'] = Loc::getMessage('BUTTON_VIEW');
    }

	//Получим св-во "Презентация от спикера"
	$element['PRESENTATION'] = CFile::GetPath($element['PROPERTIES'][strtoupper('PRESENTATION_'.SITE_ID)]['VALUE']);

    //Форматируем дату
    $element['FORMATED_DATE'] = FormatDate('d F Y', MakeTimeStamp($element['PROPERTIES']['date']['VALUE']));
    $arResult['ITEMS'][] = $element;
}