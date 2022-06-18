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
$APPLICATION->SetAdditionalCSS('/static/css/child-page.css');
$APPLICATION->SetAdditionalCSS('/static/css/gradient.css');
?>
<div class="selection-books__speaker">
    <div class="selection-books__speaker-left">
        <div class="selection-books__speaker-img">
            <img src="<?=$arResult['speaker_avatar']['src']?>" alt="#">
        </div>
    </div>
    <div class="selection-books__speaker-content">
        <div class="selection-books__speaker-name"><?=$arResult['speaker_name_' . SITE_ID]?></div>
        <div class="selection-books__speaker-position"><?=$arResult['speaker_title_' . SITE_ID]?></div>
        <div class="selection-books__buttons">
            <div class="advice-buttons">
                <a class="advice-btn advice-btn__prev booksPrevJs" href="#"></a>
                <a class="advice-btn advice-btn__next booksNextJs" href="#"></a>
            </div>
        </div>
    </div>
</div>
<div class="selection-books__slider">
    <div class="books-speaker__slider books-slider booksSliderInit"
         id="booksSpeakerSlider">
        <?php foreach ($arResult['BOOKS'] as $book) { ?>
            <div class="books-slide">
                    <span class="books-slide__block<? /*is-download */?>"<? /* target="_blank" href="<?= $book['PROPERTIES']['FILE']['SRC'] ?>"*/?>>
                                    <span class="books-slide__cover">
                                        <img src="<?= $book['PREVIEW_PICTURE']['src'] ?>" alt="<?= $book['PROPERTIES']['NAME'] ?>">
                                    </span>
                    <span class="books-slide__title"><?= $book['NAME'] ?></span>
                    <span class="books-slide__author">Автор: <?= $book['AUTHOR']['NAME_' . strtoupper(SITE_ID)] ?></span>
                </span>
            </div>
        <?php } ?>
    </div>
</div>
