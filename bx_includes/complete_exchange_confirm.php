<? if(!empty($_COOKIE['user_id'])){ ?>
<?
    require_once('/var/www/html/flea/flea_src/base_functions.php');
    $exchange_id = $_GET['exchange_id'];
    $exchange_obj = new FleaExchangeRecord($exchange_id);
    $buyer_obj = new FleaUser($exchange_obj->buyer_id);
    $item_obj = new FleaTransactionItem($exchange_obj->item_id);
?>
<div id="complete_exchange_box" style="width:420px;">
	<div class="box_title">
        <h3>確認完成此筆交易</h3>
	</div>
    <div class="box_body">
        <form method="post" name="complete_exchange_form" id="complete_exchange_form">
            <input type="hidden" name="exchange_id" value="<?=$exchange_id?>" />
            <div id="box_confirm_message">
                <p>
                    您確認已與「<?=$buyer_obj->nickname?>」完成商品「<?=$item_obj->title?>」的交易?
                </p>
            </div>
        </form>
    </div>
    <div class="box_foot">
        <input type="button" value="確定" onclick="complete_exchange(<?=$exchange_id?>);" class="TBbtn butt" /> <input type="button" value="取消" class="TBbtn butt-cancel close" />
    </div> 
</div>
<? 
    unset($exchange_obj);
    unset($buyer_obj);
    unset($item_obj);
} else {?>
<? require_once('/var/www/html/flea/bx_includes/alert_box.php'); ?>
<? }?>