<?php
/**
 * @var CMain $APPLICATION
 * @var array $arResult
 * @var array $arParams
 */

use Bitrix\Main\Page\Asset;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
$APPLICATION->AddHeadScript('/local/templates/ustaz/js/tooltipster.bundle.min.js');
$APPLICATION->AddHeadScript('/local/templates/ustaz/js/ion.rangeSlider.min.js');
$APPLICATION->SetAdditionalCSS('/local/templates/ustaz/css/tooltipster.bundle.css');
$APPLICATION->SetAdditionalCSS('/local/templates/ustaz/css/ion.rangeSlider.css');

?>

<div class="page-content">
    <main class="wrapper">
        <div class="main-content">
            <div class="container">
                <div class="main-wrapper">
                    <div class="main-container">
                        <div class="main-container__block main-container--style">
                            <div class="task-title">
                                <?= Loc::getMessage('USER_COMPETITION_STAGE'.($arResult['cur_stage']?:1).'_NAME') ?>.
                                <?= Loc::getMessage('USER_COMPETITION_STAGE'.($arResult['cur_stage']?:1).'_TITLE') ?>
                            </div>
                            <ul class="quest-card__list">

                                <li>
                                    <b><?= Loc::getMessage("USER_NAME") ?></b> <?= $arResult['user']['LAST_NAME'] ?>, ID <?= $arResult['user']['ID'] ?></li>
                            </ul>
                            <ul class="quest-card__info">
                                <li>
                                    <div class="quest-card__info--label"><?= Loc::getMessage("ARTICLE_LINK") ?></div>
                                    <div class="quest-card__info--text">
                                        <a href="<?= $arResult['work']['PROPERTY_COMPETITION_URL_VALUE'] ?>"
                                           target="_blank"><?= $arResult['work']['PROPERTY_COMPETITION_URL_VALUE'] ?></a>
                                    </div>
                                </li>
                                <li>
                                    <div class="quest-card__info--label"><?= Loc::getMessage("COMMENT") ?></div>
                                    <div class="quest-card__info--text">
                                        <p><?= $arResult['work']['PROPERTY_COMPETITION_TEXT_VALUE']['TEXT'] ?></p>
                                    </div>
                                </li>
                            </ul>
                            <form class="quest-card__form" id="work-rating-form" method="post">
                                <input type="hidden" name="work_id" value="<?= $arResult['work']['ID'] ?>">
                                <?= bitrix_sessid_post()?>
                                <div class="quest-card__form--title"><?= Loc::getMessage("CRITERIA_RATE") ?></div>
                                <ul class="quest-card__form-list">
                                    <? foreach ($arResult['criteriaRatings'] as $key => $criteriaRating) { ?>
                                        <li>
                                            <div class="quest-card__form-block--label"><?= ($key + 1) ?>
                                                . <?= $criteriaRating['NAME'] ?>:
                                            </div>
                                            <div class="quest-card__form-block">
                                                <input data-oldvalue="<?= $criteriaRating['RATING'] ?>"
                                                       name="rating[<?= $criteriaRating['ID'] ?>]"
                                                       value="1" class="rang-slider"
                                                       type="text" data-step="1"
                                                       data-max="<?= $criteriaRating['MAX_POINTS'] ?>" data-min="0"
                                                       data-from="0" data-grid="true"
                                                       data-skin="round" data-grid-num="5">
                                                <?php for ($i = 0; $i <= $criteriaRating['MAX_POINTS']; $i++){ ?>
                                                    <div class="<?=$i?> tooltip quest-card__tooltip quest-card__tooltip-<?=$i?>"
                                                         data-tooltip-content="#tooltip_content_<?= $criteriaRating['ID'] ?>_<?=$i?>"></div>
                                                <? } ?>
                                                <div class="tooltip_templates">
                                                    <?php for ($i = 0; $i <= $criteriaRating['MAX_POINTS']; $i++){ ?>
                                                        <div id="tooltip_content_<?= $criteriaRating['ID'] ?>_<?=$i?>">
															<?
																if($criteriaRating['TOOLTIPS'][$i])
																	echo $criteriaRating['TOOLTIPS'][$i]
															?>
                                                            <?//= $criteriaRating['TOOLTIPS'][$i] ?? $criteriaRating['TOOLTIP'] ?>
                                                        </div>
                                                    <? } ?>
                                                </div>
                                            </div>
                                        </li>
                                    <? } ?>
                                </ul>
                                <div class="response-message"></div>
                                <div class="quest-card__form-action">
                                    <?php if ($arResult['user_stage'] != $arResult['work']['PROPERTY_STAGE_VALUE']) { ?>
                                        <a href="<?=(SITE_ID == 'ru' ? '/ru' : '')?>/personal/expert/" class="btn btn-blue" type="submit"><?= Loc::getMessage("BACK") ?></a>
                                    <?php } else { ?>
                                        <button type="button" class="btn btn-grey btn-reset-rating"><?= Loc::getMessage("RESET") ?></button>
                                        <button class="btn btn-blue" type="submit"><?= Loc::getMessage("SAVE") ?></button>
                                    <? } ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>