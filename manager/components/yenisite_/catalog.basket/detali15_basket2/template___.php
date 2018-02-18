<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?php
$dbq = CIBlockElement::GetList(array("PROPERTY_DISCOUNT"=>"ASC"), array("IBLOCK_ID"=>11), false, false, array("NAME", "PROPERTY_DISCOUNT_GROUP", "PROPERTY_DISCOUNT"));
$discounts = array();
while ($row=$dbq->Fetch()) {
    $discounts[$row["PROPERTY_DISCOUNT_GROUP_VALUE"]] = $row["PROPERTY_DISCOUNT_VALUE"];
}
//print_r($discounts);
?>
<pre>
<?php

if (count(array_intersect($USER->GetUserGroupArray(), array_keys($discounts))) > 0) {
    $discount_ids = array_intersect($USER->GetUserGroupArray(), array_keys($discounts));
    $discount_id = array_shift($discount_ids);
    $isCompany = True;
} else {
    $isCompany = False;
}

//print $discount_id."\n";
$discount_code = $discounts[$discount_id];
//print $discount_code."\n";
if ($discount_id==8)$scidka='со скидкой 5%';if ($discount_id==9) $scidka='со скидкой 10%'; 
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
    <table class="big-basket" width="100%">
        <tr><td width="20%" class="head"><?=GetMessage("PHOTO");?></td><td width="50%" class="head"><?=GetMessage("NAME");?></td><td width="10%" class="head l"><?=GetMessage("COUNT");?></td><td width="10%" class="head c"><?=GetMessage("PRICE");?></td><td width="10%" class="head"><?=GetMessage("DELETE");?></td></tr>
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
		<td>
			<?	if($arItem["FIELDS"]['PREVIEW_PICTURE']): ?>
				   <a href="<?=$arItem["FIELDS"]["DETAIL_PAGE_URL"]?>" title="<?=$arItem["FIELDS"]["NAME"]?>"><img src='<?=CFile::GetPath($arItem["FIELDS"]['PREVIEW_PICTURE']);?>' alt='<?=$arItem["FIELDS"]["NAME"]?>' /></a>
			<? endif; ?>
		</td>
		
		<td>
                <!--<a href="<?=$arItem["FIELDS"]["DETAIL_PAGE_URL"]?>" title="<?=$arItem["FIELDS"]["NAME"]?>">--><?=$arItem["FIELDS"]["NAME"]?><!--</a>--><br/>


                <span>
                <? $i=0; foreach($arItem["PROPERTIES"] as $arProp): $i++;?>
				<?if($arProp[VALUE]):?>
                    <b><?=$arProp["NAME"]?>:</b> <?=$arProp["VALUE"]?><?=($i<count($arItem["PROPERTIES"]))?",&nbsp;":"";?>
				<?endif?>
                <?endforeach?>    
                </span>

            </td>
            <td><input style="width: 40px;" type="text" name="count[<?=$arItem["KEY"]?>]" value="<?=$arItem["COUNT"]?>" /></td>
			<td>
<?php 
/*print $arItem["MIN_PRICE"];*/ 
$line_price = $price*$arItem["COUNT"];
$total_price += $line_price;
$total_count += $arItem["COUNT"];
print $line_price; 
?> 
<?=$arParams['UE'];?>
</td>
            <td><input type="checkbox" name="del[]" value="<?=$arItem["KEY"]?>"/></td></tr>
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
    <table class="big-basket-fields" width="100%">
		<table class="left" width="50%">
<tr class="field">
<td class="left">Тип плательщика:</td>
<td class="right">
<input type="radio" <?php if (!$isCompany) print "checked='checked'"; ?> name="type" value="private" id="private"><label for="private">Частное лицо</label><br>
<input type="radio" <?php if ($isCompany) print "checked='checked'"; ?>  name="type" value="company" id="company"><label for="company">Представитель юридического лица</label></td>
</tr>

                <tr class="field company_name_input">
            <td class="left">
                Название организации:
            </td>
            <td class="right">
                <input type='text' size="40" name='PROPERTY[COMPANY_NAME]' value='<?=$arUser["WORK_COMPANY"]?>' />            </td>
        </tr>

                <tr class="field">
            <td class="left">
                Контактное лицо:
            </td>
            <td class="right">
                <input type='text' size="40" name='PROPERTY[KONT_NAME]' value='<?=$arUser["NAME"]?>' />            </td>
        </tr>
                <tr class="field">
            <td class="left">
                Контактный телефон:
            </td>
            <td class="right">
                <input type='text' size="40" name='PROPERTY[PHONE]' value='<?=$arUser["PERSONAL_PHONE"]?>' />            </td>
        </tr>
		              <tr class="field">
            <td class="left">
                Уведомлять по смс:
            </td>
            <td class="right">
	
                <input type='checkbox' size="40" name='PROPERTY[sms]' value='Да'  <?=$checked?>/>  

				</td>
        </tr> 
                <tr class="field">
            <td class="left">
                E-mail*:
            </td>
            <td class="right">
                <input type='text' size="40" name='PROPERTY[EMAIL]' value='<?=$arUser["EMAIL"]?>' id="property_email"/>  
				
				</td>
        </tr>
		</table>
		<table class="right" width="50%">
                <tr class="field">
            <td class="left">
                Адрес, комментарии и примечания к заказу:
            </td>
            <td class="right">
                <textarea cols="40" rows="5" name='PROPERTY[ABOUT]'></textarea>            </td>
        </tr>
                <tr class="field">
            <td class="left">
                Служба доставки:
            </td>
            <td class="right">
                <input type='radio' checked='checked' name='PROPERTY[DELIVERY]' value='6' />Самовывоз<br/><input type='radio' name='PROPERTY[DELIVERY]' value='7' />Доставка по Москве<br/><input type='radio' name='PROPERTY[DELIVERY]' value='198' />Доставка по Московской области<br/><input type='radio' name='PROPERTY[DELIVERY]' value='199' />Доставка по России<br/>            </td>
        </tr>
                <tr class="field">
            <td class="left">
                Способ оплаты:
            </td>
            <td class="right">
                <input type='radio' checked='checked' name='PROPERTY[PAYMENT]' value='13' />Наличные<br/><input type='radio' name='PROPERTY[PAYMENT]' value='14' />Безналичный расчет<br/>            </td>
        </tr>
<?php
if (!$USER->IsAuthorized()) {
?>
<tr><td class="left"></td>
<td class="right"><br>
<a href="http://detali15.ru/auth/?register=yes&backurl=%2F" id="register">Зарегистрироваться, как постоянный покупатель</a><br>
<p style="padding: 1em; background: #e0e0e0; font-size: 0.8em; width: 300px;">
Регистрация на сайте дает право на получение 5% скидки в случае, если вы - представитель юридического лица.
</p>


</td></tr>
<tr class="register_field">
<td class="left" >E-mail:</td>
<td class="right"><input placeholder="e-mail" size="40" type="text" name="register_email" value="" id="register_email"></td>
</tr>
<tr class="register_field">
<td class="left">Пароль:</td>
<td class="right"><input placeholder="пароль" size="40" type="password" name="register_password" value="" id="register_password"></td>
</tr>
<tr class="register_field">
<td></td>
<td class="right"><input type="button" id="register_user" value=" Зарегистрироваться "></td>
</tr>
<tr class="register_field">
<td></td>
<td class="right">
<div class="error_msg" style="font-size: 0.8em; padding: 0.3em; width: 300px;"></div></td>
</tr>
<?php
} 
?>
</table>
           </table>
   
   <br/>

<br>
   <input style="float: right; font-size: 1.5em;"  type="submit" name="order" id="place_order" value="  <?=GetMessage("ORDER");?>  "/>
</form>
<style>
.register_field {
    display: none;
}
.company_name_input {
    <?php if (!$isCompany) print "display: none;"; ?>
}
</style>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<script>
$(document).ready(function(){
   
   $("#company").click(function() {
      $(".company_name_input").show("slow");
   });
   $("#private").click(function() {
      $(".company_name_input").hide("slow");
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
      if ($("#property_email").val() !== "") {
         //alert("OK");
         return;
        
      }

      if ($("#property_email").val() === "") {
          $("#property_email").css("outline", "solid 5px red").delay(1000).animate({"outline-color": "#eeeeee"}, {duration:1000});
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
</script>
<?else:?>
<?=GetMessage("YENISITE_BASKET_EMPTY")?>
<?endif;?>