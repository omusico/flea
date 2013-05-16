<? if(!empty($_COOKIE['user_id'])){ ?>
<?
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $item_id = $_GET['item_id'];
    $item_obj = new FleaTransactionItem($item_id);
    $dbc = connectdb();
?>
<form method="post" id="edit_item_form<?=$item_id?>" name="edit_item_form">
    <div class="textfield">
        <label for="item_title">商品名稱</label>
        <input type="text" name="item_title" id="item_title<?=$item_id?>" value="<?=$item_obj->title?>" class="text">
        <span id="item_title_error<?=$item_id?>"></span>
    </div>
    <div class="textfield-half">
        <label for="price">價錢(元)</label>
        <input type="text" name="price" id="price<?=$item_id?>" value="<?=$item_obj->price?>" class="text" style="width:30%" />
        <span id="price_error"></span>
    </div>
    <div class="textfield-half">
        <label for="method_id">交易方式</label>
        <select name="method_id" id="method_id<?=$item_id?>" >
            <?
            $query_method = mysql_query("SELECT id FROM method ORDER BY ordernum",$dbc);
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
        <select name="school_id" id="school_id<?=$item_id?>" >
            <?
            $query_school = mysql_query("SELECT id FROM school ORDER BY ordernum",$dbc);
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
        <select name="school_location_id" id="school_location_id<?=$item_id?>" >
            <option value="0">請選擇</option>
            <?
            $query_school_location = mysql_query("SELECT id FROM school_location WHERE school_id='$item_obj->school_id' ORDER BY ordernum",$dbc);
            while ($query_school_location_data = mysql_fetch_array($query_school_location)) {
                $location_obj = new FleaSchoolLocation($query_school_location_data['id']);
            ?>
            <option value="<?=$location_obj->id?>" <? if($location_obj->id==$item_obj->school_location_id){ echo 'selected="selected"'; } ?>><?=$location_obj->title?></option>
            <? 
                unset($location_obj);
            }
            ?>
        </select>
        <span id="school_location_id_error<?=$item_id?>"></span>
    </div>
    <br class="clearboth">
    <div class="textfield-half">
        <label for="category_id">商品分類</label>
        <select name="category_id" id="category_id<?=$item_id?>" >
            <option value="0">請選擇</option>
            <?
            $query_category = mysql_query("SELECT id FROM category ORDER BY ordernum",$dbc);
            while ($query_category_data = mysql_fetch_array($query_category)) {
                $category_obj = new FleaCategory($query_category_data['id']);
            ?>
            <option value="<?=$category_obj->id?>" <? if($category_obj->id==$item_obj->category_id){ echo 'selected="selected"'; } ?>><?=$category_obj->title?></option>
            <? 
                unset($category_obj);
            }
            ?>
        </select>
        <span id="category_id_error<?=$item_id?>"></span>
    </div>
    <div class="textfield-half">
        <label for="subcategory_id">商品子分類</label>
        <select name="subcategory_id" id="subcategory_id<?=$item_id?>" >
            <option value="0">請選擇</option>
            <?
            $query_subcategory = mysql_query("SELECT id FROM subcategory_id WHERE category_id='1' ORDER BY ordernum",$dbc);
            while ($query_subcategory_data = mysql_fetch_array($query_subcategory)) {
                $subcategory_obj = new FleaSubcategory($query_subcategory_data['id']);
            ?>
            <option value="<?=$subcategory_obj->id?>" <? if($subcategory_obj->id==$item_obj->subcategory_id){ echo 'selected="selected"'; } ?>><?=$subcategory_obj->title?></option>
            <? 
                unset($subcategory_obj);
            }
            ?>
        </select>
        <span id="subcategory_id_error<?=$item_id?>"></span>
    </div>
    <br class="clearboth">
    <div class="textfield">
        <label for="content">商品描述</label>
        <textarea style="width:90%;" rows="7" cols="40" name="content" id="content<?=$item_id?>"><?=$item_obj->content?></textarea>
    </div>
    <br class="clearboth">
    <br class="clearboth">
    <div>
        <input type="button" value="更新" name="button" onclick="edit_item_validate(<?=$item_id?>);" class="TBbtn butt">
    </div>
    <br class="clearboth">
</form>	
<? } ?>