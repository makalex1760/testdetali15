<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

	<h1><?$APPLICATION->ShowTitle();?> </h1>		
<?php

$dbq = CIBlockElement::GetList(array("PROPERTY_DISCOUNT"=>"ASC"), array("IBLOCK_ID"=>11), false, false, array("NAME", "PROPERTY_DISCOUNT_GROUP", "PROPERTY_DISCOUNT"));
$discounts = array();
while ($row=$dbq->Fetch()) {
    $discounts[$row["PROPERTY_DISCOUNT_GROUP_VALUE"]] = $row["PROPERTY_DISCOUNT_VALUE"];
}

session_start();

?>

<?php
//if($_SESSION['promokod'])$_SESSION['sk5']='Да';
$sk5=(int)$_REQUEST["PROPERTY"]['sk5']-658;
if($sk5==4) $sk5=3; if($sk5==12||$sk5==-658) $sk5=0;
//$_REQUEST["PROPERTY"]=$_SESSION["PROPERTY"];
//echo ttt;print_r($_REQUEST["PROPERTY"]['sk5']); print_r($_REQUEST["PROPERTY"]['sk5']['value']);
$slctd0=$slctd3=$slctd5=$slctd6=$slctd7=$slctd8=$slctd9=$slctd10=$slctd11=""; 
switch($sk5)
{case 0: $slctd0="selected"; break;
case 3: $slctd3="selected"; break;
case 5: $slctd5="selected"; break;
case 6: $slctd6="selected"; break;
case 7: $slctd7="selected"; break;
case 8: $slctd8="selected"; break;
case 9: $slctd9="selected"; break;
case 10: $slctd10="selected"; break;
case 11: $slctd11="selected"; break;
}
if(!$_REQUEST["PROPERTY"]['promokod'])$_SESSION['promokod']="";


if($_SESSION['sms'])$checksms="checked"; else $checksms="";

if (count(array_intersect($USER->GetUserGroupArray(), array_keys($discounts))) > 0) {
    $discount_ids = array_intersect($USER->GetUserGroupArray(), array_keys($discounts));
    $discount_id = array_shift($discount_ids);

} else {
 
}

$discount_code = $discounts[$discount_id];

if ($discount_id==8) $sk5=5;if ($discount_id==9)  $sk5=10;
if($sk5) $scidka='со скидкой '.$sk5.'%';


$admp=0;
foreach ($USER->GetUserGroupArray() as $group_id) {  
	//if (isset($discounts[$group_id])) 
		if($group_id==13)$admp=1;
	
}
 if($admp) $tooltip="tooltip";
// print("adm");print_r($USER->GetUserGroupArray());
?>


<div style='color: red;'>
<? if(count($arResult['ERROR']) > 0) foreach($arResult['ERROR'] as $err) echo GetMessage("ERROR").$err.'<br/>'; ?>
</div>

<?if(isset($arResult["ITEMS"])):?>

<?php 
$total_price = 0;
$total_discount = 0;
$total_count = 0;
?>
<br/>
<form method="POST" id="order_form">
    <table class="big-basket">
        <tr>
		<th class="head hidden-xs"><?=GetMessage("PHOTO");?></th>
		<th class="head ch"><?=GetMessage("NAME");?></th>
		<th class="head"><?=GetMessage("COUNT");?></th>
		<th class="head ch hidden-xs"><?=GetMessage("PRICE");?></td>
		<th class="head"><?=GetMessage("DELETE");?></th>
		</tr>
        <?foreach($arResult["ITEMS"] as $arItem):?>

<?php

if (isset($discount_code)) {
$dbq = CIBlockElement::GetProperty($arItem["FIELDS"]["IBLOCK_ID"], $arItem["FIELDS"]["ID"], array("SORT"=>"ASC"), array("CODE"=>$discount_code));
$r = $dbq->Fetch();
$price = $r["VALUE"];
} else {
$dbq = CIBlockElement::GetProperty($arItem["FIELDS"]["IBLOCK_ID"], $arItem["FIELDS"]["ID"], array("SORT"=>"ASC"), array("CODE"=>"PRICE_BASE"));
$r = $dbq->Fetch();
$price = $r["VALUE"];
}

?>

        <tr class="item">
		<td class="foto hidden-xs ">
			<?	if($arItem["FIELDS"]['PREVIEW_PICTURE']): ?>
				   <a href="<?=$arItem["FIELDS"]["DETAIL_PAGE_URL"]?>" title="<?=$arItem["FIELDS"]["NAME"]?>">
				   <img src='<?=CFile::GetPath($arItem["FIELDS"]['PREVIEW_PICTURE']);?>' alt='<?=$arItem["FIELDS"]["NAME"]?>' height="100px"/></a>
			<? endif; ?>
		</td>
		
		<td class="prop3 ">
                <!--<a href="<?=$arItem["FIELDS"]["DETAIL_PAGE_URL"]?>" title="<?=$arItem["FIELDS"]["NAME"]?>">--><?=$arItem["FIELDS"]["NAME"]?><!--</a>--><br/>


                <span>
                <? $i=0; foreach($arItem["PROPERTIES"] as $arProp): $i++;?>
				<?if($arProp[VALUE]):?>
                    <b><?=$arProp["NAME"]?>:</b> <?=$arProp["VALUE"]?><?=($i<count($arItem["PROPERTIES"]))?",&nbsp;":"";?>
				<?endif?>
                <?endforeach?>    
                </span>

            </td>
            <td class="num3 hidden-xs"><input style="width: 40px;" type="text" name="count[<?=$arItem["KEY"]?>]" value="<?=$arItem["COUNT"]?>" /></td>
			<td class="price3">
<?php 
/*print $arItem["MIN_PRICE"];*/ 
$line_price = $price*$arItem["COUNT"];
if($sk5)$line_price=ceil($line_price*(100-$sk5)/100);
$total_price += $line_price;


$total_count += $arItem["COUNT"];
print $line_price; 
?> 
<?=$arParams['UE'];?>
</td>
            <td class="del3"><input type="checkbox" name="del[]" value="<?=$arItem["KEY"]?>"/></td></tr>
        <?endforeach?>
			<tr><td class="hidden-xs"></td><td></td> <td class="hidden-xs"></td><td colspan="2"><br/><b><?=GetMessage("ITOG");?> <?=$scidka?>:
<?php 
/*print $arResult["COMMON_PRICE"]; */

print $total_price;
?>&nbsp;<?=$arParams['UE'];?></b></td></tr>
        </table>
    
        <br/>
       
        <input style="float: right; background:#fff; border:2px solid #3F618E; color:#093A7D;padding:7px 15px; font-weight:bold" name="calculate" id="recalculate" type="submit" value="  <?=GetMessage("CALCULATE");?>  "/>

<br/>
<br/>

<?php
   $rsUser = CUser::GetByID($USER->GetID());
   $arUser = $rsUser->Fetch();
   
?>
<br/>
<br/>
<h1>Оформление заказа</h1>
<br/>
<div class="dleft">
<div class="left">
<? if($admp): ?> Спроси физическое лицо или организация? <?else:?> Тип плательщика:<?endif;?>
</div>

 <div class="right">
 <? if($_REQUEST["PROPERTY"]['paytype']==660) {$check="checked"; $check1="";} else  {$check1="checked"; $check="";} ?>
                <input class="ntSaveForms" type='radio' <?=$check?> name='PROPERTY[paytype]' value='660' id="private" /><label for="private">Частное лицо</label><br/>
				<input type='radio' name='PROPERTY[paytype]' value='661' <?=$check1?> id="company" /><label for="company">Представитель юридического лица</label><br/>
				
</div>

</br>
   
	


<div class="left">
<? if($admp): ?> Спроси физическое лицо или организация? <?else:?> Тип плательщика:<?endif;?>
</div>
<div class="right">

<? 	if($_SESSION["typef"]) {if($_SESSION["typef"]=='private') { $private='checked'; $company='';} else { $private=''; $company='checked';}} else { $private='checked'; $company='';} ?>
<input  type="radio" <?=$private?> name="typef" value="private" id="private"><label for="private">Частное лицо</label><br>
<input  type="radio" <?=$company?>  name="typef" value="company" id="company"><label for="company">Представитель юридического лица</label>
</div>
<?$_SESSION["typef"]=$_GET["typef"];?>
</br>

              
            <div class="left">
             <? if($admp): ?> Договориться о получении реквизитов: <?else:?> Название организации:<?endif;?>  
            </div>
            <div class="right">
                <input class="ntSaveForms" type='text' size="40" name='PROPERTY[COMPANY_NAME]' value='<? if($admp==0) echo $arUser["WORK_COMPANY"];?>' />            </div>
</br>
  
            <div class="left">
                Контактное лицо <? if($admp): ?> <br/><i>Для юр. лиц: ФИО (полностью)</i> <?endif;?>:
            </div>
            <div class="right">
                <input class="ntSaveForms" type='text' size="40" name='PROPERTY[KONT_NAME]' value='<?=$_SESSION["namekl"]?>' />  <?$_SESSION["namekl"]=$_GET["namekl"];?>          </div>
</br>
              
            <div class="left">
                Контактный телефон:
            </div>
            <div class="right">
                <input  class="ntSaveForms" type='text' size="40" name='PROPERTY[PHONE]' value='<? if($admp==0) echo $arUser["PERSONAL_PHONE"];?>' id="property_phone" />            </div>
 </br>
		<? if($admp): ?>	

            <div class="left">
		Контактный телефон2
               
            </div>
            <div class="right">
                <input class="ntSaveForms"  type='text' size="40" name='PROPERTY[PHONE2]' id="phone" />           </div>
 </br>
		<?endif;?>
		
            <div class="left">
                Уведомлять по смс:
            </div>
            <div class="right">
			<? if($admp) $smsdat="Уточни телефон для СМС"; ?> 
                <input class="<?=$tooltip?>" data-title="<?=$smsdat?>" type='checkbox' size="30" name='PROPERTY[sms]' value='Да'  <?=$checksms?>/>  

				</div>
				
 </br>
		<? if($admp): ?>

            <div class="left">
                Скидка: 
            </div>
            <div class="right">
			<select name='PROPERTY[sk5]'>
			<option value='670' <?=$slctd0?>>Без скидки</option>
			<option value='662' <?=$slctd3?>>3%</option>
				<option value='663' <?=$slctd5?>>5%</option>
				<option value='664' <?=$slctd6?>>6%</option>
				<option value='665' <?=$slctd7?>>7%</option>
				<option value='666' <?=$slctd8?>>8%</option>
				<option value='667' <?=$slctd9?>>9%</option>
				<option value='668' <?=$slctd10?>>10%</option>
				<option value='669' <?=$slctd11?>>11%</option>
			</select>
             

				</div>
				
 </br>

            <div class="left">
                Промокод:
            </div>
            <div class="right">
			
                <input  type='text' size="7" name='PROPERTY[promokod]' value='<?=$_SESSION["promokod"]?>'  >  
			     
				</div>
				
</br>
		<? endif; ?>		
 
 <div class="left">
           <? if($admp) echo "E-mail клиента:"; else  echo "E-mail:"; ?>
            </div>
            <div class="right">
                <input class="ntSaveForms" type='text' size="40" name='PROPERTY[EMAIL]' value='<?if($admp==0)echo $arUser["EMAIL"];?>' id="property_email"/>  
				
				</div>
</br>

            <div class="left">
 <? if($admp): ?> Предложи сбросить компред на email. Оформить в 1-с счет и отправить на email<?else:?>  Адрес, комментарии и примечания к заказу:<?endif;?>  
               
            </div>
            <div class="right">
                <textarea class="ntSaveForms"  cols="40" rows="5" name='PROPERTY[ABOUT]'></textarea>            </div>
 </br>
		
           
             <div class="left">
                Способ доставки:
            </div>
            <div class="right">
                <input class="ntSaveForms" type='radio' checked='checked' name='PROPERTY[DELIVERY]' value='6' id="samovivoz" /><label>&nbsp;Самовывоз</label><br/>
				<input type='radio' name='PROPERTY[DELIVERY]' value='7' id="dost1" /><label>&nbsp;Доставка по Москве и Московской области</label><br/>
				 <? if($admp) $dost="Предложи наши транспортные компании или уточни пожелания покупателя";?>  
				
				<input type='radio' class="<?=$tooltip?>" data-title="<?=$dost?>" name='PROPERTY[DELIVERY]' value='199' id="dost2" /><label>&nbsp;Доставка по России</label><br/></div>
</br>
 
            <div class="left">
                Способ оплаты:
            </div>
            <div class="right">
			
			<div id="Oplata1">Оплата при получении наличными или банковской картой</div>
			<div id="Oplata2">Предоплата банковским переводом</div>
			<div id="Oplata3">Оплата картой или наличными при получении, либо предоплата по безналичному расчёту</div>
			<div id="Oplata4">Оплата наличными при получении, либо предоплата по безналичному расчёту</div>
			<div id="Oplata5">Предоплата по безналичному расчёту</div>
			<div id="Oplata6">Оплата при получении наличными<br/></div>
                <div id="nal"><input  type='radio' checked='checked' name='PROPERTY[PAYMENT]' value='13' />Наличные</div>
			<!--	<div id="beznal"><input  type='radio' name='PROPERTY[PAYMENT]' value='14' />Безналичный расчет</div>-->
			
				<? //if($admp): ?>
				<!--<div id="card" class="<?=$tooltip?>" data-title="В нашем магазине Вы можете оплатить товар картами VISA, MasterCard, Мир"><input  type='radio' name='PROPERTY[PAYMENT]' value='560' />Оплата картой</div>-->
				<?//endif;?> 
				</div>
</br>
<? if($admp): ?>	
		<div class="field" id="adr_deliv">
            <div class="left">
		Адрес доставки
               
            </div>
            <div class="right">
                <textarea class="ntSaveForms"  cols="31" rows="5" name='PROPERTY[PRIM]'></textarea>            </div>
        </div>
		<?endif;?>
<?php
if (!$USER->IsAuthorized()) {
?>

<div colspan=2 class="right"><br>
<p style="padding: 20px; background: #E6F3FB; font-size: 95%; width: 85%">
"Зарегистрируйтесь на сайте и получите скидку 5% на данную и все последующие покупки. Для регистрации введите пароль длиной не менее 6 символов. Не забудьте нажать кнопку "пересчитать" что бы получить скидку до отправки заказа. В дальнейшем вы сможете авторизоваться на сайте, используя указанный email и пароль".
Поле "пароль" поле "повторить пароль". При заполнении полей появляется кнопка "пересчитать" - нажимая на которую происходит пересчёт суммы в корзине (-5%)
на месте
</p>
</div>
<div class="left hidden" >E-mail:</div>
<div class="right hidden"><input placeholder="e-mail" size="30" type="text" name="register_email" value="" id="register_email"></div>
<div class="left hidden">Пароль:</div>
<div class="right hidden"><input placeholder="пароль" size="30" type="password" name="register_password" value="" id="register_password"></div>

<div class="right hidden"><input type="button" id="register_user" value=" Зарегистрироваться "></div>

<div  class="left" id="nodisplay" >Введите телефон или email</div>  

<div class="right">
<div class="error_msg" style="font-size: 0.8em; padding: 0.3em; width: 300px;"></div></div>

</br>
<?php
} 
?>


<div class="left"><input class="ntSaveFormsSubmit" style="padding:7px 30px; background-color:#194A8C; border:0; font-weight:bold; color:#fff"  type="submit" name="order" id="place_order" value="Сделать заказ"/></div>
         
</br>


          </div>
		   
   
   <br/>

<br>
   
</form>
<style>
#nal{display:none}
#adr_deliv{display:none}
#Oplata2{display:none}
#Oplata3{display:none}
#Oplata4{display:none}
#Oplata5{display:none}
#Oplata6{display:none}
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
	  if ($("#company").prop("checked")){$("#Oplata1").hide("slow");$("#Oplata3").show("slow");} else { $("#Oplata1").show("slow");$("#Oplata3").hide("slow");}
	   $("#Oplata2").hide("slow");$("#Oplata4").hide("slow");$("#Oplata5").hide("slow"); $("#Oplata6").hide("slow");
   });
   $("#dost1").click(function() {
      $("#adr_deliv").show("slow"); 
	if ($("#company").prop("checked")){$("#Oplata1").hide("slow");$("#Oplata4").show("slow");} else $("#Oplata6").show("slow");
	
	 $("#Oplata2").hide("slow");$("#Oplata3").hide("slow");$("#Oplata5").hide("slow");$("#Oplata1").hide("slow");
	    });
	$("#dost2").click(function() {
      $("#adr_deliv").show("slow");
	  if ($("#private").prop("checked")){$("#Oplata2").show("slow");$("#Oplata1").hide("slow");} else  $("#Oplata5").show("slow");
	  $("#Oplata3").hide("slow");$("#Oplata4").hide("slow");$("#Oplata6").hide("slow");
	    });	
		
   $("#company").click(function() {
      $(".company_name_input").show("slow");
 $("#samovivoz").attr('checked', true).trigger("click"); 
   });
   $("#private").click(function() {
      $(".company_name_input").hide("slow");
$("#samovivoz").attr('checked', true).trigger("click"); 
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