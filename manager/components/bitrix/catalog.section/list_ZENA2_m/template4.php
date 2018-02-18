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
$admp=0;
switch($id_user)
{

case 558: $id_user=8; $admp=1; break;	
case 2035: $id_user=12; $admp=1; break;	
case 1886: $id_user=20;$admp=1; break;	
case 2021: $id_user=18;$admp=1; break;
case 2020: $id_user=60;$admp=1; break;
case 1888: $id_user=28;$admp=1; break;
 default: $id_user=42;	break;
}
//print_r($USER->GetParam("GROUPS")); 
//print_r("test");
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
				<td class="foto">Фото</td>
				<td><?=GetMessage("CATALOG_TITLE")?></td>
				<?if(count($arResult["ITEMS"]) > 0):
				foreach($arResult["ITEMS"][0]["DISPLAY_PROPERTIES"] as $arProperty):?>
				<?if($arProperty["CODE"]=="PRICE_BASE" || !isset($arProperty["NAME"]) ||  ($arProperty["CODE"]=="NALICHIE" && $admp) || ($arProperty["CODE"]=="OSTATOK" && $admp==0)) continue;?>
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
					<a href="/img/<?=$arElement["DISPLAY_PROPERTIES"]["KOD_TOVAR"]["DISPLAY_VALUE"]?>.jpg" class="screenshot" rel="/img/<?=$arElement["DISPLAY_PROPERTIES"]["KOD_TOVAR"]["DISPLAY_VALUE"]?>.jpg"><img src="//detali15.ru/upload/medialibrary/cff/icon-camera.png"></a>
					<?php } ?>
					<br>

					<?php
					$artikul = $arElement["PROPERTIES"]["ARTIKUL"]["VALUE"];
					
					if ($artikul!="" && $db ) {
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
					} ?>
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
				<?if($arProperty["CODE"]=="PRICE_BASE" || !isset($arProperty["NAME"]) || ($arProperty["CODE"]=="NALICHIE" && $admp) || ($arProperty["CODE"]=="OSTATOK" && $admp==0)) continue;?>
				<?if($arProperty["CODE"]=="NALICHIE"): ?>
				<td class="prop" align="right">
				<? switch($arProperty["DISPLAY_VALUE"]){
			case "Есть":$tooltip_text="ул. Коминтерна д. 20/2";break;
			case "Склад":$tooltip_text="Доставка в течении 1-го рабочего дня";break;
			case "Нет":$tooltip_text="Нет в наличии";break;
			case "Под заказ":$tooltip_text="Сроки уточнять у менеджера";break;
			} ?>
			
<span class="tooltip" data-title="<?echo$tooltip_text;?>"><?=$arProperty["DISPLAY_VALUE"]?></span>
				</td>
				<? else: ?>
                
				<td class="prop" align="right">
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

					<td align="right"><?=$arElement["PROPERTIES"]["PRICE_BASE"]["VALUE"]?></td>
					<td align="right"><b><?=$price?><b></td>
				
				<? } else { 
					$price = $arElement["PROPERTIES"]["PRICE_BASE"]["VALUE"];
				?> 
					<td align="right"><?=$price?></td>
				<? } ?>				
				
				<td align="center" width="60">
    				<?if(!$arElement["CAN_BUY"]):?>
						<noindex>
							<input type="hidden" name="price" value="<?=$price?>" id="product_price<?=$arElement["ID"];?>">
							<input class="prop" type="text" name="quantity" value="1" size="2" style="width: 25px;" id="product_quantity<?=$arElement["ID"];?>">
							<a href="#add" rel="nofollow" onclick="add2basket(<?=$arElement["ID"];?>)">
								<img src="//detali15.ru/upload/medialibrary/ebe/cart.png" alt="Положить в корзину" />
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