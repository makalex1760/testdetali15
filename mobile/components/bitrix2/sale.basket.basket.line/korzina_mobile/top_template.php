<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();?>

<div class="bx-hdr-profile">
	<?if ($arParams['SHOW_AUTHOR'] == 'Y'):?>
		<div class="bx-basket-block">
			<i class="fa fa-user"></i>
			<?if ($USER->IsAuthorized()):
				$name = trim($USER->GetFullName());
				if (! $name)
					$name = trim($USER->GetLogin());
				if (strlen($name) > 15)
					$name = substr($name, 0, 12).'...';
				?>
				<a href="<?=$arParams['PATH_TO_PROFILE']?>"><?=$name?></a>
				&nbsp;
				<a href="?logout=yes"><?=GetMessage('TSB1_LOGOUT')?></a>
			<?else:?>
				<a href="<?=$arParams['PATH_TO_REGISTER']?>?login=yes"><?=GetMessage('TSB1_LOGIN')?></a>
				&nbsp;
				<a href="<?=$arParams['PATH_TO_REGISTER']?>?register=yes"><?=GetMessage('TSB1_REGISTER')?></a>
			<?endif?>
		</div>
	<?endif?>

	<div class="bx-basket-block">
		
		<a class="kor_mob" href="<?=$arParams['PATH_TO_BASKET']?>"></a>
		
	</div>
</div>
