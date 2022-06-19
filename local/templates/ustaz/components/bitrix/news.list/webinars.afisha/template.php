<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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

<? if ($arResult['ITEMS']): ?>
    <ul class="webinars-poster__list">
        <? foreach ($arResult["ITEMS"] as $arItem): ?>
            <li class="webinars-poster__item">
                <a class="webinars-poster__link" <?php if ($USER->IsAuthorized()) { ?>href="/redirect.php?id=<?=$arItem['ID']?>&lang=<?=SITE_ID?>" <?php } else { ?>href="javascript:" data-src="#modalLogin" data-fancybox <?php } ?>>
                    <span class="webinars-poster__date"><?= $arItem['FORMATED_DATE'] ?></span>
                    <span class="webinars-poster__theme"><?= $arItem['PROPERTIES']['name_' . SITE_ID]['VALUE'] ?></span>
                    <span class="webinars-poster__info"><span class="webinars-poster__left">
                        <span class="webinars-poster__img">
                            <img src="<?= $arItem['SPEAKER']['speaker_avatar']['src'] ?>" alt="<?= $arItem['SPEAKER']['speaker_title_' . SITE_ID] ?>"></span>
                        </span>
                        <span class="webinars-poster__author">
                            <span class="webinars-poster__author-name"><?= $arItem['SPEAKER']['speaker_name_' . SITE_ID] ?></span>
                            <spann class="webinars-poster__author-position"><?= $arItem['SPEAKER']['speaker_title_' . SITE_ID] ?></span>
                    </span>
                </a>
            </li>
        <? endforeach; ?>
    </ul>
<? endif; ?>


