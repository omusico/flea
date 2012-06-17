<?
require_once('flea_src/base_functions.php');
 
if(!empty($_GET['item_id'])&&!empty($_GET['box_item_id'])){
    $dbc = connectdb();
    $box_item_id = $_GET['box_item_id'];
    $query_box_item_result = mysql_query("SELECT bi.id,bi.item_id FROM box_item bi INNER JOIN item it ON (bi.item_id=it.id) WHERE bi.id='$box_item_id' AND bi.type='normal' AND bi.status!='is_deleted' AND bi.status!='paid' AND it.is_deleted='0' LIMIT 1",$dbc);
    $box_item_exist_num = mysql_num_rows($query_box_item_result);
    mysql_free_result($query_box_item_result);
    if($box_item_exist_num>0){
        require_once('flea_src/head.php');
        ?>  
            <div id="wrapper">
                <?
                require_once('flea_src/header.php');
                ?>
                <?
                require_once('flea_src/content/item.php');
                ?>
                <?
                require_once('flea_src/footer.php');
                ?>
            </div>
        <?
        require_once('flea_src/script_manager.php');  
        
    } else {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".SITE_URL."/404.php");
    }
} else {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".SITE_URL."/404.php");
}


