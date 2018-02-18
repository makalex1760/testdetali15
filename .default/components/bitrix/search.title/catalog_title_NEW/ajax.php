<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(!empty($arResult["CATEGORIES"])):?>
	<table class="title-search-result">
		<?foreach($arResult["CATEGORIES"] as $category_id => $arCategory):?>
			<tr>
				<th class="title-search-separator">&nbsp;</th>
				<td class="title-search-separator">&nbsp;</td>
			</tr>
			<?foreach($arCategory["ITEMS"] as $i => $arItem):?>
			<?
				$propTxt = "";
				foreach($arItem[PROPERTIES] as $prop){	
				
					if($prop[DISPLAY_VALUE]){
						
						if(is_array($prop[DISPLAY_VALUE])){
							$propTxt .= $prop[NAME].": ";
							$propTxt .= strip_tags(implode(", ", $prop[DISPLAY_VALUE])."; ");
						}
						else{							
							$propTxt .= $prop[NAME].": ".strip_tags($prop[DISPLAY_VALUE])."; ";
						}
					}
					
					
				}
				
				if($propTxt) $propTxt = "<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$propTxt;
				
				if($arItem[PRICES])
					$price = implode(", ", $arItem[PRICES]);
					if($price) $price = "&nbsp;".$price;
			?>
			<tr>
				<?if($i == 0):?>
					<th align="center"><?//echo $arCategory["TITLE"]?><?if($arItem[PREVIEW_PICTURE]):?><a href="<?echo $arItem["URL"]?>"><img height="50px" src="<?=$arItem[PREVIEW_PICTURE]?>" /></a><?endif?></th>
				<?else:?>
					<th align="center"><?if($arItem[PREVIEW_PICTURE]):?><a href="<?echo $arItem["URL"]?>"><img height="50px" src="<?=$arItem[PREVIEW_PICTURE]?>" /></a><?endif?></th>
				<?endif?>

				<?if($category_id === "all"):?>
					<td class="title-search-all"><a href="<?echo $arItem["URL"]?>"><?echo $arItem["NAME"]?><span class="price"><?=$price?></span><i><?=$propTxt?></i></td>
				<?elseif(isset($arItem["ICON"])):?>
					<td class="title-search-item"><img src="<?echo $arItem["ICON"]?>"><a href="<?echo $arItem["URL"]?>"><?echo $arItem["NAME"]?><span class="price"><?=$price?></span><i><?=$propTxt?></i></td>
				<?else:?>
					<td class="title-search-more"><a href="<?echo $arItem["URL"]?>"><?echo $arItem["NAME"]?><span class="price"><?=$price?></span><i><?=$propTxt?></i></td>
				<?endif;?>
			</tr>
			<?$price = "";?>
			<?endforeach;?>
		<?endforeach;?>
		<tr>
			<th class="title-search-separator">&nbsp;</th>
			<td class="title-search-separator">&nbsp;</td>
		</tr>
	</table><div class="title-search-fader"></div>
<?endif;
//echo "<pre>",htmlspecialchars(print_r($arResult,1)),"</pre>";
?>