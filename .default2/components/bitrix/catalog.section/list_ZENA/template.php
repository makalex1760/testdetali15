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
$admp=0;
foreach ($USER->GetParam("GROUPS") as $group_id) { if($group_id==13||$group_id==1) $admp=1;
	if ($group_id < 8 || $group_id==11) {
		continue;
	}
	$discount = $discounts[$group_id];
}

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
function addq(qu) {
// addquantity
    $.ajax({
        type: "POST",
        url: "/addq.php",
        data: {
            QUANTITY: qu,
               }
           });
}
function zak1(id,price){ // ловим клик по ссылки с id="go"
		//event.preventDefault(); // выключаем стандартную роль элемента
		
		var request_uri = location.pathname;	
	href0="/add2basket2.php?quantity=1&PRODUCT_ID="+id+"&dir="+request_uri+"&price="+price;
	href1="/add2basket2.php?quantity=1&PRODUCT_ID="+id+"&price="+price;	
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

	<table class="katalog" cellspacing="0" cellpadding="0"  width="100%">
		<thead style="background-color:#E2EEFC" >
			<tr >
				<th class="foto" ></th>
				<th><?=GetMessage("CATALOG_TITLE")?></th>
				<?if(count($arResult["ITEMS"]) > 0):
				foreach($arResult["ITEMS"][0]["DISPLAY_PROPERTIES"] as $arProperty):?>
				
				<?if($arProperty["CODE"]=="PRICE_BASE" || !isset($arProperty["NAME"]) ||  ($arProperty["CODE"]=="NALICHIE" && $admp) || ($arProperty["CODE"]=="OSTATOK" && $admp==0)) continue;?>
				<th class="prop"><?=$arProperty["NAME"]?></th>
				<?endforeach;
				endif;?>
				
				<?php
				if (is_array($discount)) {
				?>
				<th>Розничная<br>цена, руб</th>	
				<th>Ваша цена<br>(<?=$discount["NAME"]?>), руб</th>
				<?
				} else {
				?>
				<th>Цена, руб</th>
				<? } ?>
								
				
				
				<th align="center">Купить&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
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
					<a href="/img/<?=$arElement["DISPLAY_PROPERTIES"]["KOD_TOVAR"]["DISPLAY_VALUE"]?>.jpg" class="screenshot" rel="/img/<?=$arElement["DISPLAY_PROPERTIES"]["KOD_TOVAR"]["DISPLAY_VALUE"]?>.jpg">
					<img style="margin-bottom:0px" src="/upload/medialibrary/cff/icon-camera.png"></a>
					<?php } ?>
					<br>

					<?php
					$artikul = $arElement["PROPERTIES"]["ARTIKUL"]["VALUE"];
					/*if ($artikul != "") {
						$dbq = $db->Query("SELECT DISTINCT 
												partname.id, 
												partname.name, 
												partpicture.id as partid, 
												partpicture.idmodel, 
												partpicture.idgroup, 
												grouptree.groupname, 
												grouptree.groupnameen, 
												models.namefull, 
												models.nameshort, 
												models.idmark, 
												models.typeauto, 
												marks.namefull as markname, 
												marks.enameshort as mark_ename, 
												models.enameshort as model_ename 
											FROM 
												partname 
												LEFT JOIN partpicture 
													on partname.id = partpicture.partnameid 
												LEFT JOIN grouptree 
													on partpicture.idgroup = grouptree.groupno 
													and partpicture.idmodel = grouptree.idmodel 
												LEFT JOIN models on partpicture.idmodel = models.id 
												LEFT JOIN marks on models.idmark = marks.id 
											WHERE 
												partname.number LIKE '".mysql_escape_string($artikul)."' 
												and grouptree.groupno > 0
										");
										
						if (intval($dbq->SelectedRowsCount()) > 0) {                      
					
						?>
						<div class="drawings" title="<?=$arElement["NAME"]?>"></div>
						<div class="display_drawings" style="display: none;" align="left">
							<div class="white_block">
								<div class="content">
									<b>Посмотреть в каталогах запчастей:</b>
									<ul>
									<?php
									while ($row = $dbq->Fetch()) {
										print "<li>";
										print "<a href='/acat/".$row["mark_ename"]."/".$row["model_ename"]."/".$row["groupnameen"]."/#part".$row["partid"]."'>".$row["nameshort"]." / ".$row["groupname"]."</a>";
										print "</li>";
									}
									?>
									</ul>
								</div>
							</div>
						</div>
						<?php
						}
					} */?>
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
				<?if($arProperty["CODE"]=="PRICE_BASE" || !isset($arProperty["NAME"]) ||  ($arProperty["CODE"]=="NALICHIE" && $admp) || ($arProperty["CODE"]=="OSTATOK" && $admp==0)) continue;?>
				<?if($arProperty["CODE"]=="NALICHIE"): ?>
				<td class="prop" align="left">
				<? 
				//echo $arProperty["DISPLAY_VALUE"];
				switch(trim($arProperty["DISPLAY_VALUE"])){
			case "Есть":$tooltip_text="ул. Коминтерна д. 20/2";break;
			case "На складе":$tooltip_text="Доставка в течении 1-го рабочего дня";break;
			case "Нет":$tooltip_text="Нет в наличии";break;
			case "Под заказ":$tooltip_text="Сроки и цену уточняйте у менеджера";break;
			} ?>
			
<span class="tooltip" data-title="<?echo $tooltip_text;?>"><?=$arProperty["DISPLAY_VALUE"]?></span>
				</td>
				<? else: ?>
                
				<td class="prop" align="left">
					<?if(is_array($arProperty["DISPLAY_VALUE"]))
						echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
					elseif($arProperty["DISPLAY_VALUE"] === false)
						echo "&nbsp;";
					else
						echo $arProperty["DISPLAY_VALUE"];?>
				</td>
				<? endif ?>
				<?endforeach?>
				
				<?  
                    
                ?>
				<?php
				if (is_array($discount)) {
					$price = $arElement["PROPERTIES"][$discount["CODE"]]["VALUE"];
				?>

					<td align="left"><?=$arElement["PROPERTIES"]["PRICE_BASE"]["VALUE"]?></td>
					<td align="left"><b><?=$price?><b></td>
				
				<? } else { 
					$price = $arElement["PROPERTIES"]["PRICE_BASE"]["VALUE"];
				?> 
					<td class="prop" align="left"><?=$price?></td>
				<? } ?>				
				
				<td class="prop" align="left">
    				<?if(!$arElement["CAN_BUY"]):?>
						
							<input type="hidden" name="price" value="<?=$price?>" id="product_price<?=$arElement["ID"];?>">
							<input type="text" name="quantity" value="1" size="2" style="margin-right:5px;width: 35px;text-align:center;font-weight:bold;border:1px solid #ccc" id="product_quantity<?=$arElement["ID"];?>" onchange="addq(this.value)">
							&nbsp;<a  href="#" rel="nofollow"<?if($admp):?> class="tooltip" data-title="Спроси: Все ли заказано, и предложи сопутствующий товар и оформить заказ." onclick="add2basket(<?=$arElement["ID"];?>) <?else:?>
							onclick="zak1(<?=$arElement["ID"]?>,<?=$price?>)
							<? endif;?>
							"><i class="glyphicon glyphicon-shopping-cart" style="font-size:110%"> </i></a>&nbsp;&nbsp;
						
					<?elseif((count($arResult["PRICES"]) > 0) || is_array($arElement["PRICE_MATRIX"])):?>
						<?=GetMessage("CATALOG_NOT_AVAILABLE")?>
					<?endif?>
				</td>
		
			</tr>
		<?endforeach;?>
		</tbody>
	</table>
	<br/>
	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif?>
	
</div>

