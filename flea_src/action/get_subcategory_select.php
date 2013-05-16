<? if(!empty($_COOKIE['user_id'])){ ?>
<?
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $category_id = $_GET['category_id'];
    $dbc = connectdb();
?>
    <option value="0">請選擇</option>
    <?
    $query_subcategory = mysql_query("SELECT id FROM subcategory WHERE category_id='$category_id' AND is_deleted='0' ORDER BY ordernum",$dbc);
    while ($query_subcategory_data = mysql_fetch_array($query_subcategory)) {
        $subcategory_obj = new FleaSubcategory($query_subcategory_data['id']);
    ?>
    <option value="<?=$subcategory_obj->id?>"><?=$subcategory_obj->title?></option>
    <? 
        unset($subcategory_obj);
    }
    ?>
<? } ?>