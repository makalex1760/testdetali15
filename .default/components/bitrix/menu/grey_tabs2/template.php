<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<div class="grey-tabs-menu">
<ul>

<?
$i=0;
$count=0;
foreach($arResult as $arItem):
	if ($arItem["IS_PARENT"]):
		if ($arItem["DEPTH_LEVEL"] == 1):
			$i++;
		endif;
	endif;
endforeach;
?>

<?
$previousLevel = 0;
foreach($arResult as $arItem):?>
	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
		<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
	<?endif?>

	<?if ($arItem["IS_PARENT"]):?>

		<?if ($arItem["DEPTH_LEVEL"] == 1):?>
			<?$count++;?>
			<li><a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>selected<?else:?><?endif?>"><nobr><?=$arItem["TEXT"]?></nobr></a>
				<ul>
		<?else:?>
			<li<?if ($arItem["SELECTED"]):?> class="selected"<?endif?>><a href="<?=$arItem["LINK"]?>" class="parent"><nobr><?=$arItem["TEXT"]?></nobr></a>
				<ul <?if ($count==$i):?>class="left_menu"<?endif;?>>
		<?endif?>

	<?else:?>

		<?if ($arItem["PERMISSION"] > "D"):?>

			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
				<li><a href="<?=$arItem["LINK"]?>" class="<?if ($arItem["SELECTED"]):?>selected<?else:?><?endif?>"><nobr><?=$arItem["TEXT"]?></nobr></a></li>
			<?else:?>
				<li<?if ($arItem["SELECTED"]):?> class="selected"<?endif?>><nobr><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></nobr></a></li>
			<?endif?>

		<?else:?>

			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
				<li><a href="" class="<?if ($arItem["SELECTED"]):?>selected<?else:?><?endif?>" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
			<?else:?>
				<li><a href="" class="denied" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><nobr><?=$arItem["TEXT"]?></nobr></a></li>
			<?endif?>

		<?endif?>

	<?endif?>

	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>

<?endforeach?>

<?if ($previousLevel > 1)://close last item tags?>
	<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
<?endif?>

</ul>
</div>
<div style="clear: both;"></div>
<?endif?>