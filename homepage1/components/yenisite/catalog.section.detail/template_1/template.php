<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?//print_r($arResult);
if(is_array($arResult)):
?>
<div class="catalog-section-detail">
<h1><?=$arResult["NAME"]?></h1>
<br />
<?=$arResult["DESCRIPTION"]?>
<br />
<img border="0" src="<?=$arResult["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arResult["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arResult["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arResult["NAME"]?>" />
<br />
<img border="0" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>" title="<?=$arResult["NAME"]?>" />
<?endif;?>
</div>
