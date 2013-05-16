<? 
if(!empty($_COOKIE['user_id'])){ 
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $user_obj = new FleaUser($_COOKIE['user_id']);
    $dbc = connectdb();
    $query_paid_exchange = "SELECT id FROM exchange_record WHERE owner_id='$user_obj->id' AND status='paid' ORDER BY order_time DESC";
    $query_paid_exchange_result = mysql_query($query_paid_exchange, $dbc);
    $paid_num = mysql_num_rows($query_paid_exchange_result);
    
    
    if($paid_num>0){
        while ($query_paid_exchange_data = mysql_fetch_array($query_paid_exchange_result)) {
        
            $exchange_obj = new FleaExchangeRecord($query_paid_exchange_data['id']);
            $buyer_boj = new FleaUser($exchange_obj->buyer_id);
            $item_obj = new FleaTransactionItem($exchange_obj->item_id);
            $method_obj = new FleaTransactionMethod($item_obj->method_id);
            $school_obj = new FleaSchool($item_obj->school_id);
            $location_obj = new FleaSchoolLocation($item_obj->school_location_id);
        ?>
        <div id="buy_form_item_block<?=$exchange_obj->id?>">
            <div id="buy_form_item_icon_block">
                <a href="<?=SITE_URL;?>/item.php?item_id=<?=$item_obj->id?>&box_item_id=<?=$exchange_obj->box_item_id?>"><img src="<?=$item_obj->getItemIcon('200')?>" /></a>
            </div>
            <div id="buy_form_item_info_block" style="width:320px;">
                <div id="item_sub" style="border-bottom: none;">
                    <div id="title"><h2><?=$item_obj->title?></h2></div>
                    <div class="left" id="price">
                        <h4>價格</h4>
                        <div id="price_text" style="line-height:1">$ <?=$item_obj->price?></div>
                        <div class="func_block">
                            <a onclick="exchange_comment_box('&exchange_id=<?=$exchange_obj->id?>&type=owner')"><span>評價</span></a>
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
                            買家: <a href="/flea/user.php?account=<?=$buyer_boj->account?>"><?=$exchange_obj->contact_name?></a>
                        </div>
                    </div>
                    <div class="clearboth"></div>
                </div>
            </div>
            <br class="clearboth" />
        </div>
        <?
            unset($buyer_boj);
            unset($item_obj);
            unset($method_obj);
            unset($school_obj);
            unset($location_obj);
            unset($exchange_obj);
        }
    } else {
    ?>
    <h3>尚無任何待處理商品訂單。</h3>
    <?
    }
    mysql_free_result($query_paid_exchange_result);
    ?>
    <div class="clearboth"></div>
<? 
    unset($user_obj);
} 
?>