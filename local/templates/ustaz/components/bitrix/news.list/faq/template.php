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
<div class="faq-container"><div class="faq-row">
	<div class="faq-col">
	<? $i = 0; ?>
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		//Четные пропускаем. Спасибо Стас за прекрасную верстку )
		$i++; 
		if ($i % 2 === 0) {continue;}
		?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                
		<div class="faq-block"   id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<div class="faq-collapse collapse__item"><a class="faq-collapse__head collapse__btn" href="#"><?=$arItem['DISPLAY_PROPERTIES']['faq_title_' . SITE_ID]['VALUE'] ?></a>
				<div class="faq-collapse__body collapse__content">
					<p><?=html_entity_decode($arItem['DISPLAY_PROPERTIES']['faq_text_' . SITE_ID]['VALUE']['TEXT']) ?></p>
				</div>
			</div>
		</div>
	<?endforeach;?>
	</div>
	
	<div class="faq-col">
	<? $i = 0; ?>
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		//НеЧетные пропускаем. Спасибо Стас за прекрасную верстку )
		$i++; 
		if ($i % 2 === 1) {continue;}
		?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                
		<div class="faq-block"   id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<div class="faq-collapse collapse__item"><a class="faq-collapse__head collapse__btn" href="#"><?=$arItem['DISPLAY_PROPERTIES']['faq_title_' . SITE_ID]['VALUE'] ?></a>
				<div class="faq-collapse__body collapse__content">
					<p><?=html_entity_decode($arItem['DISPLAY_PROPERTIES']['faq_text_' . SITE_ID]['VALUE']['TEXT']) ?></p>
				</div>
			</div>
		</div>
	<?endforeach;?>
</div>
	
</div></div>
<?endif;?>
