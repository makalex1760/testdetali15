<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<noindex>
<div class="bx-system-auth-form">
<?if($arResult["FORM_TYPE"] == "login"):?>
		<noindex><a style="text-decoration:none" href="/login/" rel="nofollow"><b style="color:#000; font-size:90%;" >Авторизация</b></a></noindex> <i class="glyphicon glyphicon-user" style="color:#ff0734"aria-hidden="true"></i>
		<noindex><a style="text-decoration:none" href="/login/?register=yes" rel="nofollow"><b style="color:#000; font-size:90%;" ><?=GetMessage("AUTH_REGISTER")?></b></a></noindex>

<?
//if($arResult["FORM_TYPE"] == "login")
else:
?>

<form class="plmr-form" action="<?=$arResult["AUTH_URL"]?>">
	<table width="95%">
		<tr>
			<td align="center">
				<i class="glyphicon glyphicon-user" style="color:#ff0734"aria-hidden="true"></i>
				<noindex><a href="<?=$arResult["PROFILE_URL"]?>" title="<?=GetMessage("AUTH_PROFILE")?>"><b style="color:#000; font-size:90%;" ><?=$arResult["USER_LOGIN"]?></b></a></noindex>
			<?foreach ($arResult["GET"] as $key => $value):?>
				<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
			<?endforeach?>
			<input type="hidden" name="logout" value="yes" />
			<input type="submit" name="logout_butt" value="<?=GetMessage("AUTH_LOGOUT_BUTTON")?>" />
			</td>
		</tr>
		
	</table>
</form>
<?endif?>
</div>
</noindex>