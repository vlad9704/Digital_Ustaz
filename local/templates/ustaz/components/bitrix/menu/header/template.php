<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?php if (!empty($arResult)):?>
	<div class="header-nav__block"><ul class="header-nav">
            <?php foreach($arResult as $arItem):?>
                <li class="header-nav__item<?=($arItem['CHILD']?' is-parent':'')?>">
                    <?php if ($arItem['CHILD']) { ?>
                        <a class="header-nav__link navDropdownJs" href="#"><span><?=$arItem["TEXT"]?></span></a>
                    <?php } elseif (mb_substr($arItem["LINK"],0, 2) == '/#' || mb_substr($arItem["LINK"],0, 5) == '/ru/#') { ?>
                        <a class="header-nav__link link-scroll scrollJsMenu" href="<?=$arItem["LINK"]?>" target="_self"><?=$arItem["TEXT"]?></a>
                    <?php } else { ?>
                        <a class="header-nav__link" href="<?=$arItem["LINK"]?>" target="_self"><?=$arItem["TEXT"]?></a>
                    <?php } ?>
                    <?php if($arItem['CHILD']):?>
                        <div class="header-nav__dropdown">
                            <ul class="nav-dropdown__list">
                                <?php foreach ($arItem['CHILD'] as $item):?>
                                    <li>
                                        <?php if (mb_substr($item["LINK"],0, 2) == '/#' || mb_substr($item["LINK"],0, 5) == '/ru/#') { ?>
                                            <a class="link-scroll scrollJsMenu header-nav__link" href="<?=$item["LINK"]?>" target="_self"><?=$item["TEXT"]?></a>
                                        <?php } else { ?>
                                            <a class="header-nav__link" href="<?=$item["LINK"]?>" target="_self"><?=$item["TEXT"]?></a>
                                        <?php } ?>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                        </div>
                    <?php endif;?>
                </li>
            <?php endforeach?>
	</ul></div>
<?php endif?>
