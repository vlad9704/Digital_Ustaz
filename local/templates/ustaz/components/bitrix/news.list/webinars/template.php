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
    <div class="profile-intensive">
        <? foreach ($arResult["ITEMS"] as $arItem): ?>
            <div class="profile-intensive__block">
                <div class="profile-intensive__left">
                    <div class="profile-intensive__type"><?=$arItem['PROPERTIES']['type']['VALUE']?></div>
                    <div class="profile-intensive__title">
                        <span><?=$arItem['PROPERTIES']['name_'.SITE_ID]['VALUE']?></span>
                    </div>
                    <div class="profile-intensive__date"><?=$arItem['FORMATED_DATE']?> </div>
                    <div class="profile-intensive__action">
                        <a class="btn btn-white" href="/redirect.php?id=<?=$arItem['ID']?>&lang=<?=SITE_ID?>" target="_blank"><?=$arItem['BUTTON_TEXT']?></a>
                    </div>
                </div>
                <div class="profile-intensive__right">
                    <div class="profile-intensive__speaker">
                        <div class="profile-intensive__speaker--img"
                             style="background-image: url(<?=$arItem['SPEAKER']['speaker_avatar']['src']?>)"></div>
                        <div class="profile-intensive__speaker--name"><?=$arItem['SPEAKER']['speaker_name_'.SITE_ID]?></div>
                        <div class="profile-intensive__speaker--info"><?=$arItem['SPEAKER']['speaker_title_'.SITE_ID]?></div>
                        <div class="profile-intensive__speaker--city"><?=$arItem['SPEAKER']['speaker_town_'.SITE_ID]?></div>
                    </div>
                </div>
            </div>
        <? endforeach; ?>
    </div>
<? endif; ?>
