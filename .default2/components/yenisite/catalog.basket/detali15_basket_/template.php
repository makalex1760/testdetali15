<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?php
$dbq = CIBlockElement::GetList(array("PROPERTY_DISCOUNT"=>"ASC"), array("IBLOCK_ID"=>11), false, false, array("NAME", "PROPERTY_DISCOUNT_GROUP", "PROPERTY_DISCOUNT"));
$discounts = array();
while ($row=$dbq->Fetch()) {
    $discounts[$row["PROPERTY_DISCOUNT_GROUP_VALUE"]] = $row["PROPERTY_DISCOUNT_VALUE"];
}
//print_r($discounts);
session_start();

?>
<pre>
<?php
 
$sk5=$_SESSION['sk5'];
if($_SESSION['sms'])$checksms="checked"; else $checksms="";
print_r($sk5);
/*	if(isset($sk5)){
	$arGroups[] = 8;
$USER->SetUserGroupArray($arGroups);
$checks="checked";
		}
		else{
		array_pop($arGroups);
		$USER->SetUserGroupArray($arGroups);
		$checks="";
		}
*/
if (count(array_intersect($USER->GetUserGroupArray(), array_keys($discounts))) > 0) {
    $discount_ids = array_intersect($USER->GetUserGroupArray(), array_keys($discounts));
    $discount_id = array_shift($discount_ids);
//$isCompany = True;
} else {
  //  $isCompany = False;
}
//print_r($USER->GetUserGroupArray());
//print $discount_id."\n";
$discount_code = $discounts[$discount_id];
//print $discount_code."\n";
if ($discount_id==8||$sk5)$scidka='�� ������� 5%';if ($discount_id==9) $scidka='�� ������� 10%'; 

if($sk5)$checks="checked";



$admp=0;
foreach ($USER->GetUserGroupArray() as $group_id) {  
	if (isset($discounts[$group_id]))  if($group_id==13)$admp=1;
	
}
 if($admp) $tooltip="tooltip";
?>
</pre>

<div style='color: red;'>
<? if(count($arResult['ERROR']) > 0) foreach($arResult['ERROR'] as $err) echo GetMessage("ERROR").$err.'<br/>'; ?>
</div>

<?if(isset($arResult["ITEMS"])):?>

<?php 

$total_price = 0;
$total_discount = 0;
$total_count = 0;
?>

<form method="POST" id="order_form">
    <table class="big-basket">
        <tr><td class="foto"  class="head"><?=GetMessage("PHOTO");?></td><td class="head"><?=GetMessage("NAME");?></td><td class="head l"><?=GetMessage("COUNT");?></td><td class="head c"><?=GetMessage("PRICE");?></td><td class="head"><?=GetMessage("DELETE");?></td></tr>
        <?foreach($arResult["ITEMS"] as $arItem):?>
<pre>
<?php

if (isset($discount_code)) {
$dbq = CIBlockElement::GetProperty($arItem["FIELDS"]["IBLOCK_ID"], $arItem["FIELDS"]["ID"], array("SORT"=>"ASC"), array("CODE"=>$discount_code));
$r = $dbq->Fetch();
$price = $r["VALUE"];
//  $price = $arItem["MIN_PRICE"];
//print $price;
} else {
$dbq = CIBlockElement::GetProperty($arItem["FIELDS"]["IBLOCK_ID"], $arItem["FIELDS"]["ID"], array("SORT"=>"ASC"), array("CODE"=>"PRICE_BASE"));
$r = $dbq->Fetch();
$price = $r["VALUE"];
}
//print $price;

?>
</pre>
        <tr class="item">
		<td class="foto">
			<?	if($arItem["FIELDS"]['PREVIEW_PICTURE']): ?>
				   <a href="<?=$arItem["FIELDS"]["DETAIL_PAGE_URL"]?>" title="<?=$arItem["FIELDS"]["NAME"]?>"><img src='<?=CFile::GetPath($arItem["FIELDS"]['PREVIEW_PICTURE']);?>' alt='<?=$arItem["FIELDS"]["NAME"]?>' /></a>
			<? endif; ?>
		</td>
		
		<td class="prop3">
                <!--<a href="<?=$arItem["FIELDS"]["DETAIL_PAGE_URL"]?>" title="<?=$arItem["FIELDS"]["NAME"]?>">--><?=$arItem["FIELDS"]["NAME"]?><!--</a>--><br/>


                <span>
                <? $i=0; foreach($arItem["PROPERTIES"] as $arProp): $i++;?>
				<?if($arProp[VALUE]):?>
                    <b><?=$arProp["NAME"]?>:</b> <?=$arProp["VALUE"]?><?=($i<count($arItem["PROPERTIES"]))?",&nbsp;":"";?>
				<?endif?>
                <?endforeach?>    
                </span>

            </td>
            <td class="num3"><input style="width: 40px;" type="text" name="count[<?=$arItem["KEY"]?>]" value="<?=$arItem["COUNT"]?>" /></td>
			<td class="price3">
<?php 
/*print $arItem["MIN_PRICE"];*/ 
$line_price = $price*$arItem["COUNT"];
if($sk5)$line_price=ceil($line_price*95/100);
$total_price += $line_price;


$total_count += $arItem["COUNT"];
print $line_price; 
?> 
<?=$arParams['UE'];?>
</td>
            <td class="del3"><input type="checkbox" name="del[]" value="<?=$arItem["KEY"]?>"/></td></tr>
        <?endforeach?>
			<tr><td></td><td></td> <td></td><td colspan="2"><br/><b><?=GetMessage("ITOG");?> <?=$scidka?>:</b>
<?php 
/*print $arResult["COMMON_PRICE"]; */

print $total_price;
?>
<?=$arParams['UE'];?></td></tr>
        </table>
    
        <br/>
        
        <input style="float: right; font-size: 1.5em;" name="calculate" id="recalculate" type="submit" value="  <?=GetMessage("CALCULATE");?>  "/>

<br/>
<br/>
<pre>
<?php
   $rsUser = CUser::GetByID($USER->GetID());
   $arUser = $rsUser->Fetch();
   
?>
</pre>
<div class="dleft">
    <table class="big-basket-fields" style="float:left">
<tr class="field">

<td class="left">
<? if($admp): ?> ������ ���������� ���� ��� �����������? <?else:?> ��� �����������:<?endif;?>
</td>
<td class="right">
<? 	
print_r($_SESSION); print_r("test");
if($_SESSION["type"]) {if($_SESSION["type"]=='private') { $private='checked'; $company='';} else { $private=''; $company='checked';}} else { $private='checked'; $company='';} ?>
<input  type="radio" <?=$private?> name="type" value="private" id="private"><label for="private">������� ����</label><br>
<input  type="radio" <?=$company?>  name="type" value="company" id="company"><label for="company">������������� ������������ ����</label></td>
</tr>

                <tr class="field company_name_input">
            <td class="left">
             <? if($admp): ?> ������������ � ��������� ����������: <?else:?> �������� �����������:<?endif;?>  
            </td>
            <td class="right">
                <input class="ntSaveForms" type='text' size="30" name='PROPERTY[COMPANY_NAME]' value='<? if($admp==0) echo $arUser["WORK_COMPANY"];?>' />            </td>
        </tr>

                <tr class="field">
            <td class="left">
                ���������� ���� <? if($admp): ?> <br/><i>��� ��. ���: ��� (���������)</i> <?endif;?>:
            </td>
            <td class="right">
                <input class="ntSaveForms" type='text' size="30" name='PROPERTY[KONT_NAME]' value='<?=$_SESSION["namekl"]?>' />  <?$_SESSION["namekl"]=$_GET["namekl"];?>          </td>
        </tr>
                <tr class="field">
            <td class="left">
                ���������� �������:
            </td>
            <td class="right">
                <input  class="ntSaveForms" type='text' size="30" name='PROPERTY[PHONE]' value='<? if($admp==0) echo $arUser["PERSONAL_PHONE"];?>' id="property_phone" />            </td>
        </tr>
		<? if($admp): ?>	
		<tr class="field">
            <td class="left">
		���������� �������2
               
            </td>
            <td class="right">
                <input class="ntSaveForms"  type='text' size="30" name='PROPERTY[PHONE2]' id="phone" />           </td>
        </tr>
		<?endif;?>
		
		<tr class="field">
            <td class="left">
                ���������� �� ���:
            </td>
            <td class="right">
			<? if($admp) $smsdat="������ ������� ��� ���"; ?> 
                <input class="<?=$tooltip?>" data-title="<?=$smsdat?>" type='checkbox' size="30" name='PROPERTY[sms]' value='��'  <?=$checksms?>/>  

				</td>
				
        </tr>
		<? if($admp): ?>
		<tr class="field">
            <td class="left">
                ������ 5%:
            </td>
            <td class="right">
	
                <input  type='checkbox' size="40" name='PROPERTY[sk5]' value='��'  <?=$checks?>/>  

				</td>
				
        </tr>
		<? endif; ?>		
                <tr class="field">
            <td class="left">
           <? if($admp) echo "E-mail �������:"; else  echo "E-mail:"; ?>
            </td>
            <td class="right">
                <input class="ntSaveForms" type='text' size="30" name='PROPERTY[EMAIL]' value='<?if($admp==0)echo $arUser["EMAIL"];?>' id="property_email"/>  
				
				</td>
        </tr>
		     <tr class="field">
            <td class="left">
 <? if($admp): ?> �������� �������� ������� �� email. �������� � 1-� ���� � ��������� �� email<?else:?>  �����, ����������� � ���������� � ������:<?endif;?>  
               
            </td>
            <td class="right">
                <textarea class="ntSaveForms"  cols="31" rows="5" name='PROPERTY[ABOUT]'></textarea>            </td>
        </tr>
		</table>
</div>
<div class="dleft2">		
		  <table class="big-basket-fields">
           
                <tr class="field">
            <td class="left">
                ������ ��������:
            </td>
            <td class="right">
                <input class="ntSaveForms" type='radio' checked='checked' name='PROPERTY[DELIVERY]' value='6' id="samovivoz" />���������<br/>
				<input type='radio' name='PROPERTY[DELIVERY]' value='7' id="dost1" />�������� �� ������ � ���������� �������<br/>
				 <? if($admp) $dost="�������� ���� ������������ �������� ��� ������ ��������� ����������";?>  
				
				<input type='radio' class="<?=$tooltip?>" data-title="<?=$dost?>" name='PROPERTY[DELIVERY]' value='199' id="dost2" />�������� �� ������<br/>            </td>
        </tr>
                <tr class="field">
            <td class="left">
                ������ ������:
            </td>
            <td class="right">
                <div id="nal"><input  type='radio' checked='checked' name='PROPERTY[PAYMENT]' value='13' />��������</div>
				<div id="beznal"><input  type='radio' name='PROPERTY[PAYMENT]' value='14' />����������� ������</div>
				<? if($admp): ?>
				<div id="card" class="<?=$tooltip?>" data-title="� ����� �������� �� ������ �������� ����� ������� VISA, MasterCard, ���"><input  type='radio' name='PROPERTY[PAYMENT]' value='560' />������ ������</div>
				<?endif;?> 
				</td>
        </tr>
<? if($admp): ?>	
		<tr class="field" id="adr_deliv">
            <td class="left">
		����� ��������
               
            </td>
            <td class="right">
                <textarea class="ntSaveForms"  cols="31" rows="5" name='PROPERTY[PRIM]'></textarea>            </td>
        </tr>
		<?endif;?>
<?php
if (!$USER->IsAuthorized()) {
?>
<tr><td class="left"></td>
<td class="right"><br>
<a href="//detali15.ru/auth/?register=yes&backurl=%2F" id="register">������������������, ��� ���������� ����������</a><br>
<p style="padding: 1em; background: #e0e0e0; font-size: 0.8em; width: 300px;">
����������� �� ����� ���� ����� �� ��������� 5% ������ � ������, ���� �� - ������������� ������������ ����.
</p>


</td></tr>
<tr class="register_field">
<td class="left" >E-mail:</td>
<td class="right"><input placeholder="e-mail" size="30" type="text" name="register_email" value="" id="register_email"></td>
</tr>
<tr class="register_field">
<td class="left">������:</td>
<td class="right"><input placeholder="������" size="30" type="password" name="register_password" value="" id="register_password"></td>
</tr>
<tr class="register_field">
<td></td>
<td class="right"><input type="button" id="register_user" value=" ������������������ "></td>
</tr>
<tr class="register_field">
<td></td>
<td class="right">
<div class="error_msg" style="font-size: 0.8em; padding: 0.3em; width: 300px;"></div></td>

</tr>
<?php
} 
?>
<tr class="field">

<td class="right"><input class="ntSaveFormsSubmit" style="float: right; font-size: 1.5em;"  type="submit" name="order" id="place_order" value="  <?=GetMessage("ORDER");?>  "/></td>
<td  class="left" id="nodisplay" >������� ������� ��� email</td>           
</tr>


           </table></div>
		   
   
   <br/>

<br>
   
</form>
<style>
#adr_deliv{display:none}
#nodisplay{ text-aline:left;   display:none; color:red}
.register_field {
    display: none;
}
.company_name_input {
    <?php if (!$isCompany) print "display: none;"; ?>
}
</style>
<script type="text/javascript" src="//code.jquery.com/jquery-latest.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script src="jquery.maskedinput.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
	$("#property_phone").mask("+7 (999) 999-9999");
	$("#samovivoz").click(function() {
      $("#adr_deliv").hide("slow");
   });
   $("#dost1").click(function() {
      $("#adr_deliv").show("slow");
	    });
	$("#dost2").click(function() {
      $("#adr_deliv").show("slow");
	    });	
   $("#company").click(function() {
      $(".company_name_input").show("slow");
	  $("#beznal").show("slow");
	  $("#card").hide("slow");
   });
   $("#private").click(function() {
      $(".company_name_input").hide("slow");
	  $("#beznal").hide("slow");
	  $("#card").show("slow");
   });

   $("#register").change(function() {
      $(".register_field").toggle({easing: "easeInCubic", duration: 300});
   });
   $("#property_email").keyup(function() {
       $("#register_email").val(this.value);
   });

   $( "#order_form" ).submit(function( event ) {
      var btn = $( ":input[type=submit]:focus" );

      if (btn.attr("id") === "recalculate") {
          return;
      }
	  
	
      if ($("#property_email").val() !== "" || $("#property_phone").val() !== "") {
         //alert("OK");
         return;
        
      } 

      if ($("#property_email").val() === "" && $("#property_phone").val() === "") {
          $("#nodisplay").css("display", "block").delay(1000).animate({"outline-color": "#eeeeee"}, {duration:1000});
      }
      $(document).scrollTop($("#property_email").position().top - 100);
      event.preventDefault();
   });


   $("#register_user").click(function() {
      if ($("#register_email").val() !== "" && $("#register_password").val() !== "") {
         
         $.ajax({
             url: '/dev/register_user.php',
             type: 'POST',
             data: { email: $("#register_email").val(), password: $("#register_password").val(), type: "company" },
             success: function(response) {
                 if (response.indexOf("OK") != -1 ) {
                     $(".error_msg").html(response).css("outline", "solid 5px green").delay(1000).animate({"outline-color": "#eeeeee"}, {duration:1000});
                     location.reload();
                 } else {
                     $(".error_msg").html(response).css("outline", "solid 5px red").delay(1000).animate({"outline-color": "#eeeeee"}, {duration:1000});
                 }
             } 
         });
         return;
      }
//      if ($("#register").prop("checked")) {
          if ($("#register_email").val() === "") {
              $("#register_email").css("outline", "solid 5px red").delay(1000).animate({"outline-color": "#eeeeee"}, {duration:1000});
          } 
          if ($("#register_password").val() === "") {
              $("#register_password").css("outline", "solid 5px red").delay(1000).animate({"outline-color": "#eeeeee"}, {duration:1000});
          }
//      }      
   });
});

(function(jQuery){var isLS=typeof window.localStorage!=="undefined";function wls(n,v){var c;if(typeof n==="string"&&typeof v==="string"){localStorage[n]=v;return true}else if(typeof n==="object"&&typeof v==="undefined"){for(c in n)if(n.hasOwnProperty(c))localStorage[c]=n[c];return true}return false}function wc(n,v){var dt,e,c;dt=new Date;dt.setTime(dt.getTime()+31536E6);e="; expires="+dt.toGMTString();if(typeof n==="string"&&typeof v==="string"){document.cookie=n+"="+v+e+"; path=/";return true}else if(typeof n===
"object"&&typeof v==="undefined"){for(c in n)if(n.hasOwnProperty(c))document.cookie=c+"="+n[c]+e+"; path=/";return true}return false}function rls(n){return localStorage[n]}function rc(n){var nn,ca,i,c;nn=n+"=";ca=document.cookie.split(";");for(i=0;i<ca.length;i++){c=ca[i];while(c.charAt(0)===" ")c=c.substring(1,c.length);if(c.indexOf(nn)===0)return c.substring(nn.length,c.length)}return null}function dls(n){return delete localStorage[n]}function dc(n){return wc(n,"",-1)}jQuery.extend({Storage:{set:isLS?
wls:wc,get:isLS?rls:rc,remove:isLS?dls:dc}})})(jQuery);

(function ntSaveForms() {
	var text, cl;
	$(".ntSaveForms").each(function(i) {
		cl = "ntSaveForms"+i;
		$(this).addClass(cl); // add new class
		text = $.Storage.get(cl);
		if (text && text.length > 0 && !$(this).val()) {
			$(this).val(text); // set field data
		}
	});

	$(".ntSaveForms").keyup(function() {
		$.Storage.set($(this).attr("class").split(" ")[$(this).attr("class").split(" ").length -1], $(this).val()); // save field data
	});

	$(".ntSaveFormsSubmit").click(function() {
		$(".ntSaveForms").each(function(i) {
			$.Storage.remove("ntSaveForms"+i); // remove data
		});
	});
})();
</script>
<?else:?>
<?=GetMessage("YENISITE_BASKET_EMPTY")?>
<?endif;?>