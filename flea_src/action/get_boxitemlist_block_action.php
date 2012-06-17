<? if(!empty($_COOKIE['user_id'])){ ?>
    <?
    require_once('/var/www/html/flea/flea_src/base_functions.php');

    $user_obj = new FleaUser($_COOKIE['user_id']);
    $dbc = connectdb();
    $box_id = $_GET['box_id'];
    
    $query_box_item = "SELECT item_id FROM box_item WHERE box_id='$box_id' AND type='normal' AND status!='is_deleted' ORDER BY id DESC";
    $query_box_item_result = mysql_query($query_box_item, $dbc);
    while ($query_box_item_result_data = mysql_fetch_array($query_box_item_result)) {
        $box_item_obj = new FleaTransactionItem($query_box_item_result_data['item_id']);
    ?>
    <div class="box_item_merch">
        <span class="polaroids_noshadow">
            <img src="<?=$box_item_obj->getItemIcon('200')?>" />
        </span>
        <br class="clearboth" />
        <div class="info_block">
            <div class="info_title"><?=$box_item_obj->title?></div>
        </div>
    </div>
    <?
        unset($box_item_obj);
    }
    mysql_free_result($query_box_item_result);
}
?>