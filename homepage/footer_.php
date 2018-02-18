				
				<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
				IncludeTemplateLangFile(__FILE__);
				?> 
        				
				<br />
			
			</div><!-- end .content -->
			
			<div class="sidebar2">
			
				<?$APPLICATION->IncludeComponent(
							"bitrix:main.include", 
							".default", 
							array(
								"AREA_FILE_SHOW" => "file",
								"PATH" => "/sect_right.php",
								"EDIT_TEMPLATE" => "sect_inc.php"
							),
							false
				);?> 
			</div><!-- end .sidebar2 -->
			
			<div class="footer">
				<div id="footertop">
					<strong>Адрес магазина автозапчастей: Москва, ул. Коминтерна, д.20/2</strong>
					<br />
					Для регионов бесплатно: 8 (800) 500-72-83
					<br /> 
					Для Москвы, многоканальный: +7 (495) 215-09-73
					<br />
                                        <a href="/site_map.php">Карта сайта</a><br />
					    
				</div>
				<div id="footerleft">
					<noindex>

						<!-- Yandex.Metrika counter -->
 						<div style="display: none;"> 
							<script type="text/javascript">
								(function(w, c) {
									(w[c] = w[c] || []).push(function() {
										try {
											w.yaCounter9872791 = new Ya.Metrika({id:9872791, enableAll: true, webvisor:true});
									        }
									        catch(e) { }
									});
								})(window, "yandex_metrika_callbacks");
							</script>
						</div>
         
						<script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript" defer></script>

						<noscript> 
							<div>		
								<img src="//mc.yandex.ru/watch/9872791" style="position:absolute; left:-9999px;" />
							</div>
						</noscript> 
						<!-- /Yandex.Metrika counter -->
					</noindex>
				</div>
				<div id="footerright">

				</div>
			</div><!-- end .footer -->
		</div><!-- end .container -->
                <noindex>
		<script async src="https://w.uptolike.com/widgets/v1/zp.js?pid=978844" type="text/javascript"></script>
<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
(function(){ var widget_id = 'fmzhIieMDL';
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);})();</script>
<!-- {/literal} END JIVOSITE CODE --> 

<!-- BEGIN JIVOSITE INTEGRATION WITH ROISTAT -->
<script type='text/javascript'>
var getCookie = window.getCookie = function (name) {
        var matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
        return matches ? decodeURIComponent(matches[1]) : undefined;
};
function jivo_onLoadCallback() {
        jivo_api.setUserToken(getCookie('roistat_visit'));
}
</script>
<!-- END JIVOSITE INTEGRATION WITH ROISTAT --> 
 <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-81359934-1', 'auto');
  ga('send', 'pageview');

</script>
 </noindex> 			
	</body>
</html>