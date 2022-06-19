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
    <ul class="competition-news__latest-list">
        <? foreach ($arResult["ITEMS"] as $arItem): ?>
            <li class="competition-news__latest-item">
                <a class="competition-news__lates-link" href="<? echo $arItem["DETAIL_PAGE_URL"] ?>" title="<?=$arItem['NAME']?>">
                    <span class="competition-news__lates-left">
                            <span class="competition-news__lates-title"><?=$arItem['NAME']?></span>
                            <span class="competition-news__lates-date"><?=$arItem['DATE']?></span>
                    </span>
                    <span class="competition-news__lates-right">
                        <span class="competition-news__lates-img">
                            <img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="#">
                        </span>
                    </span>
                </a>
            </li>
        <? endforeach; ?>
    </ul>
<? endif; ?>
