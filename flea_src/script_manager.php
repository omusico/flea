    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.js"></script>
    <script type="text/javascript" src="http://gsgd.co.uk/sandbox/jquery/easing/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="<?=URL;?>/library/nathansearles-Slides/source/slides.min.jquery.js"></script>
    <script type='text/javascript' src='<?=URL;?>/library/boxy-0.1.4/docs/javascripts/jquery.boxy.js'></script>
    <? if($current_page == "/flea/explore.php"){ ?>
    <script type="text/javascript" src="<?=SITE_URL;?>/js/menu.js"></script>
    <? } ?>
    <script type="text/javascript" src="<?=SITE_URL;?>/js/base_js.php"></script>
	<script type="text/javascript">	
		window.fbAsyncInit = function() {
		 	FB.init({appId: '218582441497963', status: true, cookie: true, xfbml: true});
			
			FB.getLoginStatus(function(response) {
				if (response.session)
					FB.Cookie.set(FB.getSession()); // hack: refresh session
			});
		};
		
		(function() {
			var e = document.createElement('script');
			e.type = 'text/javascript';
			e.src = document.location.protocol +
                    '//connect.facebook.net/zh_TW/all.js';
			e.async = true;
			document.getElementById('fb-root').appendChild(e);
		}());
	</script>
    <script>
        $(function(){
            $('#slides').slides({
                preload: true,
                preloadImage: '<?=SITE_URL;?>/images/slide/img/loading.gif',
                play: 5000,
                pause: 2500,
                hoverPause: true
            });
        });
    </script>
    <?  
    if($current_page == "/flea/my.php"){
        $ajaxFileLoader = "my_main_content";
        $ajaxDefaultPage = "message";
    ?>
    <script type="text/javascript">
        var defaultPage = '<?=$ajaxDefaultPage?>';
        function loadAjaxContentURL(){
            $('#<?=$ajaxFileLoader?>').html('<img src="<?=SITE_URL?>/images/loading.gif" />');
            var url = window.location.href;
            var page = url.split("#")[1];
            var ajaxPage = '';
            var para = '';
            if(page==undefined || page==''){
                ajaxPage = defaultPage.split("?")[0];
                para = defaultPage.split("?")[1];
                page = defaultPage;
            }else{
                //reload
                ajaxPage = page.split("?")[0];
                para = page.split("?")[1];
                page = page;
            };
            
            var check_page = page.split("=")[0];
            if(check_page=='access_token'){
                page = 'message';
            }
            $.ajax({
                    url: "<?=SITE_URL?>/flea_src/content/my_page/"+page+".php", 
                    type: "POST",
                    dataType: "html",
                    data:para,
                    success:function(msg){
                        change_mypage_active(page);
                        $('#<?=$ajaxFileLoader?>').html(msg);
                        if(page=='message'){
                            $("#my_news_tabs").tabs();
                        } else if(page=='transaction'){
                            $("#my_transaction_tabs").tabs();
                        }
                    }
            });
            return false;
        }
        function loadAjaxContent(page,para){
            $('#<?=$ajaxFileLoader?>').html('<img src="<?=SITE_URL?>/images/loading.gif" />');
            $.ajax({
                    url: "<?=SITE_URL?>/flea_src/content/my_page/"+page+".php", 
                    type: "POST",
                    dataType: "html",
                    data:para,
                    success:function(msg){
                        change_mypage_active(page);
                        $('#<?=$ajaxFileLoader?>').html(msg);
                        if(page=='message'){
                            $("#my_news_tabs").tabs();
                        } else if(page=='transaction'){
                            $("#my_transaction_tabs").tabs();
                        }
                    }
            });
            return false;
        }
    </script>
    <? } ?>
    <script>
        $(document).ready(function() {
            <? if($current_page == "/flea/my.php"){ ?>
            loadAjaxContentURL();
            <? } ?>
        });  
    </script>
    <script type="text/javascript">
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-23888594-1']);
      _gaq.push(['_trackPageview']);
    
      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    </script>
    <script type="text/javascript">
        var GoSquared={};
        GoSquared.acct = "GSN-615299-W";
        (function(w){
            function gs(){
                w._gstc_lt=+(new Date); var d=document;
                var g = d.createElement("script"); g.type = "text/javascript"; g.async = true; g.src = "//d1l6p2sc9645hc.cloudfront.net/tracker.js";
                var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(g, s);
            }
            w.addEventListener?w.addEventListener("load",gs,false):w.attachEvent("onload",gs);
        })(window);
    </script>
    </body>
</html>