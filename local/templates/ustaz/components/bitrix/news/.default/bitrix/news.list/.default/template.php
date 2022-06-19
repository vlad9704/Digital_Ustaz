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
<ul class="main-news__list">
    <? if ($arParams["DISPLAY_TOP_PAGER"]): ?>
        <?= $arResult["NAV_STRING"] ?>
    <? endif; ?>
    <? foreach ($arResult["ITEMS"] as $arItem): ?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
        <li class="main-news__item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
            <div class="main-news__card">
                <div class="main-news__card-img__block">
                    <? if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])): ?>
                        <a class="main-news__card-img" href="<?= $arItem["DETAIL_PAGE_URL"] ?>">
                            <img
                                    class="preview_picture"
                                    src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                                    alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                            />
                        </a>
                    <? else: ?>
                        <span class="main-news__card-img">
                            <img
                                    class="preview_picture"
                                    src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                                    alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                            />
                        </span>
                    <? endif; ?>
                </div>
                <div class="main-news__card-content">
                    <div class="main-news__card-content-top">
                        <? if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])): ?>
                            <a class="main-news__card-title" href="<? echo $arItem["DETAIL_PAGE_URL"] ?>">
                                <? echo $arItem["NAME"] ?>
                            </a>
                        <? else: ?>
                            <span class="main-news__card-title" href="<? echo $arItem["DETAIL_PAGE_URL"] ?>">
                                <? echo $arItem["NAME"] ?>
                            </span>
                        <? endif; ?>
                        <div class="main-news__card-text">
                            <? echo $arItem["PREVIEW_TEXT"]; ?>
                        </div>
                    </div>
                    <div class="main-news__card-bottom">
                        <div class="main-news__card-date"><? echo $arItem["DATE"] ?></div>
                        <div class="main-news__card-time"><? echo $arItem["TIME"] ?></div>
                    </div>
                </div>
            </div>
        </li>
    <? endforeach; ?>
</ul>
<? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
    <?= $arResult["NAV_STRING"] ?>
<? endif; ?>
