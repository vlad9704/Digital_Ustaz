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
<ul class="prizes-block__list">
	<?foreach($arResult["ITEMS"] as $arItem):?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
		<li class="prizes-block__list-item"  id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		    <div class="prizes-block__list-item--head">
			<div class="prizes-block__list-item-place"><?=$arItem['DISPLAY_PROPERTIES']['prizes_place_' . SITE_ID]['VALUE'] ?></div>
		    </div>
		    <div class="prizes-block__list-item--body">
			<p><?=$arItem['DISPLAY_PROPERTIES']['prizes_info_' . SITE_ID]['VALUE'] ?></p>
		    </div>
		</li>
	<?endforeach;?>
</ul>
<?endif;?>
