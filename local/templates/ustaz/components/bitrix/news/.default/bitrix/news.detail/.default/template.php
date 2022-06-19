<? use Bitrix\Main\Localization\Loc;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
Loc::loadLanguageFile(dirname(dirname(dirname(dirname(__FILE__)))).'/news.php');
?>
<div class="news-detail">
    <div class="news-detail__header">
        <div class="news-detail__header-content">
            <h1><?=$arResult["NAME"]?></h1>
            <h2><?=$arResult["PROPERTIES"]['SUBTITLE_'.strtoupper(SITE_ID)]['VALUE']?></h2>
        </div>
    </div>
    <div class="news-detail__body">
        <div class="news-detail__body-content">
            <?if($arResult["NAV_RESULT"]):?>
                <?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
                <?echo $arResult["NAV_TEXT"];?>
                <?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?><?endif;?>
            <?elseif($arResult["DETAIL_TEXT"] <> ''):?>
                <?echo $arResult["DETAIL_TEXT"];?>
            <?else:?>
                <?echo $arResult["PREVIEW_TEXT"];?>
            <?endif?>
        </div>
    </div>
</div>