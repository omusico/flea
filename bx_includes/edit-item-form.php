<? if(!empty($_COOKIE['user_id'])){ ?>
<?
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $item_id = $_GET['item_id'];
    $item_obj = new FleaTransactionItem($item_id);
    $dbc = connectdb();
?>
<div id="edit_form_box" style="width:600px;">
	<div class="box_title">
        <h3>修改商品資訊</h3>
	</div>
    <div class="box_body">   
	<form method="post" id="edit_item_form" name="edit_item_form">
        <input type="hidden" name="item_id" id="item_id" value="<?=$item_obj->id?>" />
        <div class="textfield">
            <label for="item_title">商品名稱</label>
            <input type="text" name="item_title" id="item_title" value="<?=$item_obj->title?>" class="text">
            <span id="item_title_error"></span>
        </div>
        <div class="textfield-half">
            <label for="price">價錢(元)</label>
            <input type="text" name="price" id="price" value="<?=$item_obj->price?>" maxlength="5" class="text" style="width:30%" />
            <span id="price_error"></span>
        </div>
        <div class="textfield-half">
            <label for="method_id">交易方式</label>
            <select name="method_id" id="method_id" >
                <?
                $query_method = mysql_query("SELECT id FROM method WHERE is_deleted='0' ORDER BY ordernum",$dbc);
                while ($query_method_data = mysql_fetch_array($query_method)) {
                    $method_obj = new FleaTransactionMethod($query_method_data['id']);
                ?>
                <option value="<?=$method_obj->id?>" <? if($method_obj->id==$item_obj->method_id){ echo 'selected="selected"'; } ?>><?=$method_obj->title?></option>
                <? 
                    unset($method_obj);
                }
                ?>
            </select>
        </div>
        <br class="clearboth">
        <div class="textfield-half">
            <label for="school_id">交易學校</label>
            <select name="school_id" id="school_id" >
                <?
                $query_school = mysql_query("SELECT id FROM school WHERE is_deleted='0' ORDER BY ordernum",$dbc);
                while ($query_school_data = mysql_fetch_array($query_school)) {
                    $school_obj = new FleaSchool($query_school_data['id']);
                ?>
                <option value="<?=$school_obj->id?>" <? if($school_obj->id==$item_obj->school_id){ echo 'selected="selected"'; } ?>><?=$school_obj->title?></option>
                <? 
                    unset($school_obj);
                }
                ?>
            </select>
        </div>
        <div class="textfield-half">
            <label for="school_location_id">交易地點</label>
            <select name="school_location_id" id="school_location_id" >
                <option value="0">請選擇</option>
                <?
                $query_school_location = mysql_query("SELECT id FROM school_location WHERE school_id='$item_obj->school_id' AND is_deleted='0' ORDER BY ordernum",$dbc);
                while ($query_school_location_data = mysql_fetch_array($query_school_location)) {
                    $location_obj = new FleaSchoolLocation($query_school_location_data['id']);
                ?>
                <option value="<?=$location_obj->id?>" <? if($location_obj->id==$item_obj->school_location_id){ echo 'selected="selected"'; } ?>><?=$location_obj->title?></option>
                <? 
                    unset($location_obj);
                }
                ?>
            </select>
            <span id="school_location_id_error"></span>
        </div>
        <br class="clearboth">
        <div class="textfield-half">
            <label for="category_id">商品分類</label>
            <select name="category_id" id="category_id" onchange="change_subcategory_select();">
                <option value="0">請選擇</option>
                <?
                $query_category = mysql_query("SELECT id FROM category WHERE is_deleted='0' ORDER BY ordernum",$dbc);
                while ($query_category_data = mysql_fetch_array($query_category)) {
                    $category_obj = new FleaCategory($query_category_data['id']);
                ?>
                <option value="<?=$category_obj->id?>" <? if($category_obj->id==$item_obj->category_id){ echo 'selected="selected"'; } ?>><?=$category_obj->title?></option>
                <? 
                    unset($category_obj);
                }
                ?>
            </select>
            <span id="category_id_error"></span>
        </div>
        <div class="textfield-half">
            <label for="subcategory_id">商品子分類</label>
            <select name="subcategory_id" id="subcategory_id" >
                <option value="0">請選擇</option>
                <?
                $query_subcategory = mysql_query("SELECT id FROM subcategory WHERE category_id='$item_obj->category_id' AND is_deleted='0' ORDER BY ordernum",$dbc);
                while ($query_subcategory_data = mysql_fetch_array($query_subcategory)) {
                    $subcategory_obj = new FleaSubcategory($query_subcategory_data['id']);
                ?>
                <option value="<?=$subcategory_obj->id?>" <? if($subcategory_obj->id==$item_obj->subcategory_id){ echo 'selected="selected"'; } ?>><?=$subcategory_obj->title?></option>
                <? 
                    unset($subcategory_obj);
                }
                ?>
            </select>
            <span id="subcategory_id_error"></span>
        </div>
        <br class="clearboth">
        <div class="textfield">
            <label for="item_content">商品描述</label>
            <textarea style="width:90%;" rows="7" cols="20" name="item_content" id="item_content"><?=$item_obj->content?></textarea>
            <br/>
            <span id="item_content_error"></span>
        </div>
        <br class="clearboth">
	</form>
    </div>
    <div class="box_foot">
        <input type="button" value="送出" onclick="edit_item_validate();" class="TBbtn butt" /> <input type="button" value="取消" class="TBbtn butt-cancel close" />
    </div> 
</div>
<? } else {?>
<? require_once('/var/www/html/flea/bx_includes/alert_box.php'); ?>
<? }?>