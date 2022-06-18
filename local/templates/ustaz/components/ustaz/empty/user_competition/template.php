<?php

use Bitrix\Main\Page\Asset;
use Bitrix\Main\Localization\Loc;

$asset = Asset::getInstance();
/**
 * $asset->addCss(STATIC_PATH . '/css/gradient.css');
 * $asset->addCss(STATIC_PATH . '/css/select2.css');
 * $asset->addCss(STATIC_PATH . '/css/tooltipster.bundle.css');
 *
 * $asset->addJs(STATIC_PATH . "js/select2.min.js");
 * $asset->addJs(STATIC_PATH . "js/select-profile.js");
 * $asset->addJs(STATIC_PATH . "js/tooltipster.bundle.min.js");
 * $asset->addJs($templateFolder . "/script.js");
 **/
Loc::loadMessages(__FILE__);

//print_r($arResult);
//echo $arParams['IBLOCK_ID'];
//echo SITE_TEMPLATE_PATH . "include_areas/user_profile_tabs.php";
//print_r($_SERVER)
?>
<script>
    seconds = [
        <?=timerCountdownInSeconds(new DateTime(COMPETITION_COUNTDOWN_STAGE_1, new \DateTimeZone('Asia/Almaty')))?>,
        <?=timerCountdownInSeconds(new DateTime(COMPETITION_COUNTDOWN_STAGE_2, new \DateTimeZone('Asia/Almaty')))?>,
        <?=timerCountdownInSeconds(new DateTime(COMPETITION_COUNTDOWN_STAGE_3, new \DateTimeZone('Asia/Almaty')))?>];
</script>
<div class="page-content">
    <main class="wrapper">
        <div class="main-content">
            <div class="container">
                <div class="main-wrapper">
                    <div class="main-container">
                        <div class="main-container__block main-container--style pt-0">
                            <? $APPLICATION->IncludeFile(SITE_TEMPLATE_PATH . "/include_areas/user_profile_tabs.php", $arResult, array("MODE" => "text", "SHOW_BORDER" => false)); ?>
                            <div class="contest-container">
                                <? if ($arResult['stage'] >= 1) { ?>
                                    <a name="linkStage1" id="linkStage1"></a>
                                    <form class="contest-block formCompetition" action="#linkStage1" method="post">
                                        <input type="hidden" name="data[stage]" value='1'>
                                        <input type="hidden" name="data[lang]" value='<?= SITE_ID ?>'>
                                        <div class="contest-block__header">
                                            <div class="contest-block__header-left">
                                                <div class="contest-block__header-title"><?= Loc::getMessage('USER_COMPETITION_STAGE1_NAME') ?></div>
                                                <div class="contest-block__header-format is-online">Online</div>
                                            </div>
                                            <div class="contest-block__header-right">
                                                <div class="contest-tasks">
                                                    <? if ($arResult['downloadCert']) { ?>
                                                        <a href="/cert?lang=<?=SITE_ID?>" target="_blank" class="btn btn-blue btn-style--1"><?= Loc::getMessage('USER_COMPETITION_CERT_DOWNLOAD') ?></a>
                                                    <? } elseif (isset($arResult['stages'][1])) { ?>
                                                        <? if ($arResult['stages'][1]['approved']) { ?>
                                                            <div class="contest-tasks__btn is-success"><?= Loc::getMessage('USER_COMPETITION_STAGE_APPROVED') ?></div>
                                                        <? } else { ?>
                                                            <div class="contest-tasks__btn"><?= Loc::getMessage('USER_COMPETITION_STAGE_APPROVE') ?></div>
                                                        <? } ?>
                                                    <? } elseif (in_array(1, DISABLED_STAGES)) { ?>
                                                        <div class="contest-tasks__btn"><?= Loc::getMessage('USER_COMPETITION_STAGE_COMPLETED') ?></div>
                                                    <? } else { ?>
                                                        <div class="contest-tasks__title"><?= Loc::getMessage('USER_COMPETITION_BUTTON_COUNTDOWN') ?></div>
                                                        <div class="contest-tasks__btn task-timer"
                                                             id="countdown_1"></div>
                                                    <? } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="contest-block__body">
                                            <div class="contest-block__text">
                                                <div class="contest-block__title">
                                                    <h2><?= Loc::getMessage('USER_COMPETITION_STAGE1_TITLE') ?></h2>
                                                </div>
                                                <div class="contest-block__paragraph">
                                                    <p><?= Loc::getMessage('USER_COMPETITION_STAGE1_TEXT') ?></p>
                                                </div>
                                            </div>
                                            <? if (isset($arResult['stages'][1]) && $arResult['stages'][1]['approved']) { ?>
                                                <div class="contest-block__content">
                                                    <div class="contest-block__result">
                                                        <div class="contest-block__result-title"><?= Loc::getMessage("RESULTS") ?></div>
                                                        <ul class="contest-result__list">
                                                            <li class="contest-result__item">
                                                                <div class="contest-result__num"><?=$arResult['stages'][1]['ratingSum']?></div>
                                                                <div class="contest-result__text"><?= Loc::getMessage("FINAL_RATING") ?></div>
                                                                <div class="contest-result__max">(max. <?=$arResult['criterionMaxRating']?>)</div>
                                                            </li>
                                                            <? foreach ($arResult['stages'][1]['ratings'] as $criteriaId=>$rating){ ?>
                                                                <li class="contest-result__item">
                                                                    <div class="contest-result__num"><?=$rating?></div>
                                                                    <div class="contest-result__text"><?=$arResult['criteria'][1][$criteriaId]['name_'.SITE_ID]['VALUE']?></div>
                                                                    <div class="contest-result__max">(max. <?=$arResult['criteria'][1][$criteriaId]['max_points']['VALUE']?>)</div>
                                                                </li>
                                                            <? } ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <? if ($arResult['stage'] > 1) { ?>
                                                    <div class="contest-block__result-title"><?= Loc::getMessage("STAGE_1_C") ?></div>
                                                <? } else { ?>
                                                    <div class="contest-block__result-title"><?= Loc::getMessage("STAGE_1_NC") ?></div>
                                                <? } ?>
                                            <? } else {?>

                                                <div class="contest-block__content">
                                                    <div class="form-group">
                                                        <div class="form-group__title"><?= Loc::getMessage('USER_COMPETITION_STAGE_LINK_ARTICLE') ?></div>
                                                        <div class="form-group__block">
                                                            <div class="form-group__row">
                                                                <div class="form-group__col">
                                                                    <div class="form-control">
                                                                        <input class="form-input" type="text"
                                                                               name="data[url]"
                                                                               placeholder="<?= Loc::getMessage('USER_COMPETITION_ARTICLE_PLACEHOLDER') ?>"<? if (isset($arResult['stages'][1]) || in_array($arResult['stage'], DISABLED_STAGES)) {
                                                                            echo ' disabled';
                                                                        } ?> <? if (isset($arResult['stages'][1])) {
                                                                            echo "value='{$arResult['stages'][1]['url']}'";
                                                                        } ?>>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="form-group__title"><?= Loc::getMessage('USER_COMPETITION_STAGE_COMMENT') ?></div>
                                                        <div class="form-group__block">
                                                            <div class="form-group__row">
                                                                <div class="form-group__col">
                                                                    <div class="form-control">
                                                                    <textarea class="form-input" name="data[text]"
                                                                              placeholder="<?= Loc::getMessage('USER_COMPETITION_COMMENT_PLACEHOLDER') ?>"<? if (isset($arResult['stages'][1]) || in_array($arResult['stage'], DISABLED_STAGES)) {
                                                                        echo ' disabled';
                                                                    } ?>><? if (isset($arResult['stages'][1])) {
                                                                            echo $arResult['stages'][1]['text'];
                                                                        } ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group__block-action">
                                                            <div class="form-group__block-action__head-btn">
                                                                <button disabled class="btn btn-blue btn-style--1"
                                                                        type="submit" <? if (isset($arResult['stages'][1]) || in_array($arResult['stage'], DISABLED_STAGES)) {
                                                                    echo ' disabled';
                                                                } ?>><?= Loc::getMessage('USER_COMPETITION_BUTTON_SEND') ?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?} ?>
                                        </div>
                                    </form>
                                <? } ?>
                                <? if ($arResult['stage'] >= 2) { ?>
                                    <a name="linkStage2" id="linkStage2"></a>
                                    <form class="contest-block formCompetition" action="#linkStage2" method="post">
                                        <input type="hidden" name="data[stage]" value='2'>
                                        <input type="hidden" name="data[lang]" value='<?= SITE_ID ?>'>
                                        <div class="contest-block__header">
                                            <div class="contest-block__header-left">
                                                <div class="contest-block__header-title"><?= Loc::getMessage('USER_COMPETITION_STAGE2_NAME') ?></div>
                                                <div class="contest-block__header-format is-online">Online</div>
                                            </div>
                                            <div class="contest-block__header-right">
                                                <div class="contest-tasks">
                                                    <? if (isset($arResult['stages'][2])) {?>
                                                        <?if ($arResult['stages'][2]['approved']) { ?>
                                                            <div class="contest-tasks__btn is-success"><?= Loc::getMessage('USER_COMPETITION_STAGE_APPROVED') ?></div>
                                                        <? } else { ?>
                                                            <div class="contest-tasks__btn"><?= Loc::getMessage('USER_COMPETITION_STAGE_APPROVE') ?></div>
                                                        <? } ?>
                                                    <? } elseif (in_array(2, DISABLED_STAGES)) { ?>
                                                        <div class="contest-tasks__btn"><?= Loc::getMessage('USER_COMPETITION_STAGE_COMPLETED') ?></div>
                                                    <? } else { ?>
                                                        <div class="contest-tasks__title"><?= Loc::getMessage('USER_COMPETITION_BUTTON_COUNTDOWN') ?></div>
                                                        <div class="contest-tasks__btn task-timer" id="countdown_2">
                                                            <!--<span class="days">02</span> дня : <span class="hours">01</span> час : <span class="minutes">43</span> минуты--></div>
                                                    <? } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="contest-block__body">
                                            <div class="contest-block__text">
                                                <div class="contest-block__title">
                                                    <h2><?= Loc::getMessage('USER_COMPETITION_STAGE2_TITLE') ?></h2>
                                                </div>
                                                <div class="contest-block__paragraph">
                                                    <p><?= Loc::getMessage('USER_COMPETITION_STAGE2_TEXT') ?></p>
                                                </div>
                                            </div>
                                            <? if (isset($arResult['stages'][2]) && $arResult['stages'][2]['approved']) { ?>
                                                <div class="contest-block__content">
                                                    <div class="contest-block__result">
                                                        <div class="contest-block__result-title"><?= Loc::getMessage("RESULTS") ?></div>
                                                        <ul class="contest-result__list">
                                                            <li class="contest-result__item">
                                                                <div class="contest-result__num"><?=$arResult['stages'][2]['ratingSum']?></div>
                                                                <div class="contest-result__text"><?= Loc::getMessage("FINAL_RATING") ?></div>
                                                                <div class="contest-result__max">(max. <?=$arResult['criterionMaxRating']?>)</div>
                                                            </li>
                                                            <? foreach ($arResult['stages'][2]['ratings'] as $criteriaId=>$rating){ ?>
                                                                <li class="contest-result__item">
                                                                    <div class="contest-result__num"><?=$rating?></div>
                                                                    <div class="contest-result__text"><?=$arResult['criteria'][2][$criteriaId]['name_'.SITE_ID]['VALUE']?></div>
                                                                    <div class="contest-result__max">(max. <?=$arResult['criteria'][2][$criteriaId]['max_points']['VALUE']?>)</div>
                                                                </li>
                                                            <? } ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            <? } else {?>
                                                <div class="contest-block__content">
                                                    <div class="form-group">
                                                        <div class="form-group__title"><?= Loc::getMessage('USER_COMPETITION_STAGE_LINK_LESSON') ?></div>
                                                        <div class="form-group__block">
                                                            <div class="form-group__row">
                                                                <div class="form-group__col">
                                                                    <div class="form-control">
                                                                        <input class="form-input" type="text"
                                                                               name="data[url]"
                                                                               placeholder="https://tilda.cc/ru/"<? if (isset($arResult['stages'][2]) || in_array($arResult['stage'], DISABLED_STAGES)) {
                                                                            echo ' disabled';
                                                                        } ?> <? if (isset($arResult['stages'][2])) {
                                                                            echo "value='{$arResult['stages'][2]['url']}'";
                                                                        } ?>>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="form-group__title"><?= Loc::getMessage('USER_COMPETITION_STAGE_COMMENT') ?></div>
                                                        <div class="form-group__block">
                                                            <div class="form-group__row">
                                                                <div class="form-group__col">
                                                                    <div class="form-control">
                                                                        <textarea class="form-input" name="data[text]"
                                                                                  placeholder="<?= Loc::getMessage('USER_COMPETITION_COMMENT_PLACEHOLDER') ?>"<? if (isset($arResult['stages'][2]) || in_array($arResult['stage'], DISABLED_STAGES)) {
                                                                            echo ' disabled';
                                                                        } ?>><? if (isset($arResult['stages'][2])) {
                                                                                echo $arResult['stages'][2]['text'];
                                                                            } ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group__block-action">
                                                            <div class="form-group__block-action__head-btn">
                                                                <button class="btn btn-blue btn-style--1"
                                                                        type="submit"<? if (isset($arResult['stages'][2]) || in_array($arResult['stage'], DISABLED_STAGES)) {
                                                                    echo ' disabled';
                                                                } ?>><?= Loc::getMessage('USER_COMPETITION_BUTTON_SEND') ?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <? } ?>
                                        </div>
                                    </form>
                                <? } ?>
                                <? if ($arResult['stage'] == 3) { ?>
                                    <form class="contest-block">
                                        <div class="contest-block__header">
                                            <div class="contest-block__header-left">
                                                <div class="contest-block__header-title"><?= Loc::getMessage('USER_COMPETITION_STAGE3_NAME') ?></div>
                                                <div class="contest-block__header-format is-live">Live</div>
                                            </div>
                                            <div class="contest-block__header-right">
                                                <div class="contest-tasks">
                                                    <? if (isset($arResult['stages'][3])) { ?>
                                                        <?if ($arResult['stages'][3]['approved']) { ?>
                                                            <div class="contest-tasks__btn is-success"><?= Loc::getMessage('USER_COMPETITION_STAGE_COMPLETED') ?></div>
                                                        <? } else { ?>
                                                            <div class="contest-tasks__btn"><?= Loc::getMessage('USER_COMPETITION_STAGE_APPROVE') ?></div>
                                                        <? } ?>
                                                    <? } elseif (in_array(3, DISABLED_STAGES)) { ?>
                                                        <div class="contest-tasks__btn"><?= Loc::getMessage('USER_COMPETITION_STAGE_COMPLETED') ?></div>
                                                    <? } else { ?>
                                                        <div class="contest-tasks__title"><?= Loc::getMessage('USER_COMPETITION_BUTTON_COUNTDOWN') ?></div>
                                                        <div class="contest-tasks__btn task-timer" id="countdown_3">
                                                            <!--<span class="days">04</span> дня : <span class="hours">01</span> час : <span class="minutes">43</span> минуты--></div>
                                                    <? } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="contest-block__body">
                                            <div class="contest-block__text">
                                                <div class="contest-block__title">
                                                    <h2><?= Loc::getMessage('USER_COMPETITION_STAGE3_TITLE') ?></h2>
                                                </div>
                                                <? if (isset($arResult['stages'][3]) && $arResult['stages'][3]['approved']) { ?>
                                                    <ul class="contest-block__result-list">
                                                        <li><?= Loc::getMessage("STAGE_3_RATINGS") ?></li>
                                                        <li><?= Loc::getMessage("MASTER_CLASS") ?><?=$arResult['stages'][3]['RATING_2']['VALUE']?></li>
                                                        <li><?= Loc::getMessage("SPEECH") ?><?=$arResult['stages'][3]['RATING_1']['VALUE']?></li>
                                                        <li><?= Loc::getMessage("RATING_FINAL") ?><?=$arResult['stages'][3]['RATING_FINAL']['VALUE']?></li>
                                                    </ul>
                                                <? } ?>
                                            </div>
                                        </div>
                                    </form>
                                <? } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
