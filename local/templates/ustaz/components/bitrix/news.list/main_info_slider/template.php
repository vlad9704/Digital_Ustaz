<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

<?if ($arResult['ITEMS']):?>
<div class="main-labels__container">
    <div class="container">
        <div class="main-labels__content">
            <div class="slider labelSlider">
                <?foreach($arResult["ITEMS"] as $arItem):?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <div class="main-label__slide" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                    <div class="main-label__block">
                        <div class="main-label__block--icon"><img src="<?=$arItem['DISPLAY_PROPERTIES']['file_icon']['FILE_VALUE']['SRC'] ?>" alt="#"></div>
                        <div class="main-label__block--text"><?=$arItem['DISPLAY_PROPERTIES']['title_' . SITE_ID]['VALUE'] ?></div>
                    </div>
                </div>
                <?endforeach;?>
            </div>
        </div>
    </div>
</div>
<?endif;?>
