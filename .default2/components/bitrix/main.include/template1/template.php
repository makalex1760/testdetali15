<[tabsection]> 
<[tab name="Описание раздела" access=""]> 
<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if($arResult["FILE"] <> '')
	include($arResult["FILE"]);
?>   
<[tab name="Поиск по разделу" access=""]> 

<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.filter",
	"template_new",
	Array(
		"IBLOCK_TYPE" => "gaz",
		"IBLOCK_ID" => "75",
		"FILTER_NAME" => "arrFilter",
		"FIELD_CODE" => array(0=>"NAME",1=>"",),
		"PROPERTY_CODE" => array(0=>"",1=>"",),
		"LIST_HEIGHT" => "5",
		"TEXT_WIDTH" => "50",
		"NUMBER_WIDTH" => "5",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "N",
		"SAVE_IN_SESSION" => "N",
		"PRICE_CODE" => array()
	)
);?>
 
<[tab name="Поиск по ключевым словам" access=""]> 
<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if($arResult["FILE"] <> '')
	include($arResult["FILE"]);
?>

<[/tabsection]> 
<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if($arResult["FILE"] <> '')
	include($arResult["FILE"]);
?>
