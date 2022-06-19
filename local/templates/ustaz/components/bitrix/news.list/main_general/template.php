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
?><?if ($arResult['ITEMS']):?>

				<ul class="organizers-list">
				<?foreach($arResult["ITEMS"] as $item):?>
				<?php
					$this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				?>
                    <li id="<?=$this->GetEditAreaId($item['ID']);?>">
					<?
                $imgAvatar = CFile::ResizeImageGet($item['DISPLAY_PROPERTIES']['general_img']['FILE_VALUE']['ID'], ["width"=>100000,'height' => 125], BX_RESIZE_IMAGE_PROPORTIONAL, true);
                
                ?>
                        <div class="organizers-block__logo--icon"><img class="lazyload" data-src="<?= $imgAvatar['src'] ?>" srcset="<?= $imgAvatar['src'] ?>" alt="#" loading="lazy"></div>
                     <? if($item['DISPLAY_PROPERTIES']['general_text_' . SITE_ID]['VALUE'])  {  ?>
					 <div class="organizers-block__logo--text"><?=$item['DISPLAY_PROPERTIES']['general_text_' . SITE_ID]['VALUE'] ?></div>
					 <? }?>
                    </li>
				<?endforeach;?>
                </ul>
				
<?endif;?>