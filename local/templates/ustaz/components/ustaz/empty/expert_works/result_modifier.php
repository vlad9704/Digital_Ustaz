<?php

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(str_replace('result_modifier.php', 'template.php', __FILE__));
$messages = Loc::loadLanguageFile(str_replace('result_modifier.php', 'template.php', __FILE__));

//Информация о пользователе
$userId = $GLOBALS["USER"]->GetId();
$arUser = CUser::GetByID($userId)->Fetch();

//Если пользователь не соотоит в группе эксперты, редиректим на главную
if (!CSite::InGroup([5])) {
    LocalRedirect('/');
}

/** Распределение работ по экспертам */
global $DB;
$expertsPropId = 69;
$langPropId = 44;

$expertIds = [];
$expertsRes = \Bitrix\Main\UserTable::getList(['filter' => ['GROUPS.GROUP_ID' => 5], 'select' => ['ID']]);
while ($expert = $expertsRes->fetch()){
    $expertIds[] = $expert['ID'];
}

if ($expertIds) {
    //Удаление записей с несуществующими экспертами
    $DB->Query("DELETE FROM b_iblock_element_property WHERE IBLOCK_PROPERTY_ID = $expertsPropId AND VALUE NOT IN (".implode(',', $expertIds).")");
}

foreach (EXPERT_LANG as $lang=>$langId) {
    //Все эксперты отфильтрованные по языку. NULL - эксперт для 2 языков
    $experts = \Bitrix\Main\UserTable::getList(['filter' => ['GROUPS.GROUP_ID' => 5, 'UF_EXPERT_LANG' => [NULL, $langId]]])->fetchAll();
    $expertsCount = count($experts);
    if ($expertsCount > 0) {
        $maxExpertsToOneWork = min($expertsCount, 3);


        //Все работы у которых количество экспертов меньше максимального количества
        $allWorksRes = $DB->Query("SELECT e.ID as ELEMENT_ID, count(p.VALUE) as EXPERTS_COUNT, GROUP_CONCAT(p.VALUE) as EXPERTS
        FROM b_iblock_element e 
        LEFT JOIN b_iblock_element_property p ON e.ID = p.IBLOCK_ELEMENT_ID AND p.IBLOCK_PROPERTY_ID = {$expertsPropId}
        WHERE e.IBLOCK_ID = " . IBLOCK_COMPETITION_WORKS . " AND e.ACTIVE = 'Y' 
        AND (SELECT p2.VALUE FROM b_iblock_element_property p2 WHERE p2.IBLOCK_PROPERTY_ID = {$langPropId} AND e.ID = p2.IBLOCK_ELEMENT_ID) = '{$lang}'
        GROUP BY e.ID 
        HAVING COUNT(p.VALUE) < " . $maxExpertsToOneWork);

        $works = [];
        while ($ob = $allWorksRes->fetch()) {
            $ob['EXPERTS'] = $ob['EXPERTS'] ? explode(',', (string)$ob['EXPERTS']) : [];
            $works[] = $ob;
        };

        $workCount = count($works);
        if (!$workCount) {
            break;
        }

        $lastIndex = 0;
        foreach ($works as $key => &$work) {
            $i = 0;
            $index = 0;
            while (true) {
                $index++;
                if ($index > 1000) {
                    break;
                }
                if (!isset($experts[$i])) {
                    $i = 0;
                    $lastIndex = 0;
                }
                if ($i >= $lastIndex) {
                    $expert = $experts[$i];

                    //Если работа уже была добавлена эксперту, то пропускаем
                    if (in_array($expert['ID'], $work['EXPERTS'])) {
                        $i++;
                        continue;
                    }

                    //Если экспертов больще максимального количества на 1 работу
                    if ($work['EXPERTS_COUNT'] >= $maxExpertsToOneWork) {
                        $lastIndex = $i;
                        break;
                    }

                    //Добавляем эксперту работу на оценку
                    \Bitrix\Iblock\ElementPropertyTable::add([
                        'IBLOCK_PROPERTY_ID' => $expertsPropId,
                        'IBLOCK_ELEMENT_ID' => $work['ELEMENT_ID'],
                        'VALUE' => $expert['ID'],
                        'VALUE_NUM' => $expert['ID'],
                    ]);

                    $work['EXPERTS'][] = $expert['ID'];
                    $work['EXPERTS_COUNT']++;
                }
                $i++;
            }
        }
    }
}
/* --- */

//Критерии оценок
$criteriaRatings = [];
$arFilter = ["IBLOCK_ID" => IBLOCK_COMPETITION_RATING_CRITERIA, 'ACTIVE' => 'Y'];
$arSelect = ['IBLOCK_ID', 'ID', 'PROPERTY_stage'];
$criteriaRatingRes = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
while ($ob = $criteriaRatingRes->GetNext()) {
    $criteriaRatings[$ob['PROPERTY_STAGE_VALUE']][$ob['ID']] = $ob['ID'];
}

//Оценки эксперта
$workRatings = [];
$arFilter = ["IBLOCK_ID" => IBLOCK_COMPETITION_WORKS_RATING, 'ACTIVE' => 'Y', 'PROPERTY_expert' => $userId];
$arSelect = ['IBLOCK_ID', 'PROPERTY_expert', 'PROPERTY_criteria', 'PROPERTY_work', 'PROPERTY_rating'];
$workRatingsRes = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
while ($ob = $workRatingsRes->GetNext()) {
    $workRatings[$ob['PROPERTY_WORK_VALUE']][$ob['PROPERTY_CRITERIA_VALUE']] = $ob['PROPERTY_RATING_VALUE'];
}

$works = [];
$arSelect = ['*', 'IBLOCK_ID', 'PROPERTY_competition_user_id', 'PROPERTY_stage'];
$arFilter = ["IBLOCK_ID" => IBLOCK_COMPETITION_WORKS, 'ACTIVE' => 'Y', 'PROPERTY_experts' => $userId];
$res = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);

$workUserIds = [];
$ratedCount = [];
while ($ob = $res->GetNext()) {
    $ratings = $workRatings[$ob['ID']] ?? [];

    $ob['rated'] = (count($ratings) >= count($criteriaRatings[$ob['PROPERTY_STAGE_VALUE']]));
    if (!isset($ratedCount[$ob['PROPERTY_STAGE_VALUE']])) {
        $ratedCount[$ob['PROPERTY_STAGE_VALUE']] = 0;
    }
    if ($ob['rated']) {
        $ratedCount[$ob['PROPERTY_STAGE_VALUE']]++;
    }

    $ob['USER_ID'] = $ob['PROPERTY_COMPETITION_USER_ID_VALUE'];

    $workUserIds[] = $ob['USER_ID'];
    $works[$ob['PROPERTY_STAGE_VALUE']][] = $ob;
}

$userRes = \Bitrix\Main\UserTable::getList(['filter' => ['ID' => $workUserIds], 'select' => ['*', 'UF_COMPETITION_STAGE'],]);
$users = [];
while ($row = $userRes->fetch()) {
    $users[$row['ID']] = $row;
}

$stageField = \Bitrix\Main\UserFieldTable::getList(['filter' => ['FIELD_NAME' => 'UF_COMPETITION_STAGE'], 'select' => ['ID']])->fetch();

$userFieldEnum = new CUserFieldEnum();
$userStageRes = $userFieldEnum->GetList([], [
    'USER_FIELD_ID' => $stageField['ID'],
]);

$userStages = [];
while ($row = $userStageRes->GetNext()) {
    $userStages[$row['ID']] = $row['VALUE'];
}

foreach ($works as &$s) {
    foreach ($s as &$work) {
        $userInfo = $users[$work['USER_ID']];
        $work['USER_NAME'] = trim($userInfo['LAST_NAME'] . " " . $userInfo['NAME'] . " " . $userInfo['SECOND_NAME']);
        $work['USER_STAGE'] = $userStages[$userInfo['UF_COMPETITION_STAGE']];
    }
}

$arResult['works'] = $works;
$arResult['expert'] = $arUser;
$arResult['ratedCount'] = $ratedCount;

