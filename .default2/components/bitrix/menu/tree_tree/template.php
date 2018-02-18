<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):
ob_start();
?>

<table cellpadding=0 cellspacing=0 width=100%>

<?$previousLevel = 0;$first=1;foreach($arResult as $arItem):?>

<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
<?=str_repeat("</ul></td></tr>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
<?endif?>

<?=(!$first && ($arItem["DEPTH_LEVEL"]==1))?'<tr><td class="cherta"></td></tr>':''?>

<?if ($arItem["IS_PARENT"]):?>
<!--<? if (($arItem["SELECTED"]) && ($arItem["DEPTH_LEVEL"]==1)) { ?> <li class="cherta"></li> <?php } ?>-->
<tr>
<td class="<?=(!$arItem["SELECTED"])?'close':''?>"><?
if ($arItem["SELECTED"]) { ?><?
if ($arItem["DEPTH_LEVEL"]==1) { ?>

<img src="/images/folder_open.gif"> <?=$arItem["TEXT"]?>

<?php
} else { ?>

<img src="/images/folder_open.gif"> <?=$arItem["TEXT"]?>

<?php
} ?><?php } else { ?><? if ($arItem["DEPTH_LEVEL"]==1) { ?>

<img src="/images/folder_open.gif"> <a onClick="return OpenMenuNode(this)" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
<?php } else
{ ?>

<img src="/images/folder_open.gif"> <a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
<?php
} ?><?php
} ?>
<? $first = true; ?>
<ul class=l_menu_ul>
<?else:?>
<?if ($arItem["PERMISSION"] > "D"):?>
<? $first = false; ?>
<?if ($arItem["SELECTED"]) { ?>
<? if ($arItem["DEPTH_LEVEL"]==1)
{ ?>

<tr><td><table cellpadding=0 cellspacing=0 class="left_menu_act">
<tr><td><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></td></tr>
</table></td></tr>

<?php
} else
{ ?>

<li class="act"><img src="/images/folder_open.gif"> <a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li><?php
} ?><?php
} else { ?><?
if ($arItem["DEPTH_LEVEL"]==1)
{ ?>

<tr>
<td><img src="/images/folder_close.gif"> <a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></td>
</tr>

<?php
} else
{ ?>

<li><img src="/images/folder_open.gif"> <a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li><?php


} ?>
<?php } ?>
<?endif?>
<?endif?>

<?$previousLevel = $arItem["DEPTH_LEVEL"];?>

<?endforeach?>

<?if ($previousLevel > 1)://close last item tags?>
<?=str_repeat("</ul></td></tr>", ($previousLevel-1) );?>
<?endif?>


<?endif ?>

</table>

<?php
$menu_content = ob_get_clean();
//$menu_content = str_replace("\n",'', preg_replace("/\s{2,}/",'', $menu_content));
echo $menu_content;
?>