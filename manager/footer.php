				
		</section> 
				<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
				IncludeTemplateLangFile(__FILE__);
				?> 
  			
			</div><!-- end .content -->
        				
		
		
			

<div id="modal_form"><!-- Само окно --> 
	
     <span id="tovar2">Товар добавлен в корзину<span><br>
     <div style="margin-top:15px"><a href=""  id="modal_close1"  > Перейти к оформлению заказа</a></div>
	 <div  style="margin-top:15px"><a href=""  id="modal_close"  > Остаться на сайте </a> </div>
	
</div>
<div id="overlay"></div><!-- Подложка -->		
   <? if(!$admp):?>	     
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
<?endif;?>
<script> 
 <!-- header top --> 
 
 (function($) {
    $(document).ready(function() {
        var $header = $("header"),
            $clone = $header.before($header.clone().addClass("clone"));
        
        $(window).on("scroll", function() {
            var fromTop = $(document).scrollTop();
            $("body").toggleClass("down", (fromTop > 60));
        });
    });
})(jQuery); 

</script>
</noindex>

	</body>
</html>