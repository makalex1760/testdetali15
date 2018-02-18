<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?=LANG_CHARSET;?>" />
		<meta name="viewport" content="width=device-width">
		<meta name="geo.placename" content="Ярославское ш., 136, Москва, Россия" />
		<meta name="geo.position" content="55.874715;37.717298" />
		<meta name="geo.region" content="" />
		<meta name="ICBM" content="55.874715, 37.717298" />

		<meta name='yandex-verification' content='428ba7d2ed690b22' />
		<link href="//detali15.ru/dev/abcd.css" type="text/css" rel="stylesheet">
		<link href="/bitrix/templates/katalog/min760.css" rel="stylesheet" type="text/css" media="only screen and (min-width:1px) and (max-width:980px)">
		<link href="/bitrix/templates/katalog/15end2.css" rel="stylesheet" type="text/css" media="only screen and (min-width:981px) and (max-width:3000px)">
		       <link href="/bitrix/templates/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />

		<?$APPLICATION->ShowHeadStrings()?>
		<?$APPLICATION->ShowHeadScripts()?>
		<?$APPLICATION->ShowHead()?>
	<?	$roistat="roistat-phone";
		if(date(N) >=1 && date(N) <=5) {
		if(date("H") >=8 && date("H") < 9) $roistat="";
		if(date("H") >=18 && date("H") < 20) $roistat="";
										}
		if(date(N) >=6 && date(N) <=7) 	if(date("H") >=9 && date("H") < 18) $roistat="";
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
if($admp){ $roistat=""; $nalich="OSTATOK";} else $nalich="NALICHIE";

		?>

		<link rel="icon" href="/favicon.ico" type="image/x-icon">
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
		
		<title><?$APPLICATION->ShowTitle()?></title>
     
	
		<!--[if lt IE 9]>
	        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        	<script src="http://css3-mediaqueries-js.googlecode.com/files/css3-mediaqueries.js"></script>
		<![endif]-->
		
		<!--[if lte IE 7]>
		<style>
			.content { margin-right: -1px; }
			ul.nav a { zoom: 1; }
		</style>
		<![endif]-->
       
	</head>
	<body>
		<div id="panel">
			<?$APPLICATION->ShowPanel();?>
		</div>

		<div class="container">
		<h2>Интерфейс для менеджера</h2>
		<header>
		
		<div style="float:left;margin-right:30px">
	<form name="forma1">
	 <? if($_GET["namekl"])$_SESSION["namekl"]=$_GET["namekl"];?>
	 <span class='tooltip' data-title='Спроси как зовут? Организация или физ. лицо'>
 Обращение к клиенту:<input type="text" name="namekl" size="40"   maxlength="100" value="<?=$_SESSION["namekl"]?>">
	</span>
	<? if($_GET["type"])$_SESSION["type"]=$_GET["type"];
	if($_SESSION["type"]) {if($_SESSION["type"]=='private') { $private='checked'; $company='';} else { $private=''; $company='checked';}} else { $private='checked'; $company='';} ?>
 <input type="radio" <?=$private?> name="type" value="private" id="private"><label for="private">Частное лицо</label>
<input type="radio" <?=$company?> name="type" value="company" id="company"><label for="company">Юридическое лицо</label>
 
  <input type="submit" name="submit" value="Сохранить"> 
 
					
 
	</form>
	</div>
	 <?$APPLICATION->IncludeComponent("yenisite:catalog.basket.small", "basket_top", array(
															"VALUTA" => "руб.",
															"BASKET_URL" => "/account/cart/"
															),
															false
					);?>
		</header>
		
			<div class="header">
		
			


				<div id="headmenu">
					<?$APPLICATION->IncludeComponent("bitrix:menu", "bitronic_horizontal3", array(
	"ROOT_MENU_TYPE" => "top",
	"MENU_CACHE_TYPE" => "N",
	"MENU_CACHE_TIME" => "3600",
	"MENU_CACHE_USE_GROUPS" => "N",
	"MENU_CACHE_GET_VARS" => array(
	),
	"MAX_LEVEL" => "2",
	"CHILD_MENU_TYPE" => "child_left",
	"USE_EXT" => "N",
	"DELAY" => "N",
	"ALLOW_MULTI_SELECT" => "N",
	"INCLUDE_JQUERY" => "Y",
	"THEME" => "metal"
	),
	false
);?>
				</div>
	           					
			</div>  
			
			 <div id="poloska"></div>	
			
			<!-- end .header -->
			<div class="sidebar1">
				<div class="menucatalog">
				<?if($admp) $tooltip1="class='tooltip' data-title='Если Вы на нашем сайте назовите код товара'"; ?>
					<span id="catalog"><a href="/katalog/" <?=$tooltip1?>>Каталог</a></span>
					<br>
					<?$APPLICATION->IncludeComponent(
									"bitrix:menu",
									"tree_new",
									Array(
										"ROOT_MENU_TYPE" => "left",
										"MAX_LEVEL" => "4",
										"CHILD_MENU_TYPE" => "tree",
										"USE_EXT" => "N",
										"DELAY" => "N",
										"ALLOW_MULTI_SELECT" => "N",
										"MENU_CACHE_TYPE" => "N",
										"MENU_CACHE_TIME" => "3600",
										"MENU_CACHE_USE_GROUPS" => "N",
										"MENU_CACHE_GET_VARS" => array()
									)
					);?>
     
				</div>
 
				<div class="menucatalog">
					<span id="catalog">Авторизация</span>
					<br>
					<?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "template1", array(
	"REGISTER_URL" => "/auth/",
	"FORGOT_PASSWORD_URL" => "",
	"PROFILE_URL" => "/personal/profile/",
	"SHOW_ERRORS" => "N"
	),
	false
);?>
				</div>
			</div><!-- end .sidebar1 -->

			<div class="content">
				<div id="breadcrumb">
					<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", ".default", array(
	"START_FROM" => "3",
	"PATH" => "",
	"SITE_ID" => "s1"
	),
	false
);?>
				</div>
					
				<h1>
					<?$APPLICATION->ShowTitle(false)?>
				</h1>
				
				