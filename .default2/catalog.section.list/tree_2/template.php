<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="catalog-section-list">
<ul>
<?
$CURRENT_DEPTH=$arResult["SECTION"]["DEPTH_LEVEL"]+1;

foreach($arResult["SECTIONS"] as $arSection):

if($CURRENT_DEPTH<$arSection["DEPTH_LEVEL"])

echo "<ul>";

elseif($CURRENT_DEPTH>$arSection["DEPTH_LEVEL"])

echo str_repeat("</ul>", $CURRENT_DEPTH - $arSection["DEPTH_LEVEL"]);

$CURRENT_DEPTH = $arSection["DEPTH_LEVEL"];

?>

<li>

 <? if ($arSection["PICTURE"]["SRC"]){?><img src="<?=$arSection["PICTURE"]["SRC"]?>" title="<?=$arSection["NAME"]?>" border="0"/><br><?}?>

<a href="<?=$arSection["SECTION_PAGE_URL"]?>"><?=$arSection["NAME"]?><?if($arParams["COUNT_ELEMENTS"]):?> (<?=$arSection["ELEMENT_CNT"]?>)<?endif;?></a></li>

<?endforeach?>

</ul>

</div> 

<?=($strTitle?'<br/><h2>'.$strTitle.'</h2>':'')?>
