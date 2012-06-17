<? 
if(!empty($_COOKIE['user_id'])){ 
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $user_obj = new FleaUser($_COOKIE['user_id']);
    $dbc = connectdb();
    $query_follow_item = "SELECT id,item_id,box_item_id FROM follow_item WHERE follower_id='$user_obj->id' AND is_deleted='0' ORDER BY create_time DESC";
    $query_follow_item_result = mysql_query($query_follow_item, $dbc);
    $follow_num = mysql_num_rows($query_follow_item_result);
    
    
    if($follow_num>0){
        while ($query_follow_item_data = mysql_fetch_array($query_follow_item_result)) {
        
            $follow_id = $query_follow_item_data['id'];
            $box_item_id = $query_follow_item_data['box_item_id'];
            
            $item_obj = new FleaTransactionItem($query_follow_item_data['item_id']);
            $owner_obj = new FleaUser($item_obj->owner_id);
            $method_obj = new FleaTransactionMethod($item_obj->method_id);
            $school_obj = new FleaSchool($item_obj->school_id);
            $location_obj = new FleaSchoolLocation($item_obj->school_location_id);
        ?>
        <div id="follow_form_item_block<?=$follow_id?>">
            <div id="buy_form_item_icon_block">
                <a href="<?=SITE_URL;?>/item.php?item_id=<?=$item_obj->id?>&box_item_id=<?=$box_item_id?>"><img src="<?=$item_obj->getItemIcon('200')?>" /></a>
            </div>
            <div id="buy_form_item_info_block" style="width:320px;">
                <div id="item_sub" style="border-bottom: none;">
                    <div id="title"><h2><?=$item_obj->title?></h2></div>
                    <div class="left" id="price">
                        <h4>價格</h4>
                        <div id="price_text" style="line-height:1">$ <?=$item_obj->price?></div>
                        <div class="func_block">
                            <a onclick="send_message_box('&receiver_id=<?=$owner_obj->id?>')"><span>發訊息</span></a>
                            <a onclick="delete_follow_item('<?=$follow_id?>')"><span>刪除</span></a>
                        </div>
                    </div>
                    <div class="left" id="btns" style="width:160px;">
                        <div class="btn_item">
                            交易方式: <?=$method_obj->title?>
                        </div>
                        <div class="btn_item">
                            交易學校: <?=$school_obj->title?>
                        </div>
                        <div class="btn_item">
                            交易地點: <?=$location_obj->title?>
                        </div>
                        <div class="btn_item">
                            賣家: <a href="/flea/user.php?account=<?=$owner_obj->account?>"><?=$owner_obj->nickname?></a>
                        </div>
                    </div>
                    <div class="clearboth"></div>
                </div>
            </div>
            <br class="clearboth" />
        </div>
        <?
            unset($owner_obj);
            unset($item_obj);
            unset($method_obj);
            unset($school_obj);
            unset($location_obj);
        }
    } else {
    ?>
    <h3>尚無任何追蹤商品。</h3>
    <?
    }
    mysql_free_result($query_follow_item_result);
    ?>
    <div class="clearboth"></div>
<? 
    unset($user_obj);
} 
?>