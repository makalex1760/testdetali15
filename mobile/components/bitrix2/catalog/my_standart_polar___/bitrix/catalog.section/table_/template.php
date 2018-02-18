<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
$templateData = array(
		'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
		'TEMPLATE_CLASS' => 'bx_'.$arParams['TEMPLATE_THEME']
	);

	CJSCore::Init(array("popup")); ?>
<div class="catalog-section">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<p><?=$arResult["NAV_STRING"]?></p>
<?endif?>
<table class="data-table" cellspacing="0" cellpadding="5" border="0" width="100%">
	
	<?foreach($arResult["ITEMS"] as $arElement):?>
	<?
	$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
	$strMainID = $this->GetEditAreaId($arElement['ID']);

	$arItemIDs = array(
		'ID' => $strMainID,
		'PICT' => $strMainID.'_pict',
		'SECOND_PICT' => $strMainID.'_secondpict',

		'QUANTITY' => $strMainID.'_quantity',
		'QUANTITY_DOWN' => $strMainID.'_quant_down',
		'QUANTITY_UP' => $strMainID.'_quant_up',
		'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
		'BUY_LINK' => $strMainID.'_buy_link',
		'SUBSCRIBE_LINK' => $strMainID.'_subscribe',

		'PRICE' => $strMainID.'_price',
		'DSC_PERC' => $strMainID.'_dsc_perc',
		'SECOND_DSC_PERC' => $strMainID.'_second_dsc_perc',

		'PROP_DIV' => $strMainID.'_sku_tree',
		'PROP' => $strMainID.'_prop_',
		'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
		'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
	);
	
	$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
	
	
	
	
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
			case "есть в наличии":$tooltip_text="ул. Полярная, д. 18";break;
			case "на складе":$tooltip_text="Доставка в течении 1-го рабочего дня";break;
			case "нет в наличии":$tooltip_text="Нет в наличии";break;
			} ?>
			
<br/><span class="tooltip" data-title="<?echo$tooltip_text;?>"><?=$arElement["PROPERTIES"]["NALICHIE"]["VALUE"]?></span>
		</td class="row_dec">
		<?endforeach;?>
		<?if(count($arResult["PRICES"]) > 0):?>
		<td class="row_dec2">
		<?
		if ('Y' == $arParams['PRODUCT_DISPLAY_MODE'])
		{
			?>
		<div class="bx_catalog_item_controls no_touch">
			
		<div class="bx_catalog_item_controls_blockone">
			<a id="<? echo $arItemIDs['QUANTITY_DOWN']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">-</a>
			<input type="text" class="bx_col_input" id="<? echo $arItemIDs['QUANTITY']; ?>" name="<? echo $arParams["PRODUCT_QUANTITY_VARIABLE"]; ?>" value="<? echo $arElement['CATALOG_MEASURE_RATIO']; ?>">
			<a id="<? echo $arItemIDs['QUANTITY_UP']; ?>" href="javascript:void(0)" class="bx_bt_button_type_2 bx_small" rel="nofollow">+</a>
			<span id="<? echo $arItemIDs['QUANTITY_MEASURE']; ?>"></span>
		</div>
			<?
			}
			?>
		<div class="bx_catalog_item_controls_blocktwo">
			<a id="<? echo $arItemIDs['BUY_LINK']; ?>" class="bx_bt_button bx_medium" href="javascript:void(0)" rel="nofollow"><?
			echo ('' != $arParams['MESS_BTN_BUY'] ? $arParams['MESS_BTN_BUY'] : GetMessage('CT_BCS_TPL_MESS_BTN_BUY'));
			?></a>
		</div>
				<div style="clear: both;"></div>
			</div>
		
		</td>
		<?endif;?>
	
		<?	$arJSParams = array(
			'PRODUCT_TYPE' => $arElement['CATALOG_TYPE'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_ADD_BASKET_BTN' => false,
			'SHOW_BUY_BTN' => true,
			'SHOW_ABSENT' => true,
			'PRODUCT' => array(
				'ID' => $arElement['ID'],
				'NAME' => $arElement['~NAME'],
				'PICT' => ('Y' == $arElement['SECOND_PICT'] ? $arElement['PREVIEW_PICTURE_SECOND'] : $arElement['PREVIEW_PICTURE']),
				'CAN_BUY' => $arElement["CAN_BUY"],
				'SUBSCRIPTION' => ('Y' == $arElement['CATALOG_SUBSCRIPTION']),
				'CHECK_QUANTITY' => $arElement['CHECK_QUANTITY'],
				'MAX_QUANTITY' => $arElement['CATALOG_QUANTITY'],
				'STEP_QUANTITY' => $arElement['CATALOG_MEASURE_RATIO'],
				'QUANTITY_FLOAT' => is_double($arElement['CATALOG_MEASURE_RATIO']),
				'ADD_URL' => $arElement['~ADD_URL'],
				'SUBSCRIBE_URL' => $arElement['~SUBSCRIBE_URL']
			),
			'BASKET' => array(
				'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),
				'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
				'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
				'EMPTY_PROPS' => $emptyProductProperties
			),
			'VISUAL' => array(
				'ID' => $arItemIDs['ID'],
				'PICT_ID' => ('Y' == $arElement['SECOND_PICT'] ? $arItemIDs['SECOND_PICT'] : $arItemIDs['PICT']),
				'QUANTITY_ID' => $arItemIDs['QUANTITY'],
				'QUANTITY_UP_ID' => $arItemIDs['QUANTITY_UP'],
				'QUANTITY_DOWN_ID' => $arItemIDs['QUANTITY_DOWN'],
				'PRICE_ID' => $arItemIDs['PRICE'],
				'BUY_ID' => $arItemIDs['BUY_LINK'],
				'BASKET_PROP_DIV' => $arItemIDs['BASKET_PROP_DIV']
			),
			'LAST_ELEMENT' => $arElement['LAST_ELEMENT']
		);
		unset($emptyProductProperties); ?>
	<script type="text/javascript">
var <? echo $strObName; ?> = new JCCatalogSection(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
</script>
</tr>
	<?endforeach;?>
</table>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<p><?=$arResult["NAV_STRING"]?></p>
<?endif?>
</div>
<script type="text/javascript">
BX.message({
	MESS_BTN_BUY: '<? echo ('' != $arParams['MESS_BTN_BUY'] ? CUtil::JSEscape($arParams['MESS_BTN_BUY']) : GetMessageJS('CT_BCS_TPL_MESS_BTN_BUY')); ?>',
	MESS_BTN_ADD_TO_BASKET: '<? echo ('' != $arParams['MESS_BTN_ADD_TO_BASKET'] ? CUtil::JSEscape($arParams['MESS_BTN_ADD_TO_BASKET']) : GetMessageJS('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET')); ?>',
	MESS_NOT_AVAILABLE: '<? echo ('' != $arParams['MESS_NOT_AVAILABLE'] ? CUtil::JSEscape($arParams['MESS_NOT_AVAILABLE']) : GetMessageJS('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE')); ?>',
	BTN_MESSAGE_BASKET_REDIRECT: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_BASKET_REDIRECT'); ?>',
	BASKET_URL: '<? echo $arParams["BASKET_URL"]; ?>',
	ADD_TO_BASKET_OK: '<? echo GetMessageJS('ADD_TO_BASKET_OK'); ?>',
	TITLE_ERROR: '<? echo GetMessageJS('CT_BCS_CATALOG_TITLE_ERROR') ?>',
	TITLE_BASKET_PROPS: '<? echo GetMessageJS('CT_BCS_CATALOG_TITLE_BASKET_PROPS') ?>',
	TITLE_SUCCESSFUL: '<? echo GetMessageJS('ADD_TO_BASKET_OK'); ?>',
	BASKET_UNKNOWN_ERROR: '<? echo GetMessageJS('CT_BCS_CATALOG_BASKET_UNKNOWN_ERROR') ?>',
	BTN_MESSAGE_SEND_PROPS: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_SEND_PROPS'); ?>',
	BTN_MESSAGE_CLOSE: '<? echo GetMessageJS('CT_BCS_CATALOG_BTN_MESSAGE_CLOSE') ?>'
});
</script>