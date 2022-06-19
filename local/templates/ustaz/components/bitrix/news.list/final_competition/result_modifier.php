<?php
/**
 * @var CMain $APPLICATION
 * @var array $arResult
 * @var array $arParams
 */
use Bitrix\Main\Localization\Loc;
Loc::loadLanguageFile(str_replace('result_modifier.php', 'template.php', __FILE__));

foreach ($arResult['ITEMS'] as &$item) {
    $propRes = CIBlockElement::GetProperty($item['IBLOCK_ID'], $item['ID'], []);
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
            if (strpos($value, '_KZ') === false) {
                $item[str_replace('_RU', '', $key)] = $value;
            }
        }
    } else {
        foreach ($properties as $key => $value) {
            if (strpos($value, '_RU') === false) {
                $item[str_replace('_KZ', '', $key)] = $value;
            }
        }
    }

    $item['PREVIEW_PICTURE'] = CFile::ResizeImageGet($item['PREVIEW_PICTURE'], ['width' => 275, 'height' => 275]);;
}