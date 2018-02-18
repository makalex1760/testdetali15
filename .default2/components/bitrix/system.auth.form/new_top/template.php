<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if($arResult["FORM_TYPE"] == "login"):?>
<?
if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'])
	ShowMessage($arResult['ERROR_MESSAGE']);
?>
<form name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
<?if($arResult["BACKURL"] <> ''):?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?endif?>
<?foreach ($arResult["POST"] as $key => $value):?>
	<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
<?endforeach?>
	<input type="hidden" name="AUTH_FORM" value="Y" />
	<input type="hidden" name="TYPE" value="AUTH" />
<?=GetMessage("AUTH_LOGIN")?>: <input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>" size="17" />
<?=GetMessage("AUTH_PASSWORD")?>: 
<input type="password" name="USER_PASSWORD" maxlength="50" size="17" />
<?if($arResult["SECURE_AUTH"]):?>
				<span class="bx-auth-secure" id="bx_auth_secure<?=$arResult["RND"]?>" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
					<div class="bx-auth-secure-icon"></div>
  </span>
				<noscript>
				<span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>"></span>
				</noscript>
<script type="text/javascript">
document.getElementById('bx_auth_secure<?=$arResult["RND"]?>').style.display = 'inline-block';
</script>
<?endif?>

<?if ($arResult["STORE_PASSWORD"] == "Y"):?>
<input type="checkbox" id="USER_REMEMBER_frm" name="USER_REMEMBER" value="Y" />
<label for="USER_REMEMBER_frm" title="<?=GetMessage("AUTH_REMEMBER_ME")?>"><?echo GetMessage("AUTH_REMEMBER_SHORT")?></label>
<?endif?>
<?if ($arResult["CAPTCHA_CODE"]):?>
		<?echo GetMessage("AUTH_CAPTCHA_PROMT")?>:	<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
			<img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
			<input type="text" name="captcha_word" maxlength="50" value="" />
		
<?endif?>
		<input type="submit" name="Login" value="<?=GetMessage("AUTH_LOGIN_BUTTON")?>" />
<?if($arResult["NEW_USER_REGISTRATION"] == "Y"):?>
<noindex><a href="<?=$arResult["AUTH_REGISTER_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_REGISTER")?></a></noindex>
<?endif?>
<noindex><a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a></noindex>


<?
//if($arResult["FORM_TYPE"] == "login")
else:
?>

<form action="<?=$arResult["AUTH_URL"]?>">
				<?=$arResult["USER_NAME"]?>
				[<?=$arResult["USER_LOGIN"]?>]
				<a href="<?=$arResult["PROFILE_URL"]?>" title="<?=GetMessage("AUTH_PROFILE")?>"><?=GetMessage("AUTH_PROFILE")?></a>
			<?foreach ($arResult["GET"] as $key => $value):?>
				<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
			<?endforeach?>
			<input type="hidden" name="logout" value="yes" />
			<input type="submit" name="logout_butt" value="<?=GetMessage("AUTH_LOGOUT_BUTTON")?>" />
</form>
<?endif?>