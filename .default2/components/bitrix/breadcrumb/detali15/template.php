<?
//$log=fopen($_SERVER['DOCUMENT_ROOT']."/log3.html","w");
//fputs($log,print_r($arResult,true));

//fputs($log,print_r($APPLICATION->arAdditionalChain),true);
//fputs($log,print_r($APPLICATION->ShowNavChain(),true));
//$APPLICATION->ShowNavChain();
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//delayed function must return a string
if(empty($arResult))
	return "";

$strReturn = '<ul style="padding-left:0px; font-size:85%;margin-bottom:20px" class="breadcrumb-navigation">';

for($index = 0, $itemSize = count($arResult); $index < $itemSize; $index++)
{
	if($index > 0)
		$strReturn .= '<li><span>&nbsp;&rarr;&nbsp;</span></li>';

	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	if($arResult[$index]["LINK"] <> ""&&$index<(count($arResult)-1))
		$strReturn .= '<li><a href="'.$arResult[$index]["LINK"].'" title="'.$title.'">'.$title.'</a></li>';
	else
		$strReturn .= '<li>'.$title.'</li>';
}

$strReturn .= '</ul>';
//$strReturn .= print_r($arResult,true);
return $strReturn;
?>
