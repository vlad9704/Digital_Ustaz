<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CMain $APPLICATION
 * @var array $arResult
 * @var array $arParams
 */

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(str_replace('result_modifier.php', 'template.php', __FILE__));
$messages = Loc::loadLanguageFile(str_replace('result_modifier.php', 'template.php', __FILE__));


//Информация о пользователе
$userId = $GLOBALS["USER"]->GetId();
$arUser = CUser::GetByID($userId)->Fetch();
$expertsPropId = 69;
$criteriaPropId = 80;
$ratingPropId = 79;

//Если пользователь не соотоит в группе эксперты, редиректим на главную
if (!CSite::InGroup([5])) {
    LocalRedirect('/');
}

$workId = (int)($_GET['id'] ?? 0);

if (!$workId) {
    LocalRedirect('/personal/expert/');
}

$arSelect = ['*', 'IBLOCK_ID', 'PROPERTY_competition_user_id', 'PROPERTY_stage', 'PROPERTY_competition_url', 'PROPERTY_competition_text'];
$arFilter = ["IBLOCK_ID" => IBLOCK_COMPETITION_WORKS, 'ACTIVE' => 'Y', 'PROPERTY_experts' => $userId, 'ID' => $workId];
$work = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect)->Fetch();

if (!$work) {
    LocalRedirect('/personal/expert/');
}

//Критерии оценок
$criteriaRatings = [];

$arSelect = ['ID', 'IBLOCK_ID', 'PROPERTY_stage'];
$arFilter = ["IBLOCK_ID" => IBLOCK_COMPETITION_RATING_CRITERIA, 'ACTIVE' => 'Y'];
$criteriaRatingRes = CIBlockElement::GetList(['SORT' => 'ASC'], $arFilter, false, false, $arSelect);
$criteriaIds = [];
while ($ob = $criteriaRatingRes->GetNext()) {
    $properties = [];

    $propertiesRes = CIBlockElement::GetProperty(IBLOCK_COMPETITION_RATING_CRITERIA, []);
    $propertyValues = CIBlockElement::GetPropertyValues(IBLOCK_COMPETITION_RATING_CRITERIA, ['ID' => $ob['ID']])->Fetch();
    while ($prop = $propertiesRes->GetNext()) {
        $value = $propertyValues[$prop['ID']] ?? '';
        if (is_array($value)) {
            foreach ($value as &$item) {
                if (@unserialize($item) !== false) {
                    $item = unserialize($item);
                    $item = $item['TEXT'] ?? $item;
                }
            }
        } else if (@unserialize($value) !== false) {
            $value = unserialize($value);
            $value = $value['TEXT'] ?? $value;
        }
        $properties[$prop['CODE']] = $value;
    }

    if ($ob['PROPERTY_STAGE_VALUE'] != $work['PROPERTY_STAGE_VALUE']) {
        continue;
    }
    $lang = strtolower(SITE_ID);
    $ob['NAME'] = $properties['name_' . $lang];
    $ob['DESCRIPTION'] = $properties['description_' . $lang];
    $ob['TOOLTIP'] = $properties['tooltip_' . $lang];
    $ob['TOOLTIPS'] = $properties['tooltips_' . $lang];
    $ob['MAX_POINTS'] = $properties['max_points'];

    $criteriaRatings[] = $ob;
    $criteriaIds[] = $ob['ID'];
}


$arSelect = ['ID', 'IBLOCK_ID', 'PROPERTY_criteria', 'PROPERTY_rating'];
$arFilter = ["IBLOCK_ID" => IBLOCK_COMPETITION_WORKS_RATING, 'ACTIVE' => 'Y', 'PROPERTY_criteria' => $criteriaIds, 'PROPERTY_work' => $work['ID'], 'PROPERTY_expert' => $USER->GetID()];
$workRatingsRes = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
$workRatings = [];
while ($ob = $workRatingsRes->GetNext()) {
    $workRatings[$ob['PROPERTY_CRITERIA_VALUE']] = $ob['PROPERTY_RATING_VALUE'];
}

foreach ($criteriaRatings as &$criteriaRating) {
    $criteriaRating['RATING'] = $workRatings[$criteriaRating['ID']] ?? 0;
}

$stage = [
    'I' => 1,
    'II' => 2,
    'III' => 3,
];


$arResult['work'] = $work;
$arResult['criteriaRatings'] = $criteriaRatings;
$arResult['user'] = CUser::GetById($work['PROPERTY_COMPETITION_USER_ID_VALUE'])->Fetch();
$arResult['cur_stage'] = $stage[$work['PROPERTY_STAGE_VALUE']];

$userFieldEnum = new CUserFieldEnum();
$userStage = $userFieldEnum->GetList([], [
    'ID' => $arResult['user']['UF_COMPETITION_STAGE'],
])->Fetch();

$arResult['user_stage'] = @$userStage['VALUE'];
















