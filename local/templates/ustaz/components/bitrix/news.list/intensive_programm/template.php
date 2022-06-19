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
    <div class="intensive-programm">
        <div class="container">
            <h2><?= GetMessage('PROGRAM_TITLE') ?></h2>
            <div class="intensive-programm__content tabs-container">
                <div class="intensive-programm__left">
                    <ul class="tabs-list tabs-intensive__list">
                        <?php $i = 1; ?>
                        <?php foreach ($arResult["PROGRAMS"] as $program): ?>
                            <li>
                                <a class="tabBtnJs tab<?= $i ?><?= ($i == 1 ? ' is-active' : '') ?> tab-intensive__btn" href="#"
                                   data-tab="tab<?= $i ?>">
                                    <span><?= $program['DATE'] ?></span>
                                </a>
                            </li>
                            <?php $i++ ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="intensive-programm__right">
                    <div class="intensive-programm__tabs-content">
                        <?php $i = 1; ?>
                        <?php foreach ($arResult["PROGRAMS"] as $program): ?>
                            <div class="tab-content intensive-tab__content tab<?= $i ?><?= ($i == 1 ? ' is-active' : '') ?>">
                                <div class="tab-btn__block">
                                    <a class="tab-btn__mobile tabBtnMobJs tab<?= $i ?><?= $i ?><?= ($i == 1 ? ' is-active' : '') ?> tab-intensive__btn"
                                       href="#" data-tab="tab<?= $i ?>">
                                        <?= $program['DATE'] ?>
                                    </a>
                                </div>
                                <div class="tabs-block">
                                    <ul class="intensive-programm__date-list">
                                        <?php foreach ($program['ITEMS'] as $item): ?>
                                            <?php
                                                $this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_EDIT"));
                                                $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                                            ?>
                                            <li  id="<?=$this->GetEditAreaId($item['ID']);?>">
                                                <div class="intensive-programm__time"><?= $item['TIME'] ?></div>
                                                <div class="intensive-programm__time-text"><?= $item['NAME'] ?></div>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            <?php $i++ ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php if($arParams['LINK_TO_DOWNLOAD']): ?>
                <div class="intensive-programm__action">
                    <a class="btn btn-orange btn-style--1" target="_blank" download="" href="<?=$arParams['LINK_TO_DOWNLOAD']?>"><?=GetMessage('DOWNLOAD_PROGRAM')?></a>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
