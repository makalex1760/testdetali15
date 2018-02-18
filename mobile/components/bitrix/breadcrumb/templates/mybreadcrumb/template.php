<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//delayed function must return a string
if(empty($arResult))
	return "";
	
$strReturn = '<div class="bx_breadcrumbs"><ul>';

$num_items = count($arResult);
for($index = 0, $itemSize = $num_items-2; $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	
	
		$strReturn .= '<li><a href="'.$arResult[$index]["LINK"].'" title="'.$title.'">'.$title.'</a></li>';
	
}

$strReturn .= '</ul></div>';

return $strReturn;
?>