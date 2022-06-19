<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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
    <div class="intensive-gallery section-slider">
        <div class="container">
            <div class="intensive-gallery__content">
                <div class="intensive-gallery__left">
                    <h2><?= GetMessage('TITLE_GALLERY') ?></h2>
                </div>
                <div class="intensive-gallery__right">
                    <div class="slider-buttons__list">
                        <a class="advice-btn advice-btn__prev sliderPrevJs" href="#"></a>
                        <a class="advice-btn advice-btn__next sliderNextJs" href="#"></a>
                    </div>
                </div>
            </div>
            <div class="inetnsive-gallery__slider-container">
                <div class="inetnsive-gallery__slider slider intensiveGalleryInit">
                    <?php foreach ($arResult['ITEMS'] as $item): ?>
                        <?php
                            $this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_EDIT"));
                            $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                        ?>
                        <?php $image = CFile::ResizeImageGet($item['PREVIEW_PICTURE'], ['width' => 470, 'height' => 313]); ?>
                        <div class="intensive-gallery__slide" id="<?=$this->GetEditAreaId($item['ID']);?>">
                            <a class="intensive-gallery__block"
                               href="<?= $item['PREVIEW_PICTURE']['SRC'] ?>">
                                <img src="<?= $image['src'] ?>" alt="#">
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="intensive-gallery__action">
                <div class="slider-buttons__list">
                    <a class="advice-btn advice-btn__prev sliderPrevJs" href="#"></a>
                    <a class="advice-btn advice-btn__next sliderNextJs" href="#"></a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
