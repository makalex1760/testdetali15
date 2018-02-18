<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<? if(!$arResult['ERRORS'])
{
	switch($arResult['RESULT'])
	{
		case 'OK': $mes = GetMessage('PRMEDIA_OK'); break;
		case 'AUTHORIZED_USER_OK': $mes = GetMessage('PRMEDIA_AUTHORIZED_USER_OK'); break;
		case 'UNSUBSCRIBE_OK': $mes = GetMessage('UNSUBSCRIBE_OK'); break;
		case 'SUBSCRIBE_CONFIRMED': $mes = GetMessage('PRMEDIA_SUBSCRIBE_CONFIRMED'); break;
	}
	?>
    <div class="prmedia_subscribe_ok"><?=$mes?></div>
    <?
}
?>

<div class="prmedia_subscribe_form">
    <form action="" method="post">
    	<? if($arResult['ERRORS']):?>
			<? foreach($arResult['ERRORS'] as $error):?>
                <div class="error"><?=$error?></div>    
            <? endforeach; ?>
	    <? endif;?>
        <p class="title"><?=$arResult['TITLE']?></p>
        <? if($arResult['SHOW_EMAIL_FIELD'] != 'N'):?>
        <p class="email"><?=GetMessage("PRMEDIA_EMAIL"); ?>:</p>
        <input type="text" name="prmedia_subscribe_email" class="email" value="<?=$_POST['prmedia_subscribe_email']?>" />
        <? endif;?>
        <?  if($arResult['USE_CAPTCHA'] == 'Y'):?>
        <p class="captcha"><?=GetMessage("PRMEDIA_CAPTCHA"); ?>:</p>
        <img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" alt="CAPTCHA" style="width: 125px; height: 30px; float: left; margin-right: 5px;" />
        <input type="text" name="captcha_word" class="captcha" maxlength="5" />
        <input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>"  />
        <? endif; ?>
        <input type="image" style="margin-top: 5px;" value="<? if($arResult['USER_SUBSCRIBED'] == 'Y'):?>un<? endif;?>subscribe" name="prmedia_subscribe_submit" src="<?=$this->__folder?>/images/<? if($arResult['USER_SUBSCRIBED'] == 'Y'):?>un<? endif;?>subscribe.png" />
    </form>
</div>