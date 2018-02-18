</div>
</div>								
	<div class="notive header">
		<a href="javascript:void(0)" onclick="eshopOpenNativeMenu()" class="gn_general_nav notive"></a>
		<a href="<?=SITE_DIR?>account/cart/" class="cart_link notive"></a>
		<?if ($curPage != SITE_DIR."index.php"):?>	
	<div class="tel_mob white">   
         <a href="tel:+74952150973" class="roistat-phone">+7 (495) 215-09-73</a> 

		</div>
		<? else: ?>
		<div id="catalog_mob">   
         <a href="<?=SITE_DIR?>catalog/">Каталог товаров</a>  

		</div>
		<? endif ?>
		<div class="clb"></div>
	</div>
	<div class="menu-page" id="bx_native_menu">
		<div class="menu-items">
		<?$APPLICATION->IncludeComponent("bitrix:menu", "catalog_native", array(
				"ROOT_MENU_TYPE" => "top_mobil",
				"MENU_CACHE_TYPE" => "A",
				"MENU_CACHE_TIME" => "36000000",
				"MENU_CACHE_USE_GROUPS" => "Y",
				"CACHE_SELECTED_ITEMS" => "N",
				"MENU_CACHE_GET_VARS" => array(
				),
				"MAX_LEVEL" => "1",
				"CHILD_MENU_TYPE" => "top_mobil",
				"USE_EXT" => "N",
				"DELAY" => "N",
				"ALLOW_MULTI_SELECT" => "N"
			),
			false
		);?>
		
		</div>
	</div>

 
<footer id="foot_mobil">

					
						<!-- Yandex.Metrika counter -->
						<script type="text/javascript">
						(function (d, w, c) {
							(w[c] = w[c] || []).push(function() {
							try {
							w.yaCounter26877837 = new Ya.Metrika({id:26877837,
							webvisor:true,
							clickmap:true,
							trackLinks:true,
							accurateTrackBounce:true});
							} catch(e) { }
						});

						var n = d.getElementsByTagName("script")[0],
						s = d.createElement("script"),
						f = function () { n.parentNode.insertBefore(s, n); };
						s.type = "text/javascript";
						s.async = true;
						s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

						if (w.opera == "[object Opera]") {
						d.addEventListener("DOMContentLoaded", f, false);
						} else { f(); }
						})(document, window, "yandex_metrika_callbacks");
						</script>
						<noscript>
						<div><img src="//mc.yandex.ru/watch/26877837" style="position:absolute; left:-9999px;" alt="" /></div>
						</noscript>
						<!-- /Yandex.Metrika counter -->

<div id="copyright">© <a href="/">Магазин автозапчасти</a>&nbsp;<br/>Москва, ул. Коминтерна, д.20/2, 2015</div>
</footer>
							

<div id="modal_form"><!-- Само окно --> 
	
     <span id="tovar2">Товар добавлен в корзину<span><br>
     <div style="margin-top:15px"><a href=""  id="modal_close1"  > Перейти к оформлению заказа</a></div>
	 <div  style="margin-top:15px"><a href=""  id="modal_close"  > Остаться на сайте </a> </div>
	
</div>
<div id="overlay"></div><!-- Подложка -->	
</body>
</html>