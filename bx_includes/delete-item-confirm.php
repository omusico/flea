<? if(!empty($_COOKIE['user_id'])){ ?>
<?
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $item_id = '';
    if(isset($_GET['item_id'])&&!empty($_GET['item_id'])){
        $item_id = $_GET['item_id'];
        $item_obj = new FleaTransactionItem($item_id);
    }
?>
<div id="delete_item_box" style="width:420px;">
	<div class="box_title">
        <h3>刪除商品</h3>
	</div>
    <div class="box_body">
        <form method="post" name="delete_item_form" id="delete_item_form">
            <input type="hidden" name="item_id" value="<?=$item_id?>" />
            <div id="box_confirm_message">
                <p>
                    您確認要刪除「<?=$item_obj->title?>」?
                </p>
            </div>
        </form>
    </div>
    <div class="box_foot">
        <input type="button" value="確定" onclick="delete_item(<?=$item_obj->id?>);" class="TBbtn butt" /> <input type="button" value="取消" class="TBbtn butt-cancel close" />
    </div> 
</div>
<? } else {?>
<? require_once('/var/www/html/flea/bx_includes/alert_box.php'); ?>
<? }?>