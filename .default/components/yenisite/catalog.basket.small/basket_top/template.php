<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?php
$dbq = CIBlockElement::GetList(
array("PROPERTY_DISCOUNT"=>"ASC"), 
array("IBLOCK_ID"=>11), 
false, 
false, 
array("NAME", "PROPERTY_DISCOUNT_GROUP", "PROPERTY_DISCOUNT")
);

$discounts = array();
while ($row=$dbq->Fetch()) {
    $discounts[$row["PROPERTY_DISCOUNT_GROUP_VALUE"]] = $row["PROPERTY_DISCOUNT_VALUE"];
}
$id_user=$USER->GetID();
$admp=0;
switch($id_user)
{

case 558: $id_user=8; $admp=1; break;	
case 2035: $id_user=12; $admp=1; break;	
case 1886: $id_user=20;$admp=1; break;	
case 2021: $id_user=18;$admp=1; break;
case 2020: $id_user=60;$admp=1; break;
case 1888: $id_user=28;$admp=1; break;
case 2394: $id_user=87;$admp=1; break;
 default: $id_user=42;	break;
}
?>

<?php

if (count(array_intersect($USER->GetUserGroupArray(), array_keys($discounts))) > 0) {
    $discount_ids = array_intersect($USER->GetUserGroupArray(), array_keys($discounts));
    $discount_id = array_shift($discount_ids);
    $isCompany = True;
} else {
    $isCompany = False;
}

//print $discount_id."\n";
$discount_code = $discounts[$discount_id];
?>
<?php 
$total_price = 0;
$total_discount = 0;
$total_count = 0;
?>

<?foreach($arResult["ITEMS"] as $arItem):?>


<?php



if (isset($discount_code)) {
$dbq = CIBlockElement::GetProperty(6, $arItem["ID"], array("SORT"=>"ASC"), array("CODE"=>$discount_code));
$r = $dbq->Fetch();
$price = $r["VALUE"];
  //$price = $arItem["MIN_PRICE"];
} else {
$dbq = CIBlockElement::GetProperty(6, $arItem["ID"], array("SORT"=>"ASC"), array("CODE"=>"PRICE_BASE"));
$r = $dbq->Fetch();
$price = $r["VALUE"];
}
?>

<?php 

$line_price = $price*$arItem["COUNT"];
if($_REQUEST["PROPERTY"]['sk5'])$line_price=ceil($line_price*95/100); 
$total_price += $line_price;
$total_count += $arItem["COUNT"];

?> 
        <?endforeach?> 
<?if($admp) { $tooltip='tooltip'; $help="Спроси: Все ли заказано, и предложи сопутствующий товар и оформить заказ."; } ?>
<a  class="<?=$tooltip?>" data-title="<?=$help?>" href="<?=$arParams["BASKET_URL"]?>" rel=nofollow ><?=GetMessage("YENISITE_BASKET_NAME")?>
<?=GetMessage("YENISITE_BASKET_BASKET")?>:  <strong><?=$total_count?></strong>
<?=GetMessage("YENISITE_BASKET_SUMM")?>:  <strong><?=$total_price?> <?=$arParams['VALUTA']?></strong>
</a>
 