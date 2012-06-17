<? require_once('/var/www/html/flea/flea_src/base_functions.php'); ?>
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
        <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
        <style type="text/css">
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
            #dropped_item_block{
                width: 480px;
                margin-left: 10px;
                float: left;
            }
            #added_item_blcok{
                width: 100%;
                height: 245px;
                overflow:auto;
            }
            #added_item_blcok li {
              list-style: none;
              float:left;
              width: 220px;
            }
             
            #added_item_blcok li a:hover:after {
              content: ' (移出)';
            } 
            #added_item_blcok li a {
              text-decoration: none;
              color: #000;
              margin: 10px;
              width: 180px;
              border: 3px dashed #999;
              background: #eee;
              padding: 10px;
              display: block;
            }
             
            #added_item_blcok  li.over {
              border-color: #333;
              background: #ccc;
            }
 
            .items {
                z-index: 100;
            }
            #drop_box_block{
                float: left;
                width: 230px;
            }
            #dropped_item_block h3, #drop_box_block h3{
                margin: 10px;
            }
            .droparea {
                width: 210px;
                height: 210px;
                text-align: center;
                padding: 10px;
            }
            .dropareahover {
                background-color:#EFD2A4;
                border-color:#DFA853;
            }
            #item_tabs {
                height: 175px;
                margin-top: 10px;
            }
            .item_img_block{
                padding: 10px;
                float: left;
            }
            #user_item{
                height: 120px;
                overflow:auto;
            }
            #site_sitem{
                height: 120px;
                overflow:auto;
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
        <div id="drag_to_shelve_block">
            <div id="drop_box_block">
                <h3>請拖放商品至福利格子</h3>
                <div class="droparea">
                    <img src="<?=SITE_URL;?>/images/box_640.png" width="200px;" />
                </div>
            </div>
            <div id="dropped_item_block">
                <h3>已上架商品</h3>
                <div id="added_item_blcok">
                    <ul id="added_item_blcok_ul">
                        <?
                        $query_box_item = "SELECT id,item_id,type FROM box_item WHERE box_id='$box_obj->id' AND status!='paid' AND status!='is_deleted'";
                        $query_box_item_result = mysql_query($query_box_item, $dbc);
                        while ($query_box_item_result_data = mysql_fetch_array($query_box_item_result)) {
                            $box_item_obj = '';
                            $item_type = '';
                            if($query_box_item_result_data['type']=='normal'){
                                $box_item_obj = new FleaTransactionItem($query_box_item_result_data['item_id']);
                                $item_type = 'dn';
                            } else {
                                $box_item_obj = new FleaSpecialItem($query_box_item_result_data['item_id']);
                                $item_type = 'ds';
                            }
                        ?>
                        <li id="boxitem<?=$query_box_item_result_data['id']?>"><a href="#" id="<?=$item_type?>item_<?=$box_item_obj->id?>_<?=$query_box_item_result_data['id']?>" onclick="delete_boxitem('<?=$query_box_item_result_data['id']?>')"><?=$box_item_obj->title?></a></li> 
                        <?
                        }
                        mysql_free_result($query_box_item_result);
                        ?>
                    </ul>
                </div>
            </div>
            <br class="clearboth" />
            <div id="item_tabs">
                <ul>
                    <li><a href="#user_item"><span>未上架商品</span></a></li>
                    <li><a href="#site_sitem"><span>裝飾元件</span></a></li>
                </ul>
                <div id="user_item">
                    <?
                    $query_item = mysql_query("SELECT it.id FROM item it LEFT JOIN box_item bi ON (it.id=bi.item_id AND bi.status!='is_deleted' AND bi.box_id='$box_obj->id' AND bi.owner_id='$user_obj->id' AND bi.type='normal') WHERE it.owner_id = '$user_obj->id'  AND it.is_deleted='0' AND it.is_released='1'  AND it.title!='尚未填寫品名' AND bi.item_id IS NULL ORDER BY it.id DESC",$dbc);
                    while ($query_item_data = mysql_fetch_array($query_item)) {
                        $item_obj = new FleaTransactionItem($query_item_data['id']);
                        ?>
                        <div class="items item_img_block" id="nitem_<?=$item_obj->id?>">
                            <img id="item_icon<?=$item_obj->id?>" src="<?=$item_obj->getItemIconR('100');?>" height="100" />
                        </div>
                        <?
                        unset($item_obj);
                    }
                    mysql_free_result($query_item);
                    ?>
                    <br class="clearboth" />
                </div>
                <div id="site_sitem">
                    <?
                    $query_sitem = mysql_query("SELECT si.id FROM special_item si LEFT JOIN box_item bi ON (si.id=bi.item_id AND bi.type='special' AND bi.box_id='$box_obj->id' AND bi.status!='is_deleted') WHERE si.is_deleted='0' AND si.is_released='1' AND si.title!='尚未填寫元件名稱' AND bi.id IS NULL ORDER BY si.id DESC",$dbc);
                    while ($query_sitem_data = mysql_fetch_array($query_sitem)) {
                        $sitem_obj = new FleaSpecialItem($query_sitem_data['id']);
                        ?>
                        <div class="items item_img_block" id="sitem_<?=$sitem_obj->id?>">
                            <img id="sitem_icon<?=$sitem_obj->id?>" src="<?=$sitem_obj->getItemIconR('100');?>" height="100" />
                        </div>
                        <?
                        unset($sitem_obj);
                    }
                    mysql_free_result($query_sitem);
                    ?>
                    <br class="clearboth" />
                </div>
            </div>
        </div>
        <? } ?>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.js"></script>
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
            function delete_boxitem(boxitem_id){
                var req_url = "/flea/flea_src/action/delete_boxitem_action.php";
                $.ajax({
                        url: req_url, 
                        type: "POST",
                        dataType: "json",
                        data:"boxitem_id="+boxitem_id,
                        success:function(msg){
                            if(msg.status=='success'){
                                $('#boxitem'+boxitem_id).remove();
                                if(msg.item_type=='nitem'){
                                    $('#user_item').prepend('<div class="items item_img_block" id="nitem_'+msg.item_id+'"><img id="item_icon'+msg.item_id+'" src="'+msg.item_src+'" height="100" /></div>');
                                } else {
                                    $('#site_sitem').prepend('<div class="items item_img_block" id="sitem_'+msg.item_id+'"><img id="sitem_icon'+msg.item_id+'" src="'+msg.item_src+'" height="100" /></div>');
                                }
                                create_draggable_item();
                            } else {
                            }
                        }
                }); 
            }
        
            function create_draggable_item(){
                $(".items").draggable({helper: 'clone'});
                $(".droparea").droppable({
                    accept: ".items",
                    hoverClass: 'dropareahover',
                    tolerance: 'pointer',
                    drop: function(ev, ui) {
                        if(itemTotalCtr >= 10) { alert("Area is full"); return;}
                        var dropElemId = ui.draggable.attr("id");
                        var dropElem = ui.draggable.html();
                        var itempara_array = dropElemId.split('_');
                        var item_type = 'normal';
                        if(itempara_array[0]=='sitem'){
                            item_type = 'special';
                        }
                        
                        var req_url = "/flea/flea_src/action/addto_box_action.php";
                        $.ajax({
                                url: req_url, 
                                type: "POST",
                                dataType: "json",
                                data:"box_id=<?=$box_obj->id?>&item_id="+itempara_array[1]+"&type="+item_type,
                                success:function(msg){
                                    if(msg.status=='success'){
                                        $('#'+dropElemId).remove();
                                        $('#added_item_blcok_ul').prepend('<li id="boxitem'+msg.boxitem_id+'"><a href="#" id="d'+itempara_array[0]+'_'+itempara_array[1]+'_'+msg.boxitem_id+'" onclick="delete_boxitem(\''+msg.boxitem_id+'\')">'+msg.item_title+'</a></li>'); 
                                    } else {
                                        
                                    }
                                }
                        }); 
                    }
                });
            }
        
            $(document).ready(function() {
                 $("#item_tabs").tabs();
            
                var itemDogCtr = 0; itemSheepCtr = 0; itemTotalCtr = 0;
                $(document).ready(function(){
                    $(".items").draggable({helper: 'clone'});
                    $(".droparea").droppable({
                        accept: ".items",
                        hoverClass: 'dropareahover',
                        tolerance: 'pointer',
                        drop: function(ev, ui) {
                            if(itemTotalCtr >= 10) { alert("Area is full"); return;}
                            var dropElemId = ui.draggable.attr("id");
                            var dropElem = ui.draggable.html();
                            var itempara_array = dropElemId.split('_');
                            var item_type = 'normal';
                            if(itempara_array[0]=='sitem'){
                                item_type = 'special';
                            }
                            
                            var req_url = "/flea/flea_src/action/addto_box_action.php";
                            $.ajax({
                                    url: req_url, 
                                    type: "POST",
                                    dataType: "json",
                                    data:"box_id=<?=$box_obj->id?>&item_id="+itempara_array[1]+"&type="+item_type,
                                    success:function(msg){
                                        if(msg.status=='success'){
                                            $('#'+dropElemId).remove();
                                            $('#added_item_blcok_ul').prepend('<li id="boxitem'+msg.boxitem_id+'"><a href="#" id="d'+itempara_array[0]+'_'+itempara_array[1]+'_'+msg.boxitem_id+'" onclick="delete_boxitem(\''+msg.boxitem_id+'\')">'+msg.item_title+'</a></li>'); 
                                        } else {
                                            
                                        }
                                    }
                            }); 
                        }
                    });
                });
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
