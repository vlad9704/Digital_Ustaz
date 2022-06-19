<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
	<div class="footer-content__links">
		<?foreach($arResult as $arItem):?>
			<? $i++; ?>
			<? if ($i >1) echo ' и '?><a href="<?=$arItem["LINK"]?>" target="_self"><?=$arItem["TEXT"]?></a> 
		<?endforeach?>
	</div>
<?endif?>
