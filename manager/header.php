<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?=LANG_CHARSET;?>" />
		<meta name="viewport" content="width=device-width">
		<meta name="geo.placename" content="ул. Коминтерна, д.20/2, Москва, Россия" />
		<meta name="geo.position" content="55.86722;37.68417" />
		<meta name="geo.region" content="" />
		<meta name="ICBM" content="55.874715, 37.717298" />

		<meta name='yandex-verification' content='428ba7d2ed690b22' />
		<link href="//detali15.ru/dev/abcd.css" type="text/css" rel="stylesheet">
		<link href="/bitrix/templates/katalog/min760.css" rel="stylesheet" type="text/css" media="only screen and (min-width:1px) and (max-width:980px)">
		<link href="/bitrix/templates/katalog/15end2.css" rel="stylesheet" type="text/css" media="only screen and (min-width:981px) and (max-width:3000px)">
		       <link href="/bitrix/templates/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
		<link href="/bitrix/templates/homepage/styles.css" rel="stylesheet" type="text/css" media="only screen and (min-width:981px) and (max-width:3000px)">
		
		<?$APPLICATION->ShowHeadStrings()?>
		<?$APPLICATION->ShowHeadScripts()?>
		<?$APPLICATION->ShowHead()?>
	<?	$roistat="roistat-phone";
		if(date(N) >=1 && date(N) <=5) {
		if(date("H") >=8 && date("H") < 9) $roistat="";
		if(date("H") >=18 && date("H") < 20) $roistat="";
										}
		if(date(N) >=6 && date(N) <=7) 	if(date("H") >=9 && date("H") < 18) $roistat="";

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
	<body style="background-color:#fff">
	<!-- Роистат -->
<!--* <script>(function(w, d, s, h, id) { w.roistatProjectId = id; w.roistatHost = h; var p = d.location.protocol == "https:" ? "https://" : "http://"; var u = /^.*roistat_visit=[^;]+(.*)?$/.test(d.cookie) ? "/dist/module.js" : "/api/site/1.0/"+id+"/init"; var js = d.createElement(s); js.async = 1; js.src = p+h+u; var js2 = d.getElementsByTagName(s)[0]; js2.parentNode.insertBefore(js, js2);})(window, document, 'script', 'cloud.roistat.com', 'bfa915b3947792e7049d93da73036e26');</script> -->
		<div id="panel">
			<?$APPLICATION->ShowPanel();?>
		</div>
		<div class="wrapper container" style="margin-top:15px">
		
			<div style="float:left; font-weight:bold; font-size:150%; margin-right: 50px">Интерфейс для менеджера </div>
				
				<div style="padding-top:10px; width:600px;float:left">
				<span class='tooltip' data-title='Если Вы на нашем сайте назовите код товара'>				
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
					</span>
					</div>
			<div style="clear:both"></div> 
			
		<table width="100%"cellspacing="1">
		<tr>
		
		<td>
		<span class='tooltip' data-title='Какой товар вас интересует. Мы можем организовать доставку  ТК Деловые Линии, EMS Почта России или удобной для вас компанией.'><i>Есть ли филиал вашего магазина в другом городе?</i> </span>
		</td>
		<td>
		<span class='tooltip' data-title='Да работаем. Если продиктуете адрес электронной почты, вышлем вам коммерческое предложение и договор на рассмотрение. Так же вы можете зарегестрироваться на нашем сайте как Юр.лицо  и получить скидку до 10%.'><i>Вы работаете по безналичному расчету?</i> </span>
		</td>
		<td>
		<span class='tooltip' data-title='У вас организация с парком автомобилей? Сейчас переведу звонок на руководителя. Если руководителя нет, берем контактные телефоны.'><i>Интересуют оптовые цены на запчасти?</i> </span>
		</td>

		</tr>
		<tr>
		
		<td>
		<span class='tooltip' data-title='Да,у нас цены указаны с НДС,Вы хотите приобретать запчасти для вашего парка? Надо завязать диалог:вытащить всю информацию по парку( колличество а/м,марки),уточнить контактный телефон,соединить с Закутным О.В.'><i>Хотим приобретать товар по безналичному расчету.У вас цены на сайте с НДС?</i> </span>
		</td>
		
		</tr>
		</table>
	
		<br/>
	<header style="background-color:#fff;height:50px">
		
		<div style="float:left;margin-right:30px">
	<form name="forma1">
	 <? if($_GET["namekl"])$_SESSION["namekl"]=$_GET["namekl"];
	 if($_GET["promokod"])$_SESSION["promokod"]=$_GET["promokod"];
	
	 ?>
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
	"THEME" => "metal"
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


	
	<section class="col-md-19 content">
	