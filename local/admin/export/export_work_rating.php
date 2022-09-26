<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");

Header("Content-Type: application/force-download");
Header("Content-Type: application/octet-stream");
Header("Content-Type: application/download");
Header("Content-Disposition: attachment;filename=ratings.xls");
Header("Content-Transfer-Encoding: binary");


CModule::IncludeModule('iblock');

$ratingsRes = CIBlockElement::GetList(['SORT' => 'ASC'], [
    'IBLOCK_ID' => IBLOCK_COMPETITION_WORKS_RATING,

]);

$ratings = [];
$experIds = [];
$workIds = [];
$criteriaIds = [];
$userIds = [];

while ($rating = $ratingsRes->GetNextElement()) {
    $value = array_merge($rating->GetFields(), $rating->GetProperties());
    if ($value['work']['VALUE']) {
        if (!isset($ratings[$value['work']['VALUE']])) {
            $ratings[$value['work']['VALUE']] = [
                'experts' => [],
                'experts_ratings' => [],
                'ratings' => [],
                'criteria_ratings' => [],
            ];
        }
        $ratings[$value['work']['VALUE']]['experts'][$value['expert']['VALUE']][$value['criteria']['VALUE']] = $value['rating']['VALUE'];
        $ratings[$value['work']['VALUE']]['ratings'][] = $value['rating']['VALUE'];
        $ratings[$value['work']['VALUE']]['experts_ratings'][$value['expert']['VALUE']][] = $value['rating']['VALUE'];
        $ratings[$value['work']['VALUE']]['criteria_ratings'][$value['criteria']['VALUE']][] = $value['rating']['VALUE'];

        $workIds[$value['work']['VALUE']] = $value['work']['VALUE'];
        $experIds[$value['expert']['VALUE']] = $value['expert']['VALUE'];
        $criteriaIds[$value['criteria']['VALUE']] = $value['criteria']['VALUE'];
    }
}


$maxExpertsCount = 0;
foreach ($ratings as $rating) {
    $maxExpertsCount = max(count($rating['experts']), $maxExpertsCount);
}

$worksRes = CIBlockElement::GetList([], ['ID' => $workIds, 'IBLOCK_ID' => IBLOCK_COMPETITION_WORKS]);
$works = [];
while ($work = $worksRes->GetNextElement()) {
    $fields = $work->GetFields();
    $properties = $work->GetProperties();
    $works[$fields['ID']] = array_merge($fields, $properties);
    $userIds[] = $properties['competition_user_id']['VALUE'];
    foreach ($properties['experts']['VALUE'] as $expertId){
        $experIds[$expertId] = $expertId;
    }
}

$by = 'ID';
$order = 'ASC';
$expertsRes = CUser::GetList($by, $order, ['ID' => $experIds]);
$experts = [];
while ($expert = $expertsRes->GetNext()) {
    $experts[$expert['ID']] = $expert;
}

$by = 'ID';
$order = 'ASC';
$usersRes = CUser::GetList($by, $order, ['ID' => $userIds]);
$users = [];
while ($user = $usersRes->GetNext()) {
    $users[$user['ID']] = $user;
}

$criteriaRes = CIBlockElement::GetList([], ['ID' => $criteriaIds, 'IBLOCK_ID' => IBLOCK_COMPETITION_RATING_CRITERIA]);
$criteria = [];
while ($criterion = $criteriaRes->GetNextElement()) {
    $fields = $criterion->GetFields();
    $properties = $criterion->GetProperties();
    $criteria[$fields['ID']] = array_merge($fields, $properties);
}

$siteUrl = 'https://almatyustazy.kz/';

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
        <td>ID статьи</td>
        <td>Имя участника</td>
        <td>Этап</td>
        <td>Ссылка на статью</td>
        <td>Язык</td>
        <td>Эксперты</td>
        <td>Итоговая оценка</td>
        <?php for ($i = 0; $i < $maxExpertsCount; $i++) { ?>
            <td>Оценка эксперта №<?= ($i + 1) ?></td>
        <?php } ?>
    </tr>
    <?php foreach ($ratings as $workId => $rating) { ?>
        <tr>
            <td class="number0"><?= $workId ?></td>
            <td>
                <?= $users[$works[$workId]['competition_user_id']['VALUE']]['LAST_NAME'] ?>
                <?= $users[$works[$workId]['competition_user_id']['VALUE']]['NAME'] ?>
                <?= $users[$works[$workId]['competition_user_id']['VALUE']]['SECOND_NAME'] ?>
            </td>
            <td><?= $works[$workId]['stage']['VALUE'] ?></td>
            <td>
                <a href="<?= $works[$workId]['competition_url']['VALUE'] ?></a>"><?= $works[$workId]['competition_url']['VALUE'] ?></a>
            </td>
            <td><?= $works[$workId]['competiton_lang']['VALUE'] ?></td>
            <td>
                <?php
                $expertsInfo = [];
                foreach ($works[$workId]['experts']['VALUE'] as $expertId) {
                    $expertsInfo[] = '['.$expertId.'] (' . $experts[$expertId]['EMAIL'] . ') ' . $experts[$expertId]['NAME'] . ' ' . $experts[$expertId]['LAST_NAME'];
                }

                echo implode(' / ', $expertsInfo);
                ?>
            </td>
            <td>
                <?php
                    $ratingSum = 0;
                    foreach ($rating['criteria_ratings'] as $expertId => $experts_rating) {
                        $ratingSum += array_sum($experts_rating) / count($experts_rating);
                    }
                ?>
                <?= round($ratingSum, 1) ?>
            </td>
            <?php foreach ($rating['experts_ratings'] as $expertId => $experts_rating) { ?>
                <td>
                    <?= $experts[$expertId]['LAST_NAME'] ?>
                    <?= $experts[$expertId]['NAME'] ?>
                    <?= $experts[$expertId]['SECOND_NAME'] ?>:
                    <?= round(array_sum($experts_rating) / count($experts_rating), 1) ?>
                </td>
            <?php } ?>
            <?php if (count($rating['experts_ratings']) < $maxExpertsCount) { ?>
                <?php for ($i = 0; $i < $maxExpertsCount - count($rating['experts_ratings']); $i++) { ?>
                    <td></td>
                <?php } ?>
            <?php } ?>
        </tr>
    <?php } ?>
</table>
</body>
</html>