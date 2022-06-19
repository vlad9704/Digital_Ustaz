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
<div class="advice-content"><div class="adviceSlider slider">
        <?foreach($arResult["ITEMS"] as $item):?>
		<?php
	       $this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_EDIT"));
	       $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
                <?
                $imgAvatar = CFile::ResizeImageGet($item['DISPLAY_PROPERTIES']['advice_avatar']['FILE_VALUE']['ID'], ['width' => 270, 'height' => 270], BX_RESIZE_IMAGE_PROPORTIONAL, true);
                $imgAvatarSmall = CFile::ResizeImageGet($item['DISPLAY_PROPERTIES']['advice_avatar']['FILE_VALUE']['ID'], ['width' => 540, 'height' => 540], BX_RESIZE_IMAGE_PROPORTIONAL, true);
                ?>
                
		<div class="advice-slide" id="<?=$this->GetEditAreaId($item['ID']);?>">
		    <div class="advice-slide__block">
			<div class="advice-slide__img speakerImg" data-1x="<?= $imgAvatarSmall['src'] ?>" data-2x="<?= $imgAvatar['src'] ?>"><img class="img-responsive" src="<?= STATIC_PATH ?>images/advice/270x270.png" alt="#"></div>
			<div class="advice-slide__content">
			    <div class="advice-slide__title"><?=$item['DISPLAY_PROPERTIES']['advice_title_' . SITE_ID]['VALUE'] ?></div>
			    <div class="advice-slide__text">
				<p><?=$item['DISPLAY_PROPERTIES']['advice_info_' . SITE_ID]['VALUE'] ?></p>
			    </div>
			</div>
		    </div>
		</div>
	<?endforeach;?>
</div></div>
<?endif;?>
