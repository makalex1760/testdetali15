<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="/img-rollover.js" type="text/javascript"></script>
<script>
function add2basket(ID) {
//    alert(ID + " / " + $("#product_quantity" + ID).val());]
    $.ajax({
        type: "POST",
        url: "/add2basket.php",
        data: {
            PRODUCT_ID: ID,
            QUANTITY: $("#product_quantity" + ID).val()
        },
        success: function(msg){
            //alert(msg)
            location.reload()
        }
    });
}

$(document).ready(function() {
$('.display_drawings').bind("mouseleave",function(){
        $(this).hide();
    });
$('.display_drawings').bind("click",function(){
        $(this).hide();
    });
    
	$(' .drawings').bind("mouseenter",function(){
		
		$(this).next('.display_drawings').show().parent().css({zoom:1});
		$(this).find('.display_drawings').show().parent().css({zoom:1});
	});
});
</script>
<style>
/*  */



#screenshot{

	position:absolute;

	border:1px solid #ccc;

	background:#333;

	padding:5px;

	display:none;

	color:#fff;

	}
.display_drawings {
position: absolute;
width: 600px;
background: #ffffff;
border: solid 1px black;
padding: 0.5em;
margin-top: -20px;
}
.drawings {
width: 14px;
height: 14px;
background: url('/grids.gif');
}

/*  */
</style>
<div class="catalog-section">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<p><?=$arResult["NAV_STRING"]?></p>
<?endif?>



<table class="data-table" cellspacing="0" cellpadding="0" border="0" width="100%">
	<thead>
	<tr>

<td>Фото</td>

		<td><?=GetMessage("CATALOG_TITLE")?></td>
		<?if(count($arResult["ITEMS"]) > 0):
			foreach($arResult["ITEMS"][0]["DISPLAY_PROPERTIES"] as $arProperty):?>
				<td><?=$arProperty["NAME"]?></td>
			<?endforeach;
		endif;?>
		<?foreach($arResult["PRICES"] as $code=>$arPrice):?>
			<td><?=$arPrice["TITLE"]?></td>
		<?endforeach?>
		<?if(count($arResult["PRICES"]) > 0):?>
			<td>&nbsp;</td>
		<?endif?>
		<td align="center">
		Купить
		</td>
	</tr>
	</thead>
	<?foreach($arResult["ITEMS"] as $arElement):?>
	<?
	$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
	?>
	<tr id="<?=$this->GetEditAreaId($arElement['ID']);?>">

<td width="30px" align="center" style="zoom:1">
<?php if (file_exists($_SERVER["DOCUMENT_ROOT"]."/img/".$arElement["DISPLAY_PROPERTIES"]["KOD_TOVAR"]["DISPLAY_VALUE"].".jpg")) { ?>
<a href="/img/<?=$arElement["DISPLAY_PROPERTIES"]["KOD_TOVAR"]["DISPLAY_VALUE"]?>.jpg" class="screenshot" rel="/img/<?=$arElement["DISPLAY_PROPERTIES"]["KOD_TOVAR"]["DISPLAY_VALUE"]?>.jpg"><img src="//detali15.ru/upload/medialibrary/cff/icon-camera.png"></a>
<?php } ?>

</td>
		<td>
			<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a>
			<?if(count($arElement["SECTION"]["PATH"])>0):?>
				<br />
				<?foreach($arElement["SECTION"]["PATH"] as $arPath):?>
					/ <a href="<?=$arPath["SECTION_PAGE_URL"]?>"><?=$arPath["NAME"]?></a>
				<?endforeach?>
			<?endif?>
		</td>
		<?foreach($arElement["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
		<td  align="right">
			<?if(is_array($arProperty["DISPLAY_VALUE"]))
				echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
			elseif($arProperty["DISPLAY_VALUE"] === false)
				echo "&nbsp;";
			else
				echo $arProperty["DISPLAY_VALUE"];?>
		</td>
		<?endforeach?>
		<?foreach($arResult["PRICES"] as $code=>$arPrice):?>
		<td  align="right">
			<?if($arPrice = $arElement["PRICES"][$code]):?>
				<?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
					<s><?=$arPrice["PRINT_VALUE"]?></s><br /><span class="catalog-price"><?=$arPrice["PRINT_DISCOUNT_VALUE"]?></span>
				<?else:?>
					<span class="catalog-price"><?=$arPrice["PRINT_VALUE"]?></span>
				<?endif?>
			<?else:?>
				&nbsp;
			<?endif;?>
		</td>
		<?endforeach;?>
		<?//if(count($arResult["PRICES"]) > 0):?>
		<td align="left" width="60">


			<?if(!$arElement["CAN_BUY"]):?>
				<noindex>
				<input type="text" name="quantity" value="1" size="2" style="width: 30px;" id="product_quantity<?=$arElement["ID"];?>">
				<a href="#add" rel="nofollow" onclick="add2basket(<?=$arElement["ID"];?>)"><img src="//detali15.ru/upload/medialibrary/ebe/cart.png" alt="Положить в корзину" /></a></noindex>
			<?elseif((count($arResult["PRICES"]) > 0) || is_array($arElement["PRICE_MATRIX"])):?>
				<?=GetMessage("CATALOG_NOT_AVAILABLE")?>
			<?endif?>&nbsp;
		</td>
		<?//endif;?>
	</tr>
	<?endforeach;?>
</table>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<p><?=$arResult["NAV_STRING"]?></p>
<?endif?>
</div>