<?include_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
foreach($_COOKIE as $i=>$val) if(preg_match("#order_#",$i)) $_COOKIE[preg_replace("#order_#","",$i)] = $val;

__IncludeLang(dirname(__FILE__).'/lang/'.LANGUAGE_ID.'/template.php');

CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");
CModule::IncludeModule("sale");
CModule::IncludeModule("iarga.cleverbasket");

// Extract directory from filename
if(!$templateFolder){
	$templateFolder = str_replace($_SERVER['DOCUMENT_ROOT'],'',$_SERVER['SCRIPT_FILENAME']);
	$templateFolders = explode('/',$templateFolder);
	$templateFolder = str_replace($templateFolders[sizeof($templateFolders)-1],'',$templateFolder);
}


if($_POST['person_type']!='') $p_t = $_POST['person_type'];
else $p_t = $person_type['ID'];
if($p_t):
	$groups = CSaleOrderPropsGroup::GetList(Array("SORT"=>"ASC"),Array("PERSON_TYPE_ID"=>$p_t));
	while($group = $groups->GetNext()):
?>

		
		<?$props = CSaleOrderProps::GetList(Array("SORT"=>"ASC"),Array("PROPS_GROUP_ID"=>$group['ID']));
		while($prop = $props->GetNext()):
			
			if($prop['REQUIED']=='Y') $prop['NAME'] = '<b>'.$prop['NAME'].'</b>';?>
			<?if($prop['TYPE']=='LOCATION')continue; ?>
			
			
			<dl>
				<dt><?=$prop['NAME']?>:</dt>
				
				
                <?if($prop['TYPE']=="TEXTAREA"):?>
					<dd><textarea name="prop_<?=$prop['ID']?>" class="inp-text_ia style-1_ia"><?=$_COOKIE['prop_'.$prop['ID']]!=''?$_COOKIE['prop_'.$prop['ID']]:$user[$prop['CODE']]?></textarea></dd>
				<?else:?>
					<dd><input type="text" value="<?=$_COOKIE['prop_'.$prop['ID']]!=''?$_COOKIE['prop_'.$prop['ID']]:$user[$prop['CODE']]?>" name="prop_<?=$prop['ID']?>" class="inp-text_ia style-1_ia"></dd>
				<?endif;?>
			</dl>
		<?endwhile;?>
			
	<?endwhile;?>

	<div class="delivery_ajax_ia">
		<?include($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/delivery.php')?>
	</div>

	<?$pay_types = CSalePaySystem::GetList(Array("SORT"=>"ASC", "PSA_NAME"=>"ASC"), Array("ACTIVE"=>"Y", "PERSON_TYPE_ID"=>$p_t));
	$payn = $pay_types->SelectedRowsCount();
	if($payn > 0):?>
		<div class="hr_ia"></div>
		<dl>
			<dt><?=GetMessage("PAY_TYPE")?></dt>
			<dd>
				<?$i = 0;
				while($type = $pay_types->GetNext()):
					$i++;?>
					<label>
						<span class="input_ia">
							<input class="styled" <?=($payn<=1 || $type['ID']==$_COOKIE['paytype'])?'checked':''?> type="radio" value="<?=$type['ID']?>" name="paytype"> 
						</span>
						<span class="description_ia">
							<?if($type['PSA_LOGOTIP']!=""):?>
								<img src="<?=iarga::res($type['PSA_LOGOTIP'],400,100,1)?>"><br><?=($type['DESCRIPTION']!='')?''.$type['DESCRIPTION'].'':''?>
								<?=($type['DESCRIPTION']!='')?'<br>'.$type['DESCRIPTION'].'':''?>
							<?else:?>
								<strong><?=$type['NAME']?></strong><?=($type['DESCRIPTION']!='')?''.$type['DESCRIPTION'].'':''?>
							<?endif;?>
						</span>
					</label>
					<?if($i<$pay_types->SelectedRowsCount()):?><div class="hr_ia"></div><?endif;?>
				<?endwhile;?>
			</dd>
		</dl>

	<?endif;?>
	<div class="hr_ia"></div>


<?endif;?>