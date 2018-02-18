<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>

$(document).ready(function() {
	$(".add2basket").click(function() {
		ID = $(this).attr("rel");
		$.ajax({
			type: "POST",
			url: "/add2basket.php",
			data: {
				PRODUCT_ID: ID,
				QUANTITY: $("#product_quantity" + ID).val(),
				PRICE: $("#product_price" + ID).val()
			},
			success: function(msg){
				//alert(msg)
				location.reload()
			}
		});
	});
});
</script>
<h1><?$APPLICATION->ShowTitle("Запчасти ГАЗ");?> </h1>
<?
$dbq_discounts = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 11), false, array(), array("NAME", "PROPERTY_DISCOUNT", "PROPERTY_DISCOUNT_GROUP"));
while ($row = $dbq_discounts->Fetch()) {
	$discounts[$row["PROPERTY_DISCOUNT_GROUP_VALUE"]] = array("CODE"=>$row["PROPERTY_DISCOUNT_VALUE"], "NAME"=>$row["NAME"]);
}
foreach ($USER->GetParam("GROUPS") as $group_id) {  
	if ($group_id < 8) {
		continue;
	}
	$discount = $discounts[$group_id];
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

<div style="margin-top:30px; padding:30px 0px;background:#fff">
	
	
		<?if(is_array($arResult["PREVIEW_PICTURE"]) || is_array($arResult["DETAIL_PICTURE"])):?>
			<div id="foto_el">
				<?if(is_array($arResult["PREVIEW_PICTURE"]) && is_array($arResult["DETAIL_PICTURE"])):?>
					<img border="0" src="<?=$arResult["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arResult["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arResult["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" id="image_<?=$arResult["PREVIEW_PICTURE"]["ID"]?>" style="display:block;cursor:pointer;cursor: hand;" OnClick="document.getElementById('image_<?=$arResult["PREVIEW_PICTURE"]["ID"]?>').style.display='none';document.getElementById('image_<?=$arResult["DETAIL_PICTURE"]["ID"]?>').style.display='block'" />
					<img border="0" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" id="image_<?=$arResult["DETAIL_PICTURE"]["ID"]?>" style="display:none;cursor:pointer; cursor: hand;" OnClick="document.getElementById('image_<?=$arResult["DETAIL_PICTURE"]["ID"]?>').style.display='none';document.getElementById('image_<?=$arResult["PREVIEW_PICTURE"]["ID"]?>').style.display='block'" />
				<?elseif(is_array($arResult["DETAIL_PICTURE"])):?>
					<img border="0" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" />
				<?elseif(is_array($arResult["PREVIEW_PICTURE"])):?>
					<img border="0" src="<?=$arResult["PREVIEW_PICTURE"]["SRC"]?>" width="<?=$arResult["PREVIEW_PICTURE"]["WIDTH"]?>" height="<?=$arResult["PREVIEW_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" />
				<?endif?>
				<?if(count($arResult["MORE_PHOTO"])>0):?>
					<br /><a href="#more_photo"><?=GetMessage("CATALOG_MORE_PHOTO")?></a>
				<?endif;?>
			</div>
		<?endif;?>
			<div id="prop1">
			<? if (is_array($discount)) {
$price = $arResult["PROPERTIES"][$discount["CODE"]]["VALUE"];
?>
<span style="font-weight:bold; color:#017F01">Ваша цена (<?=$discount["NAME"]?>): <?=$arResult["PROPERTIES"][$discount["CODE"]]["VALUE"]?> руб.</span><br>
<font color="black" face="Tahoma" size="3"><i><b>Розничная цена: <?=$arResult["PROPERTIES"]["PRICE_BASE"]["VALUE"]?> руб.</b></i></font>
<? } else  {
$price = $arResult["PROPERTIES"]["PRICE_BASE"]["VALUE"];
?>

<span style="font-weight:bold; color:#017F01">Розничная цена: <span style="font-size:120%"><?=$arResult["PROPERTIES"]["PRICE_BASE"]["VALUE"]?> руб.</span></span>
<span class="price" style="display:none"><?=$arResult["PROPERTIES"]["PRICE_BASE"]["VALUE"]?> руб.</span>
<? } ?><br/>






			
		
			<?if(!$arResult["CAN_BUY"]):?>
			<?if($arParams["USE_PRODUCT_QUANTITY"] || count($arResult["PRODUCT_PROPERTIES"])):?>
				<!--<form action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data">-->
				<table id="4" border="0" cellspacing="0" cellpadding="8">
				<?if($arParams["USE_PRODUCT_QUANTITY"]):?>
					<tr valign="center">
						
						<td>
							<!--<input type="text" name="<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>" value="1" size="5">-->
                                                        <input type="text" name="quantity" value="1" size="2" style="font-weight:bold;text-align:center;width: 60px; height:33px" id="product_quantity<?=$arResult["ID"];?>">
						</td>
<td>
<p><input type="hidden" name="price" value="<?=$price?>" id="product_price<?=$arResult["ID"];?>">

<input type="button" class="c add2basket" style="border:0; background-color:#194A8C" rel="<?=$arResult["ID"]?>" value=" Добавить в корзину ">
</p>								
<!--<input type="submit" name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" value=" Добавить в корзину ">-->
</td>
<td>
<a class="c" href="/add2basket2.php?quantity=1&PRODUCT_ID=<?=$arResult["ID"]?>&price=<?=$price?>">Оформить заказ </a>
</td>
					</tr>
				<?endif;?>
				<?foreach($arResult["PRODUCT_PROPERTIES"] as $pid => $product_property):?>
										

					<tr valign="top">
					
						<td><?echo $arResult["PROPERTIES"][$pid]["NAME"]?>:</td>
						<td>
						<?if(
							$arResult["PROPERTIES"][$pid]["PROPERTY_TYPE"] == "L"
							&& $arResult["PROPERTIES"][$pid]["LIST_TYPE"] == "C"
						):?>
							<?foreach($product_property["VALUES"] as $k => $v):?>
								<label><input type="radio" name="<?echo $arParams["PRODUCT_PROPS_VARIABLE"]?>[<?echo $pid?>]" value="<?echo $k?>" <?if($k == $product_property["SELECTED"]) echo '"checked"'?>><?echo $v?></label><br>
							<?endforeach;?>
						<?else:?>
							<select name="<?echo $arParams["PRODUCT_PROPS_VARIABLE"]?>[<?echo $pid?>]">
								<?foreach($product_property["VALUES"] as $k => $v):?>
									<option value="<?echo $k?>" <?if($k == $product_property["SELECTED"]) echo '"selected"'?>><?echo $v?></option>
								<?endforeach;?>
							</select>
						<?endif;?>
						</td>

					</tr>
				<?endforeach;?>
				</table>
				<input type="hidden" name="<?echo $arParams["ACTION_VARIABLE"]?>" value="BUY">
				<input type="hidden" name="<?echo $arParams["PRODUCT_ID_VARIABLE"]?>" value="<?echo $arResult["ID"]?>">
				<!--<input type="submit" name="<?//echo $arParams["ACTION_VARIABLE"]."BUY"?>" value="<?//echo GetMessage("CATALOG_BUY")?>">-->
				
<!--				</form>-->
			<?else:?>
				<noindex>
				<!--<a href="<?//echo $arResult["BUY_URL"]?>" rel="nofollow"><?//echo GetMessage("CATALOG_BUY")?></a>-->
				&nbsp;<a href="<?echo $arResult["ADD_URL"]?>" rel="nofollow"><?echo GetMessage("CATALOG_ADD_TO_BASKET")?></a>
				</noindex>
			<?endif;?>
		<?elseif((count($arResult["PRICES"]) > 0) || is_array($arResult["PRICE_MATRIX"])):?>
			<?=GetMessage("CATALOG_NOT_AVAILABLE")?>
		<?endif?>
		
	
	<div style="clear:both"></div>
	<?if(is_array($arResult["OFFERS"]) && !empty($arResult["OFFERS"])):?>
		<?foreach($arResult["OFFERS"] as $arOffer):?>
			<?foreach($arParams["OFFERS_FIELD_CODE"] as $field_code):?>
				<small><?echo GetMessage("IBLOCK_FIELD_".$field_code)?>:&nbsp;<?
						echo $arOffer[$field_code];?></small><br />
			<?endforeach;?>
			<?foreach($arOffer["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
			
				<small><?=$arProperty["NAME"]?>:&nbsp;<?
					if(is_array($arProperty["DISPLAY_VALUE"]))
						echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
					else
						echo $arProperty["DISPLAY_VALUE"];?></small><br />
			
			<?endforeach?>
			<?foreach($arOffer["PRICES"] as $code=>$arPrice):?>
				<?if($arPrice["CAN_ACCESS"]):?>
					<p><?=$arResult["CAT_PRICES"][$code]["TITLE"];?>:&nbsp;&nbsp;
					<?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
						<s><?=$arPrice["PRINT_VALUE"]?></s> <span class="catalog-price"><?=$arPrice["PRINT_DISCOUNT_VALUE"]?></span>
					<?else:?>
						<span class="catalog-price"><?=$arPrice["PRINT_VALUE"]?></span>
					<?endif?>
					</p>
				<?endif;?>
			<?endforeach;?>
			<p>
			<?if($arParams["DISPLAY_COMPARE"]):?>
				<noindex>
				<a href="<?echo $arOffer["COMPARE_URL"]?>" rel="nofollow"><?echo GetMessage("CT_BCE_CATALOG_COMPARE")?></a>&nbsp;
				</noindex>
			<?endif?>
			<?if($arOffer["CAN_BUY"]):?>
				<?if($arParams["USE_PRODUCT_QUANTITY"]):?>
					<!--<form action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data">-->
					<table id="2" border="1" cellspacing="0" cellpadding="2">
						<tr valign="center">
							<td><?echo GetMessage("CT_BCE_QUANTITY")?>:</td>
							<td>
								<input type="text" name="<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>" value="1" size="5">
							</td>
<td>
<input type="submit" name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" value="<?echo GetMessage("CT_BCE_CATALOG_ADD")?>">
</td>
						</tr>
					</table>
					
					<input type="hidden" name="<?echo $arParams["ACTION_VARIABLE"]?>" value="BUY">
					<input type="hidden" name="<?echo $arParams["PRODUCT_ID_VARIABLE"]?>" value="<?echo $arOffer["ID"]?>">
					<!--<input type="submit" name="<?//echo $arParams["ACTION_VARIABLE"]."BUY"?>" value="<?//echo GetMessage("CATALOG_BUY")?>">-->
					
					<!--</form>-->
				<?else:?>
					<noindex>
					<a href="<?//echo $arOffer["BUY_URL"]?>" rel="nofollow"><?//echo GetMessage("CATALOG_BUY")?></a>
					&nbsp;<a href="<?echo $arOffer["ADD_URL"]?>" rel="nofollow"><?echo GetMessage("CT_BCE_CATALOG_ADD")?></a>
					</noindex>
				<?endif;?>
			<?elseif(count($arResult["CAT_PRICES"]) > 0):?>
				<?=GetMessage("CATALOG_NOT_AVAILABLE")?>
			<?endif?>
			</p>
		<?endforeach;?>
	<?else:?>
		<?foreach($arResult["PRICES"] as $code=>$arPrice):?>
			<?if($arPrice["CAN_ACCESS"]):?>
				<p><?=$arResult["CAT_PRICES"][$code]["TITLE"];?>&nbsp;
				<?if($arParams["PRICE_VAT_SHOW_VALUE"] && ($arPrice["VATRATE_VALUE"] > 0)):?>
					<?if($arParams["PRICE_VAT_INCLUDE"]):?>
						(<?echo GetMessage("CATALOG_PRICE_VAT")?>)
					<?else:?>
						(<?echo GetMessage("CATALOG_PRICE_NOVAT")?>)
					<?endif?>
				<?endif;?>:&nbsp;
				<?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
					<s><?=$arPrice["PRINT_VALUE"]?></s> <span class="catalog-price"><?=$arPrice["PRINT_DISCOUNT_VALUE"]?></span>
					<?if($arParams["PRICE_VAT_SHOW_VALUE"]):?><br />
						<?=GetMessage("CATALOG_VAT")?>:&nbsp;&nbsp;<span class="catalog-vat catalog-price"><?=$arPrice["DISCOUNT_VATRATE_VALUE"] > 0 ? $arPrice["PRINT_DISCOUNT_VATRATE_VALUE"] : GetMessage("CATALOG_NO_VAT")?></span>
					<?endif;?>
				<?else:?>
					<span class="catalog-price"><?=$arPrice["PRINT_VALUE"]?></span>
					<?if($arParams["PRICE_VAT_SHOW_VALUE"]):?><br />
						<?=GetMessage("CATALOG_VAT")?>:&nbsp;&nbsp;<span class="catalog-vat catalog-price"><?=$arPrice["VATRATE_VALUE"] > 0 ? $arPrice["PRINT_VATRATE_VALUE"] : GetMessage("CATALOG_NO_VAT")?></span>
					<?endif;?>
				<?endif?>
				</p>
			<?endif;?>
		<?endforeach;?>
		<?if(is_array($arResult["PRICE_MATRIX"])):?>
			<table id="1" cellpadding="0" cellspacing="0" border="0" width="100%" class="data-table">
			<thead>
			<tr>
				<?if(count($arResult["PRICE_MATRIX"]["ROWS"]) >= 1 && ($arResult["PRICE_MATRIX"]["ROWS"][0]["QUANTITY_FROM"] > 0 || $arResult["PRICE_MATRIX"]["ROWS"][0]["QUANTITY_TO"] > 0)):?>
					<td><?= GetMessage("CATALOG_QUANTITY") ?></td>
				<?endif;?>
				<?foreach($arResult["PRICE_MATRIX"]["COLS"] as $typeID => $arType):?>
					<td><?= $arType["NAME_LANG"] ?></td>
				<?endforeach?>
			</tr>
			</thead>
			<?foreach ($arResult["PRICE_MATRIX"]["ROWS"] as $ind => $arQuantity):?>
			<tr>
				<?if(count($arResult["PRICE_MATRIX"]["ROWS"]) > 1 || count($arResult["PRICE_MATRIX"]["ROWS"]) == 1 && ($arResult["PRICE_MATRIX"]["ROWS"][0]["QUANTITY_FROM"] > 0 || $arResult["PRICE_MATRIX"]["ROWS"][0]["QUANTITY_TO"] > 0)):?>
					<th nowrap>
						<?if(IntVal($arQuantity["QUANTITY_FROM"]) > 0 && IntVal($arQuantity["QUANTITY_TO"]) > 0)
							echo str_replace("#FROM#", $arQuantity["QUANTITY_FROM"], str_replace("#TO#", $arQuantity["QUANTITY_TO"], GetMessage("CATALOG_QUANTITY_FROM_TO")));
						elseif(IntVal($arQuantity["QUANTITY_FROM"]) > 0)
							echo str_replace("#FROM#", $arQuantity["QUANTITY_FROM"], GetMessage("CATALOG_QUANTITY_FROM"));
						elseif(IntVal($arQuantity["QUANTITY_TO"]) > 0)
							echo str_replace("#TO#", $arQuantity["QUANTITY_TO"], GetMessage("CATALOG_QUANTITY_TO"));
						?>
					</th>
				<?endif;?>
				<?foreach($arResult["PRICE_MATRIX"]["COLS"] as $typeID => $arType):?>
					<td>
						<?if($arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["DISCOUNT_PRICE"] < $arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["PRICE"])
							echo '<s>'.FormatCurrency($arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["PRICE"], $arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["CURRENCY"]).'</s> <span class="catalog-price">'.FormatCurrency($arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["DISCOUNT_PRICE"], $arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["CURRENCY"])."</span>";
						else
							echo '<span class="catalog-price">'.FormatCurrency($arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["PRICE"], $arResult["PRICE_MATRIX"]["MATRIX"][$typeID][$ind]["CURRENCY"])."</span>";
						?>
					</td>
				<?endforeach?>
			</tr>
			<?endforeach?>
			</table>
			<?if($arParams["PRICE_VAT_SHOW_VALUE"]):?>
				<?if($arParams["PRICE_VAT_INCLUDE"]):?>
					<small><?=GetMessage('CATALOG_VAT_INCLUDED')?></small>
				<?else:?>
					<small><?=GetMessage('CATALOG_VAT_NOT_INCLUDED')?></small>
				<?endif?>
			<?endif;?><br />
		<?endif?>

	<?endif?>
	
					<?
				usort($arResult["DISPLAY_PROPERTIES"], function($a, $b){    return ($a['SORT'] - $b['SORT']);});
				foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
				
				<?if($arProperty["CODE"] == "PRICE_BASE" || ($arProperty["CODE"] == "OSTATOK"&& $admp==0) ) continue; ?>
					
					<?=$arProperty["NAME"]?>:<span class="prop2" <? if($arProperty["CODE"]=='NALICHIE'){
						switch(trim($arProperty["VALUE"])){
						case 'Нет': echo("style='font-weight:bold; color:red'"); break;
						case 'Есть': echo ("style='font-weight:bold; color:green'"); break;
						case 'На складе': echo "style='color:green'"; break;
						default:break;
					}; }
					?> >&nbsp;<b><?	echo $arProperty["DISPLAY_VALUE"];?></b>
					</span><br />
				<?endforeach?>
	
	
	</div>
	<div style="clear:both;padding-left:30px">
	<?if($arResult["DETAIL_TEXT"]):?>
		<br /><span class="fn brand category"><?=$arResult["DETAIL_TEXT"]?></span><br />
	<?elseif($arResult["PREVIEW_TEXT"]):?>
		<br /><?=$arResult["PREVIEW_TEXT"]?><br />
	<?endif;?>
	<?if(count($arResult["LINKED_ELEMENTS"])>0):?>
		<br /><b><?=$arResult["LINKED_ELEMENTS"][0]["IBLOCK_NAME"]?>:</b>
		<ul>
	<?foreach($arResult["LINKED_ELEMENTS"] as $arElement):?>
		<li><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a></li>
	<?endforeach;?>
		</ul>
	<?endif?>
	<?
	// additional photos
	$LINE_ELEMENT_COUNT = 2; // number of elements in a row
	if(count($arResult["MORE_PHOTO"])>0):?>
		<a name="more_photo"></a>
		<?foreach($arResult["MORE_PHOTO"] as $PHOTO):?>
			<img border="0" src="<?=$PHOTO["SRC"]?>" width="<?=$PHOTO["WIDTH"]?>" height="<?=$PHOTO["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>" title="<?=$arResult["NAME"]?>" /><br />
		<?endforeach?>
	<?endif?>
	<?if(is_array($arResult["SECTION"])):?>
	         <!-- <br /><a href="<?=$arResult["SECTION"]["SECTION_PAGE_URL"]?>"><?=GetMessage("CATALOG_BACK")?></a> -->
	<?endif?>
	<br/>
	<a id="back1" href="<?=substr($_SERVER[PHP_SELF],0,-10);?>" >Назад в раздел</a>
	</div>	
</div>