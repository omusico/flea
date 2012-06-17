<?
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $box_id = $_GET['box_id'];
    $dbc = connectdb();
?>
<div id="flea_box_decoration_box" style="width:500px; height: 560px;">
	<div class="box_title">
        <h3>佈置福利格子</h3>
	</div>
    <div class="box_body" style="height: 475px; width:475px; overflow:hidden;">
        <div id="flea_box_decoration_block">
        <?
        $query_box_item = "SELECT item_id FROM box_item WHERE box_id='$box_id' AND type='normal' AND status!='is_deleted' ORDER BY id DESC";
        $query_box_item_result = mysql_query($query_box_item, $dbc);
        $query_box_item_result_num = mysql_num_rows($query_box_item_result);
        if($query_box_item_result_num>0){
        ?>
        <iframe scrolling="no" src="/flea/flea_src/content/box-decoration-iframe.php?box_id=<?=$box_id?>" height="475" width="450" />
        <?
        } else {
        ?>
        <h2 style="margin-top:30px;text-align:center;">請先上架商品才能佈置格子喔!<h2>
        <?
        }
        mysql_free_result($query_box_item_result);
        ?>
        </div>
    </div>
    <div class="box_foot">
        <input type="button" value="關閉" class="TBbtn butt close" />
    </div> 
</div>