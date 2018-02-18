<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if($arParams['INCLUDE_JQUERY'] == 'Y') CJSCore::Init(array("jquery"));

if($this->__folder)
    $pathToTemplateFolder = $this->__folder ;
else
    $pathToTemplateFolder = str_replace(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '', dirname(__FILE__));

$arColorSchemes = array ('red', 'green', 'ice', 'metal', 'pink', 'yellow') ;

if($arParams['THEME'] && in_array($arParams['THEME'], $arColorSchemes, true))
    $color_scheme = $arParams['THEME'] ;
elseif($arParams['THEME'] === "blue")
    $color_scheme = 'ice' ;
elseif(($bitronic_color_scheme = COption::GetOptionString('yenisite.market', 'color_scheme')) && in_array($bitronic_color_scheme, $arColorSchemes))
    $color_scheme = $bitronic_color_scheme ;
else
    $color_scheme = 'red' ;

$APPLICATION->SetAdditionalCSS("{$pathToTemplateFolder}/{$color_scheme}.css");?>

<?
$name = "";
?>

<nav class="navbar navbar-default">
    <div class="navmenu">
        <div class="nav_cor_l"></div>
        <div class="nav_cor_r"></div>
<?if (!empty($arResult)):
    $count_1level = 0;
    foreach($arResult as $arItem) {
        if($arItem["DEPTH_LEVEL"] == 1)
            $count++;
    }
    $previousLevel = 0;
    $cnt = 0;
    $i = 0;
?>
    <ul id="navigator"  class="nav navbar-nav">
    <?foreach($arResult as $arItem):?>
	
		<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
			<?if ($arItem["IS_PARENT"]&&$arItem["DEPTH_LEVEL"] == 1): ?>
				<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]-1));?> </ul></div></li>
			<?else:?>
				<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
			<?endif?>
        <?endif?>
		
        <?if($arItem['DEPTH_LEVEL'] == 1):
            /* $arItem["LINK"] = str_replace("catalog_", "", $arItem["LINK"]);
            $arItem["LINK"] = str_replace("_", "-", $arItem["LINK"]); */
			
			$word = split('_', $arItem["LINK"]);
			$word = $word[0];
			$word = split('/', $word);
			$arItem["LINK"] = str_replace($word[1].'_', "", $arItem["LINK"]);
          //  $arItem["LINK"] = str_replace("_", "-", $arItem["LINK"]);
        endif;?>
        <?if ($arItem["IS_PARENT"]):?>
            <?if ($arItem["DEPTH_LEVEL"] == 1): $cnt++;?>
                <li <?if($cnt==$count) echo "class='last'";?> ><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
                    <div class='subnav'><ul><?$i=0;?>
            <?else:?>
                
				<li class="<?if ($arItem["SELECTED"]):?>item-selected<?endif;?>"><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
				
                <ul>
            <?endif?>
        <?else:?>
            <?if ($arItem["PERMISSION"] > "D"):?>
                <?if ($arItem["DEPTH_LEVEL"] == 1): $cnt++;?>
                    <li <?if($cnt==$count) echo "class='last'";?> ><a href="<?=$arItem["LINK"];?>"><?=$arItem["TEXT"]?></a>
                <?else: $i++;?>
                    
                    <?if ($arItem["SELECTED"]):?>
                        <li class="<?if ($arItem["SELECTED"]):?>item-selected<?endif;?>"><?=$arItem["TEXT"]?></li>
                    <?else:?>
                        <li><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
                    <?endif?>
                <?endif?>
            <?else:?>
                <?if ($arItem["DEPTH_LEVEL"] == 1): $cnt++;?>
                    <?if ($arItem["SELECTED"]):?>
                        <li <?if($cnt==$count) echo "class='last'";?> ><?=$arItem["TEXT"]?></li>
                    <?else:?>
                        <li <?if($cnt==$count) echo "class='last'";?> >><a href="" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
                    <?endif?>
                <?else:?>
                    <li><a href="" class="denied" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
                <?endif?>
            <?endif?>
        <?endif?>
        <?$previousLevel = $arItem["DEPTH_LEVEL"];?>
    <?endforeach?>

    <?if ($previousLevel > 1): //close last item tags?>
        <?=str_repeat("</ul></li>", ($previousLevel-2) );?> </ul></div></li>
    <?endif?>

    </ul>
<?endif?>
    </div>
</nav>

<?
	echo <<<EOT
		<script>
		$(document).ready(function() {
			var li = $(this).find('.item-selected:last');
			var a = li.find('a').eq(0);
			if (a.length == 1 && a.next('ul').length == 1) {
				var txt = a.text();
				var li = a.parent();
				a.remove();
				li.prepend(txt);
			}
		});
		</script>
EOT;

?>