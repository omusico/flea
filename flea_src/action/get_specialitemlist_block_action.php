<? 
if(!empty($_COOKIE['user_id'])){ 
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $user_obj = new FleaUser($_COOKIE['user_id']);
    
    if($user_obj->auth_id>=90){
    
        $curpage = 0;
        if(!empty($_GET['page'])){
            $curpage = $_GET['page'];
        }
    
        $dbc = connectdb();
        
        $query_sitem_all = mysql_query("SELECT id FROM special_item WHERE is_deleted='0' ORDER BY id DESC",$dbc);
        $total_sitem_num = mysql_num_rows($query_sitem_all);
        mysql_free_result($query_sitem_all);
        $element_num = 10;
        $total_page = ceil($total_sitem_num/$element_num);

        $item_start = ($curpage)*$element_num;

        $query_sitem = mysql_query("SELECT id FROM special_item WHERE is_deleted='0' ORDER BY id DESC LIMIT $item_start,$element_num",$dbc);
        
        while ($query_sitem_data = mysql_fetch_array($query_sitem)) {
            $sitem_obj = new FleaSpecialItem($query_sitem_data['id']);
            ?>
            <div class="sitem_block" id="sitem_block<?=$sitem_obj->id?>">
                <div class="sitem_icon_block left">
                    <span class="polaroids <?=rand_polaroids();?>"><img id="sitem_icon" src="<?=$sitem_obj->getItemIconRW('200');?>" width="200" /></span>
                </div>
                <div class="sitem_des_block right">
                    <h3><span><?=$sitem_obj->title;?></span> (<a onclick="call_edit_sitem_box('&sitem_id=<?=$sitem_obj->id?>')">編輯</a>) (<a onclick="call_delete_sitem_box('&sitem_id=<?=$sitem_obj->id?>')">刪除</a>)</h3>
                    <div class="sitem_detail">
                        <?
                        if(!empty($sitem_obj->category_id)){
                            $special_category_obj = new FleaSpecialCategory($sitem_obj->category_id);
                        ?>
                        <span>分類:<?=$special_category_obj->title?></span><br/>
                        <?
                            unset($special_category_obj);
                        }
                        ?>
                    </div>
                    <p>
                        <?=nl2br($sitem_obj->description);?>
                    </p>
                </div>
                <br class="clearboth">
            </div>
            <?
            unset($sitem_obj);
        }
        echo ajaxShowPage($curpage, $total_page, 'item_container_block', 'get_specialitemlist_block_action.php', '');
        mysql_free_result($query_sitem);
        ?>
        <br class="clearboth">
        <? 
    } 
    unset($user_obj);
}    
?>