<?php
/**
 * @var array $arResult
 */

$menuItems = [];
foreach($arResult as $key=>$arItem){
    if (($arItem['PARAMS'] && $arItem['PARAMS']['DEPTH_LEVEL'] == 1) || (!$arItem['PARAMS'] && $arItem['DEPTH_LEVEL'] == 1)){
        $menuItems[$key] = $arItem;
        if ($arItem['PARAMS']['IS_PARENT'] == 1){
            $parentKey = $key;
        }
    }
    if ($arItem['PARAMS']['DEPTH_LEVEL'] == 2){
        $menuItems[$parentKey]['CHILD'][$key] = $arItem;
    }
}


$arResult = $menuItems;