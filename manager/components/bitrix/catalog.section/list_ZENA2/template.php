<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<noindex><!-- tag for yandex -->
<? include $_SERVER["DOCUMENT_ROOT"]."/dev/abcd.php"; ?>
</noindex>

<?
$dbq_discounts = CIBlockElement::GetList(array(), array("IBLOCK_ID" => 11), false, array(), array("NAME", "PROPERTY_DISCOUNT", "PROPERTY_DISCOUNT_GROUP"));
while ($row = $dbq_discounts->Fetch()) {
	$discounts[$row["PROPERTY_DISCOUNT_GROUP_VALUE"]] = array("CODE"=>$row["PROPERTY_DISCOUNT_VALUE"], "NAME"=>$row["NAME"]);
}

//print_r($USER->GetUserGroupArray());
//print_r($USER->GetParam("GROUPS"));
foreach ($USER->GetParam("GROUPS") as $group_id) {  
	if ($group_id < 8 || $group_id==11) {
		continue;
	}
	$discount = $discounts[$group_id];
}
		$id_user=$USER->GetID();

?>


<?php

	require_once($_SERVER["DOCUMENT_ROOT"]."/acat/functions.php");
	require_once($_SERVER["DOCUMENT_ROOT"]."/acat/config/common.conf.php");
	require_once(AC_ROOT.'/classes/acat.class.php');
	
  	$acat = new acat;
  	$acat->db = $db;

?>


<script src="/img-rollover.js" type="text/javascript"></script>
<script>
function add2basket(ID) {
//    alert(ID + " / " + $("#product_quantity" + ID).val());]
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
function zak1(id,price){ // ловим клик по ссылки с id="go"
		//event.preventDefault(); // выключаем стандартную роль элемента
		
		var request_uri = location.pathname;	
	href0="/add2basket2.php?&PRODUCT_ID="+id+"&dir="+request_uri+"&price="+price;
	href1="/add2basket2.php?&PRODUCT_ID="+id+"&price="+price;	
		//tovar1=tovar+" добавлен в корзину";
		$('#modal_close').attr("href",href0);
		$('#modal_close1').attr("href",href1);
		//$('#tovar2').html(tovar1);
		$('#overlay').fadeIn(400, // сначала плавно показываем темную подложку
		 	function(){ // после выполнения предъидущей анимации
				$('#modal_form') 
					.css('display', 'block') // убираем у модального окна display: none;
					.animate({opacity: 1, top: '50%'}, 200); // плавно прибавляем прозрачность одновременно со съезжанием вниз
		});
	};
	/* Закрытие модального окна, тут делаем то же самое но в обратном порядке */
	$('#modal_close1,#modal_close, #overlay').click( function(){ // ловим клик по крестику или подложке
		$('#modal_form')
			.animate({opacity: 0, top: '45%'}, 200,  // плавно меняем прозрачность на 0 и одновременно двигаем окно вверх
				function(){ // после анимации
					$(this).css('display', 'none'); // делаем ему display: none;
					$('#overlay').fadeOut(400); // скрываем подложку
				}
			);
	});
//});
</script>
<style>
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
</style>

<div class="catalog-section">
	<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<p><?=$arResult["NAV_STRING"]?></p>
	<?endif?>

	<table class="data-table" cellspacing="0" cellpadding="0" border="0" width="100%">
		<thead>
			<tr>
				<td class="foto" >Фото</td>
				<td><?=GetMessage("CATALOG_TITLE")?></td>
				<?if(count($arResult["ITEMS"]) > 0):
				foreach($arResult["ITEMS"][0]["DISPLAY_PROPERTIES"] as $arProperty):?>
				
				<?if($arProperty["CODE"]=="PRICE_BASE" || !isset($arProperty["NAME"]) || $arProperty["CODE"]=="NALICHIE" ||  $arProperty["CODE"]=="DESCRIPTION" ) continue;?>
				<td class="prop"><?=$arProperty["NAME"]?></td>
				<?endforeach;
				endif;?>
				
				<?php
				if (is_array($discount)) {
				?>
				<td>Розничная<br>цена, руб</td>	
				<td>Ваша цена<br>(<?=$discount["NAME"]?>), руб</td>
				<?
				} else {
				?>
				<td>Цена, руб</td>
				<? } ?>
								
				
				
				<td align="center">Купить</td>
			</tr>
		</thead>
		<tbody>
		<?foreach($arResult["ITEMS"] as $arElement):?>
		<?
		$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
		?>
	
			<tr id="<?=$this->GetEditAreaId($arElement['ID']);?>">

				<td class="foto" width="30px" align="center" style="zoom:1">
					<?php if (file_exists($_SERVER["DOCUMENT_ROOT"]."/img/".$arElement["DISPLAY_PROPERTIES"]["KOD_TOVAR"]["DISPLAY_VALUE"].".jpg")) { ?>
					<a href="/img/<?=$arElement["DISPLAY_PROPERTIES"]["KOD_TOVAR"]["DISPLAY_VALUE"]?>.jpg" class="screenshot" rel="/img/<?=$arElement["DISPLAY_PROPERTIES"]["KOD_TOVAR"]["DISPLAY_VALUE"]?>.jpg"><img src="/upload/medialibrary/cff/icon-camera.png"></a>
					<?php } ?>
					<br>

					<?php
					$artikul = $arElement["PROPERTIES"]["ARTIKUL"]["VALUE"];
 ?>
				</td>
				<td>
				<?foreach($arElement["DISPLAY_PROPERTIES"] as $pid=>$arProperty) if($arProperty["CODE"]=="DESCRIPTION")$desc1=$arProperty["DISPLAY_VALUE"];?>
					<a class="tooltip" data-title="<?echo$desc1;?>" href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a>
					
					<?if(count($arElement["SECTION"]["PATH"])>0):?>
						<br />
						<?foreach($arElement["SECTION"]["PATH"] as $arPath):?>
							/ <a href="<?=$arPath["SECTION_PAGE_URL"]?>"><?=$arPath["NAME"]?></a>
						<?endforeach?>
					<?endif?>
				</td>
				
				<?foreach($arElement["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
				<?if($arProperty["CODE"]=="PRICE_BASE" || !isset($arProperty["NAME"]) ||  $arProperty["CODE"]=="NALICHIE" ||  $arProperty["CODE"]=="DESCRIPTION") continue;?>
				
				<td class="prop" align="right">
					<?if(is_array($arProperty["DISPLAY_VALUE"]))
						echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
					elseif($arProperty["DISPLAY_VALUE"] === false)
						echo "&nbsp;";
					else
						echo $arProperty["DISPLAY_VALUE"];?>
				</td>
				
				<?endforeach?>
				
				<?  
                    
                ?>
				<?php
				$quantity=1;
				if (is_array($discount)) {
					$price = $arElement["PROPERTIES"][$discount["CODE"]]["VALUE"];
				?>

					<td align="right"><?=$arElement["PROPERTIES"]["PRICE_BASE"]["VALUE"]?></td>
					<td align="right"><b><?=$price?><b></td>
				
				<? } else { 
					$price = $arElement["PROPERTIES"]["PRICE_BASE"]["VALUE"];
				?> 
					<td align="right"><?=$price?></td>
				<? } ?>				
				
				<td align="left" width="60">
    				<?if(!$arElement["CAN_BUY"]):?>
						<noindex>
							<input type="hidden" name="price" value="<?=$price?>" id="product_price<?=$arElement["ID"];?>">
							<input type="text" name="quantity" value="<?=$quantity?>" size="2" style="width: 25px;" id="product_quantity<?=$arElement["ID"];?>">
							<a  href="#" rel="nofollow" 
							 class="tooltip" data-title="Спроси: Все ли заказано, и предложи сопутствующий товар и оформить заказ." onclick="add2basket(<?=$arElement["ID"];?>) ">
								<img src="/upload/medialibrary/ebe/cart.png" alt="Положить в корзину" />
							</a>
						</noindex>
					<?elseif((count($arResult["PRICES"]) > 0) || is_array($arElement["PRICE_MATRIX"])):?>
						<?=GetMessage("CATALOG_NOT_AVAILABLE")?>
					<?endif?>&nbsp;
				</td>
		
			</tr>
		<?endforeach;?>
		</tbody>
	</table>

	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<p><?=$arResult["NAV_STRING"]?></p>
	<?endif?>
	
</div>

