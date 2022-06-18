<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_before.php");

CModule::IncludeModule('iblock');


$stages = [
    1 => 3,
    2 => 4,
    3 => 5
];

$stagesCriteria = [
    1 => 11,
    2 => 12,
    3 => 13
];

$stage = (int)($_GET['stage'] ?? 1);
if (!isset($stages[$stage])){
    $stage = 1;
}

$by = 'LAST_NAME';
$order = 'ASC';
$expertsRes = CUser::GetList($by, $order, ['GROUPS_ID' => 5]);

$worksRes = CIBlockElement::GetList([], ['PROPERTY_stage' => $stages[$stage], 'IBLOCK_ID' => IBLOCK_COMPETITION_WORKS]);
$workIds = [];
while ($work = $worksRes->GetNext()){
    $workIds[] = $work['ID'];
}

$experts = [];
while ($expert = $expertsRes->GetNext()) {
    if ($workIds) {
        $expert['rating_count'] = CIBlockElement::GetList([], [
            'IBLOCK_ID' => IBLOCK_COMPETITION_WORKS_RATING,
            'PROPERTY_expert' => $expert['ID'],
            'PROPERTY_work' => $workIds,
        ])->SelectedRowsCount();

        $expert['rating_count_empty'] = CIBlockElement::GetList([], [
            'IBLOCK_ID' => IBLOCK_COMPETITION_WORKS_RATING,
            'PROPERTY_expert' => $expert['ID'],
            '!PROPERTY_work' => $workIds,
        ])->SelectedRowsCount();
    } else {
        $expert['rating_count'] = 0;
        $expert['rating_count_empty'] = 0;
    }
    $experts[] = $expert;
}

$criteriaCount = CIBlockElement::GetList([], ['IBLOCK_ID' => IBLOCK_COMPETITION_RATING_CRITERIA, 'PROPERTY_stage' => $stagesCriteria[$stage]])->SelectedRowsCount();


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
        <td>ФИО Эксперта</td>
        <td>Кол-во оцененных работ</td>
        <td>Кол-во оценок</td>
        <td>Кол-во оцененных работ (пустые)</td>
        <td>Кол-во оценок (пустые)</td>
    </tr>
    <?php
    foreach ($experts as $expert) { ?>
        <tr>
            <td class="number0"><?= $expert['ID'] ?></td>
            <td>
                <?= $expert['LAST_NAME'] ?>
                <?= $expert['NAME'] ?>
                <?= $expert['SECOND_NAME'] ?>
            </td>
            <td><?= (int)($expert['rating_count'] / $criteriaCount) ?></td>
            <td><?= $expert['rating_count'] ?></td>
            <td><?= (int)($expert['rating_count_empty'] / $criteriaCount) ?></td>
            <td><?= $expert['rating_count_empty'] ?></td>
        </tr>
    <?php } ?>
</table>
</body>
</html>

