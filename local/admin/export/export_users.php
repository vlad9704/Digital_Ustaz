<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");
global $USER;
if (!$USER->IsAdmin()){
    exit();
}

CModule::IncludeModule('iblock');

$stages = [
    1 => 3,
    2 => 4,
    3 => 5
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
$workStages = [];
foreach ($ratings as $workId=>$rating) {
    $schoolType = '';
    $work = $works[$workId];
    $workStage = str_replace('stage_', '', $work['stage']['VALUE_XML_ID']);
    $workStages[$workStage] = $workStage;

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
    if (!isset($workRatings[$schoolType][$key][$workStage])) {
        $workRatings[$schoolType][$key][$workStage] = 0;
    }

    foreach ($rating as $item) {
        $workRatings[$schoolType][$key][$workStage] += array_sum($item) / count($item);
    }
}


arsort($workRatings['GOS']);
arsort($workRatings['NEGOS']);

$userIdsToNextStage = $workRatings['GOS'] + $workRatings['NEGOS'];
arsort($userIdsToNextStage);


Header("Content-Type: application/force-download");
Header("Content-Type: application/octet-stream");
Header("Content-Type: application/download");
Header("Content-Disposition: attachment;filename=users.xls");
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
        <td>Имя пользователя</td>
        <?php foreach ($workStages as $workStage){?>
            <td>Средний балл за <?=$workStage?> этап</td>
        <?php }?>
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
            <?php foreach ($workStages as $workStage){?>
                <td>
                    <?= round($rating[$workStage], 1) ?>
                </td>
            <?php }?>
            <td>
                <?php
                    $user = $users[$userId];
                    $schoolTypeUser = $user['UF_SCHOOL_COM'];
                    if ($schoolTypeUser == 'USER_PROFILE_OPTION_SCHOOL_COM_NEGOS'){
                        echo 'Негосударственная';
                    }
                    elseif ($schoolTypeUser == 'USER_PROFILE_OPTION_SCHOOL_COM_GOS'){
                        echo 'Государственная';
                    }
                    elseif ($schoolTypeUser == 'государственная'){
                        echo 'Государственная';
                    }
                ?>
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

