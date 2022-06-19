<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arResult
 * @var array $arParam
 * @var CBitrixComponentTemplate $this
 */

?>
<?php if ($arResult["NavPageCount"] > 1): ?>

    <?php if ($arResult["NavPageNomer"] + 1 <= $arResult["nEndPage"]): ?>
        <?php
        $url = $arResult["sUrlPathParams"] . "PAGEN_" . $arResult["NavNum"] . "=" . ($arResult["NavPageNomer"] + 1);
        ?>

        <div class="main-news__action btn-laod-more" data-url="<?= $url ?>">
            <a class="btn btn-blue btn-style--1" href="#"><?=\Bitrix\Main\Localization\Loc::getMessage('LOAD_MORE')?></a>
        </div>

    <?php endif ?>

<?php endif ?>