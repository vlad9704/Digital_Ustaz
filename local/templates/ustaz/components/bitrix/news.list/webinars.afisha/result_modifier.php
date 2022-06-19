<?php
/**
 * @var CMain $APPLICATION
 * @var array $arResult
 * @var array $arParams
 */
use Bitrix\Main\Localization\Loc;
Loc::loadLanguageFile(str_replace('result_modifier.php', 'template.php', __FILE__));
foreach ($arResult['ITEMS'] as &$item) {
    //Получаем информацию о спикере
    $res = CIBlockElement::GetProperty(IBLOCK_ID_MAIN_SPEAKERS, $item['PROPERTIES']['speaker']['VALUE']);

    $item['SPEAKER'] = [];
    while ($prop = $res->GetNext()) {

        if ($prop['PROPERTY_TYPE'] == 'F') {
            $item['SPEAKER'][$prop['CODE']] = CFile::ResizeImageGet($prop['VALUE'], ['width' => 275, 'height' => 275]);
        } else {
            $item['SPEAKER'][$prop['CODE']] = $prop['VALUE'];
        }
    }

    //Если вебинар еще не прошел, то выводим ссылку zoom, иначе ссылка на на видео
    if (MakeTimeStamp($item['PROPERTIES']['date']['VALUE']) >= MakeTimeStamp(date('d.m.Y 00:00:00'))) {
        $item['LINK'] = $item['PROPERTIES']['zoom']['VALUE'];;
        $item['BUTTON_TEXT'] = Loc::getMessage('BUTTON_CONNECT');
    } else {
        $item['LINK'] = $item['PROPERTIES'][strtolower('youtube_'.SITE_ID)]['VALUE'];
        $item['BUTTON_TEXT'] = Loc::getMessage('BUTTON_VIEW');
    }

    //Форматируем дату
    $item['FORMATED_DATE'] = FormatDate('d F Y', MakeTimeStamp($item['PROPERTIES']['date']['VALUE']));
}

