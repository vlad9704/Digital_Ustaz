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
    <div class="intensive-reviews section-slider">
        <div class="container">
            <div class="intensive-gallery__content">
                <div class="intensive-gallery__left">
                    <h2><?= GetMessage('TITLE_REVIEWS') ?></h2>
                </div>
                <div class="intensive-gallery__right">
                    <div class="slider-buttons__list"><a class="advice-btn advice-btn__prev sliderPrevJs" href="#"></a><a class="advice-btn advice-btn__next sliderNextJs" href="#"></a></div>
                </div>
            </div>
            <div class="inetnsive-reviews__slider-container">
                <div class="inetnsive-reviews__slider slider intensiveReviewsInit">
                    <?php foreach ($arResult['ITEMS'] as $item): ?>
                        <?php
                            $this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_EDIT"));
                            $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                            $lang = strtoupper(SITE_ID);
                            $image = CFile::ResizeImageGet($item['PREVIEW_PICTURE'], ['width' => 61, 'height' => 61], BX_RESIZE_IMAGE_EXACT);
                        ?>
                        <div class="intensive-review__slide" id="<?= $this->GetEditAreaId($item['ID']); ?>">
                            <div class="intensive-review__block">
                                <div class="intensive-review__text">
                                    <p><?=$item['PROPERTIES']['REVIEW_'.$lang]['VALUE']['TEXT']?></p>
                                </div>
                                <div class="intensive-review__author">
                                    <div class="intensive-review__author-icon">
                                        <img class="img-responsive" src="<?=$image['src']?>" alt="">
                                    </div>
                                    <div class="intensive-review__author-text">
                                        <div class="intensive-review__author-name"><?=$item['PROPERTIES']['FIO_'.$lang]['VALUE']?></div>
                                        <div class="intensive-review__author-position"><?=$item['PROPERTIES']['POST_'.$lang]['VALUE']?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;?>
                </div>
            </div>
            <div class="intensive-gallery__action">
                <div class="slider-buttons__list"><a class="advice-btn advice-btn__prev sliderPrevJs" href="#"></a><a class="advice-btn advice-btn__next sliderNextJs" href="#"></a></div>
            </div>
        </div>
    </div>
<?php endif; ?>
