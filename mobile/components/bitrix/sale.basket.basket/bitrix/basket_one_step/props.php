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
if($USER->IsAuthorized()){
		$user = $USER->GetID();
		$rsUser = CUser::GetByID($user);
		$arUser = $rsUser->Fetch();
		_c($arUser);
	}
	

if($_POST['person_type']!='') $p_t = $_POST['person_type'];
else $p_t = $person_type['ID'];
if($p_t):
	$groups = CSaleOrderPropsGroup::GetList(Array("SORT"=>"ASC"),Array("PERSON_TYPE_ID"=>$p_t));
	while($group = $groups->GetNext()):
?>

		
		<?$props = CSaleOrderProps::GetList(Array("SORT"=>"ASC"),Array("PROPS_GROUP_ID"=>$group['ID']));
		while($prop = $props->GetNext()):
			
			if($prop['REQUIED']=='Y') $prop['NAME'] = $prop['NAME'].'*';?>
			
			<? 
			if($USER->IsAuthorized()){
			if($prop[CODE]=="FIO")$prop_user=$arUser["NAME"];
				elseif($prop[CODE]=="EMAIL") $prop_user=$arUser["EMAIL"];
				 elseif($prop[CODE]=="PHONE") $prop_user=$arUser["PERSONAL_PHONE"];
				   elseif($prop[CODE]=="ADDRESS") $prop_user=$arUser["PERSONAL_STREET"];
						else $prop_user="";
							} else
								$prop_user="";?>
		<?if($prop['TYPE']=='LOCATION'||$prop['CODE']=="CITY"):?>
		 <input type='LOCATION' name="prop_<?=$prop['ID']?>" value="1" style="display:none" >	
		<? continue;endif; ?>
			<dl>
				<dt><?=$prop['NAME']?>:</dt>

					
                <?if($prop['TYPE']=="TEXTAREA"):?>
					<dd><textarea name="prop_<?=$prop['ID']?>" class="inp-text_ia style-1_ia"><?=$prop_user?></textarea></dd>
				<?elseif($prop['CODE']=="sms"):?>
					<dd><input type="CHECKBOX"  value="1" name="prop_<?=$prop['ID']?>" class="inp-chk_ia style-1_ia"></dd>
				<?else:?>
				<dd><input type=<?=$prop['TYPE']?> value="<?=$prop_user?>" name="prop_<?=$prop['ID']?>" class="inp-text_ia style-1_ia"></dd>
				<?endif;?>
			</dl>
		<?endwhile;?>
			
	<?endwhile;?>
			<div class="hr_ia"></div>
			<dl>
				<dt><?=GetMessage("DISCOUNT_CODE")?></dt>
				<dd>
					<input type="text" value="<?=$_SESSION["discount_code"]?>" name="discount_code" class="inp-text_ia style-1_ia discount_code">
					<span class="discount_value"></span>

				</dd>
			</dl>
	
		<?include($_SERVER['DOCUMENT_ROOT'].$templateFolder.'/delivery.php')?>


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
							
								<strong><?=$type['NAME']?></strong><?=($type['DESCRIPTION']!='')?''.$type['DESCRIPTION'].'':''?>
							
						</span>
					</label>
					<?if($i<$pay_types->SelectedRowsCount()):?><div class="hr_ia"></div><?endif;?>
				<?endwhile;?>
			</dd>
		</dl>

	<?endif;?>
	<div class="hr_ia"></div>


<?endif;?>