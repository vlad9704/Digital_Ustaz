<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
?>

<? if ($arResult['ITEMS']): ?>
        <? foreach ($arResult["ITEMS"] as $arItem): ?>
            <a class="competition-news__main-block" href="<? echo $arItem["DETAIL_PAGE_URL"] ?>">
            <span class="competition-news__main-img">
                <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem['NAME']?>">
            </span>
                <span class="competition-news__main-title"><?=$arItem['NAME']?></span>
                <span class="competition-news__main-text"><?=TruncateText(strip_tags($arItem['PREVIEW_TEXT']), 200);?></span>
                <span class="competition-news__main-date"><?=$arItem['DATE']?></span>
            </a>
        <? endforeach; ?>
<? endif; ?>
