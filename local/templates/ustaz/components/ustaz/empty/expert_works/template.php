<?php
/**
 * @var CMain $APPLICATION
 * @var array $arResult
 * @var array $arParams
 */

use Bitrix\Main\Page\Asset;
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);
//echo $arParams['IBLOCK_ID'];
//echo SITE_TEMPLATE_PATH . "include_areas/user_profile_tabs.php";
//print_r($_SERVER)
?>
<div class="page-content">
    <main class="wrapper">
        <div class="main-content">
            <div class="container">
                <div class="main-wrapper">
                    <div class="main-container">
                        <div class="main-container__block main-container--style pt-0">
                            <div class="task-tabs">
                                <ul class="task-tabs__list">
                                    <li class="is-active task-tab__item">
                                        <a class="task-tab__btn taskTabJs" href="#" data-tab="tab1">
                                            <span class="task-tab__btn--title"><?= Loc::getMessage('USER_COMPETITION_STAGE1_NAME') ?></span>
                                            <span class="task-tab__btn--format is-online">Online</span>
                                        </a>
                                    </li>
                                    <li class="task-tab__item">
                                        <a class="task-tab__btn taskTabJs" href="#" data-tab="tab2">
                                            <span class="task-tab__btn--title"><?= Loc::getMessage('USER_COMPETITION_STAGE2_NAME') ?></span>
                                            <span class="task-tab__btn--format is-online">Online</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="task-tabs__container">
                                <div class="task-tab tab1 is-show">
                                    <div class="task-title"><?= Loc::getMessage('USER_COMPETITION_STAGE1_TITLE') ?></div>
                                    <ul class="task-list">
                                        <li class="task-list__head">
                                            <div class="task-list__head--th task-list__col task-list__col--one">
                                                <div class="task-table__block"><?= Loc::getMessage('STATUS') ?></div>
                                            </div>
                                            <div class="task-list__head--th task-list__col task-list__col--two">
                                                <div class="task-table__block"><?= Loc::getMessage('USER') ?></div>
                                            </div>
                                            <div class="task-list__head--th task-list__col task-list__col--three">
                                                <div class="task-table__block">
                                                    <?= Loc::getMessage('RATED_COUNT', ['#rated#' => $arResult['ratedCount']['I'] ?? 0, '#count#' => count($arResult['works']['I'])]) ?>
                                                </div>
                                            </div>
                                        </li>
                                        <?php if (isset($arResult['works']['I'])) { ?>
                                            <?php foreach ($arResult['works']['I'] as $work) { ?>
                                                <li class="task-list__item">
                                                    <div class="task-list__item--td task-list__col task-list__col--one"
                                                         data-title="Статус">
                                                        <div class="task-table__block">
                                                            <div class="task-btn__status<?= ($work['rated'] ? '' : ' rate-0') ?>">
                                                                <?php if ($work['rated']) { ?>
                                                                    <span><?= Loc::getMessage('RATED') ?></span>
                                                                <?php } else { ?>
                                                                    <span><?= Loc::getMessage('NO_RATED') ?></span>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="task-list__item--td task-list__col task-list__col--two"
                                                         data-title="Участник">
                                                        <div class="task-table__block">
                                                            <a class="task-list__item--link"
                                                               href="<?= (SITE_ID == 'ru' ? '/ru' : '') ?>/personal/expert/detail.php?id=<?= $work['ID'] ?>">
                                                                <?= $work['USER_NAME'] ?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="task-list__item--td task-list__col task-list__col--three">
                                                        <div class="task-table__block">
                                                            <?php if ($work['rated']) { ?>
                                                                <a class="task-btn btn btn-orange"
                                                                   href="<?= (SITE_ID == 'ru' ? '/ru' : '') ?>/personal/expert/detail.php?id=<?= $work['ID'] ?>">
                                                                    <?php if ($work['USER_STAGE'] != $work['PROPERTY_STAGE_VALUE']) { ?>
                                                                        <span><?= Loc::getMessage("SHOW") ?></span>
                                                                    <?php } else { ?>
                                                                        <span><?= Loc::getMessage('CHANGE_RATING') ?></span>
                                                                    <?php } ?>
                                                                </a>
                                                            <?php } else { ?>
                                                                <a class="task-btn btn btn-blue"
                                                                   href="<?= (SITE_ID == 'ru' ? '/ru' : '') ?>/personal/expert/detail.php?id=<?= $work['ID'] ?>">
                                                                    <?php if ($work['USER_STAGE'] != $work['PROPERTY_STAGE_VALUE']) { ?>
                                                                        <span><?= Loc::getMessage("SHOW") ?></span>
                                                                    <?php } else { ?>
                                                                        <span><?= Loc::getMessage('RATE_WORK') ?></span>
                                                                    <?php } ?>
                                                                </a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <div class="task-tab tab2">
                                    <div class="task-title"><?= Loc::getMessage('USER_COMPETITION_STAGE2_TITLE') ?></div>
                                    <ul class="task-list">
                                        <li class="task-list__head">
                                            <div class="task-list__head--th task-list__col task-list__col--one">
                                                <div class="task-table__block"><?= Loc::getMessage('STATUS') ?></div>
                                            </div>
                                            <div class="task-list__head--th task-list__col task-list__col--two">
                                                <div class="task-table__block"><?= Loc::getMessage('USER') ?></div>
                                            </div>
                                            <div class="task-list__head--th task-list__col task-list__col--three">
                                                <div class="task-table__block">
                                                    <?= Loc::getMessage('RATED_COUNT', ['#rated#' => $arResult['ratedCount']['II'] ?? 0, '#count#' => count($arResult['works']['II'])]) ?>
                                                </div>
                                            </div>
                                        </li>
                                        <?php if (isset($arResult['works']['II'])) { ?>
                                            <?php foreach ($arResult['works']['II'] as $work) { ?>
                                                <li class="task-list__item">
                                                    <div class="task-list__item--td task-list__col task-list__col--one"
                                                         data-title="Статус">
                                                        <div class="task-table__block">
                                                            <div class="task-btn__status<?= ($work['rated'] ? '' : ' rate-0') ?>">
                                                                <?php if ($work['rated']) { ?>
                                                                    <span><?= Loc::getMessage('RATED') ?></span>
                                                                <?php } else { ?>
                                                                    <span><?= Loc::getMessage('NO_RATED') ?></span>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="task-list__item--td task-list__col task-list__col--two"
                                                         data-title="Участник">
                                                        <div class="task-table__block">
                                                            <a class="task-list__item--link"
                                                               href="<?= (SITE_ID == 'ru' ? '/ru' : '') ?>/personal/expert/detail.php?id=<?= $work['ID'] ?>">
                                                                <?= $work['USER_NAME'] ?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="task-list__item--td task-list__col task-list__col--three">
                                                        <div class="task-table__block">
                                                            <?php if ($work['rated']) { ?>
                                                                <a class="task-btn btn btn-orange"
                                                                   href="<?= (SITE_ID == 'ru' ? '/ru' : '') ?>/personal/expert/detail.php?id=<?= $work['ID'] ?>">
                                                                    <?php if ($work['USER_STAGE'] != $work['PROPERTY_STAGE_VALUE']) { ?>
                                                                        <span><?= Loc::getMessage("SHOW") ?></span>
                                                                    <?php } else { ?>
                                                                        <span><?= Loc::getMessage('CHANGE_RATING') ?></span>
                                                                    <?php } ?>
                                                                </a>
                                                            <?php } else { ?>
                                                                <a class="task-btn btn btn-blue"
                                                                   href="<?= (SITE_ID == 'ru' ? '/ru' : '') ?>/personal/expert/detail.php?id=<?= $work['ID'] ?>">
                                                                    <?php if ($work['USER_STAGE'] != $work['PROPERTY_STAGE_VALUE']) { ?>
                                                                        <span><?= Loc::getMessage("SHOW") ?></span>
                                                                    <?php } else { ?>
                                                                        <span><?= Loc::getMessage('RATE_WORK') ?></span>
                                                                    <?php } ?>
                                                                </a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>