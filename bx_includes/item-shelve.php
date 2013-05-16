<?
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $box_id = $_GET['box_id'];
?>
<div id="shelve_box" style="width:800px; height: 560px;">
	<div class="box_title">
        <h3>上架商品至福利格子</h3>
	</div>
    <div class="box_body" style="height: 475px;">
        <div id="drag_to_shelve_block">
        <iframe scrolling="no" src="/flea/flea_src/content/item-shelve-iframe.php?box_id=<?=$box_id?>" width="100%" height="475" />
        </div>
    </div>
    <div class="box_foot">
            <input type="button" value="關閉" onclick="get_boxitemlist_block('<?=$box_id?>')" class="TBbtn butt close" />
    </div> 
</div>