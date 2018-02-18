<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
?>
<form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get">
	<?foreach($arResult["ITEMS"] as $arItem):
		if(array_key_exists("HIDDEN", $arItem)):
			echo $arItem["INPUT"];
		endif;
	endforeach;?>
	<table class="data-table" cellspacing="0" cellpadding="2">
	<thead>
		<tr>
			<td colspan="2" align="center"><?=GetMessage("IBLOCK_FILTER_TITLE")?></td>
		</tr>
	</thead>
	<tbody>
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?if(!array_key_exists("HIDDEN", $arItem)): ?>
				<tr>
					<td valign="top">
					 
					<?=$arItem["NAME"]?>: 
					
										
					</td>
					<td valign="top">
					<? $help="���� �� �� ����� ����� �������� ��� ������";
					if($arItem["NAME"]=='��������'&&$admp):?> <span class="tooltip" data-title="<?=$help?>">
					<?=$arItem["INPUT"]?></span>
					<?else:?>
					<?=$arItem["INPUT"]?>
					<?endif;?>
					</td>
				</tr>
			<?endif?>
		<?endforeach;?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="2">
				<input type="submit" name="set_filter" value="<?=GetMessage("IBLOCK_SET_FILTER")?>" /><input type="hidden" name="set_filter" value="Y" />&nbsp;&nbsp;<input type="submit" name="del_filter" value="<?=GetMessage("IBLOCK_DEL_FILTER")?>" /></td>
		</tr>
	</tfoot>
	</table>
</form>