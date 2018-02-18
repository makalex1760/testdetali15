<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="/img-rollover.js" type="text/javascript"></script>
<style>
/*  */
#screenshot{
	position:absolute;
	border:1px solid #ccc;
	background:#333;
	padding:5px;
	display:none;
	color:#fff;
	}

/*  */
</style>
<div style='color: red;'>
<? if(count($arResult['ERROR']) > 0) foreach($arResult['ERROR'] as $err) echo GetMessage("ERROR").$err.'<br/>'; ?>
</div>


<?if(isset($arResult["ITEMS"])):?>
<form method="POST">
    <table class="big-basket" width="96%">
        <tr><td width="20%" class="head"><?=GetMessage("PHOTO");?></td><td width="50%" class="head"><?=GetMessage("NAME");?></td><td width="10%" class="head l"><?=GetMessage("COUNT");?></td><td width="10%" class="head c"><?=GetMessage("PRICE");?></td><td width="10%" class="head"><?=GetMessage("DELETE");?></td></tr>
        <?foreach($arResult["ITEMS"] as $arItem):?>

        <tr class="item">
		<td>
			<!--<?	if($arItem["FIELDS"]['PREVIEW_PICTURE']): ?>
				   <a href="<?=$arItem["FIELDS"]["DETAIL_PAGE_URL"]?>" title="<?=$arItem["FIELDS"]["NAME"]?>"><img src='<?=CFile::GetPath($arItem["FIELDS"]['PREVIEW_PICTURE']);?>' alt='<?=$arItem["FIELDS"]["NAME"]?>' /></a>
			<? endif; ?>-->

<?php if (file_exists($_SERVER["DOCUMENT_ROOT"]."/img/".$arItem["FIELDS"]["XML_ID"].".jpg")) { ?>
<a href="/img/<?=$arItem["FIELDS"]["XML_ID"]?>.jpg" class="screenshot" rel="/img/<?=$arItem["FIELDS"]["XML_ID"]?>.jpg"><img src="http://detali15.ru/upload/medialibrary/cff/icon-camera.png"></a>
<?php } ?>
		</td>
		
		<td>
                <a href="<?=$arItem["FIELDS"]["DETAIL_PAGE_URL"]?>" title="<?=$arItem["FIELDS"]["NAME"]?>"><?=$arItem["FIELDS"]["NAME"]?></a><br/>


                <span>
                <? $i=0; foreach($arItem["PROPERTIES"] as $arProp): $i++;?>
				<?if($arProp[VALUE]):?>
                    <b><?=$arProp["NAME"]?>:</b> <?=$arProp["VALUE"]?><?=($i<count($arItem["PROPERTIES"]))?",&nbsp;":"";?>
				<?endif?>
                <?endforeach?>    
                </span>

            </td>
            <td><input style="width: 40px;" type="text" name="count[<?=$arItem["KEY"]?>]" value="<?=$arItem["COUNT"]?>" /></td>
			<td><?=$arItem["MIN_PRICE"]?> <?=$arParams['UE'];?></td>
            <td><input type="checkbox" name="del[]" value="<?=$arItem["KEY"]?>"/></td></tr>
        <?endforeach?>
			<tr><td></td><td></td> <td></td> <td></td> <td><br/><b><?=GetMessage("ITOG");?>:</b> <?=$arResult["COMMON_PRICE"]?> <?=$arParams['UE'];?></td></tr>
        </table>
    
        <br/>
        
        <input style="float: right;" name="calculate" type="submit" value="<?=GetMessage("CALCULATE");?>"/>

<br/>
<br/>

    <table class="big-basket-fields" width="100%">
        <?foreach($arResult["DISPLAY_PROPERTIES"] as $arProp):?>
        <tr class="field">
            <td class="left">
                <?=$arProp["NAME"]?><?if($arProp['IS_REQUIRED']):?>*<?endif?>:
            </td>
            <td class="right">
                <?=$arProp["INPUT"]?>
            </td>
        </tr>
        <?endforeach?>
   </table>
   
   <br/>
   <input style="float: right;" type="submit" name="order" value="<?=GetMessage("ORDER");?>"/>
</form>

<?else:?>
<?=GetMessage("YENISITE_BASKET_EMPTY")?>
<?endif;?>