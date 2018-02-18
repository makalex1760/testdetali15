<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="catalog-section">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<p><?=$arResult["NAV_STRING"]?></p>
<?endif?>
<table class="data-table" cellspacing="0" cellpadding="5" border="0" width="100%">
	
	<?foreach($arResult["ITEMS"] as $arElement):?>
	<?
	$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
	?>
	<tr id="<?=$this->GetEditAreaId($arElement['ID']);?>" >
		<td class="row_dec">

<?if(!$arElement[PREVIEW_PICTURE][SRC]) $arElement[PREVIEW_PICTURE][SRC]="/images/nophoto.jpg";?>
<a  href="<?=$arElement[DETAIL_PAGE_URL]?>"   alt="<?=$arElement[PREVIEW_PICTURE][SRC]?>" ?><img src="<?=$arElement[PREVIEW_PICTURE][SRC]?>" width="100px" ></a>



		</td>		

		<td class="row_dec">
		<span class="name_elem_prop">		
			<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a>
			<?if(count($arElement["SECTION"]["PATH"])>0):?>
				<br />
				<?foreach($arElement["SECTION"]["PATH"] as $arPath):?>
					/ <a href="<?=$arPath["SECTION_PAGE_URL"]?>"><?=$arPath["NAME"]?></a>
				<?endforeach?>
			<?endif?>
		</span>	
		<span class="text_elem_prop">
		<?foreach($arElement["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
	
			<?if(is_array($arProperty["DISPLAY_VALUE"]))
				echo implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);
			elseif($arProperty["DISPLAY_VALUE"] === false)
				echo "&nbsp;";
			else
				{ if($arProperty["DISPLAY_VALUE"]) {echo"<br/>";echo $arProperty["NAME"]; echo":&nbsp;";echo $arProperty["DISPLAY_VALUE"];}}?>
		
		<?endforeach?>
		</span>
		</td>
<?// print_r($arResult); ?>
		<?foreach($arResult["PRICES"] as $code=>$arPrice):?>
		<td class="row_dec1">
			<?if($arPrice = $arElement["PRICES"][$code]):?>
				<?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
					<s><?=$arPrice["PRINT_VALUE"]?></s><br /><span class="catalog-price"><?=$arPrice["PRINT_DISCOUNT_VALUE"]?></span>
				<?else:?>
					<span class="catalog-price"><?=$arPrice["PRINT_VALUE"]?></span>
				<?endif?>
			<?else:?>
				&nbsp;
			<?endif;?>
<? switch($arElement["PROPERTIES"]["NALICHIE"]["VALUE"]){
			case "Есть":$tooltip_text="ул. Полярная, д. 18";break;
			case "Под заказ":$tooltip_text="Сроки уточнять у менеджера";break;
			case "Нет":$tooltip_text="Нет в наличии";break;
			case "Склад":$tooltip_text="Доставка в течении 1-го рабочего дня";break;
			} ?>
			
<br/><span class="tooltip" data-title="<?echo$tooltip_text;?>"><?=$arElement["PROPERTIES"]["NALICHIE"]["VALUE"]?></span>
		</td class="row_dec">
		<?endforeach;?>
		<?if(count($arResult["PRICES"]) > 0):?>
		<td class="row_dec2">
		
		<?if($arElement["CAN_BUY"]):?>
				<noindex>
				
				<a  class="basket_mini" href="<?echo $arElement["ADD_URL"]?>" rel="nofollow"></a>
				</noindex>
			<?elseif((count($arResult["PRICES"]) > 0) || is_array($arElement["PRICE_MATRIX"])):?>
				<?=GetMessage("CATALOG_NOT_AVAILABLE")?>
				<?$APPLICATION->IncludeComponent("bitrix:sale.notice.product", ".default", array(
							"NOTIFY_ID" => $arElement['ID'],
							"NOTIFY_URL" => htmlspecialcharsback($arElement["SUBSCRIBE_URL"]),
							"NOTIFY_USE_CAPTHA" => "N"
							),
							$component
						);?>
			<?endif?>
		
		
		</td>
		<?endif;?>
	</tr>
	<?endforeach;?>
</table>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<p><?=$arResult["NAV_STRING"]?></p>
<?endif?>
</div>
<div id="ajax-add-schema" style="display:none; width:200px; min-height:50px;text-align:center;margin-top: 25px;">
	 Товар добавлен в корзину
</div>
<script type="text/javascript">

BX.ready(function(){
   var schema = new BX.PopupWindow("schema", null, {
      content: BX('ajax-add-schema'),//Контейнер
      closeIcon: {right: "20px", top: "10px"},//Иконка закрытия
      titleBar: {content: BX.create("span", {html: '', 'props': {'className': 'access-title-bar'}})},//Название окна 
        zIndex: 0,
       
       
        draggable: {restrict: true},}); 
   $('.basket_mini').click(function(){

      schema.show("slow"); //отображение окна

   });
});

</script>