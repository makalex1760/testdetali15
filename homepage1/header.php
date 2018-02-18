<?php
session_start();
require_once('Mobile_Detect.php');
$detect = new Mobile_Detect;

$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');	
$_SESSION["type"]="";

if($_SERVER["REQUEST_URI"] == "/?type=pda") $_SESSION["type"]='MOBILE';
if($_SERVER["REQUEST_URI"] == "/?type=original") $_SESSION["type"]='COMPUTER';

//echo $_SESSION["type"]; echo $deviceType;
if ($deviceType == "phone" && (!$_SESSION["type"] || $_SESSION["type"]=='MOBILE')) {

$_SESSION["type"]='MOBILE';
LocalRedirect("/?type=pda") ; 
exit(); 
} else $_SESSION["type"]='COMPUTER'; 	

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
case 2394: $id_user=87;$admp=1; break;
 default: $id_user=42;	break;
}
 
 $curpage=$APPLICATION->GetCurPage(true);
//if($admp &&  $curpage=='/index.php')LocalRedirect("/katalog/") ;
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
		
		<title><?$APPLICATION->ShowTitle("true")?></title>
		

		<link href="/bitrix/templates/homepage/styles.css" rel="stylesheet" type="text/css" media="only screen and (min-width:981px) and (max-width:3000px)">
		<link href="/dev/abcd.css" type="text/css" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet'  type='text/css'>
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
	<?  if($_SESSION["type"]=='COMPUTER'&& $deviceType=='phone'): ?>
		<div style="width:100%">
		<a style="font-size:200%;font-weight:bold" href='/?type=pda'>Вернуться к мобильной версии сайта</a>
		</div>
		<? endif; ?>
	<!-- Роистат -->
<script>(function(w, d, s, h, id) { w.roistatProjectId = id; w.roistatHost = h; var p = d.location.protocol == "https:" ? "https://" : "http://"; var u = /^.*roistat_visit=[^;]+(.*)?$/.test(d.cookie) ? "/dist/module.js" : "/api/site/1.0/"+id+"/init"; var js = d.createElement(s); js.async = 1; js.src = p+h+u; var js2 = d.getElementsByTagName(s)[0]; js2.parentNode.insertBefore(js, js2);})(window, document, 'script', 'cloud.roistat.com', 'bfa915b3947792e7049d93da73036e26');</script>
		<div id="panel">
			<?$APPLICATION->ShowPanel();?>
		</div>
			<div class="wrapper container" >
		<header >
		<div class="row" >
		<div class="col-md-5 text-center"  style="line-height:200%">
			<a href="/"><img src="/images/logo.png" alt="Детали15 logo"></a><br/>
			<span style="font-size:12px">г. Москва, ул. Коминтерна, д. 20/2</span>
		</div>	
		<div class="col-md-9" style="line-height:100%">
		<b style="font-size:120%">Запчасти для автомобилей ГАЗ</b><br/>
		<a href="http://detali15.ru/img/gaz-b-2019.PDF" target="_blank"><span style="font-size:90%" class="icon1">Официальный сайт торгового представительства ГАЗ</span></a>
							<?$APPLICATION->IncludeComponent("bitrix:search.title", "catalog_title_test", array(
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
		<div class="col-md-7" style="line-height:200%">
		Регионы: <b>8 800 500-72-83</b><br/>
		Москва: <b>8 495 215-09-73</span></b><br/>
		Почта: <a><b>shop@detali15.ru</b></a>
		</div>
		<div class="col-md-5" style="font-size:12px;line-height:100%;">
		<a style="text-decoration:none" href="/login/"><b style="color:#000; font-size:90%;" >Авторизация</b></a> <i class="glyphicon glyphicon-user" style="color:#ff0734"aria-hidden="true"></i>
		<a style="text-decoration:none" href="/login/?register=yes"><b style="color:#000; font-size:90%;" >Регистрация</b></a><br/><br/>
		<div style="line-height:120%;width: 180px; height:50px; color:#00498E; background-color:#00498E;padding:10px 7px">
				<i class="glyphicon glyphicon-shopping-cart" style="float:left; margin:0 5px; text-shadow: -2px 0 #fff, 0 2px #fff, 2px 0 #fff, 0 -2px #fff; font-size: 25px;"></i>
					<?$APPLICATION->IncludeComponent("yenisite:catalog.basket.small", "basket_top", array(
															"VALUTA" => "руб.",
															"BASKET_URL" => "/account/cart/"
															),
															false
					);?>
 
		
		</div>
		</div>
		
		</div>	
		<div class="row text-center"><a href="/content/news/5/40897/?lang=ru" style="color:red; font-weight:bold">Режим работы магазина в новогодние праздники</a> </div>
		</header>
		
		
				<?$APPLICATION->IncludeComponent("bitrix:menu", "detali_test_new", array(
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
	"THEME" => $ys_options["color_scheme"]
	),
	false
);?>
			
	
		
		<div class="row">
			<aside class="col-md-7">
				<a href="/katalog/"><div class="list-group-item headerl" style="color:#fff; font-size:130%">Каталог</div></a>
				<div class="menu-sitemap-tree">
				<?$APPLICATION->IncludeComponent("bitrix:menu", "test_tree_new2", array(
	"ROOT_MENU_TYPE" => "left",
	"MENU_CACHE_TYPE" => "N",
	"MENU_CACHE_TIME" => "3600",
	"MENU_CACHE_USE_GROUPS" => "N",
	"MENU_CACHE_GET_VARS" => array(
	),
	"MAX_LEVEL" => "4",
	"CHILD_MENU_TYPE" => "tree",
	"USE_EXT" => "N",
	"DELAY" => "N",
	"ALLOW_MULTI_SELECT" => "N"
	),
	false
);?>
				</div>
				
				<br/><br/>
				
				<div class="panel panel-primary">
					<div class="panel-heading">Информация</div>
					<div class="panel-body">
					<?$APPLICATION->IncludeComponent("sasha:menu", "info_test", Array(
	"ROOT_MENU_TYPE" => "left3",	// Тип меню для первого уровня
	"MAX_LEVEL" => "1",	// Уровень вложенности меню
	"CHILD_MENU_TYPE" => "tree",	// Тип меню для остальных уровней
	"USE_EXT" => "N",	// Подключать файлы с именами вида .тип_меню.menu_ext.php
	"DELAY" => "N",	// Откладывать выполнение шаблона меню
	"ALLOW_MULTI_SELECT" => "N",	// Разрешить несколько активных пунктов одновременно
	"MENU_CACHE_TYPE" => "N",	// Тип кеширования
	"MENU_CACHE_TIME" => "3600",	// Время кеширования (сек.)
	"MENU_CACHE_USE_GROUPS" => "N",	// Учитывать права доступа
	"MENU_CACHE_GET_VARS" => "",	// Значимые переменные запроса
	),
	false
);?>
			
					</div>
				</div>
			</aside>		
			<section class="col-md-19 hidden-xs content ">	

				
					

			
		
			
					

				
					
     
				

				
			
			
			
				
			
					
				
				
			
				
				
				