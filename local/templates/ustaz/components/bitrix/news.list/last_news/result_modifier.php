<?php
/**
 * @var CMain $APPLICATION
 * @var array $arResult
 * @var array $arParams
 */
use Bitrix\Main\Localization\Loc;
Loc::loadLanguageFile(str_replace('result_modifier.php', 'template.php', __FILE__));

foreach ($arResult['ITEMS'] as &$item) {
    if (SITE_ID == 'ru') {
        $propRes = CIBlockElement::GetProperty($item['IBLOCK_ID'], $item['ID'], []);
        $properties = [];
        while ($property = $propRes->GetNext()) {
            if (is_array($property['~VALUE']) && isset($property['~VALUE']['TEXT'])) {
                $properties[$property['CODE']] = $property['~VALUE']['TEXT'];
            } else {
                $properties[$property['CODE']] = $property['VALUE_XML_ID'] ?: $property['VALUE'];
            }
        }

        foreach ($properties as $key => $value) {
            $item[str_replace('_RU', '', $key)] = $value;
        }
    }

    $timestamp = MakeTimeStamp(($item['ACTIVE_FROM'] ?: $item['TIMESTAMP_X']));
    $item['DATE'] = FormatDate('d F Y', $timestamp);
}