<? require_once('/var/www/html/flea/flea_src/base_functions.php'); ?>
<? setcookie("edit_box_id", $_GET['box_id'],0,"/",".dctlab.nccu.edu.tw"); ?>
<!DOCTYPE html>
<html xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
        <title>政!大福利市集</title>
        <meta name="description" content="NCCU Flea Market" />
        <meta property="fb:app_id" content="218582441497963" />
        <meta property="og:title" content="政!大福利市集" />
        <meta property="og:site_name" content="NCCU Flea Market" />
        <meta property="og:type" content="company" />
        <meta property="og:description" content="NCCU Flea Market" />
        <meta property="og:url" content="<?=SITE_URL;?>" />
        <meta property="og:image" content="<?=SITE_URL;?>/images/logo.png" />
		<style type="text/css" media="screen">
            * {
                margin: 0;
                padding: 0;
            }
            body{
                font-family:"Microsoft JhengHei","微軟正黑體", Helvetica, Arial, sans-serif;
                font-size:12px;
                color:#333;
            }
            a{
                color:#000;
                text-decoration: underline;
                cursor:pointer;
            }
            a:hover{
                color:#36c;
            }
            img{
                border: none;
            }
            .clearboth{
                clear:both;
            }
            canvas 	{ background-color: transparent; border: 0px solid gray; top: 0; left: 0; position: absolute;}
            canvas.resize-ne { cursor: ne-resize; }
            canvas.resize-se { cursor: se-resize; }
            canvas.resize-sw { cursor: sw-resize; }
            canvas.resize-nw { cursor: nw-resize; }
            canvas.move { cursor: move; }
            canvas.default { cursor: default; }
            img 	{ display: block; visibility: hidden; position: absolute; top: -1000; left: -1000; }
            #ft 	{ background-color: #eee; height: 50px; width: 100%; border-top: 1px solid #ccc; padding: 5px; position: absolute; bottom: 0; left: 0; }
            #ft span { width: 100%; }
            
            /* start of button style */
            .butt {
                font-size:12px; 
                color:#fff; 
                background-color: black;
                background-image: url(/flea/images/button_bg.jpg);
                border: 1px solid #000;
                text-align: center;
                padding: 2px 8px;
            }
            .butt:hover, .butt-cancel:hover {
                font-size:12px; 
                color:#fff; 
                background-color: #d40000;
                background-image: url(/flea/images/button_bg_over.jpg);
                border: 1px solid #d40000;
                text-align: center;
            }
            .butt[disabled], .butt.disabled, .butt[disabled]:hover, .butt.disabled:hover,
            .butt-cancel[disabled], .butt-cancel.disabled, .butt-cancel[disabled]:hover, .butt-cancel.disabled:hover {
                color:#eee;
                background-color: #aaa;
                background-image: none;
                border: 1px solid #999;
            }
            .butt-cancel {
                font-size:12px; 
                color:#000; 
                background-color: #ccc;
                background-image: url(/flea/images/button_reg_bg.jpg);
                border: 1px solid #c4c4c4;
                text-align: center;
                padding: 2px 8px;
            }
            /* end of button style */
            .func_block{
                float:left;
                width: 90px;
                padding-top:15px;
            }
            .style_block{
                float:left;
                width: 200px;
            }
            fieldset { 
                width: 200px; 
                padding-bottom: 10px;
            }
            /*input { 
                margin-left: 20px; 
            }*/
            #new_ft {
                background-color: #eee; height: 23px; width: 450px; border-top: 1px solid #ccc; padding: 3px; position: absolute; bottom: 0; left: 0;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div id="fb-root"></div>
        <? if(!empty($_COOKIE['user_id'])){ ?>
        <?
            $box_obj = new FleaBox($_GET['box_id']);
            $user_obj = new FleaUser($_COOKIE['user_id']);
            $dbc = connectdb();
        ?>
        <canvas id="canvid1"></canvas>
        <?
        $query_box_item = "SELECT id,item_id,type FROM box_item WHERE box_id='$box_obj->id' AND status!='is_deleted' AND status='for_sale' ORDER BY id DESC";
        $query_box_item_result = mysql_query($query_box_item, $dbc);
        $img_array = array();
        while ($query_box_item_result_data = mysql_fetch_array($query_box_item_result)) {
            $box_item_obj = '';
            $item_type = '';
            if($query_box_item_result_data['type']=='normal'){
                $box_item_obj = new FleaTransactionItem($query_box_item_result_data['item_id']);
                $item_type = 'normail';
            } else {
                $box_item_obj = new FleaSpecialItem($query_box_item_result_data['item_id']);
                $item_type = 'special';
            }
            array_push($img_array, "item_img".$query_box_item_result_data['id']);
        ?>
        <img id="item_img<?=$query_box_item_result_data['id']?>" src="<?=$box_item_obj->getItemIconR('640');?>" />
        <?
            unset($box_item_obj);
        }
        mysql_free_result($query_box_item_result);
        ?>
        <img id="bg" src="<?=SITE_URL;?>/images/noboxpic/noboxpic_640r.png" width="450" />
        <!--<div id="ft">
            <div class="style_block">
                <fieldset>
                    <legend>套用樣式</legend>
                    <span><input type="radio" name="some_name" value="" id="togglenone" /> 不套用</span>
                    <span><input type="radio" name="some_name" value="" id="togglepolaroid" /> 拍立得樣式</span>
                </fieldset>
            </div>
            <div class="func_block">
                <input type="button" id="jpegbutton"  class="TBbtn butt-cancel" value="儲存" />
                <input type="button" id="pngbutton" value="Export to PNG (heavy)" />
            </div>
            <br class="clearboth" />
            <span><input type="checkbox" name="some_name" value="" id="showcorners" /> Show corners<span>
        </div>-->
        <div id="new_ft">
            <input type="button" id="movetolastbutton"  class="TBbtn butt-cancel" value="移至最後" />
            <input type="button" id="jpegbutton"  class="TBbtn butt-cancel" value="儲存" />
        </div>
        <? } ?>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.js"></script>
        <script src="<?=SITE_URL;?>/js/canvas/utilities.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?=SITE_URL;?>/js/canvas/canvaselement.js" type="text/javascript" charset="utf-8"></script>
        <script src="<?=SITE_URL;?>/js/canvas/canvasimg.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" charset="utf-8">
            var CanvasDemo = function() {
                var YD = YAHOO.util.Dom;
                var YE = YAHOO.util.Event;
                var canvas1;
                var img = [];
                return {
                    init: function() {
                        canvas1 = new Canvas.Element();
                        //canvas1.init('canvid1',  { width: YD.getViewportWidth() - 5, height: YD.getViewportHeight() - 5 });
                        canvas1.init('canvid1',  { width: 450, height: 450 });
                        <?
                        for($i=0; $i<sizeof($img_array); $i++){
                        ?>
                        img['<?=$i?>'] = new Canvas.Img('<?=$img_array[$i]?>', { top: 100, left: 100, scalex:0.3, scaley:0.3 ,borderwidth: 0 });
                        <?
                        }
                        ?>
                        //img[img.length] = new Canvas.Img('img2', { top: 100, left: 100, scalex:1, scaley:1 });
                        //img[img.length] = new Canvas.Img('img3', { top: 100, left: 100, scalex:1, scaley:1 });
                        img['<?=sizeof($img_array)?>'] = new Canvas.Img('bg', {});
                        // @param array of images ToDo: individual images
                        
                        <?
                        for($i=0; $i<sizeof($img_array); $i++){
                        ?>
                        canvas1.addImage(img['<?=$i?>']);
                        <?
                        }
                        ?>
                        //canvas1.addImage(img[0]);
                        //canvas1.addImage(img[1]);
                        //canvas1.addImage(img[2]);
                        canvas1.setCanvasBackground(img[<?=sizeof($img_array)?>]);
                        this.initEvents();
                        
                        this.showCorners();
                        canvas1.renderAll();
                    },
                    initEvents: function() {
                        YE.on('togglebg','click', this.toggleBg, this, true);
                        YE.on('showcorners','click', this.showCorners, this, true);
                        YE.on('togglenone','click', this.toggleNone, this, true);
                        YE.on('toggleborders','click', this.toggleBorders, this, true);
                        YE.on('togglepolaroid','click', this.togglePolaroid, this, true);
                        YE.on('pngbutton','click', function() { this.convertTo('png') }, this, true);
                        YE.on('jpegbutton','click', function() { this.convertTo('jpeg') }, this, true);
                        YE.on('movetolastbutton','click', this.moveToLast, this, true);
                    },
                    switchBg: function() {
                        canvas1.fillBackground = (canvas1.fillBackground) ? false : true;							
                        canvas1.renderAll();
                    },
                    moveToLast: function() {
                        canvas1.moveToLast();
                    },
                    //! insert these functions to the library. No access to _aImages should be done from here
                    showCorners: function() {
                        this.cornersvisible = (this.cornersvisible) ? false : true;
                        for (var i = 0, l = canvas1._aImages.length; i < l; i += 1) {
                            canvas1._aImages[i].setCornersVisibility(this.cornersvisible);
                        }
                        canvas1.renderAll();
                    },
                    toggleNone: function() {
                        for (var i = 0, l = canvas1._aImages.length; i < l; i += 1) {
                            canvas1._aImages[i].setBorderVisibility(false);
                        }
                        canvas1.renderAll();
                    },
                    toggleBorders: function() {
                        for (var i = 0, l = canvas1._aImages.length; i < l; i += 1) {
                            canvas1._aImages[i].setBorderVisibility(true);
                        }
                        canvas1.renderAll();
                    },
                    togglePolaroid: function() {
                        for (var i = 0, l = canvas1._aImages.length; i < l; i += 1) {
                            canvas1._aImages[i].setPolaroidVisibility(true);
                        }
                        canvas1.renderAll();
                    },
                    convertTo: function(format) {
                        this.showCorners();
                        var imgData = canvas1.canvasTo(format);
                        //window.open(imgData, "_blank");
                        var req_url = "/flea/flea_src/action/upload_boxcover_action.php";
                        $.ajax({
                            url: req_url, 
                            type: "POST",
                            dataType: "json",
                            contentType: "application/upload",
                            data: "data="+imgData,
                            success:function(msg){
                                parent.iframe_call_box_cover(msg.status,msg.box_id);
                            }
                        });
                        
                    },
                    whatever: function(e, o) {
                        // console.log(e);
                        // console.log(o);
                    }
                }
            }();
            YAHOO.util.Event.on(window, 'load', CanvasDemo.init, CanvasDemo, true);
        </script>
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
