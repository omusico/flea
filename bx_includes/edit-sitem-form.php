<? 
if(!empty($_COOKIE['user_id'])){
    
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $user_obj = new FleaUser($_COOKIE['user_id']);
    if($user_obj->auth_id>=90){
    
    $sitem_id = $_GET['sitem_id'];
    $sitem_obj = new FleaSpecialItem($sitem_id);
    $dbc = connectdb();
?>
<div id="edit_form_box" style="width:600px;">
	<div class="box_title">
        <h3>修改商品資訊</h3>
	</div>
    <div class="box_body">   
	<form method="post" id="edit_sitem_form" name="edit_sitem_form">
        <input type="hidden" name="sitem_id" id="sitem_id" value="<?=$sitem_obj->id?>" />
        <div class="textfield">
            <label for="sitem_title">元件名稱</label>
            <input type="text" name="sitem_title" id="sitem_title" value="<?=$sitem_obj->title?>" class="text">
            <span id="sitem_title_error"></span>
        </div>
        <div class="textfield-half">
            <label for="scategory_id">元件分類</label>
            <select name="scategory_id" id="scategory_id">
                <option value="0">請選擇</option>
                <?
                $query_scategory = mysql_query("SELECT id FROM special_category WHERE is_deleted='0' ORDER BY ordernum",$dbc);
                while ($query_scategory_data = mysql_fetch_array($query_scategory)) {
                    $scategory_obj = new FleaSpecialCategory($query_scategory_data['id']);
                ?>
                <option value="<?=$scategory_obj->id?>" <? if($scategory_obj->id==$sitem_obj->category_id){ echo 'selected="selected"'; } ?>><?=$scategory_obj->title?></option>
                <? 
                    unset($scategory_obj);
                }
                ?>
            </select>
            <span id="scategory_id_error"></span>
        </div>
        <br class="clearboth">
        <div class="textfield">
            <label for="sitem_content">元件描述</label>
            <textarea style="width:90%;" rows="7" cols="20" name="sitem_content" id="sitem_content"><?=$sitem_obj->description?></textarea>
            <br/>
            <span id="sitem_content_error"></span>
        </div>
        <br class="clearboth">
	</form>
    </div>
    <div class="box_foot">
        <input type="button" value="送出" onclick="edit_sitem_validate();" class="TBbtn butt" /> <input type="button" value="取消" class="TBbtn butt-cancel close" />
    </div> 
</div>
<? 
    } else {
        require_once('/var/www/html/flea/bx_includes/alert_box.php');
    }
} else {
    require_once('/var/www/html/flea/bx_includes/alert_box.php');
} 
?>