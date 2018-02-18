<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div  style="padding:10px 20px; background-color:#D5E2F3">
<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" width="100%">
	<?foreach($arResult["ITEMS"] as $arItem):
		if(array_key_exists("HIDDEN", $arItem)):
			echo $arItem["INPUT"];
		endif;
	endforeach;?>

		<?foreach($arResult["ITEMS"] as $arItem):?>
                        <?php
                        if ($arItem["NAME"] == "Наличие") { continue; }
                        ?>
			<?if(!array_key_exists("HIDDEN", $arItem)):?>
				
					<!--<td valign="middle" width="80px"><?=$arItem["NAME"]?>:</td>
					<td valign="top" class="fields"><?=$arItem["INPUT"]?></td>-->

			<?endif?>
		<?endforeach;?>
		
                        
           <input type="text" name="arrFilter_ff[NAME]" class="search1" value="<?=$arResult["ITEMS"]["NAME"]["INPUT_VALUE"]?>" placeholder="Введите наименование или каталожный номер">
                             <input type="submit" name="set_filter" value="Найти" class="btn1 submit1" />
							 <input type="hidden" name="set_filter" value="Y" />&nbsp;&nbsp;
							 <input  type="submit" class="btn1 delflt" name="del_filter" value="Сбросить" />
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             <input type="checkbox" id="availability" name="arrFilter_pf[NALICHIE]" value="Есть" <?php if (isset($_REQUEST["arrFilter_pf"]["NALICHIE"])) { print "checked=\"checked\""; } ?>>
                             <label for="availability">Только в наличии</label>
						 
 
</form>
</div>	