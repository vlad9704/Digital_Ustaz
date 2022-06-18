<?php
/**
 * @var CMain $APPLICATION
 * @var array $arResult
 * @var array $arParams
 */

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(str_replace('result_modifier.php', 'template.php', __FILE__));

$speakers = [];
$speakerRes = \Bitrix\Iblock\ElementTable::getList(['select' => ['ID'], 'order' => "SORT", 'filter' => ['IBLOCK_ID' => IBLOCK_ID_MAIN_SPEAKERS, 'ACTIVE' => 'Y',]]);
while ($speaker = $speakerRes->fetch()) {
    $speakers[$speaker['ID']] = [];

    $res = CIBlockElement::GetProperty(IBLOCK_ID_MAIN_SPEAKERS, $speaker['ID']);

    while ($prop = $res->GetNext()) {
        if ($prop['PROPERTY_TYPE'] == 'F') {
            $speakers[$speaker['ID']][$prop['CODE']] = CFile::ResizeImageGet($prop['VALUE'], ['width' => 275, 'height' => 275]);
        } else {
            $speakers[$speaker['ID']][$prop['CODE']] = $prop['VALUE'];
        }
    }
}


$arFilter = [
    'IBLOCK_ID' => IBLOCK_ID_BOOKS,
    'ACTIVE' => 'Y',
];
$arSelect = [
    '*',
];

$elementRes = CIBlockElement::GetList(["SORT" => "ASC"], $arFilter);
while ($element = $elementRes->GetNext()) {
    $resProp = CIBlockElement::GetProperty(IBLOCK_ID_BOOKS, $element['ID']);
    $element['PROPERTIES'] = [];
    while ($prop = $resProp->GetNext()) {
        if ($prop['PROPERTY_TYPE'] == 'F') {
            $element['PROPERTIES'][$prop['CODE']] = CFile::GetFileArray($prop['VALUE']);
        } else {
            $element['PROPERTIES'][$prop['CODE']] = $prop['VALUE'];
        }
        if (SITE_ID == 'ru') {
            if ($prop['CODE'] == 'NAME_RU') {
                $element['NAME'] = $prop['VALUE'];
            }
        }
    }

    $element['PREVIEW_PICTURE'] = CFile::ResizeImageGet($element['PREVIEW_PICTURE'], ['width' => 170, 'height' => 220]);

    //Получаем информацию об авторе
    $res = CIBlockElement::GetProperty(IBLOCK_ID_BOOK_AUTHOR, $element['PROPERTIES']['AUTHOR']);

    $element['AUTHOR'] = [];
    while ($prop = $res->GetNext()) {
        $element['AUTHOR'][$prop['CODE']] = $prop['VALUE'];
    }

    $speakers[$element['PROPERTIES']['SPEAKER']]['BOOKS'][] = $element;
}

$arResult['SPEAKERS'] = $speakers;
