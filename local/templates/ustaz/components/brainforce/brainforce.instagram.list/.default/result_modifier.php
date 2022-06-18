<?php
/**
 * @var array $arResult;
 */
foreach($arResult['ITEMS'] as &$arItem){
    $arItem['PROPERTIES']['BF_INST_POST_DATE']['VALUE'] = date('d.m.Y', $arItem['PROPERTIES']['BF_INST_POST_DATE']['VALUE']);
    $arItem['DETAIL_TEXT'] = json_decode($arItem['~DETAIL_TEXT']);
    if( LANG_CHARSET != 'UTF-8'){
        $arItem['DETAIL_TEXT'] = iconv('UTF-8', 'Windows-1251', $arItem['DETAIL_TEXT']);
    }
    $arItem['PICTURE'] = CFile::ResizeImageGet($arItem['DETAIL_PICTURE']['ID'], ['width' => 200, 'height' => 200]);
}