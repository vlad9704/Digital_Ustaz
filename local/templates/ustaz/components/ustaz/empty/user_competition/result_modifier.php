<?php
/**
 * @var array $arParams
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(str_replace('result_modifier.php', 'template.php', __FILE__));
$messages = Loc::loadLanguageFile(str_replace('result_modifier.php', 'template.php', __FILE__));

//Информация о пользователе
global $USER;
$userId = $GLOBALS["USER"]->GetId();
$arUser = CUser::GetByID($userId)->Fetch();

//IBLOCK_COMPETITION_WORKS -> $arParams['IBLOCK_ID']

//Пользовательские поля с типом Список
$listProreptys = ['UF_PROFILE_STATUS', 'UF_COMPETITION_STAGE'];

//Получим значения полей с типом список (не множественное поле)
foreach ($listProreptys as $prop) {
	if (isset($arUser[$prop]) && strlen($arUser[$prop]) > 0){
		$rsRes = CUserFieldEnum::GetList(array(), array(
		            "ID" => $arUser[$prop],
		));
		$arUser['properties'][$prop] = $rsRes->Fetch();
	}
}

//Определим до какого этапа допущен пользователь
$arResult['stage'] = -1;
if ($arUser['UF_COMPETITION_STAGE'] > 0 && isset($arUser['properties']['UF_COMPETITION_STAGE'])){
	$arResult['stage'] = str_replace('user_stage_', '', $arUser['properties']['UF_COMPETITION_STAGE']['XML_ID']);
}

//Получим работы пользователя по стадиям
$stageData = [];
$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM","PROPERTY_*");
$arFilter = Array("IBLOCK_ID" => $arParams['IBLOCK_ID'], 'PROPERTY_COMPETITION_USER_ID' => $userId, 'ACTIVE' => 'Y');
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
$loadCriteria = false;

while($ob = $res->GetNextElement()) {
    //$arFields = $ob->GetFields();
    //print_r($arFields);
    $arProps = $ob->GetProperties();
    //print_r($arProps);
    if (isset($arProps['stage']['VALUE_XML_ID'])) {
        $fields = $ob->GetFields();
        $arFilter = ["IBLOCK_ID" => IBLOCK_COMPETITION_WORKS_RATING, 'ACTIVE' => 'Y', 'PROPERTY_work' => $fields['ID']];
        $expertRatingCount = CIBlockElement::GetList([], $arFilter, ['PROPERTY_expert'])->SelectedRowsCount();
        $expertsCount = count($arProps['experts']['VALUE']);

        //Работа оценена всеми экспертами
        $isApproved = ($expertsCount >= 3 && $expertRatingCount >= $expertsCount);

        $ratings = [];
        $stage = str_replace('stage_', '', $arProps['stage']['VALUE_XML_ID']);
        $ratingSum = 0;

        if ($isApproved){
            $loadCriteria = true;
            $ratingRes = CIBlockElement::GetList([], ['IBLOCK_ID' => IBLOCK_COMPETITION_WORKS_RATING, 'PROPERTY_work' => $fields['ID']]);
            while ($rating = $ratingRes->GetNextElement()){
                $ratingProps = $rating->GetProperties();
                $ratings[$ratingProps['criteria']['VALUE']][] = $ratingProps['rating']['VALUE'];
            }

            foreach ($ratings as $key=>&$rating){
                $rating = round(array_sum($rating) / count($rating), 1);
                $ratingSum += $rating;
            }
            unset($rating);
        }

        $stageData[$stage] = [
            'lang' => $arProps['competiton_lang']['VALUE'],
            'url' => $arProps['competition_url']['VALUE'],
            'text' => $arProps['competition_text']['VALUE']['TEXT'],
            'approved' => $isApproved,
            'ratings' => $ratings,
            'ratingSum' => $ratingSum,
        ];
    }
}


//Критерии оценок
$criteria = [];
$criterionMaxRating = 0;
if ($loadCriteria) {
    $criteriaRes = CIBlockElement::GetList([], ['IBLOCK_ID' => IBLOCK_COMPETITION_RATING_CRITERIA]);
    while ($criterion = $criteriaRes->GetNextElement()) {
        $fields = $criterion->GetFields();
        $properties = $criterion->GetProperties();
        $stage = str_replace('stage_', '', $properties['stage']['VALUE_XML_ID']);
        $criteria[$stage][$fields['ID']] = array_merge($fields, $properties);
        if ($arResult['stage'] == $stage) {
            $criterionMaxRating += $properties['max_points']['VALUE'];
        }
    }
}

if ($arResult['stage'] == 3){
    $ratings3stage = CIBlockElement::GetList([], ['IBLOCK_ID' => 24, 'PROPERTY_USER_ID' => $userId])->GetNextElement();
    if ($ratings3stage) {
        $stageData[3] = $ratings3stage->GetProperties();
        $stageData[3]['approved'] = true;
    }
}

if ($arResult['stage'] == 3){
    $ratings3stage = CIBlockElement::GetList([], ['IBLOCK_ID' => 24, 'PROPERTY_USER_ID' => $userId])->GetNextElement();
    if ($ratings3stage) {
        $stageData[3] = $ratings3stage->GetProperties();
        $stageData[3]['approved'] = true;
    }
}

$arResult['stages'] = $stageData;
$arResult['user'] = $arUser;
$arResult['criteria'] = $criteria;
$arResult['criterionMaxRating'] = 15;//$criterionMaxRating;
$arResult['downloadCert'] = CIBlockElement::GetList([], ['IBLOCK_ID' => IBLOCK_COMPETITION_WORKS, 'PROPERTY_competition_user_id' => $userId])->SelectedRowsCount();

