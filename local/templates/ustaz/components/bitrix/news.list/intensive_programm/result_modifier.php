<?php
/**
 * @var CMain $APPLICATION
 * @var array $arResult
 * @var array $arParams
 */

$programs = [];

foreach ($arResult['ITEMS'] as $item){
    $props = $item['PROPERTIES'];
    $timestamp = MakeTimeStamp($props['DATETIME']['VALUE']);
    $date = FormatDate('d F', $timestamp);

    if (!isset($programs[$date])){
        $programs[$date] = [
            'DATE' => $date,
            'ITEMS' => [],
        ];
    }

    $programs[$date]['ITEMS'][] = array_merge($item, [
        'NAME' => SITE_ID == 'ru' ? $item['NAME'] : $props['NAME_KZ']['VALUE'],
        'TIME' => date('H:i', $timestamp),
    ]);

}

$arResult['PROGRAMS'] = $programs;