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
<?php if ($arResult['BOOKS']): ?>
<?php endif; ?>


<div class="selection-books__container">
    <?php foreach ($arResult['SPEAKERS'] as $speaker) { ?>
        <?php if ($speaker['BOOKS']) { ?>
            <div class="selection-books__block">
                <h2 class="selection-books__block-title"><?= $speaker['speaker_name_' . SITE_ID] ?></h2>
                <div class="selection-books__block-position"><?= $speaker['speaker_title_' . SITE_ID] ?></div>
                <div class="selection-books__slider">
                    <div class="books-selection__slider books-slider booksSelectionSlider" data-slider="sliderRandom<?=$speaker['ID']?>">
                        <?php foreach ($speaker['BOOKS'] as $book) { ?>
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
            </div>
        <?php } ?>
    <?php } ?>
</div>
