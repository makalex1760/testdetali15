<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<?php
for ($i=(count($arResult)-1); $i>=0; $i--) {
    if ($arResult[$i]["SELECTED"]==1) {
        $arResult[$i]["SUPERSELECTED"]=1;
        break;
    }
}
//print_r($arResult);$i=0;
?>


<ul class="list-group level1">
<?
$previousLevel = 0; $icon=0;
foreach($arResult as $arItem):
?>
	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
		<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
	<?endif?>
<?if($arItem["DEPTH_LEVEL"]==1) $icon++; ?>
	<?if ($arItem["IS_PARENT"]):  ?>
			<li class="list-group-item  level<?=$arItem["DEPTH_LEVEL"]?> <?if(!$arItem["SELECTED"] == 1)echo'closemenu';?> <?if($arItem["DEPTH_LEVEL"] == 1) echo"u".$icon;?>">
				<div class="folder" onClick="OpenMenuNode(this)"></div>
				<div class="item-text"><?  if($arItem["SUPERSELECTED"] == 1):?><b><?endif?><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a><?if($arItem["SUPERSELECTED"] == 1):?></b><?endif?></div>
				<ul>

	<?else:?>

		<?if ($arItem["PERMISSION"] > "D"):?>
				<li class="list-group-item  level<?=$arItem["DEPTH_LEVEL"]?> <?if($arItem["DEPTH_LEVEL"] == 1) echo"u".$icon;?>">
					<div class="page"></div>
					<div class="item-text"><?if($arItem["SUPERSELECTED"] == 1):?><b><?endif?><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a><?if($arItem["SUPERSELECTED"] == 1):?></b><?endif?></div>
				</li>
		<?endif?>

	<?endif?>

	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>

<?endforeach?>

<?if ($previousLevel > 1)://closemenu last item tags?>
	<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
<?endif?>

</ul>

<?endif?>