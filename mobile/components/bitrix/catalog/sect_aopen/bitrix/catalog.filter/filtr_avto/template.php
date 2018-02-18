<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get">
	<div id="cont_search">
	<?foreach($arResult["ITEMS"] as $arItem):
			
			
		if(array_key_exists("HIDDEN", $arItem)):
			echo $arItem["INPUT"];
		endif;
	endforeach;?>
	
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?if(!array_key_exists("HIDDEN", $arItem)):?>
			<? if($arItem["NAME"]=="Название")$arItem["NAME"]=""; else $arItem["NAME"].=":&nbsp;"; ?>
			
		
		
			<?=$arItem["INPUT"];?>
			<?endif?>
			
		<?endforeach;?>
	</div>
	<div style="float:left;">
	<input type="submit" name="set_filter" id="set_filter" class="search_button" value="<?=GetMessage("IBLOCK_SET_FILTER")?>" />
	</div>
	<div style="float:left;">
	<input type="hidden" name="set_filter" value="Y" />
	</div>
	<div style="float:left;">
	<input type="submit" name="del_filter" id="del_filter" class="search_button" value="<?=GetMessage("IBLOCK_DEL_FILTER")?>" />
	</div>	
</form>