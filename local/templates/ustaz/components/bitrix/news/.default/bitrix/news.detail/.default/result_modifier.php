<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */

Loc::loadLanguageFile(dirname(dirname(dirname(dirname(__FILE__)))) . '/news.php');


$propRes = CIBlockElement::GetProperty($arResult['IBLOCK_ID'], $arResult['ID'], []);
$properties = [];
while ($property = $propRes->GetNext()) {
    if (is_array($property['~VALUE']) && isset($property['~VALUE']['TEXT'])) {
        $properties[$property['CODE']] = $property['~VALUE']['TEXT'];
    } else {
        $properties[$property['CODE']] = $property['VALUE_XML_ID'] ?: $property['VALUE'];
    }
}

if (SITE_ID == 'ru') {
    foreach ($properties as $key => $value) {
        $arResult[str_replace('_RU', '', $key)] = $value;
    }
}

$timestamp = MakeTimeStamp(($arResult['ACTIVE_FROM'] ?: $arResult['TIMESTAMP_X']));
$arResult['DATE'] = FormatDate('d F Y', $timestamp);
