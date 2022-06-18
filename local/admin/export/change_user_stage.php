<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");

CModule::IncludeModule('iblock');
$stages = [
    1 => 3,
    2 => 4,
    3 => 5
];
$userStages = [
    5 => 1,
    6 => 2,
    7 => 3
];

$stage = 1;

$ratingsRes = CIBlockElement::GetList(['SORT' => 'ASC'], [
    'IBLOCK_ID' => IBLOCK_COMPETITION_WORKS_RATING,
]);

$ratings = [];

while ($rating = $ratingsRes->GetNextElement()) {
    $value = array_merge($rating->GetFields(), $rating->GetProperties());
    if ($value['work']['VALUE']) {

        $ratings[$value['work']['VALUE']][$value['criteria']['VALUE']][] = $value['rating']['VALUE'];
    }
    $workIds[] = $value['work']['VALUE'];
}

$worksRes = CIBlockElement::GetList([], ['ID' => $workIds, 'IBLOCK_ID' => IBLOCK_COMPETITION_WORKS]);
$works = [];
while ($work = $worksRes->GetNextElement()) {
    $fields = $work->GetFields();
    $properties = $work->GetProperties();
    $works[$fields['ID']] = array_merge($fields, $properties);
    $userIds[] = $properties['competition_user_id']['VALUE'];
}

$users = [];
foreach ($userIds as $userId) {
    $user = CUser::GetByID($userId)->Fetch();
    $users[$userId] = $user;
}

$workRatings = [];
foreach ($ratings as $workId=>$rating) {
    $schoolType = '';
    $work = $works[$workId];
    if ($work['stage']['VALUE_XML_ID'] !== 'stage_'.$stage){
        continue;
    }

    $user = $users[$work['competition_user_id']['VALUE']];
    $schoolTypeUser = $user['UF_SCHOOL_COM'];
    if ($schoolTypeUser == 'USER_PROFILE_OPTION_SCHOOL_COM_NEGOS'){
        $schoolType = 'NEGOS';
    }
    elseif ($schoolTypeUser == 'USER_PROFILE_OPTION_SCHOOL_COM_GOS'){
        $schoolType = 'GOS';
    }
    elseif ($schoolTypeUser == 'государственная'){
        $schoolType = 'GOS';
    } else {
        $schoolType = 'NEGOS';
    }

    $key = $user['ID'];
    if (!isset($workRatings[$schoolType][$key])) {
        $workRatings[$schoolType][$key] = 0;
    }

    foreach ($rating as $item) {
        $workRatings[$schoolType][$key] += array_sum($item) / count($item);
    }
}

//TODO надо добавить проверку на количество пользователей

arsort($workRatings['GOS']);
arsort($workRatings['NEGOS']);

$workRatings['GOS'] = array_slice($workRatings['GOS'], 0, 70, true);
$workRatings['NEGOS'] = array_slice($workRatings['NEGOS'], 0, 30, true);

$userIdsToNextStage = $workRatings['GOS'] + $workRatings['NEGOS'];
arsort($userIdsToNextStage);

$nextStageNum = $stage+1;
if (isset($stages[$nextStageNum])) {
    $userFieldEnum = new CUserFieldEnum();
    $userNextStage = $userFieldEnum->GetList([], [
        'XML_ID' => 'user_stage_' . $nextStageNum,
    ])->Fetch();

    foreach ($userIdsToNextStage as $userId=>$rating) {
        $user = new CUser();

        if ($userStages[$users[$userId]['UF_COMPETITION_STAGE']] >= $userStages[$userNextStage['ID']]){
            unset($userIdsToNextStage[$userId]);
            //$user->Update($userId, ['UF_COMPETITION_STAGE' => 5]);
            continue;
        }

        //Z$user->Update($userId, ['UF_COMPETITION_STAGE' => $userNextStage['ID']]);
    }
}

Header("Content-Type: application/force-download");
Header("Content-Type: application/octet-stream");
Header("Content-Type: application/download");
Header("Content-Disposition: attachment;filename=user_stage.xls");
Header("Content-Transfer-Encoding: binary");
?>

<html lang="ru">
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        td {
            mso-number-format: \@;
        }

        .number0 {
            mso-number-format: 0;
        }

        .number2 {
            mso-number-format: Fixed;
        }
    </style>
</head>
<body>
<table border="1">
    <tr>
        <td>ID</td>
        <td>Имя участника переведенного на <?=($stage+1)?> этап</td>
        <td>Оценка</td>
        <td>Тип школы</td>
        <td>Телефон</td>
        <td>Email</td>
    </tr>
    <?php foreach ($userIdsToNextStage as $userId=>$rating) { ?>
        <tr>
            <td class="number0"><?= $userId ?></td>
            <td>
                <?= $users[$userId]['LAST_NAME'] ?>
                <?= $users[$userId]['NAME'] ?>
            </td>
            <td>
                <?= round($rating, 1) ?>
            </td>
            <td>
                <?= isset($workRatings['GOS'][$userId]) ? 'Государственная' : 'Негосударственная' ?>
            </td>
            <td>
                <?= $users[$userId]['PERSONAL_PHONE'] ?>
            </td>
            <td>
                <?= $users[$userId]['EMAIL'] ?>
            </td>
        </tr>
    <?php } ?>
</table>
</body>
</html>

