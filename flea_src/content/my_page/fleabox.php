<? 
if(!empty($_COOKIE['user_id'])){ 
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $user_obj = new FleaUser($_COOKIE['user_id']);
    $dbc = connectdb();
    
    $query_box = "SELECT id FROM box WHERE owner_id='$user_obj->id' AND is_deleted='0'";
    $query_box_result = mysql_query($query_box, $dbc);
    $box_exist_num = mysql_num_rows($query_box_result);
    mysql_free_result($query_box_result); 
    if($box_exist_num==0){
        $query_box_in = "INSERT INTO box (owner_id,title,content,create_time,update_time) VALUES ('$user_obj->id','福利格子尚未命名','福利格子尚未編寫描述',NOW(),NOW())";
        mysql_query($query_box_in, $dbc);
    }
?>
<h2>福利格子管理</h2>
<div id="fleabox_block">
    <?
    $query_box = "SELECT id FROM box WHERE owner_id='$user_obj->id' AND is_deleted='0'";
    $query_box_result = mysql_query($query_box, $dbc);
    while ($query_box_result_data = mysql_fetch_array($query_box_result)) {
        $box_obj = new FleaBox($query_box_result_data['id']);
    ?>
    <div class="box_func_block">
        <span><a onclick="call_item_shelve_box('&box_id=<?=$box_obj->id?>')">上架商品</a></span>
        <span><a onclick="call_box_decoration_box('&box_id=<?=$box_obj->id?>')">佈置格子</a></span>
        <span>要先上架商品才能佈置格子喔!</span>
    </div>
    <div id="box_block<?=$box_obj->id?>" class="box_block">
        <div id="box_cover<?=$box_obj->id?>" class="box_cover_block">
            <img id="box_cover_img<?=$box_obj->id?>" src="<?=$box_obj->getBoxCoverR('640')?>" class="box_cover" width="570" />
        </div>
    </div>
    <br class="clearboth" />
    <div id="box_items_block<?=$box_obj->id?>">
        <?
        $query_box_item = "SELECT bi.id,bi.item_id FROM box_item bi INNER JOIN item i ON (bi.item_id=i.id) WHERE bi.box_id='$box_obj->id' AND bi.type='normal' AND bi.status!='is_deleted' AND bi.status!='paid' AND i.is_deleted='0' ORDER BY bi.id DESC";
        //$query_box_item = "SELECT item_id FROM box_item WHERE box_id='$box_obj->id' AND type='normal' AND status!='is_deleted' ORDER BY id DESC";
        $query_box_item_result = mysql_query($query_box_item, $dbc);
        while ($query_box_item_result_data = mysql_fetch_array($query_box_item_result)) {
            $box_item_obj = new FleaTransactionItem($query_box_item_result_data['item_id']);
            $true_box_item_obj = new FleaBoxItem($query_box_item_result_data['id']);
        ?>
        <div class="box_item_merch">
            <div class="polaroids_noshadow">
                <img src="<?=$box_item_obj->getItemIcon('200')?>" />
                <? if($true_box_item_obj->status=='pending'){ ?>
                <div class="box_item_buyed_alert">
                    已有人訂購
                </div>
                <? } ?>
            </div>
            <br class="clearboth" />
            <div class="info_block">
                <div class="info_title"><?=$box_item_obj->title?></div>
            </div>
        </div>
        <?
            unset($box_item_obj);
        }
        mysql_free_result($query_box_item_result);
        ?>
    </div>
    <br class="clearboth" />
    <?
    }
    mysql_free_result($query_box_result); 
    ?>
</div>
<div class="clearboth"></div>
<? } ?>