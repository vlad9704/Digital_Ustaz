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

<?php if ($arResult['ITEMS']): ?>
<div class="finalists-competition__content">
    <div class="finalists-competition__slider finalistsSliderInit slider-style">
        <?php foreach ($arResult['ITEMS'] as $item): ?>
            <?php
                $this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
            ?>
            <div class="finalists-competition__slide" id="<?=$this->GetEditAreaId($item['ID']);?>">
                <div class="finalists-competition__block">
                    <div class="finalists-competition__icon">
                        <div class="finalists-competition__icon-block">
                            <img class="img-responsive" src="<?=$item['PREVIEW_PICTURE']['src']?>"
                                 alt="#">
                        </div>
                    </div>
                    <div class="finalists-competition__info">
                        <div class="finalists-competition__name"><?=$item['NAME']?></div>
                        <div class="finalists-competition__position"><?=$item['POST']?></div>
                    </div>
                    <div class="finalists-competition__sity"><?=$item['CITY']?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>