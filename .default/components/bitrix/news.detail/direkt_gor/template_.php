<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="news-detail">
	<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arResult["DETAIL_PICTURE"])):?>
		<img class="detail_picture" border="0" src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>" width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>" height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>" alt="<?=$arResult["NAME"]?>"  title="<?=$arResult["NAME"]?>" />
	<?endif?>

	<table cellpadding="0" cellspacing="0" width="100">
		<tr>
			<td width="0%" style="padding-right: 5px"><?
				$image = $templateFolder."/images/".strtolower($arResult["DISPLAY_PROPERTIES"]["DOC_TYPE"]["VALUE_XML_ID"]).".gif";
				if(file_exists($_SERVER["DOCUMENT_ROOT"].$image)):
					?><img border="0" src="<?=$image?>" width="30" height="30" alt="<?=$arResult["DISPLAY_PROPERTIES"]["DOC_TYPE"]["VALUE_ENUM"]?>" hspace="0" vspace="0" title="<?=$arResult["DISPLAY_PROPERTIES"]["DOC_TYPE"]["VALUE_ENUM"]?>" style="float:left" /><?
				endif?><br /></td>
			<td width="100%" valign="top" class="news-date-time"><?if($arParams["DISPLAY_DATE"]!="N" && $arResult["DISPLAY_ACTIVE_FROM"]):?>
		<span><?=$arResult["DISPLAY_ACTIVE_FROM"]?></span><?endif;?></td>
		</tr>
	</table>
	<br />


	<?if(false && $arParams["DISPLAY_NAME"]!="N" && $arResult["NAME"]):?>
		<h3><?=$arResult["NAME"]?></h3><br/>
	<?endif;?>
	<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arResult["FIELDS"]["PREVIEW_TEXT"]):?>
		<p><?=$arResult["FIELDS"]["PREVIEW_TEXT"];unset($arResult["FIELDS"]["PREVIEW_TEXT"]);?></p>
	<?endif;?>
	<?if($arResult["NAV_RESULT"]):?>
		<?if($arParams["DISPLAY_TOP_PAGER"]):?><?=$arResult["NAV_STRING"]?><br /><?endif;?>
		<?echo $arResult["NAV_TEXT"];?>
		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?><br /><?=$arResult["NAV_STRING"]?><?endif;?>
	<?elseif(strlen($arResult["DETAIL_TEXT"])>0):?>
		<?echo $arResult["DETAIL_TEXT"];?>
	<?else:?>
		<?echo $arResult["PREVIEW_TEXT"];?>
	<?endif?>
	<div style="clear:both"></div>
	<br />
	<?foreach($arResult["FIELDS"] as $code=>$value):?>
			<?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?>
			<br />
	<?endforeach;?>
	<?foreach($arResult["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>

		<?=$arProperty["NAME"]?>:&nbsp;<b>
		<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
			<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
		<?else:?>
			<?=$arProperty["DISPLAY_VALUE"];?>
		<?endif?>
		<br /></b>
	<?endforeach;?>
	<?
	if(array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y")
	{
		?>
		<div class="news-detail-share">
			<noindex>
			<?
			$APPLICATION->IncludeComponent("bitrix:main.share", "", array(
					"HANDLERS" => $arParams["SHARE_HANDLERS"],
					"PAGE_URL" => $arResult["~DETAIL_PAGE_URL"],
					"PAGE_TITLE" => $arResult["~NAME"],
					"SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
					"SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
					"HIDE" => $arParams["SHARE_HIDE"],
				),
				$component,
				array("HIDE_ICONS" => "Y")
			);
			?>
			</noindex>
		</div>
		<?
	}
	?>
	<p><a href="<?echo $arResult["LIST_PAGE_URL"];?>"><?=GetMessage("NEWS_BACK_TEXT")?></a></p>
</div>

<!-- Яндекс.Директ --><div id="yandex_ad"></div><script type="text/javascript">(function(w, d, n, s, t) {w[n] = w[n] || [];w[n].push(function() {Ya.Direct.insertInto(141426, "yandex_ad", {ad_format: "direct",font_size: 1,type: "horizontal",limit: 3,title_font_size: 3,links_underline: true,site_bg_color: "FFFFFF",header_bg_color: "FEEAC7",title_color: "0000CC",url_color: "006600",text_color: "000000",hover_color: "0066FF",sitelinks_color: "0000CC",favicon: true,no_sitelinks: false});});t = d.getElementsByTagName("script")[0];s = d.createElement("script");s.src = "//an.yandex.ru/system/context.js";s.type = "text/javascript";s.async = true;t.parentNode.insertBefore(s, t);})(window, document, "yandex_context_callbacks");</script>
