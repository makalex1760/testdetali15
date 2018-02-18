<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
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
$INPUT_ID = trim($arParams["~INPUT_ID"]);
if(strlen($INPUT_ID) <= 0)
	$INPUT_ID = "title-search-input";
$INPUT_ID = CUtil::JSEscape($INPUT_ID);

$CONTAINER_ID = trim($arParams["~CONTAINER_ID"]);
if(strlen($CONTAINER_ID) <= 0)
	$CONTAINER_ID = "title-search";
$CONTAINER_ID = CUtil::JSEscape($CONTAINER_ID);

if($arParams["SHOW_INPUT"] !== "N"):?>
	<div id="<?echo $CONTAINER_ID?>">
	<form action="<?echo $arResult["FORM_ACTION"]?>">
	<?if($admp) $tooltip1="class='tooltip' data-title='Если Вы на нашем сайте назовите код товара'"; ?>
		<input <?=$tooltip1?> id="<?echo $INPUT_ID?>" type="text" name="q" value="" size="40" maxlength="50" autocomplete="off" />&nbsp;<input name="s" type="submit" value="<?=GetMessage("CT_BST_SEARCH_BUTTON");?>" />
	</form>
	</div>
<?endif?>
<script type="text/javascript">
var jsControl = new JCTitleSearch({
	//'WAIT_IMAGE': '/bitrix/themes/.default/images/wait.gif',
	'AJAX_PAGE' : '<?echo CUtil::JSEscape(POST_FORM_ACTION_URI)?>',
	'CONTAINER_ID': '<?echo $CONTAINER_ID?>',
	'INPUT_ID': '<?echo $INPUT_ID?>',
	'MIN_QUERY_LEN': 2
});
</script>
