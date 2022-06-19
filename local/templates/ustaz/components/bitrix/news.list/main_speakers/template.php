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
				<div class="speakers-content">
				<div class="speakers-left" style="padding-left: 0px;">
				<div class="speakers-left_title"><? $APPLICATION->IncludeFile(INCLUDE_PATH . "main/speakers_left_title.php", array(), array("MODE" => "text")); ?>			
				</div></div>
	<?php 
	foreach($arResult["ITEMS"] as $speaker):
	$imgAvatar = CFile::ResizeImageGet($speaker['DISPLAY_PROPERTIES']['speaker_avatar']['FILE_VALUE']['ID'], ['width' => 275, 'height' => 275], BX_RESIZE_IMAGE_PROPORTIONAL, true);
	?>
	<?php
       $this->AddEditAction($speaker['ID'], $speaker['EDIT_LINK'], CIBlock::GetArrayByID($speaker["IBLOCK_ID"], "ELEMENT_EDIT"));
       $this->AddDeleteAction($speaker['ID'], $speaker['DELETE_LINK'], CIBlock::GetArrayByID($speaker["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
	<div class="speakers-left" id="<?=$this->GetEditAreaId($speaker['ID']);?>">
	    <div class="speakers-card" data-img="<?= $imgAvatar['src'] ?>" data-title="<?=$speaker['DISPLAY_PROPERTIES']['speaker_name_' . SITE_ID]['VALUE'] ?>" data-position="<?=$speaker['DISPLAY_PROPERTIES']['speaker_title_' . SITE_ID]['VALUE'] ?>" data-city="<?=$speaker['DISPLAY_PROPERTIES']['speaker_town_' . SITE_ID]['VALUE'] ?>" data-theme="<?=$speaker['DISPLAY_PROPERTIES']['speaker_info_' . SITE_ID]['VALUE'] ?>">
		<div class="speakers-card__img">
		    <div class="speakers-card__img--block" style="background-image: url(<?= $imgAvatar['src'] ?>)"></div>
		</div>
		<div class="speakers-card__info">
		    <div class="speakers-card__info-top">
			    <div class="speakers-card__info--theme"><?=$speaker['DISPLAY_PROPERTIES']['speaker_info_' . SITE_ID]['VALUE'] ?></div>
				<div class="speakers-card__info--title"><?=$speaker['DISPLAY_PROPERTIES']['speaker_name_' . SITE_ID]['VALUE'] ?></div>
		        <div class="speakers-card__info--position"><?=$speaker['DISPLAY_PROPERTIES']['speaker_title_' . SITE_ID]['VALUE'] ?></div>
		        <div class="speakers-card__info--city"><?=$speaker['DISPLAY_PROPERTIES']['speaker_town_' . SITE_ID]['VALUE'] ?></div>
		    </div>
		   
		</div>
	    </div>
	</div>
	<?endforeach;?>
</div>
<?endif;?>
