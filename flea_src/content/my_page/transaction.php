<? 
if(!empty($_COOKIE['user_id'])){
    require_once('/var/www/html/flea/flea_src/base_functions.php');
?>
<h2>交易紀錄</h2>
<div>
    <div id="my_transaction_tabs">
        <ul>
            <li><a href="<?=SITE_URL?>/flea_src/content/my_page/sale_history_item_tab.php"><span>賣出商品歷史記錄</span></a></li>
            <li><a href="<?=SITE_URL?>/flea_src/content/my_page/buy_history_item_tab.php"><span>購買商品歷史記錄</span></a></li>
        </ul>
    </div>
</div>
<div class="clearboth"></div>
<? } ?>