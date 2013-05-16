<?
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $viewer_obj = 'guest';
    if(!empty($_COOKIE['user_id'])){
        $viewer_obj = new FleaUser($_COOKIE['user_id']);
    }
    $dbc = connectdb();
    $category_id = $_GET['category_id'];
    $current_item = $_GET['current_item'];
    if(empty($current_item)){
        $current_item = 0;
    }
    
    $query_item = '';
    if($category_id=='0'){
        $query_item = "SELECT bi.id,bi.item_id FROM box_item bi INNER JOIN box b ON (bi.box_id=b.id) INNER JOIN item i ON (bi.item_id=i.id) WHERE bi.type='normal' AND bi.status!='is_deleted' AND bi.status!='paid' AND b.is_released='1' AND b.is_deleted='0' AND i.is_deleted='0' ORDER BY bi.id DESC";
    } else {
        $query_item = "SELECT bi.id,bi.item_id FROM box_item bi INNER JOIN box b ON (bi.box_id=b.id) INNER JOIN item i ON (bi.item_id=i.id) WHERE bi.type='normal' AND bi.status!='is_deleted' AND bi.status!='paid' AND b.is_released='1' AND b.is_deleted='0' AND i.category_id='$category_id' AND i.is_deleted='0' ORDER BY bi.id DESC";
    }
    $query_item_result = mysql_query($query_item, $dbc);
    $item_exist_num = mysql_num_rows($query_item_result);
    mysql_free_result($query_item_result);
    
    $query_item = $query_item." LIMIT $current_item,30";

    if($item_exist_num==0){
        if($current_item==0){
        ?>
        <h2>尚無任何福利商品</h2>
        <?
        }
    } else {
        $explore_title = '';
        if($category_id!=0){
            $category_obj = new FleaCategory($category_id);
            $explore_title = $category_obj->title;
            unset($category_obj);
        } else {
            $explore_title = '最新';
        }
        
        if($current_item==0){
        ?>
        <h2><?=$explore_title?>福利商品</h2>
        <?
        }
        
        $dbc = connectdb();
        $query_box_item_result = mysql_query($query_item, $dbc);
        while ($query_box_item_result_data = mysql_fetch_array($query_box_item_result)) {
            $box_item_id = $query_box_item_result_data['id'];
            $box_item_obj = new FleaBoxItem($box_item_id);
            $item_obj = new FleaTransactionItem($query_box_item_result_data['item_id']);
            $box_owner_obj = new FleaUser($item_obj->owner_id);
        ?>
        <div class="home_box_item_merch">
            <div class="polaroids_noshadow">
                <a href="/flea/item.php?item_id=<?=$item_obj->id?>&box_item_id=<?=$box_item_id?>"><img src="<?=$item_obj->getItemIcon('200')?>" onmouseover="setboxiteminfo_diplay('<?=$box_item_id?>');" /></a>
                <div class="home_box_item_merch_info" id="home_box_item_merch_info<?=$box_item_id?>" onmouseout="setboxiteminfo_none('<?=$box_item_id?>');">
                    <span class="content"><?=$item_obj->content?></span>
                </div>
                <? if($box_item_obj->status=='pending'){ ?>
                <div class="box_item_buyed_alert">
                    已有人訂購
                </div>
                <? } ?>
            </div>
            <br class="clearboth" />
            <div class="info_block">
                <div class="info_title"><a href="/flea/item.php?item_id=<?=$item_obj->id?>&box_item_id=<?=$box_item_id?>"><?=$item_obj->title?></a></div>
            </div>
            <div class="func_block">
                <div class="left">
                    <a onclick="call_item_icon_box('&box_item_id=<?=$box_item_id?>&item_id=<?=$item_obj->id?>')"><span>看大圖</span></a>
                </div>
                <div class="right">
                    <?
                    if($viewer_obj=='guest'){
                    ?>
                    <a onclick="call_login_box()"><span>追蹤</span></a>
                    <?
                    } else {
                        echo $viewer_obj->getBoxItemFollowBtn('small',$item_obj->id,$box_item_id);
                    }
                    ?>
                    <?
                    if($box_item_obj->status=='for_sale'){
                        if($viewer_obj=='guest'){
                        ?>
                        <a onclick="call_login_box()"><span>購買</span></a>
                        <?
                        } else {
                            echo $viewer_obj->getBoxItemBuyBtn('small',$item_obj->id,$box_item_id);
                        }
                    }
                    ?>
                </div>
                <br class="clearboth" />
            </div>
            <div class="owner_block">
                <div class="left">
                    <a href="/flea/user.php?account=<?=$box_owner_obj->account?>"><img src="<?=$box_owner_obj->getUserIcon('25');?>" /></a>
                </div>
                <div class="user_info left">
                    <a href="/flea/user.php?account=<?=$box_owner_obj->account?>"><?=$box_owner_obj->nickname;?></a>
                </div>
                <br class="clearboth" />
            </div>
            <br class="clearboth" />
        </div>
        <?
           unset($box_item_obj);
           unset($box_owner_obj); 
           unset($item_obj);
        }
        mysql_free_result($query_box_item_result);
        
        if($item_exist_num>($current_item+30)){
        ?>
        <div id="load_more_block">
            <br class="clearboth" />
            <div class="load_more_block">
                <div class="load_more_text"><a onclick="loadExploreItem('<?=$category_id?>','<?=$current_item+30?>')">看更多商品</a></div>
            </div>
        </div>
        <?
        } else {
        ?>
        <br class="clearboth" />
        <?
        }
    }
?>