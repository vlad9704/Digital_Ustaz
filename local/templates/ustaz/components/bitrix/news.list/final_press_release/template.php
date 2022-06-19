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

<?php if ($arResult['ITEMS']): ?>
    <?php foreach ($arResult['ITEMS'] as $item): ?>
        <div class="final-press__release">
            <div class="container">
                <div class="final-press__release-top">
                    <div class="final-press__release-left">
                        <div class="final-press__release-title">
                            <?$APPLICATION->IncludeFile(INCLUDE_PATH."final_competition/title5.php", [], [
                                'NAME' => 'заголовок 4',
                                'MODE' => 'text',
                                'TEMPLATE' => 'blank'
                            ]);?>
                        </div>
                        <div class="final-press__release-sub__title"><?=$item['NAME']?></div>
                        <div class="final-press__release-text"><p><?=$item['DETAIL_TEXT']?></p></div>
                    </div>
                    <div class="final-press__release-right">
                        <div class="final-press__release-img">
                            <img src="<?=$item['PREVIEW_PICTURE']['src']?>"
                                 srcset="<?=$item['PREVIEW_PICTURE']['src']?> 1x, <?=$item['PREVIEW_PICTURE']['src']?> 2x"
                                 alt="#">
                        </div>
                    </div>
                </div>
                <?php
                    $this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <div class="final-press__release-bottom video-container" id="<?=$this->GetEditAreaId($item['ID']);?>">
                    <?/*<a class="video-block__btn videoBtnJs" href="#">
                        <img class="img-responsive"
                             src="<?=$item['VIDEO_PRIVIEW']['src']?>" alt="#">
                    </a>*/?>
                    <div class="video-block<?/* video-hidden*/?>">
                        <iframe class="videoIframe" type="text/html"
                                src="<?=$item['VIDEO']?>"
                                frameborder="0" width="100%" height="315"
                                allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>