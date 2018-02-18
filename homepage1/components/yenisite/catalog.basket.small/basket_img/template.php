<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div id ="market-basket">
    <h3><a href="<?=$arParams["BASKET_URL"]?>"><?=GetMessage("YENISITE_BASKET_NAME")?></a></h3>
    <ul>
        <li><?=GetMessage("YENISITE_BASKET_BASKET")?>:  <strong><?=$arResult["COMMON_COUNT"]?></strong></li>
        <li><?=GetMessage("YENISITE_BASKET_SUMM")?>:  <strong><?=$arResult["COMMON_PRICE"]?> <?=$arParams['VALUTA']?></strong></li>
    </ul>
</div>
