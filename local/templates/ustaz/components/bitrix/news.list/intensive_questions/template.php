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
    <div class="intensive-questions">
        <div class="container">
            <div class="intensive-questions__content">
                <h2><?= GetMessage('TITLE') ?></h2>
                <div class="intensive-questions__block">
                    <div class="faq-container">
                        <div class="faq-row">
                            <div class="faq-col">
                                <?php
                                    $i = 1;
                                    $colCountItems = ceil(count($arResult['ITEMS']) / 2);
                                ?>
                                <?php foreach ($arResult['ITEMS'] as $item): ?>
                                    <?php
                                        $this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_EDIT"));
                                        $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                                    ?>
                                    <div class="faq-block" id="<?= $this->GetEditAreaId($item['ID']); ?>">
                                        <div class="faq-collapse collapse__item">
                                            <a class="faq-collapse__head collapse__btn" href="#"><?=(SITE_ID == 'kz' ? $item['PROPERTIES']['NAME_KZ']['VALUE'] : $item['NAME'])?></a>
                                            <div class="faq-collapse__body collapse__content">
                                                <p><?=$item['PROPERTIES']['DESCRIPTION_'.strtoupper(SITE_ID)]['VALUE']['TEXT']?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if ($i > 1 && $i == $colCountItems):?>
                                </div>
                                <div class="faq-col">
                                    <?php endif;?>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
