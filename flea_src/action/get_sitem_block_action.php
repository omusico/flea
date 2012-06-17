<?
if(!empty($_COOKIE['user_id'])){ 
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $user_obj = new FleaUser($_COOKIE['user_id']);
    if($user_obj->auth_id>=90){
    
        $sitem_id = $_GET['sitem_id'];
        $sitem_obj = new FleaSpecialItem($sitem_id);
        $dbc = connectdb();
        ?>
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
        <? 
    } 
    unset($user_obj);
}    
?>