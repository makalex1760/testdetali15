<?
/* require_once('Mobile_Detect.php');
$detect = new Mobile_Detect;	
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');	 */
//$APPLICATION->set_cookie("MOBILE_VISITOR_MB", "MOBILE", time()+3600*24*30); 
//$VISITOR_ID=$APPLICATION->get_cookie("MOBILE_VISITOR_MB"); 
session_start();
$_SESSION["type"]='MOBILE';
?>
<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/".SITE_TEMPLATE_ID."/header.php");
$wizTemplateId = COption::GetOptionString("main", "wizard_template_id", "eshop_adapt_horizontal", SITE_ID);
CUtil::InitJSCore();
CJSCore::Init(array("fx"));
$curPage = $APPLICATION->GetCurPage(true);
/*$catalog=explode("/",$curPage);
if($catalog[1]=='vaz') {$name_f='vaz';LocalRedirect("/catalog/zapchasti_vaz/".$catalog[2]);}
if($catalog[1]=='gaz') {$name_f='gaz';LocalRedirect("/catalog/zapchasti_gaz/".$catalog[2]);}
if($catalog[1]=='kamaz') {$name_f='kamaz';LocalRedirect("/catalog/zapchasti_kamaz/".$catalog[2]);}
if($catalog[1]=='avtoaksessuary') {$name_f='avtoaksessuary';LocalRedirect("/catalog/avtoaksessuary/".$catalog[2]);}*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
	<meta name="geo.placename" content="ул. Коминтерна, 20/2 Москва, Россия, 127221" />
	<meta name="geo.position" content="55.8776190;37.6370880" />
	<meta name="geo.region" content="RU-город Москва" />
	<meta name="ICBM" content="55.8776190, 37.6370880" />
	<link rel="shortcut icon" type="image/x-icon" href="<?=SITE_DIR?>favicon.ico" />
	
	<?
	echo '<meta http-equiv="Content-Type" content="text/html; charset='.LANG_CHARSET.'"'.(true ? ' /':'').'>'."\n";
	$APPLICATION->ShowMeta("robots", false, true);
	$APPLICATION->ShowMeta("keywords", false, true);
	$APPLICATION->ShowMeta("description", false, true);
	$APPLICATION->ShowCSS(true, true);
	?>


	<?
	$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/colors.css");
	$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/style.css");
		$APPLICATION->SetAdditionalCSS("//bitrix/templates/mobile/components/bitrix/menu/catalog_native/style.css"); 

	//$APPLICATION->SetAdditionalCSS("/bitrix/css/main/modal.css");
	//$APPLICATION->SetAdditionalCSS("/bitrix/css/main/font-awesome.css");
	?>
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	
	<?
	$APPLICATION->ShowHeadStrings();
	$APPLICATION->ShowHeadScripts();
	
	$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/script.js");
	?>
	
	<title><?$APPLICATION->ShowTitle()?></title>

</head>
<script>$(window).scroll(function(){
  var top = $(document).scrollTop();
  if (top > 220) $('.top_panel').addClass('showed');
  else $('.top_panel').removeClass('showed');
});
     


</script>
<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:bold&subset=cyrillic,latin' rel='stylesheet' type='text/css'></link>
<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:light&subset=cyrillic,latin' rel='stylesheet' type='text/css'></link>
	<!-- ???-->
<script>(function(w, d, s, h, id) { w.roistatProjectId = id; w.roistatHost = h; var p = d.location.protocol == "https:" ? "https://" : "http://"; var u = /^.*roistat_visit=[^;]+(.*)?$/.test(d.cookie) ? "/dist/module.js" : "/api/site/1.0/"+id+"/init"; var js = d.createElement(s); js.async = 1; js.src = p+h+u; var js2 = d.getElementsByTagName(s)[0]; js2.parentNode.insertBefore(js, js2);})(window, document, 'script', 'cloud.roistat.com', 'bfa915b3947792e7049d93da73036e26');</script>
<body >

<div id="panel"><?$APPLICATION->ShowPanel();?></div>


    

	
<div class="wrap" id="bx_eshop_wrap">	
	<div class="title_mobil">
				<?if ($curPage != SITE_DIR."index.php"):?>
				<h1><?=$APPLICATION->ShowTitle(false);?></h1>
				<? endif ?>
	<a href="/?type=original" >Перейти к полной версии сайта</a> 				
	</div>
 
	
	<div id="workeria">
	
	
		



						

						


		
			
		

			
			
	
				

