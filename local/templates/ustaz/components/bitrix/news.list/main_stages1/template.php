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
	<div class="stages-content">
        <?foreach($arResult["ITEMS"] as $arItem):?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <?
                $imgBig = CFile::ResizeImageGet($arItem['DISPLAY_PROPERTIES']['stage_img_big']['FILE_VALUE']['ID'], ['width' => 191, 'height' => 191], BX_RESIZE_IMAGE_PROPORTIONAL, true);
                $imgSmall = CFile::ResizeImageGet($arItem['DISPLAY_PROPERTIES']['stage_img_small']['FILE_VALUE']['ID'], ['width' => 108, 'height' => 108], BX_RESIZE_IMAGE_PROPORTIONAL, true);
                ?>
                <?
                $i++;
                ?>
		<div class="stage-block" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		    <div class="stage-block__wrap stage--<? if ($i % 2 == 0 ) {echo 'left';} else {echo 'right';}?>">
			<div class="stage-block__img">
			    <div class="stage-block__img--big">
				<picture>
				    <source media="(max-width: 1023px)" type="image/png" srcset="<?= STATIC_PATH ?>images/simple.png"><img class="lazyload img-responsive" data-src="<?=$imgBig['src']?>" alt="#" loading="lazy">
				</picture>
			    </div>
			    <div class="stage-block__img--small">
				<picture>
				    <source media="(max-width: 1023px)" type="image/png" srcset="<?= STATIC_PATH ?>images/simple.png"><img class="lazyload img-responsive" data-src="<?=$imgSmall['src']?>" alt="#" loading="lazy">
				</picture>
			    </div>
			</div>
			<div class="stage-block__head">
			    <div class="stage-block__head--title"><?=$arItem['DISPLAY_PROPERTIES']['stage_head_title_' . SITE_ID]['VALUE'] ?></div>
			    <div class="stage-block__head--format is-online"><?=$arItem['DISPLAY_PROPERTIES']['stage_head_format']['VALUE'] ?></div>
			</div>
			<div class="stage-block__body">
			    <?= html_entity_decode($arItem['DISPLAY_PROPERTIES']['stage_title_' . SITE_ID]['VALUE']) ?>
			    <div class="stage-block__bottom"><?=$arItem['DISPLAY_PROPERTIES']['stage_description_' . SITE_ID]['VALUE'] ?></div>
			    <div class="stage-block__icon"><img src="<?= STATIC_PATH ?>images/sprites/svg/icon-snowflake.svg" alt="#"></div>
			</div>
		    </div>
		</div>
                <?endforeach;?>
	</div>
<?endif;?>



