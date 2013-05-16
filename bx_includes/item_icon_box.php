<?
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $box_item_id = $_GET['box_item_id'];
    $item_id = $_GET['item_id'];
    $box_item_obj = new FleaTransactionItem($item_id);
    $dbc = connectdb();
?>
<div id="box_item_icon_box" style="width:800px; height: 560px;">
	<div class="box_title">
        <h3><?=$box_item_obj->title?></h3>
	</div>
    <div class="box_body" style="height: 475px;">
        <div id="box_item_icon_block">
            <img src="<?=$box_item_obj->getItemIconSmart('500')?>" />
        </div>
    </div>
    <div class="box_foot">
        <input type="button" value="關閉" class="TBbtn butt close" />
    </div> 
</div>