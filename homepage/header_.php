<?php
require_once('Mobile_Detect.php');
$detect = new Mobile_Detect;	
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');	
$VISITOR_ID = $APPLICATION->get_cookie("MOBILE_VISITOR_MB"); 
//echo "test";print_r($APPLICATION->get_cookie("MOBILE_VISITOR_MB"));
if ($deviceType == "phone" && $_SERVER["SERVER_NAME"] == "detali15.ru/"  && empty($VISITOR_ID) ) { 
$APPLICATION->set_cookie("MOBILE_VISITOR_MB", "MOBILE", time()+3600*24*30,'/'); 
LocalRedirect("http://detali15.ru/?type=pda") ; 
exit(); 
} 
?>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?=LANG_CHARSET;?>" />
		<meta name="viewport" content="width=device-width">
		<meta name="geo.placename" content="ул. Коминтерна, д.20/2, Москва, Россия" />
		<meta name="geo.position" content="55.86722;37.68417" />
		<meta name="geo.region" content="" />
		<meta name="ICBM" content="55.86722, 37.68417" />

		<meta name='yandex-verification' content='428ba7d2ed690b22' />

		<?$APPLICATION->ShowHeadStrings()?>
		<?$APPLICATION->ShowHeadScripts()?>
		<?$APPLICATION->ShowHead()?>
		<? 
		$roistat="roistat-phone";
		if(date(N) >=1 && date(N) <=5) {
		if(date("H") >=8 && date("H") < 9) $roistat="";
		if(date("H") >=18 && date("H") < 20) $roistat="";
										}
		if(date(N) >=6 && date(N) <=7) 	if(date("H") >=9 && date("H") < 18) $roistat="";
		?>
		<link rel="icon" href="/favicon.ico" type="image/x-icon">
		<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
		
		<title><?$APPLICATION->ShowTitle()?></title>
       <link href="/bitrix/templates/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
		<link href="/bitrix/templates/homepage/min760.css" rel="stylesheet" type="text/css" media="only screen and (min-width:1px) and (max-width:980px)">
		<link href="/bitrix/templates/homepage/15end2.css" rel="stylesheet" type="text/css" media="only screen and (min-width:981px) and (max-width:3000px)">
	
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
	<!-- Роистат -->
<script>(function(w, d, s, h, id) { w.roistatProjectId = id; w.roistatHost = h; var p = d.location.protocol == "https:" ? "https://" : "http://"; var u = /^.*roistat_visit=[^;]+(.*)?$/.test(d.cookie) ? "/dist/module.js" : "/api/site/1.0/"+id+"/init"; var js = d.createElement(s); js.async = 1; js.src = p+h+u; var js2 = d.getElementsByTagName(s)[0]; js2.parentNode.insertBefore(js, js2);})(window, document, 'script', 'cloud.roistat.com', 'bfa915b3947792e7049d93da73036e26');</script>
		<div id="panel">
			<?$APPLICATION->ShowPanel();?>
		</div>

		<div class="container">
			<div class="header">
				<div id="headlogo">
					<a href="http://detali15.ru"><img src="http://detali15.ru/img/detalimashin-moscow.jpg" name="logopic" id="logopic" border="0" /></a>
					       г. Москва, ул. Коминтерна, д.20/2
				</div>
				<div id="headbasket">
					<?$APPLICATION->IncludeComponent("yenisite:catalog.basket.small", "basket_top", array(
															"VALUTA" => "руб.",
															"BASKET_URL" => "/account/cart/"
															),
															false
					);?>
				</div>
				<div id="headcenter">
					<span id="avtozap">ЗАПЧАСТИ для автомобилей ГАЗ</span>
					<br>
					<a href="http://detali15.ru/img/gaz-b-2019.PDF" target="_blank">Официальный сайт торгового представителя завода ГАЗ</a>
					<br>
					<?$APPLICATION->IncludeComponent("bitrix:search.title", "catalog_title", array(
															"NUM_CATEGORIES" => "1",
															"TOP_COUNT" => "12",
															"ORDER" => "rank",
															"USE_LANGUAGE_GUESS" => "Y",
															"CHECK_DATES" => "N",
															"SHOW_OTHERS" => "Y",
															"PAGE" => "/search/index.php",
															"CATEGORY_OTHERS_TITLE" => "",
															"CATEGORY_0_TITLE" => "Автозапчасти",
															"CATEGORY_0" => array(
																		0 => "iblock_catalog",
																	),
															"CATEGORY_0_iblock_catalog" => array(
																				0 => "6",
																			),
															"SHOW_INPUT" => "Y",
															"INPUT_ID" => "title-search-input",
															"CONTAINER_ID" => "title-search",
															"PRICE_CODE" => array(
																	),
															"PROPERTY_CODE" => array(
																		0 => "PRICE_BASE",
																		1 => "KOD_TOVAR",
																		2 => "NALICHIE",
																		3 => "",
																		)
															),
															false
					);?>	
				</div>
				<div id="headcontact">
					Для регионов бесплатно:
					<span id="phone">8 (800) 500-72-83</span>
					<br />
					Для Москвы:
					<!--<span id="phone">+7 (495) 215-09-73</span>-->
					<span id="phone" class="<?=$roistat?>">+7 (495) 215-09-73</span>
					<br />
					<a href="mailto:shop@detali15.ru" title="shop@detali15.ru" ><font size="2">shop@detali15.ru</font></a>
				</div>
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
	            <div id="poloska"></div>						
			</div> <!-- end .header -->
			<div class="sidebar1">
				<div class="menucatalog">
					<span id="catalog"><a href="/katalog/">Каталог</a></span>
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
					<?$APPLICATION->IncludeComponent(
							"bitrix:breadcrumb",
							".default",
							Array(
								"START_FROM" => "4",
								"PATH" => "",
								"SITE_ID" => "s1"
							)
					);?>
				</div>
					
				<h1>
					<?$APPLICATION->ShowTitle(false)?>
				</h1>
				
				
				